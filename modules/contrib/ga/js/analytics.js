/**
 * @file
 * Initialize analytics on the page.
 */
/* global ga*/

(function (drupalSettings) {
  'use strict';

  /*eslint-disable */
  window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
  /*eslint-enable */

  if (!drupalSettings.ga) {
    return;
  }

  for (var i = 0; i < drupalSettings.ga.commands.length; i++) {
    ga.apply(this, drupalSettings.ga.commands[i]);
  }

})(drupalSettings);
