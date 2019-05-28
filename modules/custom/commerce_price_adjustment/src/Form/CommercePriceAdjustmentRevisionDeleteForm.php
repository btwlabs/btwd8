<?php

namespace Drupal\commerce_price_adjustment\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for deleting a Price Adjustment revision.
 *
 * @ingroup commerce_price_adjustment
 */
class CommercePriceAdjustmentRevisionDeleteForm extends ConfirmFormBase {


  /**
   * The Price Adjustment revision.
   *
   * @var \Drupal\commerce_price_adjustment\Entity\CommercePriceAdjustmentInterface
   */
  protected $revision;

  /**
   * The Price Adjustment storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $CommercePriceAdjustmentStorage;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Constructs a new CommercePriceAdjustmentRevisionDeleteForm.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $entity_storage
   *   The entity storage.
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   */
  public function __construct(EntityStorageInterface $entity_storage, Connection $connection) {
    $this->CommercePriceAdjustmentStorage = $entity_storage;
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $entity_manager = $container->get('entity.manager');
    return new static(
      $entity_manager->getStorage('commerce_price_adjustment'),
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'commerce_price_adjustment_revision_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete the revision from %revision-date?', ['%revision-date' => format_date($this->revision->getRevisionCreationTime())]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.commerce_price_adjustment.version_history', ['commerce_price_adjustment' => $this->revision->id()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $commerce_price_adjustment_revision = NULL) {
    $this->revision = $this->CommercePriceAdjustmentStorage->loadRevision($commerce_price_adjustment_revision);
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->CommercePriceAdjustmentStorage->deleteRevision($this->revision->getRevisionId());

    $this->logger('content')->notice('Price Adjustment: deleted %title revision %revision.', ['%title' => $this->revision->label(), '%revision' => $this->revision->getRevisionId()]);
    drupal_set_message(t('Revision from %revision-date of Price Adjustment %title has been deleted.', ['%revision-date' => format_date($this->revision->getRevisionCreationTime()), '%title' => $this->revision->label()]));
    $form_state->setRedirect(
      'entity.commerce_price_adjustment.canonical',
       ['commerce_price_adjustment' => $this->revision->id()]
    );
    if ($this->connection->query('SELECT COUNT(DISTINCT vid) FROM {commerce_price_adjustment_field_revision} WHERE id = :id', [':id' => $this->revision->id()])->fetchField() > 1) {
      $form_state->setRedirect(
        'entity.commerce_price_adjustment.version_history',
         ['commerce_price_adjustment' => $this->revision->id()]
      );
    }
  }

}
