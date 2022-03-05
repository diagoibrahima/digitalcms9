<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\file;

/**
 * Utilites for uploader.
 */
class Utils {

  /**
   * Gets name without extension.
   */
  public static function getNameWithoutExt($filename) {
    $ext = Utils::getExt($filename);
    if ($ext == NULL) {
      return $filename;
    }
    return substr($filename, 0, strlen($filename) - strlen($ext) - 1);
  }

  /**
   * Gets file extension.
   */
  public static function getExt($name) {
    $i = strrpos($name, '.');
    if ($i !== FALSE) {
      return substr($name, $i + 1);
    }
    return NULL;
  }

  /**
   * Gets free file name.
   */
  public static function getFreeFileName($dir, $defaultName, $alwaysWithIndex) {
    $i = $alwaysWithIndex ? 0 : -1;
    do {
      $i++;
      if ($i == 0) {
        $name = $defaultName;
      }
      else {
        $name = Utils::getNameWithoutExt($defaultName) . "_" . $i . (Utils::getExt($defaultName) != NULL ? "." . Utils::getExt($defaultName) : "");
      }
      $filePath = $dir . $name;
      $ok = !file_exists($filePath);
    } while (!$ok);
    return $name;
  }

  const PROHIBITED_SYMBOLS = "/\\?%*:|\"<>";

  /**
   * Fixes file name.
   */
  public static function fixFileName($name) {
    $newName = "";
    for ($i = 0; $i < strlen($name); $i++) {
      $ch = substr($name, $i, 1);
      if (strpos(Utils::PROHIBITED_SYMBOLS, $ch) !== FALSE) {
        $ch = "_";
      }
      $newName = $newName . $ch;
    }
    return $newName;
  }

  /**
   * Is file name syntax fine.
   */
  public static function isFileNameSyntaxOk($name) {
    if (strlen($name) == 0 || $name == "." || strpos($name, "..") > -1) {
      return FALSE;
    }

    for ($i = 0; $i < strlen(Utils::PROHIBITED_SYMBOLS); $i++) {
      if (strpos($name, substr(Utils::PROHIBITED_SYMBOLS, $i, 1)) !== FALSE) {
        return FALSE;
      }
    }

    if (strlen($name) > 260) {
      return FALSE;
    }

    return TRUE;
  }

  /**
   * Is file an image.
   */
  public static function isImage($name) {
    $exts = ["gif", "jpg", "jpeg", "png"];
    $ext = Utils::getExt($name);
    for ($i = 0; $i < count($exts); $i++) {
      if ($exts[$i] === strtolower($ext)) {
        return TRUE;
      }
    }
    return FALSE;
  }

}
