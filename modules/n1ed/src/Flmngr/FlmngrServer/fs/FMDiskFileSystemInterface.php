<?php

namespace Drupal\n1ed\Flmngr\FlmngrServer\fs;

/**
 * Interface for interacting with file system (local disk fs is supported now).
 */
interface FMDiskFileSystemInterface {

  /**
   * Gets image preview.
   */
  public function getImagePreview($fullPath, $width, $height);

  /**
   * Gets image original.
   */
  public function getImageOriginal($filePath);

  /**
   * Gets directory list.
   */
  public function getDirs();

  /**
   * Deletes a directory.
   */
  public function deleteDir($dirPath);

  /**
   * Creates a directory.
   */
  public function createDir($dirPath, $name);

  /**
   * Renames a file.
   */
  public function renameFile($filePath, $newName);

  /**
   * Renames a directory.
   */
  public function renameDir($dirPath, $newName);

  /**
   * Gets a files list.
   */
  public function getFiles($dirPath);

  /**
   * Deletes files.
   */
  public function deleteFiles($filesPaths);

  /**
   * Copies files.
   */
  public function copyFiles($filesPaths, $newPath);

  /**
   * Moves files.
   */
  public function moveFiles($filesPaths, $newPath);

  /**
   * Moves a directory.
   */
  public function moveDir($dirPath, $newPath);

  /**
   * Creates a resized image.
   */
  public function resizeFile($filePath, $newFileNameWithoutExt, $width, $height, $mode);

  /**
   * Copies a directory.
   */
  public function copyDir($dirPath, $newPath);

  /**
   * Gets ZIP archive as file to out stream.
   */
  public function getDirZipArchive($dirPath, $out);


}
