<?php

namespace Drupal\Tests\commerce_shipping\Kernel\Formatter;

use Drupal\commerce_shipping\Entity\Shipment;
use Drupal\commerce_shipping\Entity\ShippingMethod;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\Tests\commerce\Kernel\CommerceKernelTestBase;

/**
 * Tests the shipping method formatter.
 *
 * @coversDefaultClass \Drupal\commerce_shipping\Plugin\Field\FieldFormatter\ShippingMethodFormatter
 *
 * @group commerce_shipping
 */
class ShippingMethodFormatterTest extends CommerceKernelTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'entity_reference_revisions',
    'physical',
    'profile',
    'state_machine',
    'commerce_order',
    'commerce_product',
    'commerce_shipping',
    'commerce_shipping_test',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->installEntitySchema('profile');
    $this->installEntitySchema('commerce_order');
    $this->installEntitySchema('commerce_shipping_method');
    $this->installEntitySchema('commerce_shipment');
    $this->installConfig([
      'physical',
      'profile',
      'commerce_order',
      'commerce_shipping',
    ]);
  }

  /**
   * Tests the rendered output.
   *
   * @covers ::viewElements
   */
  public function testRender() {
    /** @var \Drupal\commerce_shipping\Entity\ShippingMethodInterface $shipping_method */
    $shipping_method = ShippingMethod::create([
      'name' => $this->randomString(),
      'status' => 1,
      'plugin' => [
        'target_plugin_id' => 'flat_rate',
        'target_plugin_configuration' => [
          'rate_label' => 'Test shipping',
          'rate_amount' => [
            'amount' => '10',
            'currency_code' => 'USD',
          ],
          'services' => [
            'default',
          ],
        ],
      ],
    ]);
    $shipping_method->save();

    $shipment = Shipment::create([
      'type' => 'default',
      // The order ID is invalid, but this test doesn't need to care about that.
      'order_id' => '6',
      'shipping_method' => $shipping_method->id(),
      'shipping_service' => 'default',
      'title' => 'Shipment #1',
      'state' => 'ready',
    ]);
    $shipment->save();

    $view_display = EntityViewDisplay::collectRenderDisplay($shipment, 'default');
    $build = $view_display->build($shipment);
    $this->render($build);
    $this->assertText('Shipping method');
    $this->assertText('Test shipping');

    // Confirm that deleting the shipping method doesn't crash the formatter.
    $shipping_method->delete();
    $shipment = $this->reloadEntity($shipment);
    $build = $view_display->build($shipment);
    $this->render($build);
    $this->assertNoText('Shipping method', $this->content);
    $this->assertNoText('Test shipping');
  }

}
