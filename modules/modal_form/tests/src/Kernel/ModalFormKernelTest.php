<?php

namespace Drupal\Tests\modal_form\Kernel;

use Drupal\Core\Session\AccountInterface;
use Drupal\KernelTests\KernelTestBase;
use Drupal\modal_form\Controller\ModalFormController;
use Drupal\modal_form\Form\ModalFormAccessInterface;
use Drupal\user\Form\UserPermissionsForm;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * The permissions form that is unconditionally accessible as a modal form.
 */
class CustomAccessibleUserPermissionsForm extends UserPermissionsForm implements ModalFormAccessInterface {

  /**
   * {@inheritdoc}
   */
  public function isAccessible(AccountInterface $account): bool {
    return TRUE;
  }

}

/**
 * The permissions form that is unconditionally inaccessible as a modal form.
 */
class CustomInaccessibleUserPermissionsForm extends CustomAccessibleUserPermissionsForm {

  /**
   * {@inheritdoc}
   */
  public function isAccessible(AccountInterface $account): bool {
    return FALSE;
  }

}

/**
 * Provides the kernel-level tests.
 *
 * @group modal_form
 */
class ModalFormKernelTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'user',
    'system',
  ];

  /**
   * Tests that "CustomAccessibleUserPermissionsForm" is accessible.
   *
   * @throws \Exception
   */
  public function testAccess(): void {
    static::assertNotEmpty(ModalFormController::create($this->container)->getForm(CustomAccessibleUserPermissionsForm::class));
  }

  /**
   * Tests that "CustomInaccessibleUserPermissionsForm" is not accessible.
   *
   * @param string $form_fqcn
   *   The fully-qualified class name of a form.
   * @param string $expected_message
   *   The expected error message.
   *
   * @throws \Exception
   *
   * @dataProvider providerNoAccess
   */
  public function testNoAccess(string $form_fqcn, string $expected_message): void {
    $this->expectException(AccessDeniedHttpException::class);
    $this->expectExceptionMessage($expected_message);
    ModalFormController::create($this->container)->getForm($form_fqcn);
  }

  /**
   * Returns the test cases of inaccessible forms.
   *
   * @return string[][]
   *   The array of arrays with form's FQCN and expected error message.
   */
  public function providerNoAccess(): array {
    return [
      [
        UserPermissionsForm::class,
        'The form does not implement the access check.',
      ],
      [
        CustomInaccessibleUserPermissionsForm::class,
        'You do not have an access to this form.',
      ],
    ];
  }

}
