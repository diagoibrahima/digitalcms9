<?php

namespace Drupal\n1ed\Flmngr\FlmngrServer\resp;

/**
 * Response object.
 * Converted to JSON when ready to return HTTP response.
 */
class Response {

  public $error;

  public $data;

  /**
   * Creates instance.
   */
  public function __construct($message, $data) {
    $this->error = $message;
    $this->data = $data;
  }

}
