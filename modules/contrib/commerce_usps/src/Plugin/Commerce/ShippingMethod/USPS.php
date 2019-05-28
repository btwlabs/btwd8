<?php

namespace Drupal\commerce_usps\Plugin\Commerce\ShippingMethod;

use Drupal\commerce_shipping\Entity\ShipmentInterface;

/**
 * Provides the USPS shipping method.
 *
 * @CommerceShippingMethod(
 *  id = "usps",
 *  label = @Translation("USPS"),
 *  services = {
 *    "_1" = @translation("Priority Mail 2-Day"),
 *    "_2" = @translation("Priority Mail Express 2-Day Hold For Pickup"),
 *    "_3" = @translation("Priority Mail Express 2-Day"),
 *    "_4" = @translation("USPS Retail Ground"),
 *    "_6" = @translation("Media Mail Parcel"),
 *    "_7" = @translation("Library Mail Parcel"),
 *    "_13" = @translation("Priority Mail Express 2-Day Flat Rate Envelope"),
 *    "_16" = @translation("Priority Mail 2-Day Flat Rate Envelope"),
 *    "_17" = @translation("Priority Mail 2-Day Medium Flat Rate Box"),
 *    "_22" = @translation("Priority Mail 2-Day Large Flat Rate Box"),
 *    "_27" = @translation("Priority Mail Express 2-Day Flat Rate Envelope Hold For Pickup"),
 *    "_28" = @translation("Priority Mail 2-Day Small Flat Rate Box"),
 *    "_29" = @translation("Priority Mail 1-Day Padded Flat Rate Envelope"),
 *    "_30" = @translation("Priority Mail Express 2-Day Legal Flat Rate Envelope"),
 *    "_31" = @translation("Priority Mail Express 2-Day Legal Flat Rate Envelope Hold For Pickup"),
 *    "_38" = @translation("Priority Mail 2-Day Gift Card Flat Rate Envelope"),
 *    "_40" = @translation("Priority Mail 2-Day Window Flat Rate Envelope"),
 *    "_42" = @translation("Priority Mail 1-Day Small Flat Rate Envelope"),
 *    "_44" = @translation("Priority Mail 2-Day Legal Flat Rate Envelope"),
 *    "_62" = @translation("Priority Mail Express 2-Day Padded Flat Rate Envelope"),
 *    "_63" = @translation("Priority Mail Express 2-Day Padded Flat Rate Envelope Hold For Pickup"),
 *  }
 * )
 */
class USPS extends USPSBase {

  /**
   * {@inheritdoc}
   */
  public function calculateRates(ShipmentInterface $shipment) {
    // Only attempt to collect rates if an address exists on the shipment.
    if ($shipment->getShippingProfile()->get('address')->isEmpty()) {
      return [];
    }

    // Only attempt to collect rates for US addresses.
    if ($shipment->getShippingProfile()->get('address')->country_code != 'US') {
      return [];
    }

    // Make sure a package type is set on the shipment.
    $this->setPackageType($shipment);

    return $this->uspsRateService->getRates($shipment);
  }

}
