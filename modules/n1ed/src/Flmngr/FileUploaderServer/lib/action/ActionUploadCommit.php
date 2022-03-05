<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\file\FileUploaded;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\file\UtilsPHP;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\RespOk;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\RespUploadCommit;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;
use Exception;

/**
 * Action for processing upload commit request.
 */
class ActionUploadCommit extends AActionUploadId {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return "uploadCommit";
  }

  /**
   * Validates size options of the image.
   */
  protected function validateSize($size, $sizeName) {
    $size->enlarge = $this->validateBoolean($size->enlarge, $sizeName === "preview");
    $size->width = $this->validateInteger($size->width, 0);
    $size->height = $this->validateInteger($size->height, 0);
  }

  /**
   * Validates sizes.
   */
  protected function validateSizes($req) {
    if (!array_key_exists("sizes", $req) || $req->sizes === NULL) {
      $req->sizes = [];
    }
    else {
      $sizesNames = ["full", "preview"];
      for ($i = 0; $i < count($sizesNames); $i++) {
        $sizeName = $sizesNames[$i];
        if (array_key_exists($sizeName, $req->sizes)) {
          $this->validateSize($req->sizes->$sizeName, $sizeName);
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function run($req) {
    $this->validateUploadId($req);

    $this->validateSizes($req);

    $req->doCommit = $this->validateBoolean($req->doCommit, TRUE);
    $req->autoRename = $this->validateBoolean($req->autoRename, FALSE);
    $req->dir = $this->validateString($req->dir, "");

    if (strpos($req->dir, DIRECTORY_SEPARATOR) !== 0) {
      $req->dir = DIRECTORY_SEPARATOR . $req->dir;
    }

    if (UtilsPHP::normalizeNoEndSeparator($req->dir) === NULL) {
      throw new MessageException(Message::createMessage(Message::DIR_DOES_NOT_EXIST, $req->dir));
    }

    $req->dir = UtilsPHP::normalizeNoEndSeparator($req->dir) . DIRECTORY_SEPARATOR;

    $dir = $this->config->getBaseDir() . $req->dir;
    if (!file_exists($dir) && !mkdir($dir)) {
      throw new MessageException(Message::createMessage(Message::DIR_DOES_NOT_EXIST, $req->dir));
    }

    if ($req->files === NULL || count($req->files) == 0) {
      throw new MessageException(Message::createMessage(Message::FILES_NOT_SET));
    }

    $filesToCommit = [];
    for ($i = 0; $i < count($req->files); $i++) {
      $fileDef = $req->files[$i];

      if ($fileDef->name === NULL) {
        throw new MessageException(Message::createMessage(Message::MALFORMED_REQUEST));
      }

      if (!array_key_exists("newName", $fileDef) || $fileDef->newName === NULL) {
        $fileDef->newName = $fileDef->name;
      }

      $file = new FileUploaded($this->config, $req->uploadId, $fileDef->name, $fileDef->newName);
      $filesToCommit[] = $file;

      if (!$file->isImage() && count($req->sizes) > 0) {
        $file->addCustomError(Message::createMessage(Message::FILE_IS_NOT_IMAGE));
      }
    }

    // Check there are no equal names.
    for ($i = 0; $i < count($filesToCommit); $i++) {
      $name = $filesToCommit[$i]->getNewName();
      for ($j = 0; $j < count($filesToCommit); $j++) {
        $name2 = $filesToCommit[$j]->getNewName();
        if ($i != $j && $name === $name2) {
          $filesToCommit[$i]->addCustomError(Message::createMessage(Message::DUPLICATE_NAME));
          break;
        }
      }
    }

    // Check files for errors.
    for ($i = 0; $i < count($filesToCommit); $i++) {
      $file = $filesToCommit[$i];
      $file->checkForErrors(TRUE);
      if (!$req->autoRename) {
        $file->checkForConflicts($req->dir);
      }
    }

    $filesToCommitWithErrors = [];
    for ($i = 0; $i < count($filesToCommit); $i++) {
      if (count($filesToCommit[$i]->getErrors()) > 0) {
        $filesToCommitWithErrors[] = $filesToCommit[$i]->getData();
      }
    }

    if (count($filesToCommitWithErrors) > 0) {
      throw new MessageException(Message::createMessageByFiles(Message::FILES_ERRORS, $filesToCommitWithErrors));
    }

    // Validation ended.
    if (!$req->doCommit) {
      return new RespOk();
    }

    // 1. Commit.
    $filesCommited = [];
    for ($i = 0; $i < count($filesToCommit); $i++) {
      $fileToCommit = $filesToCommit[$i];
      $fileCommited = $fileToCommit->commit($req->dir, $req->autoRename);
      $filesCommited[] = $fileCommited;
      try {
        $fileCommited->applySizes($req->sizes);
      }
      catch (MessageException $e) {
        for ($j = 0; $j < count($filesCommited); $j++) {
          $filesCommited[$j]->delete();
        }
        throw $e;
      }
    }

    // 2. Remove uploadAndCommit directory.
    if (!$this->config->doKeepUploads()) {
      try {
        UtilsPHP::delete($this->config->getTmpDir() . DIRECTORY_SEPARATOR . $req->uploadId);
      }
      catch (Exception $e) {
        error_log($e);
        // Error, but we do not throw anything - we've commited
        // files and need to return them.
      }
    }

    // 3. Send response with the list of files copied.
    $files = [];
    for ($i = 0; $i < count($filesCommited); $i++) {
      $files[] = $filesCommited[$i]->getData();
    }

    $resp = new RespUploadCommit();
    $resp->files = $files;
    return $resp;
  }

}
