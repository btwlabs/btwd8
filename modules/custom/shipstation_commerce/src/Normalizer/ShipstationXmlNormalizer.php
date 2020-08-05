<?php

namespace Drupal\shipstation_commerce\Normalizer;

use Drupal\serialization\Normalizer\NormalizerBase;

/**
 * Converts the Drupal entity object structure to a HAL array structure.
 */
class ShipstationXmlNormalizer extends NormalizerBase {

  /**
   * The interface or class that this Normalizer supports.
   *
   * @var string
   */
  protected $supportedInterfaceOrClass = '\Drupal\shipstation_commerce\ShipstationData';

  /**
   * List of formats which supports (de-)normalization.
   *
   * @var string|string[]
   */
  protected $format = 'shipstation_xml';

  /**
   * {@inheritdoc}
   * @param \Drupal\shipstation_commerce\ShipstationData $data
   */
  public function normalize($data, $format = NULL, array $context = array()) {
    $normalized = [
      '@pages' => $data->getPages(),
      'Order' => [],
    ];
    foreach($data->getOrders() as $order) {
      /** @var $order \Drupal\commerce_order\Entity\Order */
      /** @var $first_shipment \Drupal\commerce_shipping\Entity\Shipment */
      $purchased_items = $order->get('shipments')->referencedEntities();
      $first_shipment = reset($purchased_items);
      // If there is no shipment then the order had no shipping.
      if (empty($first_shipment)) {
        continue;
      }
      /** @var $customer \Drupal\user\Entity\User */
      $customer = $order->getCustomer();

      /** @var $billing_profile \Drupal\profile\Entity\Profile */
      // If there is no billing profile then the order has not been paid.
      if (empty($billing_profile = $order->getBillingProfile())) {
        continue;
      }

      /** @var $shipping_profile \Drupal\profile\Entity\Profile */
      // If there is no shipping profile then the order had no shipping.
      if (empty($shipping_profile = $first_shipment->getShippingProfile())) {
        continue;
      }

      // Get a list of the order items.
      $items = (function($items, $order) {
        $itemList = [];
        // Go through the Items.
        foreach($items as $key => $item) {
          /** @var $item \Drupal\commerce_order\Entity\OrderItem */
          // If there is no purchased entity then we skip this item.
          if (!($purchased_entity = $item->getPurchasedEntity())) {
            \Drupal::logger('shipstation_error')->notice("Item index=$key had no purchased entity attached in order #{$order->id()} ");
            continue;
          }
          $listItem = [
            'SKU' => $item->getPurchasedEntity()->get('sku')->first()->getValue()['value'],
            'Name' => $item->getTitle(),
            'Quantity' => number_format($item->getQuantity(), 0),
            'UnitPrice' => number_format($item->getUnitPrice()->getNumber(), 2),
          ];
          if ($purchased_entity->hasField('weight')) {
            $listItem['Weight'] = (function($unit, $number) {
              // If for some reason the weight is in KG, need to convert to G.
              if ($unit == 'kg') {
                return $number * 1000;
              }
              return $number;
            })($item->getPurchasedEntity()->get('weight')->first()->getValue()['unit'], $item->getPurchasedEntity()->get('weight')->first()->getValue()['number']);
            $listItem['WeightUnits'] = (function($unit) {
              switch ($unit) {
                case 'g' :
                  return 'Grams';
                case 'lb' :
                  return 'Pounds';
                case 'kg' :
                  return 'Grams';
                case 'oz' :
                  return 'Ounces';
              }
            })($item->getPurchasedEntity()->get('weight')->first()->getValue()['unit']);
          }
          if (is_array($listItem)) {
            $itemList[] = $listItem;
          }
        }
        return $itemList;
      })($order->getItems(), $order);
      if (empty($items)) {
        continue;
      }

      $normalized['Order'][] = [
        'OrderID' => $order->id(),
        'OrderNumber' => $order->getOrderNumber(),
        'OrderDate' => date('m/d/Y H:m A', $order->getPlacedTime()),
        'OrderStatus' => $order->getState()->getLabel(),
        'LastModified' => date('m/d/Y H:m', $order->getChangedTime()),
        'ShippingMethod' => (!empty($first_shipment->getShippingMethod())) ? $first_shipment->getShippingMethod()->getName() : 'UNKNOWN',
        'OrderTotal' => number_format($order->getTotalPrice()->getNumber(), 2),
        'ShippingAmount' => number_format($this->getShippingPrice($order), 2),
        'Customer' => [
          'CustomerCode' => $customer->id(),
          'BillTo' => [
            'Name' => $billing_profile->get('address')->first()->getGivenName() . ' ' . $billing_profile->get('address')->first()->getFamilyName(),
            'Email' => $customer->getEmail(),
          ],
          'ShipTo' => [
            'Name' => $shipping_profile->get('address')->first()->getGivenName() . ' ' . $shipping_profile->get('address')->first()->getFamilyName(),
            'Address1' => $shipping_profile->get('address')->first()->getAddressLine1(),
            'City' => $shipping_profile->get('address')->first()->getLocality(),
            'State' => $shipping_profile->get('address')->first()->getAdministrativeArea(),
            'PostalCode' => $shipping_profile->get('address')->first()->getPostalCode(),
            'Country' => $shipping_profile->get('address')->first()->getCountryCode(),
          ],
        ],
        'Items' => [
          'Item' => $items,
        ]
      ];
    }
    return $normalized;
  }

  /**
   * @param $order \Drupal\commerce_order\Entity\Order
   */
  private function getShippingPrice($order) {
    /** @var $adjustment \Drupal\commerce_order\Adjustment */
    foreach($order->getAdjustments() as $adjustment) {
      if ($adjustment->getType() == 'shipping') {
        return $adjustment->getAmount()->getNumber();
      }
    }
  }

}
