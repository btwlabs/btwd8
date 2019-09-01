<?php

namespace Drupal\Tests\commerce_shipping\FunctionalJavascript;

use Drupal\commerce_order\Entity\Order;
use Drupal\commerce_order\Entity\OrderType;
use Drupal\commerce_price\Price;
use Drupal\commerce_product\Entity\ProductVariationType;
use Drupal\commerce_shipping\Entity\PackageType;
use Drupal\commerce_shipping\Entity\Shipment;
use Drupal\commerce_shipping\Entity\ShipmentType;
use Drupal\commerce_shipping\ShipmentItem;
use Drupal\Core\Url;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\physical\Weight;
use Drupal\profile\Entity\Profile;
use Drupal\profile\Entity\ProfileType;
use Drupal\Tests\commerce\FunctionalJavascript\CommerceWebDriverTestBase;
use Drupal\views\Entity\View;

/**
 * Tests the shipment admin UI.
 *
 * @group commerce_shipping
 */
class ShipmentAdminTest extends CommerceWebDriverTestBase {

  /**
   * The default profile's address.
   *
   * @var array
   */
  protected $defaultAddress = [
    'country_code' => 'US',
    'administrative_area' => 'SC',
    'locality' => 'Greenville',
    'postal_code' => '29616',
    'address_line1' => '9 Drupal Ave',
    'given_name' => 'Bryan',
    'family_name' => 'Centarro',
  ];

  /**
   * The default profile.
   *
   * @var \Drupal\profile\Entity\ProfileInterface
   */
  protected $defaultProfile;

  /**
   * A sample order.
   *
   * @var \Drupal\commerce_order\Entity\OrderInterface
   */
  protected $order;

