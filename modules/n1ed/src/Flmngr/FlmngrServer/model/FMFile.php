<?php

namespace Drupal\n1ed\Flmngr\FlmngrServer\model;

/**
 * File data structure.
 */
class FMFile {

  public $p;

  public $s;

  public $t;

  public $w;

  public $h;

  /**
   * Creates an instance.
   */
  public function __construct($path, $name, $size, $timeModification, $imageInfo) {
    $this->p = DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $name;
    $this->s = $size;
    $this->t = $timeModification;
    $this->w = $imageInfo->width == 0 ? NULL : $imageInfo->width;
    $this->h = $imageInfo->height == 0 ? NULL : $imageInfo->height;
  }

}
