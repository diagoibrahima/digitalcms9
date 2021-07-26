<?php

namespace Drupal\hello_galaxy\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class PanelController extends ControllerBase {

  public function displayPanelPage() {

    $config = $this->config('hello_galaxy.settings');

    return array(
      '#theme' => 'panel_page',
      '#text' => $config->get('page_text'),
    );

$article = Node::create(array(
    'type' => 'article',
    'title' => 'Article créé par programmation',
    'langcode' => 'fr',
    'uid' => '1',
    'status' => 1,
    'body' => 'Lorem ipsum...',
));
	
$article->save();

  }

}