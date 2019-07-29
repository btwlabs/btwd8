<?php

namespace Drupal\commerce_usps;

use USPS\Address;
use USPS\RatePackage;

/**
 * Class that sets the shipment details needed for the USPS request.
 *
 * @package Drupal\commerce_usps
 */
class USPSShipment extends USPSShipmentBase implements USPSShipmentInterface {

  /**
   * Returns an initialized rate package object.
   *
   * @return \USPS\RatePackage
   *   The rate package entity.
   */
  public function buildPackage() {
    parent::buildPackage();

    $this->setService();
    $this->setShipFrom();
    $this->setShipTo();
    $this->setWeight();
    $this->setContainer();
    $this->setDimensions();
    $this->setPackageSize();
    $this->setExtraOptions();

    return $this->uspsPackage;
  }

  /**
   * Sets the ship to for a given shipment.
   */
  protected function setShipTo() {
    /** @var \CommerceGuys\Addressing\Address $address */
    $address = $this->commerceShipment->getShippingProfile()->get('address')->first();
    $to_address = new Address();
    $to_address->setAddress($address->getAddressLine1());
    $to_address->setApt($address->getAddressLine2());
    $to_address->setCity($address->getLocality());
    $to_address->setState($address->getAdministrativeArea());

    // Due to API limitations, only accept the first 5 digits of the Zip Code.
    $this->uspsPackage->setZipDestination(substr($address->getPostalCode(), 0, 5));
  }

  /**
   * Sets the ship from for a given shipment.
   */
  protected function setShipFrom() {
    /** @var \CommerceGuys\Addressing\Address $address */
    $address = $this->commerceShipment->getOrder()->getStore()->getAddress();
    $from_address = new Address();
    $from_address->setAddress($address->getAddressLine1());
    $from_address->setCity($address->getLocality());
    $from_address->setState($address->getAdministrativeArea());

    // Due to API limitations, only accept the first 5 digits of the Zip Code.
    $this->uspsPackage->setZipOrigination(substr($address->getPostalCode(), 0, 5));
  }

  /**
   * Sets the package size.
   */
  protected function setPackageSize() {
    $this->uspsPackage->setSize(RatePackage::SIZE_REGULAR);
  }

  /**
   * Sets the services for the shipment.
   */
  protected function setService() {
    $rate_class = RatePackage::SERVICE_ALL;

    // Determine if the shipping method uses a special
    // rate class.
    if (!empty($this->configuration['rate_options']['rate_class'])) {
      switch ($this->configuration['rate_options']['rate_class']) {
        case 'online':
        case 'commercial':
          $rate_class = RatePackage::SERVICE_ONLINE;
          break;
        case 'commercial_plus':
          $rate_class = 'PLUS';
          break;
      }
    }

    $this->uspsPackage->setService($rate_class);
  }

  /**
   * Sets the package container for the shipment.
   */
  protected function setContainer() {
    $this->uspsPackage->setContainer(RatePackage::CONTAINER_VARIABLE);
  }

  /**
   * Sets any extra options specific to the shipment like ship date etc.
   */
  protected function setExtraOptions() {
    $this->uspsPackage->setField('Machinable', TRUE);
    $this->uspsPackage->setField('ShipDate', $this->getProductionDate());
  }

  /**
   * Returns the current date.
   *
   * @return string
   *   The current date, formatted.
   */
  protected function getProductionDate() {
    $date = date('Y-m-d', strtotime("now"));

    return $date;
  }

}
