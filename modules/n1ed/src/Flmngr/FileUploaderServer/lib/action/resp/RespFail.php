<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp;

/**
 * Response about a fail.
 * For conversion to JSON.
 */
class RespFail extends RespOk {

  public $message;

  /**
   * Creates response with a message.
   */
  public function __construct($message) {
    $this->ok = FALSE;
    $this->message = $message;
  }

}
