<?php

namespace Drupal\flags_languagefield\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\LanguageSelectWidget;
use Drupal\Core\Form\FormStateInterface;
use Drupal\flags\Mapping\Language;
use Drupal\flags_language\Plugin\Field\FieldWidget\LanguageSelectMenuWidget;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'languagefield_select_menu' widget.
 *
 * @FieldWidget(
 *   id = "languagefield_select_menu",
 *   label = @Translation("Language select list with flags"),
 *   field_types = {}
 * )
 */
class LanguagefieldSelectMenuWidget extends LanguageSelectWidget {

  /**
   * The flags.mapping.language service.
   *
   * @var \Drupal\flags\Mapping\Language
   */
  protected $flagsMappingLanguage;

  /**
   * LanguagefieldSelectMenuWidget constructor.
   *
   * @param string $plugin_id
   *   The plugin_id for the widget.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the widget is associated.
   * @param array $settings
   *   The widget settings.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\flags\Mapping\Language $flags_mapping_language
   *   The flags.mapping.language service.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, array $third_party_settings, Language $flags_mapping_language) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
    $this->flagsMappingLanguage = $flags_mapping_language;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($plugin_id, $plugin_definition, $configuration['field_definition'],
      $configuration['settings'], $configuration['third_party_settings'],
      $container->get('flags.mapping.language')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    $element['value']['#type'] = 'select_icons';

    $element['value']['#options_attributes'] = $this->flagsMappingLanguage->getOptionAttributes(
      array_keys($element['value']['#options'])
    );
    $element['value']['#attached'] = array('library' => array('flags/flags'));

    return $element;
  }

}
