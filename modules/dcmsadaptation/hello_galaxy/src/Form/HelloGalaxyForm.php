<?php

namespace Drupal\hello_galaxy\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class HelloGalaxyForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'hello_galaxy_form';
  }

/**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);
    $config = $this->config('hello_galaxy.settings');

    $form['page_text'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Contenu de la page Hello Galaxy'),
      '#default_value' => $config->get('page_text'),
      '#description' => $this->t('Permet de définir le texte de la page Hello Galaxy'),
    );

	return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = $this->config('hello_galaxy.settings');

    $config->set('page_text', $form_state->getValue('page_text'));
    
    $config->save();

    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'hello_galaxy.settings',
    ];
  }

}