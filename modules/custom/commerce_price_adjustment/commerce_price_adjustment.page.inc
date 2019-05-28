<?php

/**
 * @file
 * Contains commerce_price_adjustment.page.inc.
 *
 * Page callback for Price Adjustment entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Price Adjustment templates.
 *
 * Default template: commerce_price_adjustment.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_commerce_price_adjustment(array &$variables) {
  // Fetch CommercePriceAdjustment Entity Object.
  $commerce_price_adjustment = $variables['elements']['#commerce_price_adjustment'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
