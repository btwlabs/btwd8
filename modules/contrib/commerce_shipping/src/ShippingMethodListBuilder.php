<?php

namespace Drupal\commerce_shipping;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the list builder for shipping methods.
 */
class ShippingMethodListBuilder extends EntityListBuilder implements FormInterface {

  /**
   * The key to use for the form element containing the entities.
   *
   * @var string
   */
  protected $entitiesKey = 'methods';

  /**
   * The entities being listed.
   *
   * @var \Drupal\commerce_shipping\Entity\ShippingMethodInterface[]
   */
  protected $entities = [];

  /**
   * Whether tabledrag is enabled.
   *
   * @var bool
   */
  protected $hasTableDrag = TRUE;

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * Constructs a new ShippingMethodListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage.
   * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
   *   The form builder.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, FormBuilderInterface $form_builder) {
    parent::__construct($entity_type, $storage);

    $this->formBuilder = $form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.manager')->getStorage($entity_type->id()),
      $container->get('form_builder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'commerce_shipping_methods';
  }

  /**
   * {@inheritdoc}
   */
  public function load() {
    $entity_ids = $this->getEntityIds();
    $entities = $this->storage->loadMultiple($entity_ids);
    // Sort the entities using the entity class's sort() method.
    uasort($entities, [$this->entityType->getClass(), 'sort']);

    return $entities;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['name'] = $this->t('Name');
    $header['status'] = $this->t('Enabled');
    if ($this->hasTableDrag) {
      $header['weight'] = $this->t('Weight');
    }
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\commerce_shipping\Entity\ShippingMethodInterface $entity */
    if ($this->hasTableDrag) {
      $row['#attributes']['class'][] = 'draggable';
    }
    $row['#weight'] = $entity->getWeight();
    $row['name'] = $entity->label();
    $row['status'] = $entity->isEnabled() ? $this->t('Enabled') : $this->t('Disabled');
    if ($this->hasTableDrag) {
      $row['weight'] = [
        '#type' => 'weight',
        '#title' => $this->t('Weight for @title', ['@title' => $entity->label()]),
        '#title_display' => 'invisible',
        '#default_value' => $entity->getWeight(),
        '#attributes' => ['class' => ['weight']],
      ];
    }

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = $this->formBuilder->getForm($this);
    // Only add the pager if a limit is specified.
    if ($this->limit) {
      $build['pager'] = [
        '#type' => 'pager',
      ];
    }

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $this->entities = $this->load();
    if (count($this->entities) <= 1) {
      $this->hasTableDrag = FALSE;
    }
    $delta = 10;
    // Dynamically expand the allowed delta based on the number of entities.
    $count = count($this->entities);
    if ($count > 20) {
      $delta = ceil($count / 2);
    }

    $form[$this->entitiesKey] = [
      '#type' => 'table',
      '#header' => $this->buildHeader(),
      '#empty' => $this->t('There are no @label yet.', ['@label' => $this->entityType->getPluralLabel()]),
    ];
    foreach ($this->entities as $entity) {
      $row = $this->buildRow($entity);
      if (isset($row['name'])) {
        $row['name'] = ['#markup' => $row['name']];
      }
      if (isset($row['status'])) {
        $row['status'] = ['#markup' => $row['status']];
      }
      if (isset($row['weight'])) {
        $row['weight']['#delta'] = $delta;
      }
      $form[$this->entitiesKey][$entity->id()] = $row;
    }

    if ($this->hasTableDrag) {
      $form[$this->entitiesKey]['#tabledrag'][] = [
        'action' => 'order',
        'relationship' => 'sibling',
        'group' => 'weight',
      ];
      $form['actions']['#type'] = 'actions';
      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => t('Save'),
        '#button_type' => 'primary',
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // No validation.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValue($this->entitiesKey) as $id => $value) {
      if (isset($this->entities[$id]) && $this->entities[$id]->getWeight() != $value['weight']) {
        // Save entity only when its weight was changed.
        $this->entities[$id]->setWeight($value['weight']);
        $this->entities[$id]->save();
      }
    }
  }

}
