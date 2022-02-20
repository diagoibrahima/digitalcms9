<?php

namespace Drupal\flags_country\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Template\Attribute;
use Drupal\country\CountryFieldManager;
use Drupal\country\Plugin\Field\FieldFormatter\CountryDefaultFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'country' formatter.
 *
 * @FieldFormatter(
 *   id = "country_flag",
 *   label = @Translation("Country with flag"),
 *   field_types = {
 *     "country"
 *   }
 * )
 */
class CountryFlagFormatter extends CountryDefaultFormatter {

  /**
   * The country field manager.
   *
   * @var \Drupal\country\CountryFieldManager
   */
  protected $countryFieldManager;


  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, CountryFieldManager $country_field_manager) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->countryFieldManager = $country_field_manager;
  }


  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($plugin_id, $plugin_definition, $configuration['field_definition'],
      $configuration['settings'], $configuration['label'],
      $configuration['view_mode'], $configuration['third_party_settings'],
      $container->get('country.field.manager')
    );
  }



  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    $settings = array();

    // Fall back to field settings by default.
    $settings['flag_display'] = 'flag-before';

    return $settings;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);

    $form['flag_display'] = array(
      '#type' => 'select',
      '#title' => $this->t('Output format'),
      '#default_value' => $this->getSetting('flag_display'),
      '#options' => $this->getOutputFormats(),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();

    $format = $this->getSetting('flag_display');
    $formats = $this->getOutputFormats();

    $summary[] = $formats[$format];

    return $summary;
  }

  /**
   * Gets available view formats.
   *
   * @return string[]
   */
  protected function getOutputFormats() {
    return array(
      'flag-before' => $this->t('Flag before country name'),
      'flag-after' => $this->t('Flag after country name'),
      'flag-instead' => $this->t('Replace country name with flag'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $countries = $this->countryFieldManager->getSelectableCountries($this->fieldDefinition);
    $elements  = parent::viewElements($items, $langcode);

    $format = $this->getSetting('flag_display');
    $attributes = new Attribute(array('class' => array($format)));

    foreach ($items as $delta => $item) {
      if (isset($countries[$item->value])) {
        unset($elements[$delta]['#markup']);
        if ('flag-instead' != $format) {
          $elements[$delta]['country'] = array('#markup' => $countries[$item->value]);
        }

        $elements[$delta]['flag'] = array(
          '#theme' => 'flags',
          '#code' => strtolower($item->value),
          '#attributes' => clone $attributes,
          '#source' => 'country',
        );
      }

      $elements[$delta]['#prefix'] = '<div class="field__flags__item">';
      $elements[$delta]['#suffix'] = '</div>';
    }

    return $elements;
  }

}
