<?php

namespace Drupal\modal_form\Element;

use Drupal\Core\Render\Element\Link;
use Drupal\Core\Url;

/**
 * Adds a link for rendering a form in a modal window.
 *
 * @example
 * All the rest of attributes that are allowed for "link" element are
 * acceptable here.
 * @code
 * $build['examples_modal_form_link'] = [
 *   '#type' => 'modal_form_link',
 *   '#title' => t('Examples'),
 *   '#class' => 'My\Namespace\ClassName',
 * ];
 * @endcode
 *
 * @RenderElement("modal_form_link")
 */
class ModalFormLink extends Link {

  public const CONTROLLER_ROUTE = 'modal_form.modal_form';

  /**
   * {@inheritdoc}
   */
  public function getInfo(): array {
    $info = parent::getInfo();

    $info['#class'] = '';
    $info['#attached']['library'][] = 'modal_form/modal_form';

    return $info;
  }

  /**
   * {@inheritdoc}
   */
  public static function preRenderLink($element): array {
    if (!empty($element['#class']) && \class_exists($element['#class'])) {
      $element['#url'] = Url::fromRoute(static::CONTROLLER_ROUTE, [
        'form_fqcn' => $element['#class'],
      ]);
    }

    $element['#attributes']['role'] = 'button';
    $element['#attributes']['data-dialog-type'] = 'modal';

    $element['#attributes']['class'][] = 'use-ajax';
    $element['#attributes']['class'][] = 'use-modal-form';

    return parent::preRenderLink($element);
  }

}
