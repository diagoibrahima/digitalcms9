<?php

namespace Drupal\n1ed\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Drupal\n1ed\Controller\N1EDSelfHosted;

/**
 * Provides route responses for Flmngr file manager.
 */
class SelfHostedHandler extends ControllerBase {

  private $plugins_folder = DRUPAL_ROOT . "/lib/N1EDSelfHosted/ckeditor/plugins/";

  private $self_hosted_URL = '/lib/N1EDSelfHosted/';

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

  private $plugin_file = DRUPAL_ROOT . "/lib/N1EDSelfHosted/ckeditor/plugins/N1EDEco/plugin.js";

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactoryInterface $config_factory,
      RequestStack $request_stack) {
    $this->configFactory = $config_factory;
    $this->requestStack = $request_stack;
    $this->N1EDSelfHosted = new N1EDSelfHosted($this->plugin_file,$this->self_hosted_URL,$this->plugins_folder);
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

  private function setSelfHostedMode(bool $value): void{
      $config = $this->configFactory->getEditable('n1ed.settings');
      $config->set('selfHosted',$value);
      $config->save(true);
  }

  private function setSelfHosted(bool $value):Response{

    if($value){
      if($this->N1EDSelfHosted->checkSelfHostedFiles()){
        $this->N1EDSelfHosted->rebuildDependencies();
        $this->setSelfHostedMode($value);
      } else {
        return new Response(json_encode($this->N1EDSelfHosted->noFilesResponse()));
      }
    } else {
      $this->setSelfHostedMode($value);
    }

    return new Response(json_encode(['error' => null, 'data' => 'ok']));

  }

  public function selfHostedHandler(){
    $action = $this->requestStack->getCurrentRequest()->request->get("action");
    switch ($action) {
      case 'setSelfHosted':

        return $this->setSelfHosted($this->requestStack->getCurrentRequest()->request->get("isSelfHosted") == 'true');
        break;

      case 'getConfig':
        return new Response(json_encode($this->N1EDSelfHosted->getSelfHostedConfig()));
        break;
      case 'setConfig':
        return new Response(json_encode($this->N1EDSelfHosted->setSelfHostedConfig($this->requestStack->getCurrentRequest()->request->get("n1edConfig"))));
       break;
      default:
        return new Response(json_encode(['error' => "NO_ACTION_DEFINED", 'data' => null]));
        break;
    }

  }

}
