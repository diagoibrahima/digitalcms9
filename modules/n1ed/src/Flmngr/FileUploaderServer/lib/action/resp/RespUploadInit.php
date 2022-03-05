<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp;

/**
 * Response about upload initialization.
 * For conversion to JSON.
 */
class RespUploadInit extends RespOk {

  public $uploadId;

  public $settings;

  /**
   * Creates a request.
   */
  public function __construct($uploadId, $config) {
    $this->uploadId = $uploadId;
    $this->settings = new Settings();
    $this->settings->maxImageResizeWidth = $config->getMaxImageResizeWidth();
    $this->settings->maxImageResizeHeight = $config->getMaxImageResizeHeight();
  }

}
