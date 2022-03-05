<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\RespFail;

/**
 * Action for processing errors.
 */
class ActionError extends AAction {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return "error";
  }

  /**
   * {@inheritdoc}
   */
  public function run($req) {
    return new RespFail($req->message);
  }

}
