<?php

namespace Drupal\commerce_paypal\Plugin\Commerce\PaymentGateway;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_payment\Entity\PaymentInterface;
use Drupal\commerce_payment\Exception\HardDeclineException;
use Drupal\commerce_payment\Exception\PaymentGatewayException;
use Drupal\commerce_payment\PaymentMethodTypeManager;
use Drupal\commerce_payment\PaymentTypeManager;
use Drupal\commerce_payment\Plugin\Commerce\PaymentGateway\OffsitePaymentGatewayBase;
use Drupal\commerce_paypal\CheckoutSdkFactoryInterface;
use Drupal\commerce_price\Calculator;
use Drupal\commerce_price\Price;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\profile\Entity\ProfileInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Provides the PayPal Checkout payment gateway.
 *
 * @CommercePaymentGateway(
 *   id = "paypal_checkout",
 *   label = @Translation("PayPal Checkout [Preferred]"),
 *   display_label = @Translation("PayPal"),
 *   modes = {
 *     "test" = @Translation("Sandbox"),
 *     "live" = @Translation("Live"),
 *   },
 *   forms = {
 *     "offsite-payment" = "Drupal\commerce_paypal\PluginForm\Checkout\PaymentOffsiteForm",
 *   },
 *   credit_card_types = {
 *     "amex", "discover", "mastercard", "visa",
 *   },
 *   payment_type = "paypal_checkout",
 *   requires_billing_information = FALSE,
 * )
 */
class Checkout extends OffsitePaymentGatewayBase implements CheckoutInterface {

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * The PayPal Checkout SDK factory.
   *
   * @var \Drupal\commerce_paypal\CheckoutSdkFactoryInterface
   */
  protected $checkoutSdkFactory;

  /**
   * The logger.
   *
   * @var \Psr\Log\LoggerInterface $logger
   */
  protected $logger;

