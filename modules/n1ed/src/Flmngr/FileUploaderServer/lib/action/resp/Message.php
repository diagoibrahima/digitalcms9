<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp;

/**
 * A message convertable from code to string on client side.
 * Converted to the strings on a client side.
 */
class Message {

  const FILE_ERROR_SYNTAX = -1;

  const FILE_ERROR_DOES_NOT_EXIST = -2;

  const FILE_ERROR_INCORRECT_IMAGE_EXT_CHANGE = -3;

  const ACTION_NOT_FOUND = 0;

  const UNABLE_TO_CREATE_UPLOAD_DIR = 1;

  const UPLOAD_ID_NOT_SET = 2;

  const UPLOAD_ID_INCORRECT = 3;

  const MALFORMED_REQUEST = 4;

  const NO_FILE_UPLOADED = 5;

  const FILE_SIZE_EXCEEDS_LIMIT = 6;

  const INCORRECT_EXTENSION = 7;

  const WRITING_FILE_ERROR = 8;

  const UNABLE_TO_DELETE_UPLOAD_DIR = 9;

  const UNABLE_TO_DELETE_FILE = 10;

  const DIR_DOES_NOT_EXIST = 11;

  const FILES_NOT_SET = 12;

  const FILE_IS_NOT_IMAGE = 13;

  const DUPLICATE_NAME = 14;

  const FILE_ALREADY_EXISTS = 15;

  const FILES_ERRORS = 16;

  const UNABLE_TO_COPY_FILE = 17;

  const IMAGE_PROCESS_ERROR = 18;

  const MAX_RESIZE_WIDTH_EXCEEDED = 19;

  const MAX_RESIZE_HEIGHT_EXCEEDED = 20;

  const UNABLE_TO_WRITE_IMAGE_TO_FILE = 21;

  const INTERNAL_ERROR = 22;

  const DOWNLOAD_FAIL_CODE = 23;

  const DOWNLOAD_FAIL_IO = 24;

  const DOWNLOAD_FAIL_HOST_DENIED = 25;

  const DOWNLOAD_FAIL_INCORRECT_URL = 26;

  public $code;

  public $args;

  public $files;

  /**
   * Creates a message.
   */
  public static function createMessage($code, $arg1 = NULL, $arg2 = NULL, $arg3 = NULL) {
    $msg = new Message();
    $msg->code = $code;
    if ($arg1 != NULL) {
      $msg->args = [];
      $msg->args[] = $arg1;
      if ($arg2 != NULL) {
        $msg->args[] = $arg2;
        if ($arg3 != NULL) {
          $msg->args[] = $arg3;
        }
      }
    }
    return $msg;
  }

  /**
   * Creates a message by files.
   */
  public static function createMessageByFiles($code, $files) {
    $msg = new Message();
    $msg->code = $code;
    $msg->files = $files;
    return $msg;
  }

  /**
   * Creates a message by single file.
   */
  public static function createMessageByFile($code, $file) {
    $msg = new Message();
    $msg->code = $code;
    $msg->files = [];
    $msg->files[] = $file;
    return $msg;
  }

}
