<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\file\UtilsPHP;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\RespOk;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;
use Exception;

/**
 * Action for processing upload cancel request.
 */
class ActionUploadCancel extends AActionUploadId {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return "uploadCancel";
  }

  /**
   * {@inheritdoc}
   */
  public function run($req) {
    $this->validateUploadId($req);
    if (!$this->config->doKeepUploads()) {
      try {
        UtilsPHP::delete($this->config->getTmpDir() . DIRECTORY_SEPARATOR . $req->uploadId);
      }
      catch (Exception $e) {
        error_log($e);
        throw new MessageException(Message::createMessage(Message::UNABLE_TO_DELETE_UPLOAD_DIR));
      }
    }
    return new RespOk();
  }

}
