<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\RespUploadInit;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;

/**
 * Action for processing upload init request.
 */
class ActionUploadInit extends AAction {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return "uploadInit";
  }

  /**
   * {@inheritdoc}
   */
  public function run($req) {
    $alphabeth = "abcdefghijklmnopqrstuvwxyz0123456789";
    do {
      $id = "";
      for ($i = 0; $i < 6; $i++) {
        $charNumber = rand(0, strlen($alphabeth) - 1);
        $id .= substr($alphabeth, $charNumber, 1);
      }
      $dir = $this->config->getTmpDir() . DIRECTORY_SEPARATOR . $id;
    } while (file_exists($dir));

    if (!mkdir($dir)) {
      throw new MessageException(Message::createMessage(Message::UNABLE_TO_CREATE_UPLOAD_DIR));
    }

    return new RespUploadInit($id, $this->config);
  }

}
