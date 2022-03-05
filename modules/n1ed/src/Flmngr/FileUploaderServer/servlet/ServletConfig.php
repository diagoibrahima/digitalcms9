<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\servlet;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\config\ConfigInterface;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\file\UtilsPHP;
use Exception;

/**
 * Implementation of ConfigInterface interface.
 * Returnes values with validationing them.
 */
class ServletConfig implements ConfigInterface {

  protected $conf;

  protected $testConf = [];

  /**
   * Creates an instance.
   */
  public function __construct($conf) {
    $this->conf = $conf;
  }

  /**
   * Gets a parameter from config.
   */
  protected function getParameter($name, $defaultValue, $doAddTrailingSlash) {
    if (array_key_exists($name, $this->testConf)) {
      return $this->addTrailingSlash($this->testConf[$name], $doAddTrailingSlash);
    }
    else {
      if (array_key_exists($name, $this->conf)) {
        return $this->addTrailingSlash($this->conf[$name], $doAddTrailingSlash);
      }
      return $defaultValue;
    }
  }

  /**
   * Adds a trainling slash for path.
   */
  protected function addTrailingSlash($value, $doAddTrailingSlash) {
    if ($value != NULL && $doAddTrailingSlash && (strlen($value) == 0 || !substr($value, strlen($value) - 1) == DIRECTORY_SEPARATOR)) {
      $value .= DIRECTORY_SEPARATOR;
    }
    return $value;
  }

  /**
   * Gets string parameter.
   */
  protected function getParameterStr($name, $defaultValue) {
    return $this->getParameter($name, $defaultValue, FALSE);
  }

  /**
   * Gets integer parameter.
   */
  protected function getParameterInt($name, $defaultValue) {
    $value = $this->getParameter($name, $defaultValue, FALSE);
    if (is_int($value) !== FALSE) {
      return $value;
    }
    else {
      error_log("Incorrect '" . $name . "' parameter integer value");
      return $defaultValue;
    }
  }

  /**
   * Gets boolean parameter.
   */
  protected function getParameterBool($name, $defaultValue) {
    $value = $this->getParameter($name, $defaultValue, FALSE);
    if (is_bool($value) !== FALSE) {
      return $value;
    }
    else {
      error_log("Incorrect '" . $name . "' parameter boolean value");
      return $defaultValue;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getBaseDir() {
    $dir = $this->getParameter("dirFiles", NULL, TRUE);
    if ($dir == NULL) {
      throw new Exception("dirFiles not set");
    }
    if (!file_exists($dir)) {
      if (!mkdir($dir, 0777, TRUE)) {
        throw new Exception("Unable to create files directory '" . $dir . "''");
      }
    }
    return UtilsPHP::normalizeNoEndSeparator($dir);
  }

  /**
   * {@inheritdoc}
   */
  public function getTmpDir() {
    $dir = $this->getParameter("dirTmp", $this->getBaseDir() . "/tmp", TRUE);
    if (!file_exists($dir)) {
      if (!mkdir($dir)) {
        throw new Exception("Unable to create temporary files directory '" . $dir . "''");
      }
    }
    return UtilsPHP::normalizeNoEndSeparator($dir);
  }

  /**
   * {@inheritdoc}
   */
  public function getMaxUploadFileSize() {
    return $this->getParameterInt("maxUploadFileSize", 0);
  }

  /**
   * {@inheritdoc}
   */
  public function getAllowedExtensions() {
    $value = $this->getParameterStr("allowedExtensions", NULL);
    if ($value === NULL) {
      return [];
    }
    $exts = explode(",", $value);
    for ($i = 0; $i < count($exts); $i++) {
      $exts[$i] = strtolower($exts[$i]);
    }
    return $exts;
  }

  /**
   * {@inheritdoc}
   */
  public function getJpegQuality() {
    return $this->getParameterInt("jpegQuality", 95);
  }

  /**
   * {@inheritdoc}
   */
  public function getMaxImageResizeWidth() {
    return $this->getParameterInt("maxImageResizeWidth", 5000);
  }

  /**
   * {@inheritdoc}
   */
  public function getMaxImageResizeHeight() {
    return $this->getParameterInt("maxImageResizeHeight", 5000);
  }

  /**
   * {@inheritdoc}
   */
  public function getCrossDomainUrl() {
    return $this->getParameterStr("crossDomainUrl", NULL);
  }

  /**
   * {@inheritdoc}
   */
  public function doKeepUploads() {
    return $this->getParameterBool("keepUploads", FALSE);
  }

  /**
   * {@inheritdoc}
   */
  public function setTestConfig($testConf) {
    $this->testConf = (array) $testConf;
  }

  /**
   * {@inheritdoc}
   */
  public function isTestAllowed() {
    return $this->getParameterBool("isTestAllowed", FALSE);
  }

  /**
   * {@inheritdoc}
   */
  public function getRelocateFromHosts() {
    $hostsStr = $this->getParameterStr("relocateFromHosts", "");
    $hostsFound = explode(",", $hostsStr);
    $hosts = [];
    for ($i = count($hostsFound) - 1; $i >= 0; $i--) {
      $host = strtolower(trim($hostsFound[$i]));
      if (strlen($host) > 0) {
        $hosts[] = $host;
      }
    }
    return $hosts;
  }

}
