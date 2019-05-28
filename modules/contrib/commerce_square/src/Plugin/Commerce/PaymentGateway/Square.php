<?php

namespace Drupal\commerce_square\Plugin\Commerce\PaymentGateway;

use Drupal\commerce_square\Connect;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\commerce_payment\Exception\HardDeclineException;
use Drupal\commerce_price\Price;
use Drupal\commerce_square\ErrorHelper;
use Drupal\commerce_payment\Entity\PaymentInterface;
use Drupal\commerce_payment\Entity\PaymentMethodInterface;
use Drupal\commerce_payment\PaymentMethodTypeManager;
use Drupal\commerce_payment\PaymentTypeManager;
use Drupal\commerce_payment\Plugin\Commerce\PaymentGateway\OnsitePaymentGatewayBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use SquareConnect\Api\LocationsApi;
use SquareConnect\Api\TransactionsApi;
use SquareConnect\ApiClient;
use SquareConnect\ApiException;
use SquareConnect\Configuration;
use SquareConnect\Model\Address;
use SquareConnect\Model\ChargeRequest;
use SquareConnect\Model\CreateOrderRequestDiscount;
use SquareConnect\Model\CreateRefundRequest;
use SquareConnect\Model\Money;
use SquareConnect\Model\Order as SquareOrder;
use SquareConnect\Model\OrderLineItem;
use SquareConnect\ObjectSerializer;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;

/**
 * Provides the Square payment gateway.
 *
 * @CommercePaymentGateway(
 *   id = "square",
 *   label = "Square",
 *   display_label = "Square",
 *   forms = {
 *     "add-payment-method" = "Drupal\commerce_square\PluginForm\Square\PaymentMethodAddForm",
 *   },
 *   js_library = "commerce_square/square_connect",
 *   payment_method_types = {"credit_card"},
 *   credit_card_types = {
 *     "amex", "dinersclub", "discover", "jcb", "mastercard", "visa",
 *   },
 * )
 */
class Square extends OnsitePaymentGatewayBase implements SquareInterface {