  /**
   * Constructs a new Checkout object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\commerce_payment\PaymentTypeManager $payment_type_manager
   *   The payment type manager.
   * @param \Drupal\commerce_payment\PaymentMethodTypeManager $payment_method_type_manager
   *   The payment method type manager.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   * @param \Drupal\commerce_paypal\CheckoutSdkFactoryInterface $checkout_sdk_factory
   *   The PayPal Checkout SDK factory.
   * @param \Psr\Log\LoggerInterface $logger
   *   The logger.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, PaymentTypeManager $payment_type_manager, PaymentMethodTypeManager $payment_method_type_manager, TimeInterface $time, ModuleHandlerInterface $module_handler, CheckoutSdkFactoryInterface $checkout_sdk_factory, LoggerInterface $logger) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $entity_type_manager, $payment_type_manager, $payment_method_type_manager, $time);
    $this->moduleHandler = $module_handler;
    // Don't instantiate the client from there to be able to test the
    // connectivity after updating the client_id & secret.
    $this->checkoutSdkFactory = $checkout_sdk_factory;
    $this->logger = $logger;
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
      $container->get('module_handler'),
      $container->get('commerce_paypal.checkout_sdk_factory'),
      $container->get('logger.channel.commerce_paypal')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'client_id' => '',
      'secret' => '',
      'intent' => 'capture',
      'disable_funding' => [],
      'disable_card' => [],
      'shipping_preference' => 'get_from_file',
      'update_billing_profile' => TRUE,
      'update_shipping_profile' => TRUE,
      'style' => [],
      'enable_on_cart' => TRUE,
      'collect_billing_information' => FALSE,
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $documentation_url = Url::fromUri('https://www.drupal.org/node/3042053')->toString();
    $form['credentials'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('API Credentials'),
      '#tree' => FALSE,
    ];
    $form['credentials']['help'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#attributes' => [
        'class' => ['form-item'],
      ],
      '#value' => $this->t('Refer to the <a href=":url" target="_blank">module documentation</a> to find your API credentials.', [':url' => $documentation_url]),
    ];
    $form['credentials']['client_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client ID'),
      '#default_value' => $this->configuration['client_id'],
      '#maxlength' => 255,
      '#required' => TRUE,
      '#parents' => array_merge($form['#parents'], ['client_id']),
    ];
    $form['credentials']['secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Secret'),
      '#maxlength' => 255,
      '#default_value' => $this->configuration['secret'],
      '#required' => TRUE,
      '#parents' => array_merge($form['#parents'], ['secret']),
    ];
    $form['intent'] = [
      '#type' => 'radios',
      '#title' => $this->t('Transaction type'),
      '#options' => [
        'capture' => $this->t("Capture (capture payment immediately after customer's approval)"),
        'authorize' => $this->t('Authorize (requires manual or automated capture after checkout)'),
      ],
      '#description' => $this->t('For more information on capturing a prior authorization, please refer to <a href=":url" target="_blank">Capture an authorization</a>.', [':url' => 'https://docs.drupalcommerce.org/commerce2/user-guide/payments/capture']),
      '#default_value' => $this->configuration['intent'],
    ];
    $form['disable_funding'] = [
      '#title' => $this->t('Disable funding sources'),
      '#description' => $this->t('The disabled funding sources for the transaction. Any funding sources passed are not displayed in the Smart payment Buttons. By default, funding source eligibility is smartly decided based on a variety of factors.'),
      '#type' => 'checkboxes',
      '#options' => [
        'card' => $this->t('Credit or Debit Cards'),
        'credit' => $this->t('PayPal Credit'),
        'sepa' => $this->t('SEPA-Lastschrift'),
      ],
      '#default_value' => $this->configuration['disable_funding'],
    ];
    $form['disable_card'] = [
      '#title' => $this->t('Disable card types'),
      '#description' => $this->t('The disabled cards for the transaction. Any cards passed do not display in the Smart payment Buttons. By default, card eligibility is smartly decided based on a variety of factors.'),
      '#type' => 'checkboxes',
      '#options' => [
        'visa' => $this->t('Visa'),
        'mastercard' => $this->t('Mastercard'),
        'amex' => $this->t('American Express'),
        'discover' => $this->t('Discover'),
        'jcb' => $this->t('JCB'),
        'elo' => $this->t('Elo'),
        'hiper' => $this->t('Hiper'),
      ],
      '#default_value' => $this->configuration['disable_card'],
    ];
    $shipping_enabled = $this->moduleHandler->moduleExists('commerce_shipping');
    $form['shipping_preference'] = [
      '#type' => 'radios',
      '#title' => $this->t('Shipping address collection'),
      '#options' => [
        'no_shipping' => $this->t('Do not ask for a shipping address at PayPal.'),
        'get_from_file' => $this->t('Ask for a shipping address at PayPal even if the order already has one.'),
        'set_provided_address' => $this->t('Ask for a shipping address at PayPal if the order does not have one yet.'),
      ],
      '#default_value' => $this->configuration['shipping_preference'],
      '#access' => $shipping_enabled,
    ];
    $form['update_billing_profile'] = [
      '#type' => 'checkbox',
      '#title' => t('Update the billing customer profile with address information the customer enters at PayPal.'),
      '#default_value' => $this->configuration['update_billing_profile'],
    ];
    $form['update_shipping_profile'] = [
      '#type' => 'checkbox',
      '#title' => t('Update shipping customer profiles with address information the customer enters at PayPal.'),
      '#default_value' => $this->configuration['update_shipping_profile'],
      '#access' => $shipping_enabled,
    ];
    $form['customize_buttons'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Smart button style'),
      '#default_value' => !empty($this->configuration['style']),
      '#title_display' => 'before',
      '#field_suffix' => $this->t('Customize'),
      '#description_display' => 'before',
    ];
    $form['style'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Settings'),
      '#description' => $this->t('For more information, please visit <a href=":url" target="_blank">customize the PayPal buttons</a>.', [':url' => 'https://developer.paypal.com/docs/checkout/integration-features/customize-button/#layout']),
      '#states' => [
        'visible' => [
          ':input[name="configuration[' . $this->pluginId . '][customize_buttons]"]' => ['checked' => TRUE],
        ],
      ],
    ];
    // Define some default values for the style configuration.
    $this->configuration['style'] += [
      'layout' => 'vertical',
      'color' => 'gold',
      'shape' => 'rect',
      'label' => 'paypal',
      'tagline' => FALSE,
    ];
    $form['style']['layout'] = [
      '#type' => 'select',
      '#title' => $this->t('Layout'),
      '#default_value' => $this->configuration['style']['layout'],
      '#options' => [
        'vertical' => $this->t('Vertical (Recommended)'),
        'horizontal' => $this->t('Horizontal'),
      ],
    ];
    $form['style']['color'] = [
      '#type' => 'select',
      '#title' => $this->t('Color'),
      '#options' => [
        'gold' => $this->t('Gold (Recommended)'),
        'blue' => $this->t('Blue'),
        'silver' => $this->t('Silver'),
      ],
      '#default_value' => $this->configuration['style']['color'],
    ];
    $form['style']['shape'] = [
      '#type' => 'select',
      '#title' => $this->t('Shape'),
      '#options' => [
        'rect' => $this->t('Rect (Default)'),
        'pill' => $this->t('Pill'),
      ],
      '#default_value' => $this->configuration['style']['shape'],
    ];
    $form['style']['label'] = [
      '#type' => 'select',
      '#title' => $this->t('Label'),
      '#options' => [
        'paypal' => $this->t('Displays the PayPal logo (Default)'),
        'checkout' => $this->t('Displays the PayPal Checkout button'),
        'pay' => $this->t('Displays the Pay With PayPal button and initializes the checkout flow'),
      ],
      '#default_value' => $this->configuration['style']['label'],
    ];
    $form['style']['tagline'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Display tagline'),
      '#default_value' => $this->configuration['style']['tagline'],
      '#states' => [
        'visible' => [
          ':input[name="configuration[' . $this->pluginId . '][style][layout]"]' => ['value' => 'horizontal'],
        ],
      ],
    ];
    $form['enable_on_cart'] = [
      '#type' => 'checkbox',
      '#title' => t('Show the Smart payment buttons on the cart page.'),
      '#default_value' => $this->configuration['enable_on_cart'],
    ];
    $form['collect_billing_information']['#description'] = $this->t('When disabled, PayPal will collect the billing information instead, in the opened modal.');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::validateConfigurationForm($form, $form_state);
    if ($form_state->getErrors()) {
      return;
    }
    $values = $form_state->getValue($form['#parents']);
    if (empty($values['client_id']) || empty($values['secret'])) {
      return;
    }
    $sdk = $this->checkoutSdkFactory->get($values);
    // Make sure we query for a fresh access token.
    \Drupal::state()->delete('commerce_paypal.oauth2_token');
    try {
      $sdk->getAccessToken();
      $this->messenger()->addMessage($this->t('Connectivity to PayPal successfully verified.'));
    }
    catch (ClientException $exception) {
      $this->messenger()->addError($this->t('Invalid client_id or secret specified.'));
      $form_state->setError($form['credentials']['client_id']);
      $form_state->setError($form['credentials']['secret']);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);
    if ($form_state->getErrors()) {
      return;
    }
    $values = $form_state->getValue($form['#parents']);
    $values['disable_funding'] = array_filter($values['disable_funding']);
    $values['disable_card'] = array_filter($values['disable_card']);
    $keys = [
      'client_id',
      'secret',
      'intent',
      'disable_funding',
      'disable_card',
      'shipping_preference',
      'update_billing_profile',
      'update_shipping_profile',
      'enable_on_cart',
    ];

    // Only save the style settings if the customize buttons checkbox is checked.
    if (!empty($values['customize_buttons'])) {
      $keys[] = 'style';

      // Can't display the tagline if the layout configured is "vertical".
      if ($values['style']['layout'] === 'vertical') {
        $values['style']['tagline'] = FALSE;
      }
    }

    // When the "card" funding source is disabled, the "disable_card" setting
    // cannot be specified.
    if (isset($values['disable_funding']['card'])) {
      $values['disable_card'] = [];
    }

    foreach ($keys as $key) {
      if (!isset($values[$key])) {
        continue;
      }
      $this->configuration[$key] = $values[$key];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function createPayment(PaymentInterface $payment) {
    $sdk = $this->checkoutSdkFactory->get($this->configuration);
    $order = $payment->getOrder();
    $checkout_data = $order->getData('commerce_paypal_checkout');
    if (empty($checkout_data)) {
      throw new PaymentGatewayException('Cannot create the payment without the PayPal order ID.');
    }
    $remote_id = $checkout_data['remote_id'];
    $flow = $checkout_data['flow'];
    // When in the shortcut flow, we need to update the order in PayPal to
    // reflect the changes occurred since the payment was approved in PayPal.
    if ($flow === 'shortcut') {
      try {
        $sdk->updateOrder($remote_id, $order);
        $request = $sdk->getOrder($remote_id);
        $paypal_order = Json::decode($request->getBody()->getContents());
      }
      catch (ClientException $exception) {
        throw new PaymentGatewayException($exception->getMessage());
      }
      if (!in_array($paypal_order['status'], ['APPROVED', 'SAVED'])) {
        throw new PaymentGatewayException(sprintf('Wrong remote order status. Expected: "approved"|"saved", Actual: %s.', $paypal_order['status']));
      }
    }
    $intent = isset($checkout_data['intent']) ? $checkout_data['intent'] : $this->configuration['intent'];
    try {
      if ($intent == 'capture') {
        $response = $sdk->captureOrder($remote_id);
        $paypal_order = Json::decode($response->getBody()->getContents());
        $remote_payment = $paypal_order['purchase_units'][0]['payments']['captures'][0];
        $payment->setRemoteId($remote_payment['id']);
      }
      else {
        $response = $sdk->authorizeOrder($remote_id);
        $paypal_order = Json::decode($response->getBody()->getContents());
        $remote_payment = $paypal_order['purchase_units'][0]['payments']['authorizations'][0];

        if (isset($remote_payment['expiration_time'])) {
          $expiration = new \DateTime($remote_payment['expiration_time']);
          $payment->setExpiresTime($expiration->getTimestamp());
        }
      }
    }
    catch (ClientException $exception) {
      throw new PaymentGatewayException($exception->getMessage());
    }
    $remote_state = strtolower($remote_payment['status']);

    if (in_array($remote_state, ['denied', 'expired', 'declined'])) {
      throw new HardDeclineException(sprintf('Could not %s the payment for order %s. Remote payment state: %s', $intent, $order->id(), $remote_state));
    }
    $state = $this->mapPaymentState($intent, $remote_state);

    // If we couldn't find a state to map to, stop here.
    if (!$state) {
      $this->logger->debug('PayPal remote payment debug: <pre>@remote_payment</pre>', ['@remote_payment' => print_r($remote_payment, TRUE)]);
      throw new PaymentGatewayException(sprintf('The PayPal payment is in a state we cannot handle. Remote state: %s.', $remote_state));
    }

    $payment_amount = Price::fromArray([
      'number' => $remote_payment['amount']['value'],
      'currency_code' => $remote_payment['amount']['currency_code'],
    ]);
    $payment->setAmount($payment_amount);
    $payment->setState($state);
    $payment->setRemoteId($remote_payment['id']);
    $payment->setRemoteState($remote_state);
    $payment->save();
  }

  /**
   * {@inheritdoc}
   */
  public function capturePayment(PaymentInterface $payment, Price $amount = NULL) {
    $this->assertPaymentState($payment, ['authorization']);
    // If not specified, capture the entire amount.
    $amount = $amount ?: $payment->getAmount();
    $remote_id = $payment->getRemoteId();
    $params = [
      'amount' => [
        'value' => Calculator::trim($amount->getNumber()),
        'currency_code' => $amount->getCurrencyCode(),
      ],
    ];

    if ($amount->equals($payment->getAmount())) {
      $params['final_capture'] = TRUE;
    }

    try {
      $sdk = $this->checkoutSdkFactory->get($this->configuration);

      // If the payment was authorized more than 3 days ago, attempt to
      // reauthorize it.
      if (($this->time->getRequestTime() >= ($payment->getAuthorizedTime() + (86400 * 3))) && !$payment->isExpired()) {
        $sdk->reAuthorizePayment($remote_id, ['amount' => $params['amount']]);
      }

      $response = $sdk->capturePayment($remote_id, $params);
      $response = Json::decode($response->getBody()->getContents());
    }
    catch (ClientException $exception) {
      $this->logger->error($exception->getMessage());
      throw new PaymentGatewayException('An error occurred while capturing the authorized payment.');
    }
    $remote_state = strtolower($response['status']);
    $state = $this->mapPaymentState('capture', $remote_state);

    if (!$state) {
      throw new PaymentGatewayException('Unhandled payment state.');
    }
    $payment->setState('completed');
    $payment->setAmount($amount);
    $payment->setRemoteId($response['id']);
    $payment->setRemoteState($remote_state);
    $payment->save();
  }

