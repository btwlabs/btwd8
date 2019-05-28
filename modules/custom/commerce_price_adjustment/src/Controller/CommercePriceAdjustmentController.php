<?php

namespace Drupal\commerce_price_adjustment\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustmentInterface;

/**
 * Class CommercePriceAdjustmentController.
 *
 *  Returns responses for Price Adjustment routes.
 */
class CommercePriceAdjustmentController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Price Adjustment  revision.
   *
   * @param int $commerce_price_adjustment_revision
   *   The Price Adjustment  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($commerce_price_adjustment_revision) {
    $commerce_price_adjustment = $this->entityManager()->getStorage('commerce_price_adjustment')->loadRevision($commerce_price_adjustment_revision);
    $view_builder = $this->entityManager()->getViewBuilder('commerce_price_adjustment');

    return $view_builder->view($commerce_price_adjustment);
  }

  /**
   * Page title callback for a Price Adjustment  revision.
   *
   * @param int $commerce_price_adjustment_revision
   *   The Price Adjustment  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($commerce_price_adjustment_revision) {
    $commerce_price_adjustment = $this->entityManager()->getStorage('commerce_price_adjustment')->loadRevision($commerce_price_adjustment_revision);
    return $this->t('Revision of %title from %date', ['%title' => $commerce_price_adjustment->label(), '%date' => format_date($commerce_price_adjustment->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Price Adjustment .
   *
   * @param \Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustmentInterface $commerce_price_adjustment
   *   A Price Adjustment  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(CommercePriceAdjustmentInterface $commerce_price_adjustment) {
    $account = $this->currentUser();
    $langcode = $commerce_price_adjustment->language()->getId();
    $langname = $commerce_price_adjustment->language()->getName();
    $languages = $commerce_price_adjustment->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $commerce_price_adjustment_storage = $this->entityManager()->getStorage('commerce_price_adjustment');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $commerce_price_adjustment->label()]) : $this->t('Revisions for %title', ['%title' => $commerce_price_adjustment->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all price adjustment revisions") || $account->hasPermission('administer price adjustment entities')));
    $delete_permission = (($account->hasPermission("delete all price adjustment revisions") || $account->hasPermission('administer price adjustment entities')));

    $rows = [];

    $vids = $commerce_price_adjustment_storage->revisionIds($commerce_price_adjustment);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\commerce_price_adjustment\CommercePriceAdjustmentInterface $revision */
      $revision = $commerce_price_adjustment_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $commerce_price_adjustment->getRevisionId()) {
          $link = $this->l($date, new Url('entity.commerce_price_adjustment.revision', ['commerce_price_adjustment' => $commerce_price_adjustment->id(), 'commerce_price_adjustment_revision' => $vid]));
        }
        else {
          $link = $commerce_price_adjustment->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.commerce_price_adjustment.translation_revert', ['commerce_price_adjustment' => $commerce_price_adjustment->id(), 'commerce_price_adjustment_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.commerce_price_adjustment.revision_revert', ['commerce_price_adjustment' => $commerce_price_adjustment->id(), 'commerce_price_adjustment_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.commerce_price_adjustment.revision_delete', ['commerce_price_adjustment' => $commerce_price_adjustment->id(), 'commerce_price_adjustment_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['commerce_price_adjustment_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
