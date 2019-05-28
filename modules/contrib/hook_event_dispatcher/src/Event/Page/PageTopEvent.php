<?php

namespace Drupal\hook_event_dispatcher\Event\Page;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class PageTopEvent.
 */
class PageTopEvent extends Event implements EventInterface {

  /**
   * The build array.
   *
   * @var array
   */
  private $build;

  /**
   * PageTopEvent constructor.
   *
   * @param array $build
   *   The build array.
   */
  public function __construct(array &$build) {
    $this->build = &$build;
  }

  /**
   * Get the build array.
   *
   * @return array
   *   The build array.
   */
  public function &getBuild() {
    return $this->build;
  }

  /**
   * Set the build.
   *
   * @param array $build
   *   The build array.
   */
  public function setBuild(array $build) {
    $this->build = $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::PAGE_TOP;
  }

}
