<?php

namespace Drupal\modal_form\Form;

use Drupal\Core\Session\AccountInterface;

/**
 * An interface to implement by a form for checking its accessibility.
 */
interface ModalFormAccessInterface {

  /**
   * Returns a state whether the form is accessible.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account of a user to check an access for.
   *
   * @return bool
   *   The state whether an access to form is granted or not.
   *
   * @see \Drupal\modal_form\Controller\ModalFormController::getForm()
   */
  public function isAccessible(AccountInterface $account): bool;

}
