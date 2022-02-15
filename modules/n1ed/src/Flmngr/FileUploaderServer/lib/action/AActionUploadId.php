<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;

/**
 * Abstract class for all upload actions.
 */
abstract class AActionUploadId extends AAction {

  /**
   * Validates upload ID and throws exception in case of validation error.
   */
  protected function validateUploadId($req) {
    if ($req->uploadId === NULL) {
      throw new MessageException(Message::createMessage(Message::UPLOAD_ID_NOT_SET));
    }

    $dir = $this->config->getTmpDir() . DIRECTORY_SEPARATOR . $req->uploadId;
    if (!file_exists($dir) || !is_dir($dir)) {
      throw new MessageException(Message::createMessage(Message::UPLOAD_ID_INCORRECT));
    }
  }

}
