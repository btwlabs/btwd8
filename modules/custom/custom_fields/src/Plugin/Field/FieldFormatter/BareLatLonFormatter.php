<?php

namespace Drupal\custom_fields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\geofield\Plugin\Field\FieldFormatter\LatLonFormatter;

/**
 * Plugin implementation of the 'bare_lat_lon_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "bare_lat_lon_formatter",
 *   label = @Translation("Custom Lat-Lon formatter"),
 *   field_types = {
 *     "geofield"
 *   }
 * )
 */
class BareLatLonFormatter extends LatLonFormatter {

  /**
   * Helper function to get the formatter settings options.
   *
   * @return array
   *   The formatter settings options.
   */
  protected function formatOptions() {
    return [
      'decimal_bare' => $this->t("Decimal (17.76972), no markup"),
      'lat_only' => $this->t('Latitude only, No Markup'),
      'lon_only' => $this->t('Longitude only, no markup')
    ] + parent::formatOptions();
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $output = ['#markup' => ''];
      $geom = $this->geoPhpWrapper->load($item->value);
      if ($geom && $geom->getGeomType() == 'Point') {
        /* @var \Point $geom */
        switch($this->getOutputFormat()) {
          case 'decimal_bare':
            $output = [
              '#type' => 'inline_template',
              '#template' => "{$geom->y()},{$geom->x()}"
            ];
            break;
          case 'lat_only':
            $output = [
              '#type' => 'inline_template',
              '#template' => "{$geom->y()}"
            ];
            break;
          case 'lon_only':
            $output = [
              '#type' => 'inline_template',
              '#template' => "{$geom->x()}"
            ];
            break;
        }
      }
      $elements[$delta] = $output;
    }

    return $elements;
  }

}