  /**
   * The base admin shipment uri.
   *
   * @var string
   */
  protected $shipmentUri;

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'commerce_shipping_test',
    'telephone',
  ];

  /**
   * {@inheritdoc}
   */
  protected function getAdministratorPermissions() {
    return array_merge([
      'administer commerce_order',
      'administer commerce_shipment',
      'access commerce_order overview',
    ], parent::getAdministratorPermissions());
  }

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $product_variation_type = ProductVariationType::load('default');
    $product_variation_type->setTraits(['purchasable_entity_shippable']);
    $product_variation_type->setGenerateTitle(FALSE);
    $product_variation_type->save();

    $order_type = OrderType::load('default');
    $order_type->setThirdPartySetting('commerce_shipping', 'shipment_type', 'default');
    $order_type->save();

    // Create the order field.
    $field_definition = commerce_shipping_build_shipment_field_definition($order_type->id());
    \Drupal::service('commerce.configurable_field_manager')->createField($field_definition);

    // Install the variation trait.
    $trait_manager = \Drupal::service('plugin.manager.commerce_entity_trait');
    $trait = $trait_manager->createInstance('purchasable_entity_shippable');
    $trait_manager->installTrait($trait, 'commerce_product_variation', 'default');

    $variation = $this->createEntity('commerce_product_variation', [
      'title' => $this->randomMachineName(),
      'type' => 'default',
      'sku' => 'sku-' . $this->randomMachineName(),
      'price' => [
        'number' => '7.99',
        'currency_code' => 'USD',
      ],
    ]);
    $order_item = $this->createEntity('commerce_order_item', [
      'title' => $this->randomMachineName(),
      'type' => 'default',
      'quantity' => 1,
      'unit_price' => new Price('10', 'USD'),
      'purchased_entity' => $variation,
    ]);
    $order_item->save();
    $this->order = $this->createEntity('commerce_order', [
      'uid' => $this->loggedInUser->id(),
      'order_number' => '6',
      'type' => 'default',
      'state' => 'completed',
      'order_items' => [$order_item],
      'store_id' => $this->store,
    ]);
    $this->shipmentUri = Url::fromRoute('entity.commerce_shipment.collection', [
      'commerce_order' => $this->order->id(),
    ])->toString();

    /** @var \Drupal\commerce_shipping\Entity\PackageType $package_type */
    $package_type = $this->createEntity('commerce_package_type', [
      'id' => 'package_type_a',
      'label' => 'Package Type A',
      'dimensions' => [
        'length' => 20,
        'width' => 20,
        'height' => 20,
        'unit' => 'mm',

      ],
      'weight' => [
        'number' => 20,
        'unit' => 'g',
      ],
    ]);
    \Drupal::service('plugin.manager.commerce_package_type')->clearCachedDefinitions();

    $this->createEntity('commerce_shipping_method', [
      'name' => 'Overnight shipping',
      'stores' => [$this->store->id()],
      'plugin' => [
        'target_plugin_id' => 'flat_rate',
        'target_plugin_configuration' => [
          'default_package_type' => 'commerce_package_type:' . $package_type->get('uuid'),
          'rate_label' => 'Overnight shipping',
          'rate_amount' => [
            'number' => '19.99',
            'currency_code' => 'USD',
          ],
        ],
      ],
    ]);
    $this->createEntity('commerce_shipping_method', [
      'name' => 'Standard shipping',
      'stores' => [$this->store->id()],
      // Ensure that Standard shipping shows before overnight shipping.
      'weight' => -10,
      'plugin' => [
        'target_plugin_id' => 'flat_rate',
        'target_plugin_configuration' => [
          'rate_label' => 'Standard shipping',
          'rate_amount' => [
            'number' => '9.99',
            'currency_code' => 'USD',
          ],
        ],
      ],
    ]);

    // Create a different shipping profile type, which also has a Phone field.
    $bundle_entity_duplicator = $this->container->get('entity.bundle_entity_duplicator');
    $customer_profile_type = ProfileType::load('customer');
    $shipping_profile_type = $bundle_entity_duplicator->duplicate($customer_profile_type, [
      'id' => 'customer_shipping',
      'label' => 'Customer (Shipping)',
    ]);
    // Add a telephone field to the new profile type.
    $field_storage = FieldStorageConfig::create([
      'field_name' => 'field_phone',
      'entity_type' => 'profile',
      'type' => 'telephone',
    ]);
    $field_storage->save();
    $field = FieldConfig::create([
      'field_storage' => $field_storage,
      'bundle' => $shipping_profile_type->id(),
      'label' => 'Phone',
    ]);
    $field->save();
    $form_display = commerce_get_entity_display('profile', 'customer_shipping', 'form');
    $form_display->setComponent('field_phone', [
      'type' => 'telephone_default',
    ]);
    $form_display->save();
    $view_display = commerce_get_entity_display('profile', 'customer_shipping', 'view');
    $view_display->setComponent('field_phone', [
      'type' => 'basic_string',
    ]);
    $view_display->save();

    $shipment_type = ShipmentType::load('default');
    $shipment_type->setProfileTypeId('customer_shipping');
    $shipment_type->save();

    $this->defaultProfile = Profile::create([
      'type' => 'customer_shipping',
      'uid' => $this->adminUser,
      'address' => $this->defaultAddress,
      'field_phone' => '202-555-0108',
    ]);
    $this->defaultProfile->save();
  }

  /**
   * Tests that Shipments tab and operation visibility.
   */
  public function testShipmentTabAndOperation() {
    $this->drupalGet($this->order->toUrl());
    $this->assertSession()->linkExists('Shipments');
    $this->assertSession()->linkByHrefExists($this->shipmentUri);

    // Make the order type non shippable, and make sure the "Shipments" tab
    // doesn't show up.
    $order_type = OrderType::load('default');
    $order_type->unsetThirdPartySetting('commerce_shipping', 'shipment_type');
    $order_type->save();
    $this->drupalGet($this->order->toUrl());
    $this->assertSession()->linkNotExists('Shipments');
    $this->assertSession()->linkByHrefNotExists($this->shipmentUri);

    $order_type->setThirdPartySetting('commerce_shipping', 'shipment_type', 'default');
    $order_type->save();
    $this->drupalGet($this->order->toUrl());
    $this->assertSession()->linkExists('Shipments');
    // Ensure the "Shipments" operation is shown on the listing page.
    $this->drupalGet($this->order->toUrl('collection'));
    $this->assertSession()->linkByHrefExists($this->shipmentUri);
    $order_edit_link = $this->order->toUrl('edit-form')->toString();
    $this->assertSession()->linkByHrefExists($order_edit_link);

    // Make sure the "Shipments" tab isn't shown for cart orders.
    $this->order->set('cart', TRUE);
    $this->order->save();
    $this->drupalGet($this->order->toUrl());
    $this->assertSession()->linkNotExists('Shipments');
    // Ensure the "Shipments" operation is not shown on the cart listing page.
    $this->drupalGet($this->order->toUrl('collection'));
    // The order will have moved to the cart listing.
    $this->assertSession()->linkByHrefNotExists($order_edit_link);
    $this->clickLink('Carts');
    $this->assertSession()->linkByHrefExists($order_edit_link);
    $this->assertSession()->linkNotExists('Shipments');
    $this->assertSession()->linkByHrefNotExists($this->shipmentUri);
  }

  /**
   * Tests the Shipment add page.
   */
  public function testShipmentAddPage() {
    $this->drupalGet($this->shipmentUri);
    $page = $this->getSession()->getPage();
    $page->clickLink('Add shipment');
    $this->assertSession()->addressEquals($this->shipmentUri . '/add/default');

    $shipment_type = $this->createEntity('commerce_shipment_type', [
      'id' => 'foo',
      'label' => 'FOO',
    ]);
    $shipment_type->save();
    $order_type = OrderType::load('default');
    $order_type->setThirdPartySetting('commerce_shipping', 'shipment_type', 'foo');
    $order_type->save();
    $this->drupalGet($this->shipmentUri);
    $page = $this->getSession()->getPage();
    $page->clickLink('Add shipment');
    $this->assertSession()->addressEquals($this->shipmentUri . '/add/foo');
  }

  /**
   * Tests creating a shipment for an order.
   */
  public function testShipmentCreate() {
    $this->drupalGet($this->shipmentUri);
    $page = $this->getSession()->getPage();
    $page->clickLink('Add shipment');
    $this->assertSession()->addressEquals($this->shipmentUri . '/add/default');
    $this->assertTrue($page->hasSelect('package_type'));
    $this->assertSession()->optionExists('package_type', 'Custom box');
    $this->assertSession()->optionExists('package_type', 'Package Type A');
    $this->assertTrue($page->hasButton('Recalculate shipping'));
    $this->assertSession()->pageTextContains('Shipment items');
    $page->fillField('title[0][value]', 'Test shipment');
    list($order_item) = $this->order->getItems();
    $this->assertSession()->pageTextContains($order_item->label());
    $page->checkField('shipment_items[1]');

    $this->assertRenderedAddress($this->defaultAddress, 'shipping_profile[0][profile]');
    $this->assertSession()->pageTextContains('202-555-0108');
    $this->assertSession()->pageTextContains('Shipping method');
    $first_radio_button = $page->findField('Standard shipping: $9.99');
    $second_radio_button = $page->findField('Overnight shipping: $19.99');
    $this->assertNotNull($first_radio_button);
    $this->assertNotNull($second_radio_button);
    $this->assertTrue($first_radio_button->getAttribute('checked'));
    $page->findButton('Recalculate shipping')->click();
    $this->waitForAjaxToFinish();
    $this->submitForm([], 'Save');
    $this->assertSession()->addressEquals($this->shipmentUri);
    $this->assertSession()->pageTextContains(t('Shipment for order @order created.', ['@order' => $this->order->getOrderNumber()]));

    \Drupal::entityTypeManager()->getStorage('commerce_order')->resetCache([$this->order->id()]);
    $this->order = Order::load($this->order->id());
    /** @var \Drupal\commerce_shipping\Entity\ShipmentInterface $shipment */
    $shipment = Shipment::load(1);
    $this->assertEquals($this->order->id(), $shipment->getOrderId());
    $this->assertEquals('9.99', $shipment->getAmount()->getNumber());
    $this->assertSession()->pageTextContains($shipment->label());
    $shipping_profile = $shipment->getShippingProfile();
    $this->assertEquals('customer_shipping', $shipping_profile->bundle());
    $this->assertEquals('202-555-0108', $shipping_profile->get('field_phone')->value);
    $this->assertEquals($this->defaultAddress, array_filter($shipping_profile->get('address')->first()->toArray()));
    $this->assertEquals($this->defaultProfile->id(), $shipping_profile->getData('address_book_profile_id'));
    $this->assertSession()->pageTextContains('$9.99');
    $this->assertTrue($page->hasButton('Finalize shipment'));
    $this->assertTrue($page->hasButton('Cancel shipment'));

    $adjustments = $this->order->getAdjustments();
    $this->assertCount(1, $adjustments);
    $this->assertEquals($adjustments[0]->getAmount(), $shipment->getAmount());
  }

  /**
   * Tests editing a shipment.
   */
  public function testShipmentEdit() {
    $shipping_method = $this->createEntity('commerce_shipping_method', [
      'name' => 'The best shipping',
      'stores' => [$this->store->id()],
      'plugin' => [
        'target_plugin_id' => 'dynamic',
        'target_plugin_configuration' => [
          'rate_label' => 'The best shipping',
          'rate_amount' => [
            'number' => '9.99',
            'currency_code' => 'USD',
          ],
        ],
      ],
    ]);

    $address = [
      'country_code' => 'US',
      'postal_code' => '53177',
      'locality' => 'Milwaukee',
      'address_line1' => 'Pabst Blue Ribbon Dr',
      'administrative_area' => 'WI',
      'given_name' => 'Frederick',
      'family_name' => 'Pabst',
    ];
    $shipping_profile = Profile::create([
      'type' => 'customer_shipping',
      'uid' => 0,
      'address' => $address,
    ]);
    $shipping_profile->save();

    /** @var \Drupal\commerce_shipping\Entity\ShipmentInterface $shipment */
    $shipment = $this->createEntity('commerce_shipment', [
      'type' => 'default',
      'title' => 'Test shipment',
      'order_id' => $this->order->id(),
      'amount' => new Price('10', 'USD'),
      'items' => [
        new ShipmentItem([
          'order_item_id' => 1,
          'title' => 'Test shipment item label',
          'quantity' => 1,
          'weight' => new Weight(0, 'g'),
          'declared_value' => new Price('1', 'USD'),
        ]),
      ],
      'shipping_profile' => $shipping_profile,
    ]);
    /** @var \Drupal\commerce_shipping_test\Plugin\Commerce\ShippingMethod\DynamicRate $shipping_method_plugin */
    $shipping_method_plugin = \Drupal::service('plugin.manager.commerce_shipping_method')->createInstance('dynamic');
    $shipping_services = $shipping_method_plugin->getServices();
    $shipment
      ->setData('owned_by_packer', TRUE)
      ->setShippingMethod($shipping_method)
      ->setShippingService(key($shipping_services))
      ->save();
    $this->assertTrue($shipment->getAmount()->compareTo(new Price('9.99', 'USD')));

    // Edit the shipment.
    $this->drupalGet($this->shipmentUri);
    $session = $this->assertSession();
    $page = $this->getSession()->getPage();
    $page->clickLink('Edit');
    $session->addressEquals($this->shipmentUri . '/' . $shipment->id() . '/edit');
    $session->fieldValueEquals('title[0][value]', $shipment->label());
    $this->assertTrue($page->hasField($shipment->getItems()[0]->getTitle()));

    $this->assertRenderedAddress($address, 'shipping_profile[0][profile]');
    // Select the default profile instead.
    $this->getSession()->getPage()->fillField('shipping_profile[0][profile][select_address]', $this->defaultProfile->id());
    $this->waitForAjaxToFinish();
    $this->assertRenderedAddress($this->defaultAddress, 'shipping_profile[0][profile]');
    // Edit the default profile and change the street.
    $this->getSession()->getPage()->pressButton('shipping_edit');
    $this->waitForAjaxToFinish();
    foreach ($this->defaultAddress as $property => $value) {
      $prefix = 'shipping_profile[0][profile][address][0][address]';
      $this->assertSession()->fieldValueEquals($prefix . '[' . $property . ']', $value);
    }
    $this->getSession()->getPage()->fillField('shipping_profile[0][profile][address][0][address][address_line1]', '10 Drupal Ave');
    // The copy checkbox should be hidden and checked.
    $this->assertSession()->fieldNotExists('shipping_profile[0][profile][copy_to_address_book]');

    // Change the package type.
    $package_type = PackageType::load('package_type_a');
    $page->fillField('package_type', 'commerce_package_type:' . $package_type->uuid());
    $page->pressButton('Recalculate shipping');
    $this->waitForAjaxToFinish();
    $this->submitForm([], 'Save');

    // Ensure the shipment has been updated.
    $shipment = $this->reloadEntity($shipment);
    $this->assertEquals('commerce_package_type:' . $package_type->uuid(), $shipment->getPackageType()->getId());
    $this->assertFalse($shipment->getData('owned_by_packer', TRUE));
    $this->assertSame(0, $shipment->getAmount()->compareTo(new Price('199.80', 'USD')));

    $shipping_profile = $this->reloadEntity($shipping_profile);
    $this->assertEquals('customer_shipping', $shipping_profile->bundle());
    $expected_address = ['address_line1' => '10 Drupal Ave'] + $this->defaultAddress;
    $this->assertEquals($expected_address, array_filter($shipping_profile->get('address')->first()->toArray()));
    $this->assertEquals($this->defaultProfile->id(), $shipping_profile->getData('address_book_profile_id'));
    // Confirm that the address book profile was updated.
    $this->defaultProfile = $this->reloadEntity($this->defaultProfile);
    $this->assertEquals($expected_address, array_filter($this->defaultProfile->get('address')->first()->toArray()));
  }

  /**
   * Tests deleting a shipment.
   */
  public function testShipmentDelete() {
    /** @var \Drupal\commerce_shipping\Entity\ShipmentInterface $shipment */
    $shipment = $this->createEntity('commerce_shipment', [
      'type' => 'default',
      'title' => 'Test shipment',
      'order_id' => $this->order->id(),
      'amount' => new Price('10', 'USD'),
      'items' => [
        new ShipmentItem([
          'order_item_id' => 1,
          'title' => 'Test shipment item',
          'quantity' => 1,
          'weight' => new Weight(0, 'g'),
          'declared_value' => new Price('1', 'USD'),
        ]),
      ],
    ]);
    $this->drupalGet($this->shipmentUri);
    $this->assertSession()->pageTextContains($shipment->label());
    $this->assertSession()->pageTextContains('$10.00');

    $this->assertSession()->linkByHrefExists($this->shipmentUri . '/' . $shipment->id() . '/delete');
    $this->drupalGet($this->shipmentUri . '/' . $shipment->id() . '/delete');
    $this->getSession()->getPage()->pressButton('Delete');
    $this->assertSession()->addressEquals($this->shipmentUri);
    $this->assertSession()->pageTextNotContains('$10.00');

    \Drupal::entityTypeManager()->getStorage('commerce_shipment')->resetCache([$shipment->id()]);
    $shipment = Shipment::load($shipment->id());
    $this->assertNull($shipment);
  }

  /**
   * Tests the Shipments listing with and without the view.
   */
  public function testShipmentListing() {
    $this->drupalGet($this->order->toUrl());
    $this->assertSession()->linkExists('Shipments');
    $this->assertSession()->linkByHrefExists($this->shipmentUri);

    $this->clickLink('Shipments');
    $this->assertSession()->pageTextContains('There are no shipments yet.');
    $shipment = $this->createEntity('commerce_shipment', [
      'type' => 'default',
      'title' => $this->randomString(16),
      'package_type_id' => 'package_type_a',
      'order_id' => $this->order->id(),
      'amount' => new Price('10', 'USD'),
      'items' => [
        new ShipmentItem([
          'order_item_id' => 1,
          'title' => 'Test shipment item label',
          'quantity' => 1,
          'weight' => new Weight(0, 'g'),
          'declared_value' => new Price('1', 'USD'),
        ]),
      ],
    ]);
    $this->getSession()->reload();
    $this->assertSession()->pageTextNotContains('There are no shipments yet.');
    $this->assertSession()->pageTextContains($shipment->label());

    // Ensure the listing works without the view.
    View::load('order_shipments')->delete();
    \Drupal::service('router.builder')->rebuild();
    $this->drupalGet($this->shipmentUri);
    $this->assertSession()->pageTextNotContains('There are no shipments yet.');
    $this->assertSession()->pageTextContains($shipment->label());
    $shipment->delete();
    $this->getSession()->reload();
    $this->assertSession()->pageTextContains('There are no shipments yet.');
  }

}
