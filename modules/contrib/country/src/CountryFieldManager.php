<?php

namespace Drupal\country;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Locale\CountryManagerInterface;

/**
 * Defines a class for country field management.
 */
class CountryFieldManager {

  /**
   * The country manager.
   *
   * @var \Drupal\Core\Locale\CountryManagerInterface
   */
  protected $countryManager;

  /**
   * Constructs a new CountryAutocompleteController.
   *
   * @param \Drupal\Core\Locale\CountryManagerInterface $country_manager
   *   The country manager.
   */
  public function __construct(CountryManagerInterface $country_manager) {
    $this->countryManager = $country_manager;
  }

  /**
   * Get array of selectable countries.
   *
   * If some countries have been selected at the default field settings, allow
   * only those to be selectable. Else, check if any have been selected for the
   * field instance. If none, allow all available countries.
   *
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *  The field definition object.
   *
   * @return array
   *   The array of country names keyed by their ISO2 values.
   */
  public function getSelectableCountries(FieldDefinitionInterface $field_definition) {
    $field_definition_countries = $field_definition->getSetting('selectable_countries');
    $field_storage_countries = $field_definition->getFieldStorageDefinition()->getSetting('selectable_countries');

    $countries = $this->countryManager->getList();

    $allowed = (!empty($field_definition_countries)) ? $field_definition_countries : $field_storage_countries;
    return  (!empty($allowed)) ? array_intersect_key($countries, $allowed) : $countries;
  }
}
