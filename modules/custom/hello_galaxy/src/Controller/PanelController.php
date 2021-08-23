<?php

namespace Drupal\hello_galaxy\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Form\FormStateInterface;

class PanelController extends ControllerBase {

  public function displayPanelPage() {

    $config = $this->config('hello_galaxy.settings');

/*
$article = Node::create(array(
    'type' => 'article',
    'title' => 'Article créé par programmation',
    'langcode' => 'fr',
    'uid' => '1',
    'status' => 1,
    'body' => 'Lorem ipsum...',
));
	
$article->save();
*/

/** display existing article */


$entity = \Drupal::entityTypeManager()->getStorage('node');
$query = $entity->getQuery();
    
$ids = $query->condition('status', 1)
 ->condition('type', 'course')#type = bundle id (machine name)
 #->sort('created', 'ASC') #sorted
 #->pager(15) #limit 15 items
 ->execute();

// Load multiples or single item load($id)
$articles = $entity->loadMultiple($ids);


            $data = [];
            foreach($articles as $row){
                $data[] = [
                    'Libele'=> $row->Libele

                ];
            }

 $header = array('Libele');

            $build['table'] = [
                '#type'=>'table',
                '#rows'=>$data
            ];

return array(
      '#theme' => 'panel_page',
      '#text' => $articles
    );


  }



 
/**
 * Implements hook_form_alter().
 */
function starting_drupal_dev_form_alter(&$form, &$form_state, $form_id) {
dpm($form_id);
}


/**
 * Implements hook_form_alter().
 */







}