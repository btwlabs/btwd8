<?php

namespace Drupal\commerce_price_adjustment;

use Drupal\commerce_order\Adjustment;
use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\OrderProcessorInterface;
use Drupal\commerce_price\Price;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Adds order and order item adjustments for custom adjustment amounts.
 */
class CommercePriceAdjustmentProcessor implements OrderProcessorInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new CommercePriceAdjustmentProcessor object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\commerce_shipping\PackerManagerInterface $packer_manager
   *   The packer manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function process(OrderInterface $order) {
    // Get all active adjustments entities.
    $adjustments = $order->getAdjustments();

    $items = $order->getItems();
    $is_cfu = FALSE;

    foreach ($items as $item) {
      $product = $item->getPurchasedEntity()->get('product_id')->referencedEntities()[0];
      $brand = $product->get('field_product_brand')->referencedEntities()[0]->get('name')->value;

      // If the order contains a product for Country Financial brand the CC fees don't apply.
      if ($brand == 'Country Financial') {
        $is_cfu = TRUE;
      }
    }

    if (!$is_cfu) {
      foreach (\Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustment::loadMultiple() as $adjustment) {
        $label = $adjustment->get('field_cpa_label')->getValue()[0]['value'];
        $percent = $adjustment->get('field_cpa_percent_adjustment')
          ->getValue()[0]['value'];
        $type = $adjustment->get('field_cpa_adjustment_type')
          ->getValue()[0]['value'];
        if ($type == 'order') {
          $factor = $order->getTotalPrice()->getNumber();
        }
        else {
          $factor = $order->getSubtotalPrice()->getNumber();
        }
        $cost = $factor * ($percent / 100);
        $adjustments[] = new Adjustment([
          'type' => 'fee',
          'label' => $label,
          'amount' => new Price("$cost", 'USD'),
        ]);
      }
      $order->setAdjustments($adjustments);
    }
  }
}
