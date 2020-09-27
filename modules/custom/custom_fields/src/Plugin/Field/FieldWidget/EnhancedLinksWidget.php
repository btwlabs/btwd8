<?php

namespace Drupal\custom_fields\Plugin\Field\FieldWidget;

use Drupal\better_links\Plugin\Field\FieldWidget\BetterLinksFieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'flat file generator' link widget.
 *
 * @FieldWidget(
 *   id = "enhanced_links_widget",
 *   label = @Translation("Enhanced Link"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class EnhancedLinksWidget extends BetterLinksFieldWidget {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    return parent::settingsSummary();
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    $item = $this->getLinkItem($items, $delta);
    $options = $item->get('options')->getValue();

    // Allow setting the role attribute.
    $element['options']['attributes']['type'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Set a type attribute, e.g. type="button"'),
      '#default_value' => $options['attributes']['type']
    ];

    // Allow adding arbitrary attributes.
    $element['options']['other_attributes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Other Attributes'),
      '#description' => $this->t('Provide a list of other attributes in the form \'attr1="value1" attr2="value2" ...\''),
      '#default_value' => !empty($options['other_attributes']) ? $options['other_attributes'] : ''
    ];
    return $element;
  }

  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    $values = parent::massageFormValues($values, $form, $form_state);
    foreach ($values as &$value) {
      $attributes = [];
      // A valid match will have 3 elements, full, grp1(labels), grp2(values).
      if (preg_match_all('/([a-z1-9A-Z]*)="([a-z1-9-_~]*)"/', $value['options']['other_attributes'], $matches) == 2) {
        foreach($matches[1] as $key => $attr) {
          $attributes[$attr] = $matches[2][$key];
        }
      }
      $value['options']['attributes'] = array_merge($value['options']['attributes'], $attributes);
      if ($value['options']['attributes']['type'] == '') {
        unset ($value['options']['attributes']['type']);
      }
    }
    return $values;
  }

  /**
   * Getting link items.
   *
   * @param \Drupal\Core\Field\FieldItemListInterface $items
   *   Returning of field items.
   * @param string $delta
   *   Returning field delta with item.
   *
   * @return \Drupal\link\LinkItemInterface
   *   Returning link items inteface.
   */
  private function getLinkItem(FieldItemListInterface $items, $delta) {
    /** @var \Drupal\link\LinkItemInterface $item */
    return $items[$delta];
  }

}
