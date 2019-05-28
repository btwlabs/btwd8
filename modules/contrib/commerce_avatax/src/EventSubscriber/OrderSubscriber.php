<?php

namespace Drupal\commerce_avatax\EventSubscriber;

use Drupal\commerce_avatax\Avatax;
use Drupal\commerce_avatax\AvataxLib;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\state_machine\Event\WorkflowTransitionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderSubscriber implements EventSubscriberInterface {

  /**
   * The Avatax library.
   *
   * @var \Drupal\commerce_avatax\AvataxLib
   */
  protected $avataxLib;

  /**
   * The Avatax configuration.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * Constructs a new CommitTransactionSubscriber object.
   *
   * @param \Drupal\commerce_avatax\AvataxLib $avatax_lib
   *   The Avatax library.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   */
  public function __construct(AvataxLib $avatax_lib, ConfigFactoryInterface $config_factory) {
    $this->avataxLib = $avatax_lib;
    $this->config = $config_factory->get('commerce_avatax.settings');
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = [
      'commerce_order.place.post_transition' => ['commitTransaction'],
      'commerce_order.cancel.pre_transition' => ['voidTransaction'],
    ];
    return $events;
  }

  /**
   * Commits a transaction or the order in AvaTax.
   *
   * @param \Drupal\state_machine\Event\WorkflowTransitionEvent $event
   *   The workflow transition event.
   */
  public function commitTransaction(WorkflowTransitionEvent $event) {
    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $order = $event->getEntity();

    if ($this->config->get('disable_commit') || !Avatax::hasAvataxAdjustments($order)) {
      return;
    }

    $this->avataxLib->transactionsCreate($order, 'SalesInvoice');
  }

  /**
   * Voids a transaction in AvaTax for the given order.
   *
   * @param \Drupal\state_machine\Event\WorkflowTransitionEvent $event
   *   The workflow transition event.
   */
  public function voidTransaction(WorkflowTransitionEvent $event) {
    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $order = $event->getEntity();

    if (!Avatax::hasAvataxAdjustments($order)) {
      return;
    }

    $this->avataxLib->transactionsVoid($order);
  }

}
