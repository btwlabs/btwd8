<?php

namespace Drupal\paragraph_tweaks\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FormatterInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Magnific Popup FieldFormatter for Video Embed Field.
 *
 * @FieldFormatter(
 *   id = "story_blocks_video_embed_field_magnific_popup",
 *   label = @Translation("Story Blocks Magnific Popup"),
 *   field_types = {
 *     "video_embed_field"
 *   }
 * )
 */
class VideoEmbedField extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * The field formatter plugin instance for thumbnails.
   *
   * @var \Drupal\Core\Field\FormatterInterface
   */
  protected $thumbnailFormatter;

  /**
   * The field formatter plugin instance for videos.
   *
   * @var \Drupal\Core\Field\FormatterInterface
   */
  protected $videoFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a new instance of the plugin.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Third party settings.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer.
   * @param \Drupal\Core\Field\FormatterInterface $thumbnail_formatter
   *   The field formatter for thumbnails.
   * @param \Drupal\Core\Field\FormatterInterface $video_formatter
   *   The field formatter for videos.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, RendererInterface $renderer, FormatterInterface $thumbnail_formatter, FormatterInterface $video_formatter) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->thumbnailFormatter = $thumbnail_formatter;
    $this->videoFormatter = $video_formatter;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $formatter_manager = $container->get('plugin.manager.field.formatter');
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('renderer'),
      $formatter_manager->createInstance('video_embed_field_thumbnail', $configuration),
      $formatter_manager->createInstance('video_embed_field_video', $configuration)
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    $default_settings = [
      'gallery_type' => 'all_items',
      'link_text' => 'Watch Video',
      'link_classes' => ''
    ];

    return $default_settings + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = [
      'gallery_type' => [
        '#title' => $this->t('Gallery Type'),
        '#type' => 'select',
        '#default_value' => $this->getSetting('gallery_type'),
        '#options' => $this->getGalleryTypes(),
      ],
      'link_text' => [
        '#title' => $this->t('Link Text'),
        '#type' => 'textfield',
        '#default_value' => $this->getSetting('link_text'),
        '#description' => $this->t('Specify the text that will be shown in the popup trigger link.')
      ],
      'link_classes' => [
        '#title' => $this->t('Link Classes'),
        '#type' => 'textfield',
        '#default_value' => $this->getSetting('link_classes'),
        '#description' => $this->t('Extra classes that will be added to the trigger link.')
      ]
    ];

    return $form + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary[] = $this->t('Thumbnail that opens a popup.');
    $summary[] = $this->t('Link Text') . ':' . $this->getSetting('link_text');
    $summary[] = $this->t('Link Classes') . ':' . $this->getSetting('link_classes');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function view(FieldItemListInterface $items, $langcode = NULL) {
    $elements = parent::view($items, $langcode);
    $gallery_type = $this->getSetting('gallery_type');
    $elements['#attributes']['class'][] = 'mfp-field';
    $elements['#attributes']['class'][] = 'mfp-video-embed-' . Html::cleanCssIdentifier($gallery_type);
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $gallery_type = $this->getSetting('gallery_type');
    $videos = $this->videoFormatter->viewElements($items, $langcode);
    $trigger_link = '<div class="video-trigger-link' .
      (($this->getSetting('link_classes') != '') ? ' ' : '') .
      $this->getSetting('link_classes') .
      '>' .
      $this->getSetting('link_text') .
      '</div>';
    foreach ($items as $delta => $item) {
      if ($gallery_type === 'first_item' && $delta > 0) {
        $element[$delta] = [
          '#type' => 'container',
          '#attributes' => [
            'data-mfp-video-embed' => (string) $this->renderer->renderRoot($videos[$delta]),
            'class' => ['mfp-video-embed-popup'],
          ],
          '#attached' => [
            'library' => ['magnific_popup/magnific_popup', 'magnific_popup/video_embed_field'],
          ],
        ];
      }
      else {
        $element[$delta] = [
          '#type' => 'container',
          '#attributes' => [
            'data-mfp-video-embed' => (string) $this->renderer->renderRoot($videos[$delta]),
            'class' => ['mfp-video-embed-popup'],
          ],
          '#attached' => [
            'library' => ['magnific_popup/magnific_popup', 'magnific_popup/video_embed_field'],
          ],
          'children' => [
            '#markup' => $trigger_link
          ],
        ];
      }
    }

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    return \Drupal::moduleHandler()->moduleExists('video_embed_field');
  }

  /**
   * Get an array of gallery types.
   *
   * @return array
   *   An array of gallery types for use in display settings.
   */
  protected function getGalleryTypes() {
    return [
      'all_items' => $this->t('Gallery: All Items Displayed'),
      'first_item' => $this->t('Gallery: First Item Displayed'),
      'separate_items' => $this->t('No Gallery: Display Each Item Separately'),
    ];
  }

}
