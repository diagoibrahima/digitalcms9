<?php

namespace Drupal\n1ed\Flmngr\FlmngrServer\model;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;

/**
 * Message of file manager which convers to string on the client side.
 * Converted to the string on client side.
 */
class FMMessage extends Message {

  const FM_FILE_DOES_NOT_EXIST = 10001;

  const FM_UNABLE_TO_WRITE_PREVIEW_IN_CACHE_DIR = 10002;

  const FM_UNABLE_TO_CREATE_PREVIEW = 10003;

  const FM_DIR_NAME_CONTAINS_INVALID_SYMBOLS = 10004;

  const FM_DIR_NAME_INCORRECT_ROOT = 10005;

  const FM_FILE_IS_NOT_IMAGE = 10006;

  const FM_ROOT_DIR_DOES_NOT_EXIST = 10007;

  const FM_UNABLE_TO_LIST_CHILDREN_IN_DIRECTORY = 10008;

  const FM_UNABLE_TO_DELETE_DIRECTORY = 10009;

  const FM_UNABLE_TO_CREATE_DIRECTORY = 10010;

  const FM_UNABLE_TO_RENAME = 10011;

  const FM_DIR_CANNOT_BE_READ = 10012;

  const FM_ERROR_ON_COPYING_FILES = 10013;

  const FM_ERROR_ON_MOVING_FILES = 10014;

  const FM_NOT_ERROR_NOT_NEEDED_TO_UPDATE = 10015;

}
