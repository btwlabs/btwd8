<?php
/**
 * @file
 * Enables modules and site configuration for a brochure site installation.
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\feeds\Entity\Feed;
use Drupal\user\Entity\User;

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 *
function brochure_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {
  $form['#submit'][] = 'brochure_form_install_configure_submit';
}*/

/**
 * Implements hook_install_tasks().
 */
function brochure_install_tasks() {
  return [
    'brochure_create_users' => [
      'display_name' => t('Create Admin Users'),
      'display' => true,
      'type' => 'normal'
    ],
    /*'brochure_create_feeds' => [
      'display_name' => t('Create Feed Importers'),
      'display' => true,
      'type' => 'normal'
    ],
    'brochure_import_feeds' => [
      'display_name' => t('Import Demo Content'),
      'display' => true,
      'type' => 'batch'
    ]*/
  ];
}

function brochure_create_users(&$context) {
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
  $user->setUsername('btwalexey')
    ->setPassword('123yexelawtb321')
    ->enforceIsNew()
    ->setEmail('alexey@rootstack.com')
    ->addRole('administrator');
  $user->activate()
    ->save();
  $context['finished'] = true;
}

function brochure_create_feeds(&$context) {
  /**
   * @var $feeds Feed[]
   */
  $feeds['media'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'media',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import media demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=728747965&single=true&output=csv',
  ));
  $feeds['media']->save();
  /**
   * @var $article_feed Feed
   */
  $feeds['article_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'articles',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import article demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=0&single=true&output=csv',
  ));
  $feeds['article_feed']->save();
  /**
   * @var $article_sb_feed Feed
   */
  $feeds['article_sb_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'article_storyblock_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import article story block paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=1814982223&single=true&output=csv',
  ));
  $feeds['article_sb_feed']->save();
  /**
   * @var $article_image_feed Feed
   */
  $feeds['article_image_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'article_image_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import image paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=2013923235&single=true&output=csv',
  ));
  $feeds['article_image_feed']->save();
  /**
   * @var $article_text_feed Feed
   */
  $feeds['article_text_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'article_text_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import text paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=112018768&single=true&output=csv',
  ));
  $feeds['article_text_feed']->save();
  /**
   * @var $article_quote_feed Feed
   */
  $feeds['article_quote_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'article_quote_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import quote paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=1147560564&single=true&output=csv',
  ));
  $feeds['article_quote_feed']->save();
  /**
   * @var $article_embed_feed Feed
   */
  $feeds['article_embed_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'article_embed_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import embed paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=806141413&single=true&output=csv',
  ));
  $feeds['article_embed_feed']->save();
  /**
   * @var $article_gallery_feed Feed
   */
  $feeds['article_gallery_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'article_gallery_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import gallery paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=1656871980&single=true&output=csv',
  ));
  $feeds['article_gallery_feed']->save();
  /**
   * @var $article_cards_feed Feed
   */
  $feeds['article_cards_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'article_cards_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import cards paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=180108464&single=true&output=csv',
  ));
  $feeds['article_cards_feed']->save();
  /**
   * @var $story_page_feed Feed
   */
  $feeds['story_page_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'story_pages',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import story page demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=782501811&single=true&output=csv',
  ));
  $feeds['story_page_feed']->save();
  /**
   * @var $story_page_sb_feed Feed
   */
  $feeds['story_page_sb_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'story_page_storyblock_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import story page story block paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=1930353739&single=true&output=csv',
  ));
  $feeds['story_page_sb_feed']->save();
  /**
   * @var $story_page_image_feed Feed
   */
  $feeds['story_page_image_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'story_page_image_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import story page image paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=2013923235&single=true&output=csv',
  ));
  $feeds['story_page_image_feed']->save();
  /**
   * @var $story_page_text_feed Feed
   */
  $feeds['story_page_text_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'story_page_text_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import story page text paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=402225300&single=true&output=csv',
  ));
  $feeds['story_page_text_feed']->save();
  /**
   * @var $story_page_quote_feed Feed
   */
  $feeds['story_page_quote_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'story_page_quote_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import story page quote paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=2046651961&single=true&output=csv',
  ));
  $feeds['story_page_quote_feed']->save();
  /**
   * @var $story_page_embed_feed Feed
   */
  $feeds['story_page_embed_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'story_page_embed_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import story page embed paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=270226940&single=true&output=csv',
  ));
  $feeds['story_page_embed_feed']->save();
  /**
   * @var $story_page_gallery_feed Feed
   */
  $feeds['story_page_gallery_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'story_page_gallery_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import story page gallery paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=1657193749&single=true&output=csv',
  ));
  $feeds['story_page_gallery_feed']->save();
  /**
   * @var $story_page_cards_feed Feed
   */
  $feeds['story_page_cards_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'story_page_cards_paragraphs',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import story page cards paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=1513154641&single=true&output=csv',
  ));
  $feeds['story_page_cards_feed']->save();
  /**
   * @var $sub_cards_feed Feed
   */
  $feeds['sub_cards_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'sub_cards',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import sub cards paragraph demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=212932297&single=true&output=csv',
  ));
  $feeds['sub_cards_feed']->save();
  /**
   * @var $teammember_feed Feed
   */
  $feeds['teammember_feed'] = \Drupal::entityTypeManager()->getStorage('feeds_feed')->create(array(
    'type' => 'team_member',
    'uuid' => \Drupal::service('uuid')->generate(),
    'title' => 'Import team member demo content.',
    'uid' => 1,
    'status' => 1,
    'created' => time(),
    'source' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRplpEYGyG7K4Um7_ZuU064ja2zh9kgkQun1nMed3axUU96yyDo_EANpw4E9Awx4hjYD-_dHsBWAz1N/pub?gid=2074362618&single=true&output=csv',
  ));
  $feeds['teammember_feed']->save();

  $context['sandbox']['feed_importers'] = $feeds;
  $context['finished'] = true;
}

function brochure_import_feeds($context) {
  $batch = [];
  if (!empty($importers = $context['sandbox']['feed_importers'])) {
    // Create batch.
    $batch = [
      'title' => t('Import Feeds'),
      'operations' => [],
      'progress_message' => t('Imported @current out of @total feeds'),
      'error_message' => t('There was an error importing feeds')
    ];
    // Import Feeds.
    $i = 0;
    foreach ($importers as $feed) {
      $i++;
      $batch['operations'][] = ['brochure_import_feed', [$feed]];
    }
  }
  return $batch;
}

function brochure_import_feed($feed, $count) {
  $feed->import();
}
