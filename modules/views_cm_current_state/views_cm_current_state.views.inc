<?php

/**
 * @file
 * Contains views_cm_current_state\views_cm_current_state.views.inc.
 */

/**
 * Implements hook_views_data().
 */
function views_cm_current_state_views_data() {
  $data['views']['table']['group'] = t('Content revision');
  $data['views']['table']['join'] = [
    // #global is a special flag which allows a table to appear all the time.
    '#global' => [],
  ];

  $data['views']['current_state_views_field'] = [
    'title' => t('Current state'),
    'help' => t('Content moderation content current state.'),
    'field' => [
      'id' => 'current_state_views_field',
    ],
  ];
  return $data;
}
