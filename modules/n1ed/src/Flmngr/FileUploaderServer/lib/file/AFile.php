<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\file;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\FileData;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;
use Exception;

/**
 * Abstract file item both for just uploaded and fully commited files.
 * Contains some handy method for accessing files info programmatically.
 */
abstract class AFile {

  protected $config;

  private $name = NULL;

  private $dir = NULL;

  protected $commonErrors = [];

  /**
   * Creates a File instance.
   */
  public function __construct($config, $dir, $name) {
    $this->config = $config;
    $this->dir = $dir;
    $this->name = $name;
  }

  /**
   * Gets a data for response format file representation.
   */
  public function getData() {
    $data = new FileData();
    $data->isCommited = $this->isCommited();
    $data->name = $this->getName();
    $data->dir = $this->getDir();
    $data->bytes = $this->getSize();
    $errors = $this->getErrors();
    $data->errors = [];
    for ($i = 0; $i < count($errors); $i++) {
      $data->errors[] = (array) $errors[$i];
    }

    $data->isImage = $this->isImage();
    $data->sizes = [];
    if ($data->isImage) {
      $data->width = $this->getImageWidth();
      $data->height = $this->getImageHeight();
      if ($data->isCommited) {
        // mainFile is property of FileCommited.
        if ($this->mainFile === NULL) {
          $modifications = $this->getModifications();
          for ($i = 0; $i < count($modifications); $i++) {
            $data->sizes[$modifications[$i]->getModificationName()] = $modifications[$i]->getData();
          }
        }
      }
    }
    return $data;
  }

  /**
   * Gets all file modifications (original, preview, etc.).
   */
  public function getModifications() {
    return [];
  }

  /**
   * Gets modification name.
   */
  public function getModificationName() {
    return NULL;
  }

  /**
   * Gets a size of file.
   */
  public function getSize() {
    $path = $this->getFullPath();
    if (file_exists($path)) {
      return filesize($path);
    }
    return 0;
  }

  /**
   * Gets errors accumulated for file.
   */
  public function getErrors() {
    return $this->commonErrors;
  }

  /**
   * Returns do we need to continue check or not.
   */
  public function checkForErrors($checkForExist) {
    $this->commonErrors = [];

    if (!Utils::isFileNameSyntaxOk($this->getName())) {
      $this->commonErrors[] = Message::createMessage(Message::FILE_ERROR_SYNTAX, $this->getName());
      // Do not do any other checks by security reasons.
      return FALSE;
    }

    if ($checkForExist && !$this->exists()) {
      $this->commonErrors[] = Message::createMessage(Message::FILE_ERROR_DOES_NOT_EXIST);
    }

    return TRUE;
  }

  /**
   * Sets a name of file.
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * Sets a directory of file.
   */
  public function setDir($dir) {
    $this->dir = $dir;
  }

  /**
   * Is file commited.
   */
  abstract public function isCommited();

  /**
   * Gets base directory.
   */
  abstract public function getBaseDir();

  /**
   * Gets name.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Gets directory.
   */
  public function getDir() {
    if (strlen($this->dir) != 0 && substr($this->dir, strlen($this->dir) - 1) !== DIRECTORY_SEPARATOR) {
      return $this->dir . DIRECTORY_SEPARATOR;
    }
    return $this->dir;
  }

  /**
   * Gets path.
   */
  public function getPath() {
    return $this->getDir() . $this->getName();
  }

  /**
   * Gets full path.
   */
  public function getFullPath() {
    return $this->getBaseDir() . DIRECTORY_SEPARATOR . $this->getPath();
  }

  /**
   * Gets extension of file.
   */
  public function getExt() {
    return Utils::getExt($this->name);
  }

  /**
   * Gets a name without extension.
   */
  public function getNameWithoutExt() {
    $ext = $this->getExt();
    if ($ext === NULL) {
      return $this->name;
    }
    return substr($this->name, 0, strlen($this->name) - strlen($ext) - 1);
  }

  /**
   * Does file exist.
   */
  public function exists() {
    return file_exists($this->getFullPath());
  }

  /**
   * Deletes file from storage.
   */
  public function delete() {
    if (!unlink($this->getFullPath())) {
      throw new MessageException(Message::createMessage(Message::UNABLE_TO_DELETE_FILE, $this->getName()));
    }
  }

  /**
   * Checks file is image or not.
   */
  public function isImage() {
    return Utils::isImage($this->getName());
  }

  /**
   * Gets width of image.
   */
  public function getImageWidth() {
    if ($size = @getimagesize($this->getFullPath())) {
      return $size === NULL ? -1 : $size[0];
    }
    else {
      throw new MessageException(Message::createMessage(Message::IMAGE_PROCESS_ERROR));
    }
  }

  /**
   * Gets height of image.
   */
  public function getImageHeight() {
    if ($size = @getimagesize($this->getFullPath())) {
      return $size === NULL ? -1 : $size[1];
    }
    else {
      throw new MessageException(Message::createMessage(Message::IMAGE_PROCESS_ERROR));
    }
  }

  /**
   * Gets as image object.
   */
  public function getImage() {
    $path = $this->getFullPath();
    $image = NULL;
    switch (strtolower($this->getExt())) {
      case 'gif':
        $image = @imagecreatefromgif($path);
        break;

      case 'jpeg':
      case 'jpg':
        $image = @imagecreatefromjpeg($path);
        break;

      case 'png':
        $image = @imagecreatefrompng($path);
        break;

      case 'bmp':
        $image = @imagecreatefromwbmp($path);
        break;
    }

    // Somewhy it can not read ONLY SOME JPEG files,
    // we've caught it on Windows + IIS + PHP
    // Solution from here: https://github.com/libgd/libgd/issues/206
    if (!$image) {
      $image = imagecreatefromstring(file_get_contents($path));
    }

    if (!$image) {
      throw new MessageException(Message::createMessage(Message::IMAGE_PROCESS_ERROR));
    }
    imagesavealpha($image, TRUE);
    return $image;
  }

  /**
   * Generates and sets free file name for this file.
   */
  protected function setFreeFileName() {
    $name = Utils::getFreeFileName($this->getBaseDir() . $this->getDir(), $this->getName(), FALSE);
    $this->setName($name);
  }

  /**
   * Copies file to another place.
   */
  public function copyTo($dstFile) {
    try {
      UtilsPHP::copyFile($this->getFullPath(), $dstFile->getFullPath());
    }
    catch (Exception $e) {
      error_log($e);
      throw new MessageException(Message::createMessage(Message::UNABLE_TO_COPY_FILE, $this->getName(), $dstFile->getName()));
    }
  }

}
