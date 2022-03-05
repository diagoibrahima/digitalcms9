<?php

namespace Drupal\flags_ui\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class FlagMappingDeleteForm.
 *
 * Provides a confirm form for deleting the entity. This is different from the
 * add and edit forms as it does not inherit from ConfigEntityFormBase. The reason for
 * this is that we do not need to build the same form. Instead, we present the
 * user with a simple yes/no question. For this reason, we derive from
 * EntityConfirmFormBase instead.
 *
 * @package Drupal\flags\Form
 *
 * @ingroup flags
 */
abstract class FlagMappingDeleteForm extends EntityConfirmFormBase {

  /**
   * Gathers a confirmation question.
   *
   * The question is used as a title in our confirm form. For delete confirm
   * forms, this typically takes the form of "Are you sure you want to
   * delete...", including the entity label.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   Translated string.
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete mapping %label?', array(
        '%label' => $this->entity->label(),
    ));
  }

  /**
   * Gather the confirmation text.
   *
   * The confirm text is used as the text in the button that confirms the
   * question posed by getQuestion().
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup
   *   Translated string.
   */
  public function getConfirmText() {
    return $this->t('Delete mapping');
  }

  /**
   * The submit handler for the confirm form.
   *
   * For entity delete forms, you use this to delete the entity in
   * $this->entity.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   An associative array containing the current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Delete the entity.
    $this->entity->delete();

    // Set a message that the entity was deleted.
    $this->messenger()->addStatus($this->t('Mapping %label was deleted.', array(
      '%label' => $this->entity->label(),
    )));

    // Redirect the user to the list controller when complete.
    $form_state->setRedirectUrl($this->getCancelUrl());
  }

}
