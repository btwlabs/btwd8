<?php

namespace Drupal\commerce_shipping;

use Drupal\commerce_order\Entity\OrderInterface;

/**
 * Provides a summary of an order's shipments.
 *
 * Shown at checkout (review), admin/user order pages, order receipt emails.
 */
interface OrderShipmentSummaryInterface {

  /**
   * Builds a summary of the given order's shipments.
   *
   * @param \Drupal\commerce_order\Entity\OrderInterface $order
   *   The order.
   * @param string $view_mode
   *   The view mode used to render the shipments.
   *
   * @return array
   *   The renderable array with the shipment summary.
   */
  public function build(OrderInterface $order, $view_mode = 'user');

}
