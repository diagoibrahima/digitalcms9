<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action;

/**
 * Abstract action - processor for any request.
 * External code executes run() method of set config and returnes Resp* object
 * as data structure to return via HTTP.
 */
abstract class AAction {

  protected $config;

  /**
   * Sets a config.
   */
  public function setConfig($config) {
    $this->config = $config;
  }

  /**
   * Returnes name of action.
   */
  abstract public function getName();

  /**
   * Runs action.
   */
  abstract public function run($req);

  /**
   * Validates boolean and returns default value if null.
   */
  protected function validateBoolean($b, $defaultValue) {
    return $b === NULL ? $defaultValue : $b;
  }

  /**
   * Validates integer and returns default value if null.
   */
  protected function validateInteger($i, $defaultValue) {
    return $i === NULL ? $defaultValue : $i;
  }

  /**
   * Validates string and returns default value if null.
   */
  protected function validateString($s, $defaultValue) {
    return $s === NULL ? $defaultValue : $s;
  }

}
