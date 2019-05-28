<?php

namespace Drupal\shipstation_commerce;


class ShipstationData {

  private $orders;
  private $pages;

  public function __construct($startDate, $endDate, $page, $perPage = 50) {
    $this->setData($startDate, $endDate, $page, $perPage);
  }

  protected function setData($startDate, $endDate, $page, $perPage) {
    // Get orders between the specified dates, and the paged number of them.
    $query = \Drupal::entityQuery('commerce_order');
    $query->condition('changed', $startDate, '>=');
    $query->condition('changed', $endDate, '<=');
    $query->accessCheck(FALSE);
    $query->condition('state', 'draft', '<>');
    $query->condition('state', 'completed', '<>');

    // Get the number of 'pages' of 25 orders.
    $count_query = clone $query;
    $count = $count_query->count()->execute();
    $this->pages = ceil($count / $perPage);

    // Figure the range of orders to get.
    $query->range($page*$perPage, $perPage);
    $entity_ids = $query->execute();
    $this->orders = \Drupal\commerce_order\Entity\Order::loadMultiple($entity_ids);
  }

  public function getPages() {
    return $this->pages;
  }

  public function getOrders() {
    return $this->orders;
  }
}
