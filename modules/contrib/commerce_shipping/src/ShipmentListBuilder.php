<?php

namespace Drupal\commerce_shipping;

use CommerceGuys\Intl\Formatter\CurrencyFormatterInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the list builder for shipments.
 */
class ShipmentListBuilder extends EntityListBuilder {

  /**
   * The currency formatter.
   *
   * @var \CommerceGuys\Intl\Formatter\CurrencyFormatterInterface
   */
  protected $currencyFormatter;

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * {@inheritdoc}
   */
  protected $entitiesKey = 'shipments';

  /**
   * Constructs a new ShipmentListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \CommerceGuys\Intl\Formatter\CurrencyFormatterInterface $currency_formatter
   *   The currency formatter.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The current route match.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, CurrencyFormatterInterface $currency_formatter, RouteMatchInterface $route_match) {
    parent::__construct($entity_type, $storage);

    $this->currencyFormatter = $currency_formatter;
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.manager')->getStorage($entity_type->id()),
      $container->get('commerce_price.currency_formatter'),
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'commerce_shipments';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEntityIds() {
    $order_id = $this->routeMatch->getRawParameter('commerce_order');
    $query = $this->getStorage()->getQuery()
      ->condition('order_id', $order_id)
      ->sort($this->entityType->getKey('id'));

    // Only add the pager if a limit is specified.
    if ($this->limit) {
      $query->pager($this->limit);
    }
    return $query->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header = [
      'label' => $this->t('Shipment'),
      'tracking' => $this->t('Tracking'),
      'amount' => $this->t('Amount'),
      'state' => $this->t('State'),
    ];
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\commerce_shipping\Entity\ShipmentInterface $entity */
    $amount = $entity->getAmount();

    $row['label']['data'] = [
      '#type' => 'link',
      '#title' => $entity->label(),
    ] + $entity->toUrl()->toRenderArray();
    $row['tracking'] = $entity->getTrackingCode();
    $row['amount'] = $this->currencyFormatter->format($amount->getNumber(), $amount->getCurrencyCode());
    $row['state'] = $entity->getState()->getLabel();

    return $row + parent::buildRow($entity);
  }

}
