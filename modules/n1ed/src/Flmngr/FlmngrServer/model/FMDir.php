<?php

namespace Drupal\n1ed\Flmngr\FlmngrServer\model;

/**
 * Directory data structure.
 */
class FMDir {

  private $path;

  private $name;

  public $f;

  public $d;

  public $p;

  /**
   * Creates an instance.
   */
  public function __construct($name, $path, $filesCount, $dirsCount) {
    $this->path = $path;
    $this->name = $name;
    $this->f = $filesCount;
    $this->d = $dirsCount;
    $this->p = (strlen($this->path) > 0 ? (DIRECTORY_SEPARATOR . $this->path) : "") . DIRECTORY_SEPARATOR . $this->name;
  }

}
