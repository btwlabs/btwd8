<?php

namespace Drupal\commerce_price_adjustment;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustmentInterface;

/**
 * Defines the storage handler class for Price Adjustment entities.
 *
 * This extends the base storage class, adding required special handling for
 * Price Adjustment entities.
 *
 * @ingroup commerce_price_adjustment
 */
interface CommercePriceAdjustmentStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Price Adjustment revision IDs for a specific Price Adjustment.
   *
   * @param \Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustmentInterface $entity
   *   The Price Adjustment entity.
   *
   * @return int[]
   *   Price Adjustment revision IDs (in ascending order).
   */
  public function revisionIds(CommercePriceAdjustmentInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Price Adjustment author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Price Adjustment revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustmentInterface $entity
   *   The Price Adjustment entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(CommercePriceAdjustmentInterface $entity);

  /**
   * Unsets the language for all Price Adjustment with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
