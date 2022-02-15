<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\file;

use Exception;

/**
 * Utilites (PHP native).
 */
class UtilsPHP {

  /**
   * Clears a directory.
   */
  public static function cleanDirectory($dir) {
    UtilsPHP::delete($dir, FALSE);
  }

  /**
   * Deletes a file or directory.
   */
  public static function delete($dirOrFile, $deleteSelfDir = TRUE) {
    if (is_file($dirOrFile)) {

      $result = is_dir($dirOrFile) ? rmdir($dirOrFile) : unlink($dirOrFile);
      if (!$result) {
        throw new Exception('Unable to delete file: ' . $dirOrFile);
      }
    }
    elseif (is_dir($dirOrFile)) {
      $scan = glob(rtrim($dirOrFile, DIRECTORY_SEPARATOR) . '/*');
      foreach ($scan as $path) {
        UtilsPHP::delete($path);
      }
      if ($deleteSelfDir) {
        if (!rmdir($dirOrFile)) {
          throw new Exception('Unable to delete directory: ' . $dirOrFile);
        }
      }
    }
  }

  /**
   * Copies a file.
   */
  public static function copyFile($src, $dst) {
    if (!copy($src, $dst)) {
      throw new Exception('Unable to copy file ' . $src . ' to ' . $dst);
    }
  }

  /**
   * Returns a path without end separator.
   */
  public static function normalizeNoEndSeparator($path) {
    // TODO: normalize.
    return rtrim($path, DIRECTORY_SEPARATOR);
  }

}
