<?php

namespace Drupal\Tests\commerce_usps\Unit;

use Drupal\commerce_shipping\ShippingRate;
use Drupal\commerce_usps\USPSRateRequestInternational;
use Drupal\commerce_usps\USPSShipmentInternational;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class USPSRateRequestInternationalTest.
 *
 * @coversDefaultClass \Drupal\commerce_usps\USPSRateRequestInternational
 * @group commerce_usps
 */
class USPSRateRequestInternationalTest extends USPSUnitTestBase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Add the services to the config.
    $this->setConfig(['services' => [1, 2, 9]]);

    // Mock all the objects and set the config.
    $event_dispatcher = new EventDispatcher();
    $this->uspsShipment = new USPSShipmentInternational($event_dispatcher);
    $this->rateRequest = new USPSRateRequestInternational($this->uspsShipment, $event_dispatcher);
    $this->rateRequest->setConfig($this->getConfig());
  }

  /**
   * Tests getRates().
   *
   * @covers ::getRates
   * @covers ::buildRate
   * @covers ::setMode
   * @covers ::setShipment
   * @covers ::resolveRates
   */
  public function testGetRates() {
    $config = $this->getConfig();
    $shipment = $this->mockShipment(['unit' => 'lb'], ['unit' => 'in'], FALSE);

    // Fetch rates from the USPS api.
    $rates = $this->rateRequest->getRates($shipment);

    // Make sure the same number of rates requested
    // is returned.
    $this->assertEquals(count($config['services']), count($rates));

    /** @var \Drupal\commerce_shipping\ShippingRate $rate */
    foreach ($rates as $rate) {
      $this->assertInstanceOf(ShippingRate::class, $rate);
      $this->assertNotEmpty($rate->getAmount()->getNumber());
    }
  }

  /**
   * Test getRates() with commercial rate response.
   *
   * @throws \Exception
   */
  public function testCommercialRates() {
    $shipment = $this->mockShipment(['unit' => 'lb'], ['unit' => 'in'], FALSE);

    // Fetch a retail rate first.
    $config_update = [
      'services' => [1],
      'rate_options' => [
        'rate_class' => 'retail'
      ],
    ];
    $this->setConfig($config_update);
    $config = $this->getConfig();
    $this->uspsShipment->setConfig($config);
    $this->rateRequest->setConfig($config);
    $retail_rates = $this->rateRequest->getRates($shipment);

    // Then fetch a commercial rate for the same service.
    $config_update = [
      'services' => [1],
      'rate_options' => [
        'rate_class' => 'commercial_plus'
      ],
    ];

    $this->setConfig($config_update);
    $config = $this->getConfig();
    // Pass the config to the rate and shipment services.
    $this->uspsShipment->setConfig($config);
    $this->rateRequest->setConfig($config);
    $commercial_rates = $this->rateRequest->getRates($shipment);

    // Make sure both return rates.
    $this->assertEquals(count($retail_rates), count($commercial_rates));

    /** @var \Drupal\commerce_shipping\ShippingRate $rate */
    foreach ($commercial_rates as $delta => $commercial_rate) {
      // Ensure a commercial rate was returned.
      $this->assertNotEmpty($commercial_rate->getAmount()->getNumber());

      // Ensure the commercial rate is less than the retail rate.
      $this->assertLessThan($retail_rates[$delta]->getAmount()->getNumber(), $commercial_rate->getAmount()->getNumber());
    }

  }

  /**
   * Test package setup.
   *
   * @covers ::getPackages
   */
  public function testGetPackages() {
    $shipment = $this->mockShipment(['unit' => 'lb'], ['unit' => 'in'], FALSE);
    $this->rateRequest->setShipment($shipment);
    $packages = $this->rateRequest->getPackages();
    // TODO: Support multiple packages.
    /** @var \USPS\RatePackage $package */
    $package = reset($packages);
    $info = $package->getPackageInfo();
    $this->assertEquals(28806, $info['OriginZip']);
    $this->assertEquals('Great Britain and Northern Ireland', $info['Country']);
    $this->assertEquals(10, $info['Pounds']);
    $this->assertEquals(0, $info['Ounces']);
    $this->assertEquals('RECTANGULAR', $info['Container']);
    $this->assertEquals('REGULAR', $info['Size']);
    $this->assertEquals(3, $info['Width']);
    $this->assertEquals(10, $info['Length']);
    $this->assertEquals(10, $info['Height']);
    $this->assertEquals(0, $info['Girth']);
    $this->assertEquals("True", $info['Machinable']);
  }

}
