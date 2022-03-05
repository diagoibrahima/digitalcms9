<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib;

use Exception;

/**
 * Exception with a message.
 * Thrown when we need to return JSON about the error.
 */
class MessageException extends Exception {

  protected $message;

  /**
   * {@inheritdoc}
   */
  public function __construct($message) {
    parent::__construct();
    $this->message = (array) $message;
  }

  /**
   * Gets fail message.
   */
  public function getFailMessage() {
    return $this->message;
  }

}
