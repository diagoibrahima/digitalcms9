<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\req;

/**
 * Request data structure.
 */
class Req {

  public $action;

  public $testClearAllFiles;

  public $testServerConfig;

  public $fileName;

  public $fileSize;

  public $file;

}
/**
 * Error request.
 */
class ReqError extends Req {

  public $message;

  public static function createReqError($msg) {
    $req = new ReqError();
    $req->message = $msg;
    $req->action = "error";
    return $req;
  }

}
/**
 * Upload request with ID - base upload request class.
 */
class ReqUploadId extends Req {

  public $uploadId;

}
/**
 * Add file to upload list request.
 */
class ReqUploadAddFile extends ReqUploadId {

  public $url;

}
/**
 * Remove file from upload list request.
 */
class ReqUploadRemoveFile extends ReqUploadId {

  public $name;

}
/**
 * Commit uploaded files request.
 */
class ReqUploadCommit extends ReqUploadId {

  public $sizes;

  public $doCommit;

  public $autoRename;

  public $dir;

  public $files;

}
