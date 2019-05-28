<?php

namespace Drupal\commerce_price_adjustment;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Price Adjustment entities.
 *
 * @ingroup commerce_price_adjustment
 */
class CommercePriceAdjustmentListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Price Adjustment ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustment */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.commerce_price_adjustment.edit_form',
      ['commerce_price_adjustment' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
