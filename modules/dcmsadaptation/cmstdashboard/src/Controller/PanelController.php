<?php

namespace Drupal\cmst_dashboard\Controller;

use Drupal\Core\Controller\ControllerBase;

class PanelController extends ControllerBase {

  public function displayPanelPage() {

    return array(
      '#theme' => 'dashboard_page',
      '#text' => $this->t('CMS TRANSLATION !'),
    );

  }

}