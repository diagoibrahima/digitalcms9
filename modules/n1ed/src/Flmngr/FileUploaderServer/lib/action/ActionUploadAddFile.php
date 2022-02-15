<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\RespUploadAddFile;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\file\FileUploaded;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;

/**
 * Action for processing add file request.
 */
class ActionUploadAddFile extends AActionUploadId {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return "uploadAddFile";
  }

  /**
   * {@inheritdoc}
   */
  public function run($req) {
    $this->validateUploadId($req);

    $file = NULL;
    if (!array_key_exists("url", $req)) {
      if ($req->fileName === NULL || $req->file === NULL) {
        throw new MessageException(Message::createMessage(Message::NO_FILE_UPLOADED));
      }

      if ($this->config->getMaxUploadFileSize() > 0 && $req->fileSize > $this->config->getMaxUploadFileSize()) {
        throw new MessageException(Message::createMessage(Message::FILE_SIZE_EXCEEDS_LIMIT, $req->fileName, "" . $req->fileSize, "" . $this->config->getMaxUploadFileSize()));
      }

      $file = new FileUploaded($this->config, $req->uploadId, $req->fileName, $req->fileName);
      $ext = strtolower($file->getExt());
      $allowedExts = $this->config->getAllowedExtensions();
      $isAllowedExt = count($allowedExts) == 0;
      for ($i = 0; $i < count($allowedExts) && !$isAllowedExt; $i++) {
        $isAllowedExt = $allowedExts[$i] === $ext;
      }
      if (!$isAllowedExt) {
        $strExts = "";
        for ($i = 0; $i < count($allowedExts); $i++) {
          if ($i > 0) {
            $strExts .= ", ";
          }
          $strExts .= $allowedExts[$i];
        }
        throw new MessageException(Message::createMessage(Message::INCORRECT_EXTENSION, $req->fileName, $strExts));
      }
      $file->uploadAndCommit($req->file);
    }
    else {
      if (filter_var($req->url, FILTER_VALIDATE_URL) === FALSE) {
        throw new MessageException(Message::createMessage(Message::DOWNLOAD_FAIL_INCORRECT_URL, $req->url));
      }
      $host = strtolower(parse_url($req->url, PHP_URL_HOST));
      $isHostAllowed = FALSE;
      $relocateHosts = $this->config->getRelocateFromHosts();
      for ($i = 0; $i < count($relocateHosts) && !$isHostAllowed; $i++) {
        if (strtolower($relocateHosts[$i]) === $host) {
          $isHostAllowed = TRUE;
        }
      }
      if (count($relocateHosts) == 0 || $isHostAllowed) {
        $file = new FileUploaded($this->config, $req->uploadId, NULL, NULL);
        $file->rehost($req->url);
      }
      else {
        throw new MessageException(Message::createMessage(Message::DOWNLOAD_FAIL_HOST_DENIED, $host));
      }
    }
    $resp = new RespUploadAddFile();
    $resp->file = $file->getData();
    return $resp;
  }

}
