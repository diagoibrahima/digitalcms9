<?php

namespace Drupal\modal_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Form\FormState;
use Drupal\Core\Session\AccountInterface;
use Drupal\modal_form\Form\ModalFormAccessInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * The controller that builds a form by its class name.
 */
class ModalFormController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function __construct(FormBuilderInterface $form_builder, AccountInterface $current_user) {
    $this->formBuilder = $form_builder;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new static($container->get('form_builder'), $container->get('current_user'));
  }

  /**
   * Returns a constructed form.
   *
   * @param string $form_fqcn
   *   The fully-qualified class name of a form.
   *
   * @return array
   *   The implementation of a form.
   *
   * @throws \Exception
   *   Follow the "buildForm" method for the exceptions documentation.
   * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
   *   When the form is not accessible or does not implement the access check.
   */
  public function getForm(string $form_fqcn): array {
    try {
      $form_state = new FormState();
      $form_state->addBuildInfo('args', []);

      $this->formBuilder->getFormId($form_fqcn, $form_state);
    }
    catch (\Exception $e) {
      return [
        '#title' => $this->t('Error occurred'),
        '#markup' => $e->getMessage(),
      ];
    }

    $form_object = $form_state->getFormObject();

    if ($form_object instanceof ModalFormAccessInterface) {
      if (!$form_object->isAccessible($this->currentUser)) {
        throw new AccessDeniedHttpException('You do not have an access to this form.');
      }
    }
    else {
      throw new AccessDeniedHttpException('The form does not implement the access check.');
    }

    return $this->formBuilder->buildForm($form_fqcn, $form_state);
  }

}
