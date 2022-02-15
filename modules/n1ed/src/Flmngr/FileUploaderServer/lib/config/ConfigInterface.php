<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\config;

/**
 * Config interface for storing uploader settings.
 */
interface ConfigInterface {

  /**
   * Gets a path to base directory.
   */
  public function getBaseDir();

  /**
   * Gets a path to temporary directory.
   */
  public function getTmpDir();

  /**
   * Gets maximum size of uploading file in bytes.
   */
  public function getMaxUploadFileSize();

  /**
   * Gets allowed extensions array.
   */
  public function getAllowedExtensions();

  /**
   * Gets JPEG quality in percents as image optimization option.
   */
  public function getJpegQuality();

  /**
   * Gets maximum image width for resizing.
   */
  public function getMaxImageResizeWidth();

  /**
   * Gets maximum image height for resizing.
   */
  public function getMaxImageResizeHeight();

  /**
   * Get crossdomain URL (for CORS).
   */
  public function getCrossDomainUrl();

  /**
   * A flag to keep uplaods.
   */
  public function doKeepUploads();

  /**
   * Sets a test config.
   */
  public function setTestConfig($testConf);

  /**
   * Is testing allowed, do not turn on on production.
   */
  public function isTestAllowed();

  /**
   * Gets a list of hosts a relocation is allowed from.
   */
  public function getRelocateFromHosts();

}
