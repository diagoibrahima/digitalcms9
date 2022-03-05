<?php

namespace Drupal\n1ed\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Provides route responses for Flmngr file manager.
 */
class N1EDController extends ControllerBase {

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Symfony\Component\HttpFoundation\RequestStack definition.
   *
   * @var Symfony\Component\HttpFoundation\RequestStack
   */
  private $requestStack;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactoryInterface $config_factory,
      RequestStack $request_stack) {
    $this->configFactory = $config_factory;
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('request_stack')
    );
  }

  /**
   * Sets API key into Drupal config.
   */
  public function setApiKey() {
    $apiKey = $this->requestStack->getCurrentRequest()->request->get("n1edApiKey");
    $token = $this->requestStack->getCurrentRequest()->request->get("n1edToken");

    if($apiKey == NULL || $token == NULL) {
      throw new AccessDeniedHttpException();
    }

    $config = $this->configFactory->getEditable('n1ed.settings');
    $config->set('apikey', $apiKey);
    $config->set('token', $token);
    $config->save(TRUE);

    return new Response();
  }

  public function toggleUseFlmngrOnFileFields(){
    $useFlmngrOnFileFields = json_decode(file_get_contents('php://input'))->useFlmngrOnFileFields;
    $config = $this->configFactory->getEditable('n1ed.settings');
    $config->set('useFlmngrOnFileFields',$useFlmngrOnFileFields);
    $config->save(true);
    return new Response();
  }

}