  /**
   * The Connect application.
   *
   * @var \Drupal\commerce_square\Connect
   */
  protected $connect;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, PaymentTypeManager $payment_type_manager, PaymentMethodTypeManager $payment_method_type_manager, TimeInterface $time, Connect $connect) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $entity_type_manager, $payment_type_manager, $payment_method_type_manager, $time);
    $this->pluginDefinition['modes']['test'] = $this->t('Sandbox');
    $this->pluginDefinition['modes']['live'] = $this->t('Production');
    $this->connect = $connect;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('plugin.manager.commerce_payment_type'),
      $container->get('plugin.manager.commerce_payment_method_type'),
      $container->get('datetime.time'),
      $container->get('commerce_square.connect')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $default_configuration = [
      'test_location_id' => '',
      'live_location_id' => '',
    ];
    return $default_configuration + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    if (empty($this->connect->getAppId('sandbox')) && empty($this->connect->getAccessToken('sandbox'))) {
      drupal_set_message($this->t('Square has not been configured, please go to :link', [
        ':link' => Link::fromTextAndUrl($this->t('the settings form'), Url::fromRoute('commerce_square.settings')),
      ]), 'error');
    }

    foreach (array_keys($this->getSupportedModes()) as $mode) {
      $form[$mode] = [
        '#type' => 'fieldset',
        '#collapsible' => FALSE,
        '#collapsed' => FALSE,
        '#title' => $this->t('@mode location', ['@mode' => $this->pluginDefinition['modes'][$mode]]),
      ];
      $form[$mode][$mode . '_location_id'] = [
        '#type' => 'select',
        '#title' => $this->t('Location'),
        '#description' => $this->t('The location for the transactions.'),
        '#default_value' => $this->configuration[$mode . '_location_id'],
        '#required' => TRUE,
      ];

      $api_mode = ($mode == 'test') ? 'sandbox' : 'production';
      $access_token = $this->connect->getAccessToken($api_mode);
      if (!empty($access_token)) {
        $square_api_config = new Configuration();
        $square_api_config->setAccessToken($access_token);
        $location_api = new LocationsApi(new ApiClient($square_api_config));
        try {
          $locations = $location_api->listLocations();
          if (!empty($locations)) {
            $location_options = $locations->getLocations();
            $options = [];
            foreach ($location_options as $location_option) {
              $options[$location_option->getId()] = $location_option->getName();
            }
            $form[$mode][$mode . '_location_id']['#options'] = $options;
          }
        }
        catch (\Exception $e) {
          drupal_set_message($e->getMessage(), 'error');
        }
      }
      else {
        $form[$mode][$mode . '_location_id']['#disabled'] = TRUE;
        $form[$mode][$mode . '_location_id']['#options'] = ['_none' => 'Not configured'];
      }

    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::validateConfigurationForm($form, $form_state);
    $values = $form_state->getValue($form['#parents']);
    $mode = $values['mode'];
    if (empty($values[$mode][$mode . '_location_id'])) {
      $form_state->setError($form[$mode][$mode . '_location_id'], $this->t('You must select a location for the configured mode.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);
    $values = $form_state->getValue($form['#parents']);
    foreach (array_keys($this->getSupportedModes()) as $mode) {
      $this->configuration[$mode . '_location_id'] = $values[$mode][$mode . '_location_id'];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getApiClient() {
    $api_mode = ($this->getMode() == 'test') ? 'sandbox' : 'production';
    return $this->connect->getClient($api_mode);
  }

  /**
   * {@inheritdoc}
   */
  public function createPayment(PaymentInterface $payment, $capture = TRUE) {
    $this->assertPaymentState($payment, ['new']);
    $payment_method = $payment->getPaymentMethod();
    $this->assertPaymentMethod($payment_method);

    $paid_amount = $payment->getAmount();
    $rounder = \Drupal::getContainer()->get('commerce_price.rounder');
    /** @var \Drupal\commerce_price\Price $paid_amount */
    $paid_amount = $rounder->round($paid_amount);
    $currency = $paid_amount->getCurrencyCode();

    // Square only accepts integers and not floats.
    // @see https://docs.connect.squareup.com/api/connect/v2/#workingwithmonetaryamounts
    $square_total_amount = $this->toMinorUnits($paid_amount);

    $billing = $payment_method->getBillingProfile();
    /** @var \Drupal\address\Plugin\Field\FieldType\AddressItem $address */
    $address = $billing->get('address')->first();

    $mode = $this->getMode();
    $order_request = new SquareOrder();
    $order_request->setReferenceId($payment->getOrderId());
    $order_request->setLocationId($this->configuration[$mode . '_location_id']);

    $line_items = [];
    $line_item_total = 0;
    foreach ($payment->getOrder()->getItems() as $item) {
      $line_item = new OrderLineItem();

      $base_price_money = new Money();
      $square_amount = $this->toMinorUnits($rounder->round($item->getUnitPrice()));
      $base_price_money->setAmount($square_amount);
      $base_price_money->setCurrency($currency);
      $line_item->setBasePriceMoney($base_price_money);

      $total_money = new Money();
      $square_amount = $this->toMinorUnits($rounder->round($item->getTotalPrice()));
      $total_money->setAmount($square_amount);
      $total_money->setCurrency($currency);
      $line_item->setTotalMoney($total_money);

      $line_item->setName($item->getTitle());
      // Quantity needs to be a string integer.
      $line_item->setQuantity((string) (int) $item->getQuantity());
      $line_item_total += $square_amount;
      $line_items[] = $line_item;
    }
    // Square requires the order total to match the payment amount.
    if ($line_item_total != $square_total_amount) {
      $diff = $square_total_amount - $line_item_total;
      if ($diff < 0) {
        $discount_money = new Money();
        $discount_money->setCurrency($currency);
        $discount_money->setAmount(- $diff);

        $discount = new CreateOrderRequestDiscount();
        $discount->setAmountMoney($discount_money);
        $discount->setName('Adjustments');
      }
      else {
        $line_item = new OrderLineItem();
        $total_money = new Money();

        $total_money->setAmount((int) $diff);
        $total_money->setCurrency($currency);

        $line_item->setBasePriceMoney($total_money);
        $line_item->setTotalMoney($total_money);
        $line_item->setName('Adjustments');
        $line_item->setQuantity("1");
        $line_items[] = $line_item;
      }
    }
    $order_request->setLineItems($line_items);

    $charge_request = new ChargeRequest();
    $charge_request->setAmountMoney(new Money([
      'amount' => $square_total_amount,
      'currency' => $currency,
    ]));
    $charge_request->offsetSet('integration_id', 'sqi_b6ff0cd7acc14f7ab24200041d066ba6');
    $charge_request->setDelayCapture(!$capture);
    $charge_request->setCardNonce($payment_method->getRemoteId());
    $charge_request->setIdempotencyKey(uniqid());
    $charge_request->setBuyerEmailAddress($payment->getOrder()->getEmail());
    $charge_request->setBillingAddress(new Address([
      'address_line_1' => $address->getAddressLine1(),
      'address_line_2' => $address->getAddressLine2(),
      'locality' => $address->getLocality(),
      'sublocality' => $address->getDependentLocality(),
      'administrative_district_level_1' => $address->getAdministrativeArea(),
      'postal_code' => $address->getPostalCode(),
      'country' => $address->getCountryCode(),
      'first_name' => $address->getGivenName(),
      'last_name' => $address->getFamilyName(),
      'organization' => $address->getOrganization(),
    ]));

    // Since the SDK does not support `integration_id`, we must call it direct.
    try {
      $api_client = $this->getApiClient();
      $queryParams = [];
      $headerParams = [];
      $headerParams['Accept'] = ApiClient::selectHeaderAccept(['application/json']);
      $headerParams['Content-Type'] = ApiClient::selectHeaderContentType(['application/json']);
      $headerParams['Authorization'] = $api_client->getSerializer()->toHeaderValue($api_client->getConfig()->getAccessToken());

      // Create order.
      $resourcePath = '/v2/locations/{location_id}/orders';
      $resourcePath = str_replace(
        '{location_id}',
        $api_client->getSerializer()->toPathValue($this->configuration[$mode . '_location_id']),
        $resourcePath
      );
      $order_request = $order_request->__toString();
      $order_request = json_decode($order_request, TRUE);
      $order_request['idempotency_key'] =  uniqid($payment->getOrderId() . '-');
      if (isset($discount)) {
        $discount_array = json_decode($discount->__toString(), TRUE);
        $order_request['discounts'] = [$discount_array];
      }
      $order_request = json_encode($order_request, JSON_PRETTY_PRINT);
      try {
        list($response, $statusCode, $httpHeader) = $api_client->callApi(
          $resourcePath, 'POST',
          $queryParams, $order_request,
          $headerParams, '\SquareConnect\Model\CreateOrderResponse'
        );
        // Link the transaction to this order.
        $charge_request->setOrderId($response->order->id);
        if (!$response) {
          return [NULL, $statusCode, $httpHeader];
        }

        /** @var \SquareConnect\Model\CreateOrderResponse $result */
        $result = ObjectSerializer::deserialize($response, '\SquareConnect\Model\CreateOrderResponse', $httpHeader);
      }
      catch (ApiException $e) {
        switch ($e->getCode()) {
          case 200:
            $data = ObjectSerializer::deserialize($e->getResponseBody(), '\SquareConnect\Model\CreateOrderResponse', $e->getResponseHeaders());
            $e->setResponseObject($data);
            break;
        }
        throw $e;
      }

      // Create transaction.
      $resourcePath = '/v2/locations/{location_id}/transactions';
      $resourcePath = str_replace(
        '{location_id}',
        $api_client->getSerializer()->toPathValue($this->configuration[$mode . '_location_id']),
        $resourcePath
      );

      $charge_request = $charge_request->__toString();
      // The `integration_id` is only valid when live.
      if ($mode == 'live') {
        $charge_request = json_decode($charge_request, TRUE);
        $charge_request['integration_id'] = 'sqi_b6ff0cd7acc14f7ab24200041d066ba6';
        $charge_request = json_encode($charge_request, JSON_PRETTY_PRINT);
      }

      try {
        list($response, $statusCode, $httpHeader) = $api_client->callApi(
          $resourcePath, 'POST',
          $queryParams, $charge_request,
          $headerParams, '\SquareConnect\Model\ChargeResponse'
        );
        if (!$response) {
          return [NULL, $statusCode, $httpHeader];
        }

        /** @var \SquareConnect\Model\ChargeResponse $result */
        $result = ObjectSerializer::deserialize($response, '\SquareConnect\Model\ChargeResponse', $httpHeader);
      }
      catch (ApiException $e) {
        switch ($e->getCode()) {
          case 200:
            $data = ObjectSerializer::deserialize($e->getResponseBody(), '\SquareConnect\Model\ChargeResponse', $e->getResponseHeaders());
            $e->setResponseObject($data);
            break;
        }

        throw $e;
      }

      // @todo Use once SDK supports `integration_id`
      // $result = $this->transactionApi->charge(
      // $this->configuration[$mode . '_access_token'],
      // $this->configuration[$mode . '_location_id'],
      // $charge_request
      // );
      // if ($result->getErrors()) { }
    }
    catch (ApiException $e) {
      throw ErrorHelper::convertException($e);
    }

    $transaction = $result->getTransaction();
    $tender = $transaction->getTenders()[0];

    $next_state = $capture ? 'completed' : 'authorization';
    $payment->setState($next_state);
    $payment->setRemoteId($transaction->getId() . '|' . $tender->getId());
    $payment->setAuthorizedTime($transaction->getCreatedAt());
    if ($capture) {
      $payment->setCompletedTime($result->getTransaction()->getCreatedAt());
    }
    else {
      $expires = $this->time->getRequestTime() + (3600 * 24 * 6) - 5;
      $payment->setExpiresTime($expires);
    }
    $payment->save();
  }

  /**
   * {@inheritdoc}
   */
  public function createPaymentMethod(PaymentMethodInterface $payment_method, array $payment_details) {
    $required_keys = [
      'payment_method_nonce', 'card_type', 'last4',
    ];
    foreach ($required_keys as $required_key) {
      if (empty($payment_details[$required_key])) {
        throw new \InvalidArgumentException(sprintf('$payment_details must contain the %s key.', $required_key));
      }
    }

    // @todo Make payment methods reusable. Currently they represent 24hr nonce.
    // @see https://docs.connect.squareup.com/articles/processing-recurring-payments-ruby
    // Meet specific requirements for reusable, permanent methods.
    $payment_method->setReusable(FALSE);
    $payment_method->card_type = $this->mapCreditCardType($payment_details['card_type']);
    $payment_method->card_number = $payment_details['last4'];
    $payment_method->card_exp_month = $payment_details['exp_month'];
    $payment_method->card_exp_year = $payment_details['exp_year'];
    $remote_id = $payment_details['payment_method_nonce'];
    $payment_method->setRemoteId($remote_id);

    // Nonces expire after 24h. We reduce that time by 5s to account for the
    // time it took to do the server request after the JS tokenization.
    $expires = $this->time->getRequestTime() + (3600 * 24) - 5;
    $payment_method->setExpiresTime($expires);
    $payment_method->save();
  }

  /**
   * {@inheritdoc}
   */
  public function deletePaymentMethod(PaymentMethodInterface $payment_method) {
    // @todo Currently there are no remote records stored.
    // Delete the local entity.
    $payment_method->delete();
  }

  /**
   * {@inheritdoc}
   */
  public function capturePayment(PaymentInterface $payment, Price $amount = NULL) {
    $this->assertPaymentState($payment, ['authorization']);

    $amount = $amount ?: $payment->getAmount();
    // Square only accepts integers and not floats.
    // @see https://docs.connect.squareup.com/api/connect/v2/#workingwithmonetaryamounts
    list($transaction_id, $tender_id) = explode('|', $payment->getRemoteId());

    $mode = $this->getMode();
    try {
      $transaction_api = new TransactionsApi($this->getApiClient());
      $result = $transaction_api->captureTransaction(
        $this->configuration[$mode . '_location_id'],
        $transaction_id
      );
    }
    catch (ApiException $e) {
      throw ErrorHelper::convertException($e);
    }

    $payment->setState('completed');
    $payment->setAmount($amount);
    $payment->setCompletedTime($this->time->getRequestTime());
    $payment->save();

  }

  /**
   * {@inheritdoc}
   */
  public function voidPayment(PaymentInterface $payment) {
    $this->assertPaymentState($payment, ['authorization']);

    list($transaction_id, $tender_id) = explode('|', $payment->getRemoteId());
    $mode = $this->getMode();
    try {
      $transaction_api = new TransactionsApi($this->getApiClient());
      $result = $transaction_api->voidTransaction(
        $this->configuration[$mode . '_location_id'],
        $transaction_id
      );
    }
    catch (ApiException $e) {
      throw ErrorHelper::convertException($e);
    }
    $payment->setState('authorization_voided');
    $payment->save();
  }

  /**
   * {@inheritdoc}
   */
  public function refundPayment(PaymentInterface $payment, Price $amount = NULL) {
    $this->assertPaymentState($payment, ['completed', 'partially_refunded']);

    $amount = $amount ?: $payment->getAmount();
    // Square only accepts integers and not floats.
    // @see https://docs.connect.squareup.com/api/connect/v2/#workingwithmonetaryamounts
    $square_amount = $this->toMinorUnits($amount);

    list($transaction_id, $tender_id) = explode('|', $payment->getRemoteId());
    $refund_request = new CreateRefundRequest([
      'idempotency_key' => uniqid(),
      'tender_id' => $tender_id,
      'amount_money' => new Money([
        'amount' => $square_amount,
        'currency' => $amount->getCurrencyCode(),
      ]),
      'reason' => (string) $this->t('Refunded through store backend'),
    ]);

    $mode = $this->getMode();
    try {
      $transaction_api = new TransactionsApi($this->getApiClient());
      $result = $transaction_api->createRefund(
        $this->configuration[$mode . '_location_id'],
        $transaction_id,
        $refund_request
      );
    }
    catch (ApiException $e) {
      throw ErrorHelper::convertException($e);
    }

    $old_refunded_amount = $payment->getRefundedAmount();
    $new_refunded_amount = $old_refunded_amount->add($amount);
    if ($new_refunded_amount->lessThan($payment->getAmount())) {
      $payment->setState('partially_refunded');
    }
    else {
      $payment->setState('refunded');
    }


    $payment->setRefundedAmount($new_refunded_amount);
    $payment->save();
  }

  /**
   * Maps the Square credit card type to a Commerce credit card type.
   *
   * @param string $card_type
   *   The Square credit card type.
   *
   * @return string
   *   The Commerce credit card type.
   */
  protected function mapCreditCardType($card_type) {
    $map = [
      'AMERICAN_EXPRESS' => 'amex',
      'CHINA_UNIONPAY' => 'unionpay',
      'DISCOVER_DINERS' => 'dinersclub',
      'DISCOVER' => 'discover',
      'JCB' => 'jcb',
      'MASTERCARD' => 'mastercard',
      'VISA' => 'visa',
    ];
    if (!isset($map[$card_type])) {
      throw new HardDeclineException(sprintf('Unsupported credit card type "%s".', $card_type));
    }

    return $map[$card_type];
  }

}
