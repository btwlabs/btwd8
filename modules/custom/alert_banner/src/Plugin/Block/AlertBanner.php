<?php

namespace Drupal\alert_banner\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\Renderer;
use Drupal\Core\Theme\ThemeManager;
use Drupal\Core\TypedData\Exception\MissingDataException;
use Drupal\Node\entity\node;
use Drupal\path_alias\AliasManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'AlertBanner' block.
 *
 * @Block(
 *  id = "alert_banner",
 *  admin_label = @Translation("Dismissable Alert Banner"),
 * )
 */
class AlertBanner extends BlockBase implements ContainerFactoryPluginInterface {

  protected $sitePath;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param $sitePath
   */
  public function __construct(array $configuration,
                              $plugin_id,
                              $plugin_definition,
                              $sitePath) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->sitePath = $sitePath;
  }

  /**
   * @param ContainerInterface $container
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('site.path')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   * @param $form
   * @param FormStateInterface $form_state
   * @return array
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $form['alert_banner'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Alert Banner Configurations'),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
    );

    $form['alert_banner']['banner_title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $this->configuration['alert_banner']['banner_title'],
      '#size' => 90,
      '#maxlength' => 128,
    );

    $form['alert_banner']['banner_body'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Body'),
      '#default_value' => $this->configuration['alert_banner']['banner_body'],
      '#description' => t("Be careful not to add too much text here."),
    );

    $form['alert_banner']['dismiss_alert_button'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Button'),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
    );

    $form['alert_banner']['dismiss_alert_button']['button_label'] = array(
      '#type' => 'textfield',
      '#title' => t('Label'),
      '#default_value' => $this->configuration['alert_banner']['dismiss_alert_button']['banner_label'],
      '#description' => $this->t("The text used for the button on the banner."),
      '#size' => 90,
      '#maxlength' => 128,
      '#prefix' => '<div class="col-6 left">',
      '#suffix' => '</div>',
    );

    $form['alert_banner']['dismiss_alert_button']['banner_link'] = array(
      '#type' => 'textfield',
      '#title' => t('Link'),
      '#default_value' => $this->configuration['alert_banner']['dismiss_alert_button']['button_link'],
      '#description' => $this->t("The internal path of the link src. Must start with a '/'"),
      '#size' => 90,
      '#maxlength' => 128,
      '#prefix' => '<div class="col-6 left">',
      '#suffix' => '</div>',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['alert_banner'] = $values['alert_banner'];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $config = $this->getConfiguration();
    $build['#theme'] = 'alert_banner';
    $build['#content'] = $config['alert_banner'];
    $build['#attached']['library'][] = 'alert_banner/alert_banner_block';
    return $build;
  }

}
