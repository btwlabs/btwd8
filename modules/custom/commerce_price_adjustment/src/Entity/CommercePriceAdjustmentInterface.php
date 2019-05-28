<?php

namespace Drupal\commerce_price_adjustment\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Price Adjustment entities.
 *
 * @ingroup commerce_price_adjustment
 */
interface CommercePriceAdjustmentInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Price Adjustment name.
   *
   * @return string
   *   Name of the Price Adjustment.
   */
  public function getName();

  /**
   * Sets the Price Adjustment name.
   *
   * @param string $name
   *   The Price Adjustment name.
   *
   * @return \Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustmentInterface
   *   The called Price Adjustment entity.
   */
  public function setName($name);

  /**
   * Gets the Price Adjustment creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Price Adjustment.
   */
  public function getCreatedTime();

  /**
   * Sets the Price Adjustment creation timestamp.
   *
   * @param int $timestamp
   *   The Price Adjustment creation timestamp.
   *
   * @return \Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustmentInterface
   *   The called Price Adjustment entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Price Adjustment published status indicator.
   *
   * Unpublished Price Adjustment are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Price Adjustment is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Price Adjustment.
   *
   * @param bool $published
   *   TRUE to set this Price Adjustment to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustmentInterface
   *   The called Price Adjustment entity.
   */
  public function setPublished($published);

  /**
   * Gets the Price Adjustment revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Price Adjustment revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustmentInterface
   *   The called Price Adjustment entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Price Adjustment revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Price Adjustment revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustmentInterface
   *   The called Price Adjustment entity.
   */
  public function setRevisionUserId($uid);

}
