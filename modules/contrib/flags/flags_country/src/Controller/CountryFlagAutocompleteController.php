<?php

namespace Drupal\flags_country\Controller;

use Drupal\Core\Locale\CountryManagerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\country\Controller\CountryAutocompleteController;
use Drupal\country\CountryFieldManager;
use Drupal\field\Entity\FieldConfig;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Returns autocomplete responses for countries.
 */
class CountryFlagAutocompleteController extends CountryAutocompleteController {


  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * CountryFlagAutocompleteController constructor.
   * @param \Drupal\Core\Locale\CountryManagerInterface $country_manager
   * @param \Drupal\country\CountryFieldManage $country_field_manager
   * @param \Drupal\Core\Render\RendererInterface $renderer
   */
  public function __construct(CountryManagerInterface $country_manager, CountryFieldManager $country_field_manager, RendererInterface $renderer) {
    $this->renderer = $renderer;
    parent::__construct($country_manager, $country_field_manager);
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('country_manager'),
      $container->get('country.field.manager'),
      $container->get('renderer')
    );

  }

  /**
   * Returns response for the country name autocompletion.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request object containing the search string.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   A JSON response containing the autocomplete suggestions for countries.
   */
  public function autocomplete(Request $request, $entity_type, $bundle, $field_name) {
    $matches = array();
    $string = $request->query->get('q');
    if ($string) {
      $field_definition = FieldConfig::loadByName($entity_type, $bundle, $field_name);
      $countries = $this->countryFieldManager->getSelectableCountries($field_definition);
      foreach ($countries as $iso2 => $country) {
        if (strpos(mb_strtolower($country), mb_strtolower($string)) !== FALSE) {
          $label = array(
            'country' => array('#markup' => $country),
            'flag' => array(
              '#theme' => 'flags',
              '#code' => strtolower($iso2),
              '#source' => 'country',
            ),
          );

          $matches[] = array('value' => $country, 'label' => $this->renderer->render($label));
        }
      }
    }
    return new JsonResponse($matches);
  }

}
