<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\file\FileUploaded;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\RespOk;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;

/**
 * Action for processing removing file from a upload list.
 */
class ActionUploadRemoveFile extends AActionUploadId {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return "uploadRemoveFile";
  }

  /**
   * {@inheritdoc}
   */
  public function run($req) {
    $this->validateUploadId($req);
    $file = new FileUploaded($this->config, $req->uploadId, $req->name, $req->name);
    $file->checkForErrors(TRUE);

    if ($file->getErrors()->size() > 0) {
      throw new MessageException(Message::createMessageByFile(Message::UNABLE_TO_DELETE_UPLOAD_DIR, $file->getData()));
    }

    $file->delete();
    return new RespOk();
  }

}
