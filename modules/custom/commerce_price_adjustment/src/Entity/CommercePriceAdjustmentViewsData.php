<?php

namespace Drupal\commerce_price_adjustment\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Price Adjustment entities.
 */
class CommercePriceAdjustmentViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
