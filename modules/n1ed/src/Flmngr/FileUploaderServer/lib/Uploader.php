<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\req\ReqError;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\RespFail;

/**
 * Uploader - main processor for incoming request, invokes according action.
 */
class Uploader {

  protected $actions;

  protected $config;

  /**
   * Creates an instance.
   */
  public function __construct($config, $actions) {
    $this->config = $config;
    $this->actions = $actions;
  }

  /**
   * Processes upload request.
   */
  public function run($req) {
    $actionName = $req->action;
    $action = $this->actions->getAction($actionName);
    if ($action === NULL) {
      $action = $this->actions->getActionError();
      $req = ReqError::createReqError(Message::createMessage(Message::ACTION_NOT_FOUND));
    }
    $action->setConfig($this->config);
    $resp = NULL;
    try {
      $resp = $action->run($req);
    }
    catch (MessageException $e) {
      $resp = new RespFail($e->getFailMessage());
    }
    return $resp;
  }

}
