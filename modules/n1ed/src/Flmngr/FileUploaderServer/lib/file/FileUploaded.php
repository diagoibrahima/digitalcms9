<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\file;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;

/**
 * Uploaded but not commited yet file.
 * Data stucture about file is to be converted to commited file when
 * all validations are passed.
 */
class FileUploaded extends AFile {

  protected $newName;

  protected $confilictsErrors = [];

  protected $customErrors = [];

  /**
   * {@inheritdoc}
   */
  public function __construct($config, $dir, $name, $newName) {
    parent::__construct($config, $dir, $name);
    $this->newName = $newName;
  }

  /**
   * {@inheritdoc}
   */
  public function getBaseDir() {
    return $this->config->getTmpDir();
  }

  /**
   * {@inheritdoc}
   */
  public function getNewName() {
    return $this->newName;
  }

  /**
   * {@inheritdoc}
   */
  public function checkForErrors($checkForExist) {
    if (!parent::checkForErrors($checkForExist)) {
      return FALSE;
    }

    if ($this->newName !== $this->getName() && !Utils::isFileNameSyntaxOk($this->newName)) {
      $this->commonErrors[] = Message::createMessage(Message::FILE_ERROR_SYNTAX, $this->newName);
    }

    if (Utils::isImage($this->getName())) {
      $ext = $this->getExt();
      $newExt = Utils::getExt($this->newName);
      if ($ext !== $newExt) {
        if (!($ext === "jpg" && $newExt === "jpeg") && !($ext === "jpeg" && $newExt === "jpg")) {
          $this->commonErrors[] = Message::createMessage(Message::FILE_ERROR_INCORRECT_IMAGE_EXT_CHANGE, $ext, $newExt);
        }
      }
    }
    return TRUE;
  }

  /**
   * Adds custom error.
   */
  public function addCustomError($message) {
    $this->customErrors[] = $message;
  }

  /**
   * {@inheritdoc}
   */
  public function getErrors() {
    $errors = (array) parent::getErrors();
    for ($i = 0; $i < count($this->confilictsErrors); $i++) {
      $errors[] = $this->confilictsErrors[$i];
    }
    for ($i = 0; $i < count($this->customErrors); $i++) {
      $errors[] = $this->customErrors[$i];
    }
    return $errors;
  }

  /**
   * Gets commited file.
   */
  public function getCommitedFile($dir) {
    return new FileCommited($this->config, $dir, $this->newName);
  }

  /**
   * Checks for conflicts.
   */
  public function checkForConflicts($dir) {
    $this->confilictsErrors = [];

    $file = $this->getCommitedFile($dir);
    if ($file->exists()) {
      $this->confilictsErrors[] = Message::createMessage(Message::FILE_ALREADY_EXISTS, $file->getName());
    }

    if ($file->isImage()) {
      $fileOriginal = $file->getFileOriginal();
      if ($fileOriginal->exists()) {
        $this->confilictsErrors[] = Message::createMessage(Message::FILE_ALREADY_EXISTS, $fileOriginal->getName());
      }

      $filePreview = $file->getFilePreview();
      if ($filePreview->exists()) {
        $this->confilictsErrors[] = Message::createMessage(Message::FILE_ALREADY_EXISTS, $filePreview->getName());
      }
    }

  }

  /**
   * Uploads and commits file.
   */
  public function uploadAndCommit($file) {
    $initName = $this->getName();
    $this->setFreeFileName();
    if (!move_uploaded_file($file['tmp_name'], $this->getFullPath())) {
      throw new MessageException(Message::createMessage(Message::WRITING_FILE_ERROR, $initName));
    }
  }

  /**
   * Rehosts a file (downloads from some URL).
   */
  public function rehost($url) {
    $dUrl = URLDownloader::download($url, $this->getBaseDir() . DIRECTORY_SEPARATOR . $this->getDir());
    $this->setName($dUrl->fileName);
  }

  /**
   * Commits a file.
   */
  public function commit($dir, $autoRename) {
    $file = $this->getCommitedFile($dir);
    if ($autoRename) {
      $file->setFreeFileName();
    }
    $this->copyTo($file);
    return $file;
  }

  /**
   * Is file commited.
   */
  public function isCommited() {
    return FALSE;
  }

}
