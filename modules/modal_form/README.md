# Modal Form

A toolset for quick start of using forms in modal windows.

## Usage

The element to open a form in a modal window.

```php
$form['actions']['view_filter_save'] = [
  '#type' => 'modal_form_link',
  '#class' => ViewFilterSelectForm::class,
  '#title' => $this->t('Save filter'),
  '#access' => $this->currentUser->isAuthenticated(),
  '#printed' => !$this->isFiltersApplied(),
  '#attributes' => [
    'class' => ['save-filter'],
    'data-query-parameters' => Json::encode([
      'name' => $view_name,
      'display' => $this->view->current_display,
    ]),
    'data-dialog-options' => Json::encode([
      'dialogClass' => 'modal--views-save',
      'width' => '500px',
    ]),
  ],
];
```

The `ViewFilterSelectForm` is a standard form implementation (any class that implements the `\Drupal\Core\Form\FormInterface`).

The additional requirement is to implement the `\Drupal\modal_form\Form\ModalFormAccessInterface` to define the access checks.
