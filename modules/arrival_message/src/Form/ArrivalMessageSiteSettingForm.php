<?php

namespace Drupal\arrival_message\Form;

// Classes referenced in this class:
use Drupal\Core\Form\FormStateInterface;

// This is the form we are extending.
use Drupal\system\Form\SiteInformationForm;

/**
 * Configure site information settings for this site.
 */
class ArrivalMessageSiteSettingForm extends SiteInformationForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $site_config = $this->config('system.site');
    $form = parent::buildForm($form, $form_state);

    $login_duration = [
      'all' => $this->t('Everyone'),
      'first_login' => $this->t('First time login users.'),
      '1_week' => $this->t('Login after 1 week.'),
      '1_month' => $this->t('Login after 1 month.'),
      '3_month' => $this->t('Login after 3 months.'),
      '6_month' => $this->t('Login after 6 months.'),
      '1_year' => $this->t('Login after 1 year.'),
    ];

    $form['site_information']['arrival_message_container'] = [
      '#type' => 'details',
      '#title' => $this->t('Arrival Message'),
      '#description' => $this->t('Message to display after user login.'),
      '#open' => TRUE,
    ];

    $form['site_information']['arrival_message_container']['login_duration'] = [
      '#type' => 'select',
      '#title' => $this->t('Show to only'),
      '#options' => $login_duration,
      '#default_value' => $site_config->get('arrival_message_duration'),
    ];

    $form['site_information']['arrival_message_container']['arrival_message'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Message'),
      '#format' => 'full_html',
      '#default_value' => $site_config->get('arrival_message'),
      '#description' => $this->t('The description of the message'),
    ];
    if (\Drupal::service('module_handler')->moduleExists('token')) {
      $form['site_information']['arrival_message_container']['token_tree'] = [
        '#theme' => 'token_tree_link',
        '#token_types' => ['user', 'node'],
        '#show_restricted' => TRUE,
        '#weight' => 90,
      ];
    }
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('system.site')
      ->set('arrival_message_duration', $form_state->getValue('login_duration'))
      ->set('arrival_message', $form_state->getValue('arrival_message')['value'])
      ->save();
    parent::submitForm($form, $form_state);
  }

}
