<?php

namespace Drupal\commerce_usps\Plugin\Commerce\ShippingMethod;

use Drupal\commerce_shipping\Entity\ShipmentInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the USPS international shipping method.
 *
 * @CommerceShippingMethod(
 *  id = "usps_international",
 *  label = @Translation("USPS International"),
 *  services = {
 *    "_1" = @translation("Priority Mail Express International"),
 *    "_2" = @translation("Priority Mail International"),
 *    "_9" = @translation("Priority Mail International Medium Flat Rate Box"),
 *    "_11" = @translation("Priority Mail International Large Flat Rate Box"),
 *    "_12" = @translation("USPS GXG Envelopes"),
 *    "_15" = @translation("First-Class Package International Service"),
 *    "_16" = @translation("Priority Mail International Small Flat Rate Box"),
 *    "_24" = @translation("Priority Mail International DVD Flat Rate priced box"),
 *    "_25" = @translation("Priority Mail International Large Video Flat Rate priced box"),
 *  }
 * )
 */
class USPSInternational extends USPSBase {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.commerce_package_type'),
      $container->get('commerce_usps.usps_rate_request_international')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function calculateRates(ShipmentInterface $shipment) {
    // Only attempt to collect rates if an address exists on the shipment.
    if ($shipment->getShippingProfile()->get('address')->isEmpty()) {
      return [];
    }

    // Do not attempt to collect rates for US addresses.
    if ($shipment->getShippingProfile()->get('address')->country_code == 'US') {
      return [];
    }

    // Make sure a package type is set on the shipment.
    $this->setPackageType($shipment);

    return $this->uspsRateService->getRates($shipment);
  }

}
