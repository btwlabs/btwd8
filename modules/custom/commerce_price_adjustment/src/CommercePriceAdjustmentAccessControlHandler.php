<?php

namespace Drupal\commerce_price_adjustment;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Price Adjustment entity.
 *
 * @see \Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustment.
 */
class CommercePriceAdjustmentAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustmentInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished price adjustment entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published price adjustment entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit price adjustment entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete price adjustment entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add price adjustment entities');
  }

}