  /**
   * {@inheritdoc}
   */
  public function voidPayment(PaymentInterface $payment) {
    $this->assertPaymentState($payment, ['authorization']);
    try {
      $sdk = $this->checkoutSdkFactory->get($this->configuration);
      $response = $sdk->voidPayment($payment->getRemoteId());
    }
    catch (ClientException $exception) {
      $this->logger->error($exception->getMessage());
      throw new PaymentGatewayException('An error occurred while voiding the payment.');
    }
    if ($response->getStatusCode() == Response::HTTP_NO_CONTENT) {
      $payment->setState('authorization_voided');
      $payment->save();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function refundPayment(PaymentInterface $payment, Price $amount = null) {
    $this->assertPaymentState($payment, ['completed', 'partially_refunded']);
    // If not specified, refund the entire amount.
    $amount = $amount ?: $payment->getAmount();
    $this->assertRefundAmount($payment, $amount);

    $old_refunded_amount = $payment->getRefundedAmount();
    $new_refunded_amount = $old_refunded_amount->add($amount);
    $params = [
      'amount' => [
        'value' => Calculator::trim($amount->getNumber()),
        'currency_code' => $amount->getCurrencyCode(),
      ],
    ];
    if ($new_refunded_amount->lessThan($payment->getAmount())) {
      $payment->setState('partially_refunded');
    }
    else {
      $payment->setState('refunded');
    }
    try {
      $sdk = $this->checkoutSdkFactory->get($this->configuration);
      $response = $sdk->refundPayment($payment->getRemoteId(), $params);
      $response = Json::decode($response->getBody()->getContents());
    }
    catch (ClientException $exception) {
      $this->logger->error($exception->getMessage());
      throw new PaymentGatewayException('An error occurred while refunding the payment.');
    }

    if (strtolower($response['status']) !== 'completed') {
      throw new PaymentGatewayException(sprintf('Invalid state returned by PayPal. Expected: ("%s"), Actual: ("%s").', 'COMPLETED', $response['status']));
    }
    $payment->setRemoteState($response['status']);
    $payment->setRefundedAmount($new_refunded_amount);
    $payment->save();
  }

  /**
   * {@inheritdoc}
   */
  public function onReturn(OrderInterface $order, Request $request) {
    $body = Json::decode($request->getContent());
    if (!isset($body['id']) || !isset($body['flow'])) {
      throw new PaymentGatewayException('Missing PayPal order ID or unknown flow.');
    }
    try {
      $sdk = $this->checkoutSdkFactory->get($this->configuration);
      $request = $sdk->getOrder($body['id']);
      $paypal_order = Json::decode($request->getBody()->getContents());
    }
    catch (ClientException $exception) {
      throw new PaymentGatewayException('Could not load the order from PayPal.');
    }
    $paypal_amount = $paypal_order['purchase_units'][0]['amount'];
    $paypal_total = Price::fromArray(['number' => $paypal_amount['value'], 'currency_code' => $paypal_amount['currency_code']]);

    // Make sure the order total matches the total we get from PayPal.
    if (!$paypal_total->equals($order->getTotalPrice())) {
      throw new PaymentGatewayException('The PayPal order total does not match the order total.');
    }
    if (!in_array($paypal_order['status'], ['APPROVED', 'SAVED'])) {
      throw new PaymentGatewayException(sprintf('Unexpected PayPal order status %s.', $paypal_order['status']));
    }
    $flow = $body['flow'];
    $order->setData('commerce_paypal_checkout', [
      'remote_id' => $paypal_order['id'],
      'flow' => $flow,
      'intent' => strtolower($paypal_order['intent']),
    ]);

    if (empty($order->getEmail())) {
      $order->setEmail($paypal_order['payer']['email_address']);
    }

    if ($this->configuration['update_billing_profile']) {
      $this->updateProfile($order, 'billing', $paypal_order);
    }
    if (!empty($this->configuration['update_shipping_profile']) && $order->hasField('shipments')) {
      $this->updateProfile($order, 'shipping', $paypal_order);
    }
    if ($flow == 'shortcut') {
      // Force the checkout flow to PayPal checkout which is the flow the module
      // defines for the "shortcut" flow.
      $order->set('checkout_flow', 'paypal_checkout');
      $order->set('checkout_step', NULL);
    }
    elseif ($flow == 'mark') {
      $payment_storage = $this->entityTypeManager->getStorage('commerce_payment');
      /** @var \Drupal\commerce_payment\Entity\PaymentInterface $payment */
      $payment = $payment_storage->create([
        'state' => 'new',
        'amount' => $order->getBalance(),
        'payment_gateway' => $this->entityId,
        'order_id' => $order->id(),
      ]);
      $this->createPayment($payment);
    }
  }

  /**
   * Map a PayPal payment state to a local one.
   *
   * @param string $type
   *   The payment type. One of "authorize" or "capture"
   * @param string $remote_state
   *   The PayPal remote payment state.
   *
   * @return string
   *   The corresponding local payment state.
   */
  protected function mapPaymentState($type, $remote_state) {
    $mapping = [
      'authorize' => [
        'created' => 'authorization',
        'pending' => 'pending',
        'voided' => 'authorization_voided',
        'expired' => 'authorization_expired',
      ],
      'capture' => [
        'completed' => 'completed',
        'pending' => 'pending',
        'partially_refunded' => 'partially_refunded',
      ],
    ];
    return isset($mapping[$type][$remote_state]) ? $mapping[$type][$remote_state] : '';
  }

  /**
   * Updates the profile of the given type using the response returned by PayPal.
   *
   * @param \Drupal\commerce_order\Entity\OrderInterface $order
   *   The order.
   * @param $type
   *   The type (billing|profile).
   * @param array $paypal_order
   *   The PayPal order.
   */
  protected function updateProfile(OrderInterface $order, $type, array $paypal_order) {
    if ($type == 'billing') {
      /** @var \Drupal\profile\Entity\ProfileInterface $profile */
      $profile = $order->getBillingProfile() ?: $this->buildCustomerProfile($order);
      $profile->address->given_name = $paypal_order['payer']['name']['given_name'];
      $profile->address->family_name =  $paypal_order['payer']['name']['surname'];
      if (isset($paypal_order['payer']['address'])) {
        $this->populateProfile($profile, $paypal_order['payer']['address']);
      }
      $profile->save();
      $order->setBillingProfile($profile);
    }
    elseif ($type == 'shipping' && !empty($paypal_order['purchase_units'][0]['shipping'])) {
      $shipping_info = $paypal_order['purchase_units'][0]['shipping'];
      $shipments = $order->shipments->referencedEntities();
      if (!$shipments) {
        /** @var \Drupal\commerce_shipping\PackerManagerInterface $packer_manager */
        $packer_manager = \Drupal::service('commerce_shipping.packer_manager');
        list($shipments) = $packer_manager->packToShipments($order, $this->buildCustomerProfile($order), $shipments);
      }
      /** @var \Drupal\commerce_shipping\Entity\ShipmentInterface $first_shipment */
      $first_shipment = $shipments[0];
      /** @var \Drupal\profile\Entity\ProfileInterface $profile */
      $profile = $first_shipment->getShippingProfile() ?: $this->buildCustomerProfile($order);

      // This is a hack but shipments with empty amounts is crashing other
      // contrib modules.
      // Ideally, we shouldn't have to pack the shipments ourselves...
      if (!$first_shipment->getAmount()) {
        $shipment_amount = Price::fromArray([
          'number' => 0,
          'currency_code' => $order->getTotalPrice()->getCurrencyCode(),
        ]);
        $first_shipment->setAmount($shipment_amount);
      }

      // We only get the full name from PayPal, so we need to "guess" the given
      // name and the family name.
      $names = explode(' ', $shipping_info['name']['full_name']);
      $given_name = array_shift($names);
      $family_name = implode(' ', $names);
      $profile->address->given_name = $given_name;
      $profile->address->family_name =  $family_name;
      if (!empty($shipping_info['address'])) {
        $this->populateProfile($profile, $shipping_info['address']);
      }
      $profile->save();
      $first_shipment->setShippingProfile($profile);
      $first_shipment->save();
      $order->set('shipments', $shipments);
    }
  }

  /**
   * Builds a customer profile, assigned to the order's owner.
   *
   * @param \Drupal\commerce_order\Entity\OrderInterface $order
   *   The order.
   *
   * @return \Drupal\profile\Entity\ProfileInterface
   *   The customer profile.
   */
  protected function buildCustomerProfile(OrderInterface $order) {
    return $this->entityTypeManager->getStorage('profile')->create([
      'uid' => $order->getCustomerId(),
      'type' => 'customer',
    ]);
  }

  /**
   * Populate the given profile with the given PayPal address.
   *
   * @param \Drupal\profile\Entity\ProfileInterface $profile
   *   The profile to populate.
   * @param array $address
   *   The PayPal address.
   */
  protected function populateProfile(ProfileInterface $profile, array $address) {
    // Map PayPal address keys to keys expected by AddressItem.
    $mapping = [
      'address_line_1' => 'address_line1',
      'address_line_2' => 'address_line2',
      'admin_area_1' => 'administrative_area',
      'admin_area_2' => 'locality',
      'postal_code' => 'postal_code',
      'country_code' => 'country_code',
    ];
    foreach ($address as $key => $value) {
      if (!isset($mapping[$key])) {
        continue;
      }
      // PayPal address fields have a higher maximum length than ours.
      $value = $key == 'country_code' ? $value : mb_substr($value, 0, 255);
      $profile->address->{$mapping[$key]} = $value;
    }
  }

}
