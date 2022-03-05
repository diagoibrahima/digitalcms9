<?php

namespace Drupal\n1ed\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * {@inheritdoc}
 */
class N1EDConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'n1ed_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('n1ed.settings');

    $form['title'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#value' => $this->t('All the main N1ED settings are inside <a href=":formats">Text Formats</a>.<br/><b>This section is for advanced users only</b>. Be sure you know what you do to avoid breaking N1ED normal working.', [
        ":formats" => Url::fromRoute('filter.admin_overview')
          ->toString(),
      ]),
    ];

    $form['version'] = [
      '#type' => 'textfield',
      '#title' => $this->t('N1ED version'),
      '#default_value' => $config->get('version') ?: '',
      '#required' => FALSE,
    ];
    $form['versioin_text'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#attributes' => [
        'style' => 'margin-bottom:12px;margin-top: -4px;',
      ],
      '#value' => $this->t('Leave it blank to have always the latest version.'),
    ];

    $form['urlCache'] = [
      '#type' => 'textfield',
      '#title' => $this->t('URL of the cache server'),
      '#default_value' => $config->get('urlCache') ?: '',
      '#required' => FALSE,
    ];
    $form['urlCache_text'] = [
      '#type' => 'html_tag',
      '#tag' => 'p',
      '#attributes' => [
        'style' => 'margin-bottom:12px;margin-top: -4px;',
      ],
      '#value' => $this->t('Leave it blank to disable caching.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $config = $this->config('n1ed.settings');
    $config->set('version', $values['version'])->save();
    $config->set('urlCache', $values['urlCache'])->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['n1ed.settings'];
  }

}
