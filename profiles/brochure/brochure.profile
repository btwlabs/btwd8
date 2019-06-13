<?php
/**
 * @file
 * Enables modules and site configuration for a brochure site installation.
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 */
function brochure_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {
  $form['#submit'][] = 'brochure_form_install_configure_submit';
}

/**
 * Submission handler to do the bizniz.
 */
function brochure_form_install_configure_submit($form, FormStateInterface $form_state) {
  // Create Users.
  $user = User::create();
  $user->setUsername('btwted')
    ->setPassword('123detwtb321')
    ->enforceIsNew()
    ->setEmail('ted@bythewaylabs.com')
    ->addRole('administrator');
  $user->activate()
      ->save();

  $user = User::create();
  $user->setUsername('btwjon')
    ->setPassword('123nojwtb321')
    ->enforceIsNew()
    ->setEmail('jon@bythewaylabs.com')
    ->addRole('administrator');
  $user->activate()
    ->save();

  $user = User::create();
  $user->setUsername('btwdennis')
    ->setPassword('123sinnedwtb321')
    ->enforceIsNew()
    ->setEmail('dennis@bythewaylabs.com')
    ->addRole('administrator');
  $user->activate()
    ->save();

  $user = User::create();
  $user->setUsername('btwalexis')
    ->setPassword('sixelawtb321')
    ->enforceIsNew()
    ->setEmail('alexis.saransig@jobsity.com')
    ->addRole('administrator');
  $user->activate()
    ->save();

  // Create Menus.



}
