<?php

namespace Drupal\slick_paragraphs\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\slick\Plugin\Field\FieldFormatter\SlickMediaFormatter;

/**
 * Plugin implementation of the 'Slick Paragraphs Media' formatter.
 *
 * @FieldFormatter(
 *   id = "slick_paragraphs_media",
 *   label = @Translation("Slick Paragraphs Media"),
 *   description = @Translation("Display the rich paragraph as a Slick Carousel."),
 *   field_types = {
 *     "entity_reference_revisions"
 *   },
 *   quickedit = {
 *     "editor" = "disabled"
 *   }
 * )
 */
class SlickParagraphsFormatter extends SlickMediaFormatter {

  /**
   * Overrides the scope for the form elements.
   */
  public function getScopedFormElements() {
    $admin       = $this->admin();
    $target_type = $this->getFieldSetting('target_type');
    $views_ui    = $this->getFieldSetting('handler') == 'default';
    $bundles     = $views_ui ? [] : $this->getFieldSetting('handler_settings')['target_bundles'];
    $media       = $admin->getFieldOptions($bundles, ['entity_reference'], $target_type, 'media');
    $stages      = $admin->getFieldOptions($bundles, ['image', 'entity_reference'], $target_type);

    return [
      'images'   => $stages,
      'overlays' => $stages + $media,
    ] + parent::getScopedFormElements();
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    $storage = $field_definition->getFieldStorageDefinition();

    // Excludes host, prevents complication with multiple nested paragraphs.
    $paragraph = $storage->getTargetEntityTypeId() === 'paragraph';
    return $paragraph && $storage->isMultiple() && $storage->getSetting('target_type') === 'paragraph';
  }

}
