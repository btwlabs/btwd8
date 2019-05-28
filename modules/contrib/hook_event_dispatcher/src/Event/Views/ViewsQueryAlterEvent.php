<?php

namespace Drupal\hook_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\views\Plugin\views\query\QueryPluginBase;
use Drupal\views\ViewExecutable;

/**
 * Class ViewsQueryAlterEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Views
 */
final class ViewsQueryAlterEvent extends BaseViewsEvent {

  /**
   * The query.
   *
   * @var \Drupal\views\Plugin\views\query\QueryPluginBase
   */
  private $query;

  /**
   * ViewsPreExecuteEevent constructor.
   *
   * @param \Drupal\views\ViewExecutable $view
   *   The view.
   * @param \Drupal\views\Plugin\views\query\QueryPluginBase $query
   *   The query.
   */
  public function __construct(ViewExecutable $view, QueryPluginBase $query) {
    parent::__construct($view);
    $this->query = $query;
  }

  /**
   * Get the query.
   *
   * @return \Drupal\views\Plugin\views\query\QueryPluginBase
   *   The query.
   */
  public function getQuery() {
    return $this->query;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::VIEWS_QUERY_ALTER;
  }

}
