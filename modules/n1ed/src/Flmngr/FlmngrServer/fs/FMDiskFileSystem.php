<?php

namespace Drupal\n1ed\Flmngr\FlmngrServer\fs;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\file\Utils;
use Drupal\n1ed\Flmngr\FlmngrServer\model\FMDir;
use Drupal\n1ed\Flmngr\FlmngrServer\model\FMFile;
use Drupal\n1ed\Flmngr\FlmngrServer\model\FMMessage;
use Drupal\n1ed\Flmngr\FlmngrServer\model\ImageInfo;
use Exception;

/**
 * Implements file system interface.
 * Provides an interface to access file system (local disc FS).
 * This is the correct module to replace if you want to implement
 * some custom file system support (i. e. network file system like Amazon S3).
 */
class FMDiskFileSystem implements FMDiskFileSystemInterface {

  private $dirFiles;

  private $dirCache;

  /**
   * Creates an instance.
   */
  public function __construct($config) {
    $this->dirFiles = $config['dirFiles'];
    $this->dirCache = $config['dirCache'];
  }

  /**
   * {@inheritdoc}
   */
  public function getDirs() {
    $dirs = [];
    $fDir = $this->dirFiles;
    if (!file_exists($fDir) || !is_dir($fDir)) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_ROOT_DIR_DOES_NOT_EXIST));
    }

    $this->getDirsFill($dirs, $fDir, "");
    return $dirs;
  }

  /**
   * Fills direrctories list.
   */
  private function getDirsFill(&$dirs, $fDir, $path) {
    $files = scandir($fDir);

    if ($files === FALSE) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_UNABLE_TO_LIST_CHILDREN_IN_DIRECTORY));
    }

    $dirsCount = 0;
    $filesCount = 0;
    for ($i = 0; $i < count($files); $i++) {
      $file = $files[$i];
      if ($file === '.' || $file === '..') {
        continue;
      }
      if (is_file($fDir . DIRECTORY_SEPARATOR . $file)) {
        $filesCount++;
      }
      else {
        if (is_dir($fDir . DIRECTORY_SEPARATOR . $file)) {
          $dirsCount++;
        }
      }
    }

    $i = strrpos($fDir, DIRECTORY_SEPARATOR);
    if ($i !== FALSE) {
      $dirName = substr($fDir, $i + 1);
    }
    else {
      $dirName = $fDir;
    }

    $dir = new FMDir($dirName, $path, $filesCount, $dirsCount);
    $dirs[] = $dir;

    for ($i = 0; $i < count($files); $i++) {
      if ($files[$i] !== '.' && $files[$i] !== '..') {
        if (is_dir($fDir . DIRECTORY_SEPARATOR . $files[$i])) {
          $this->getDirsFill($dirs, $fDir . DIRECTORY_SEPARATOR . $files[$i], $path . (strlen($path) > 0 ? DIRECTORY_SEPARATOR : "") . $dirName);
        }
      }
    }
  }

  /**
   * Gets relative path.
   */
  private function getRelativePath($path) {
    // Do not allow to go outside of Flmngr file storage directory.
    if (strpos($path, "..") !== FALSE) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_DIR_NAME_CONTAINS_INVALID_SYMBOLS));
    }

    if (strpos($path, '/') !== 0)
      $path = '/'. $path;

    $rootDirName = $this->getRootDirName();

    // All paths start from the root directory of Flmngr file
    // storage (not a root directory of the file system).
    // We check a client sent the path to directory in correct format
    // and throw error if not. If client does not start a path with DIRECTORY_SEPARATOR
    // this means a mistake due to all paths must be relative to
    // Flmngr files directory.
    if (strpos($path, DIRECTORY_SEPARATOR . $rootDirName) !== 0) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_DIR_NAME_INCORRECT_ROOT));
    }

    return substr($path, strlen(DIRECTORY_SEPARATOR . $rootDirName));
  }

  /**
   * Gets absolute path.
   */
  public function getAbsolutePath($path) {
    return $this->dirFiles . $this->getRelativePath($path);
  }

  /**
   * Recursive deleting non-empty directories
   */
  private function rmDirRecursive($dir) {
    if (!file_exists($dir)) {
      return TRUE;
    }
    if (!is_dir($dir)) {
      return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
      if ($item == '.' || $item == '..') {
        continue;
      }
      if (!$this->rmDirRecursive($dir . DIRECTORY_SEPARATOR . $item)) {
        return FALSE;
      }
    }
    return rmdir($dir);
  }

  /**
   * {@inheritdoc}
   */
  function deleteDir($dirPath) {
    $fullPath = $this->getAbsolutePath($dirPath);
    $res = $this->rmDirRecursive($fullPath);
    if ($res === FALSE) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_UNABLE_TO_DELETE_DIRECTORY));
    }
  }

  function createDir($dirPath, $name) {
    if (strpos($name, "..") !== FALSE || strpos($name, "/") !== FALSE) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_DIR_NAME_CONTAINS_INVALID_SYMBOLS));
    }

    $fullPath = $this->getAbsolutePath($dirPath) . "/" . $name;
    $res = file_exists($fullPath) || mkdir($fullPath, 0777, true);
    if ($res === FALSE) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_UNABLE_TO_CREATE_DIRECTORY));
    }
  }


  /**
   * Renames file or directory.
   */
  private function renameFileOrDir($path, $newName) {

    if (strpos($newName, "..") !== FALSE || strpos($newName, DIRECTORY_SEPARATOR) !== FALSE) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_DIR_NAME_CONTAINS_INVALID_SYMBOLS));
    }

    $fullPath = $this->getAbsolutePath($path);

    $i = strrpos($fullPath, DIRECTORY_SEPARATOR);
    $fullPathDst = substr($fullPath, 0, $i + 1) . $newName;
    if (is_file($fullPathDst)) {
      throw new MessageException(Message::createMessage(Message::FILE_ALREADY_EXISTS, $newName));
    }

    $res = rename($fullPath, $fullPathDst);
    if ($res === FALSE) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_UNABLE_TO_RENAME));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function renameFile($filePath, $newName) {
    $this->renameFileOrDir(str_replace("/", DIRECTORY_SEPARATOR, $filePath), $newName);
  }

  /**
   * {@inheritdoc}
   */
  public function renameDir($dirPath, $newName) {
    $this->renameFileOrDir(str_replace("/", DIRECTORY_SEPARATOR, $dirPath), $newName);
  }

  /**
   * {@inheritdoc}
   */
  public function getFiles($dirPath) {

    $dirPath = str_replace("/", DIRECTORY_SEPARATOR, $dirPath);

    $fullPath = $this->getAbsolutePath($dirPath);

    if (!is_dir($fullPath)) {
      throw new MessageException(Message::createMessage(Message::DIR_DOES_NOT_EXIST, $dirPath));
    }

    $fFiles = scandir($fullPath);
    if ($fFiles === FALSE) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_DIR_CANNOT_BE_READ));
    }

    $files = [];
    for ($i = 0; $i < count($fFiles); $i++) {
      $fFile = $fFiles[$i];
      $fileFullPath = $fullPath . DIRECTORY_SEPARATOR . $fFile;
      if (is_file($fileFullPath)) {
        $preview = null;

        try {
          $imageInfo = $this->getImageInfo($fileFullPath);

          list($previewFormat, $previewFile) = $this->getImagePreview($fileFullPath, 159, 139);
          $previewData = '';
          while (!feof($previewFile)) {
            $previewData .= fread($previewFile, 8192);
          }
          fclose($previewFile);
          $preview = "data:" . $previewFormat . ";base64," . base64_encode($previewData);
        } catch (Exception $e) {
          $imageInfo = new ImageInfo();
          $imageInfo->width = NULL;
          $imageInfo->height = NULL;
        }

        $file = new FMFile($dirPath, $fFile, filesize($fileFullPath), filemtime($fileFullPath), $imageInfo);
        if ($preview != null)
          $file->preview = $preview;

        $files[] = $file;
      }
    }

    return $files;
  }

  /**
   * Gets image info.
   */
  private static function getImageInfo($file) {

    $ext = Utils::getExt($file);
    if ($ext != null && strtolower($ext) === "svg") {
      $imageInfo = new ImageInfo();
      $imageInfo->width = NULL;
      $imageInfo->height = NULL;
      return $imageInfo;
    }

    $size = getimagesize($file);
    if ($size === FALSE) {
      throw new MessageException(Message::createMessage(Message::IMAGE_PROCESS_ERROR));
    }

    $imageInfo = new ImageInfo();
    $imageInfo->width = $size[0];
    $imageInfo->height = $size[1];
    return $imageInfo;
  }

  /**
   * Gets root directory name.
   */
  private function getRootDirName() {
    $i = strrpos($this->dirFiles, DIRECTORY_SEPARATOR);
    if ($i === FALSE) {
      return $this->dirFiles;
    }
    return substr($this->dirFiles, $i + 1);
  }

  /**
   * @param $mode defines a condition when image must be processed or not. Possible values are:
   * - "ALWAYS"
   *   To recreate image preview in any case (overwrites is exists).
   *   Used when user uploads a new image and needs to get its preview.
   * - "DO_NOT_UPDATE"
   *   To create image only if it does not exist, if exists - its path returns
   *   Used when user selects existing image in Flmngr and needs its preview.
   * - "IF_EXISTS"
   *   To recreate preview if it already exists
   *   Used when file was reuploaded, edited and we recreate previews for all
   *   formats we do not need right now, but used somewhere else.
   * Examples:
   * - File uploaded / saved in image editor and reuploaded:
   *     $mode is "ALWAYS" for required formats, "IF_EXISTS" for the others.
   * - User selected image in file manager:
   *     $mode is "DO_NOT_UPDATE" for required formats and there is no requests
   *     for the otheres.
   */
  function resizeFile($filePath, $newFileNameWithoutExt, $width, $height, $mode) {
    // $filePath here starts with "/", not with "/root_dir"
    $rootDir = $this->getRootDirName();
    $filePath = '/' . $rootDir . $filePath;
    $srcPath = $this->getAbsolutePath($filePath);
    $index = strrpos($srcPath, "/");
    $oldFileNameWithExt = substr($srcPath, $index + 1);
    $newExt = "png";
    $oldExt = strtolower(Utils::getExt($srcPath));
    if ($oldExt === "jpg" || $oldExt === "jpeg") {
      $newExt = "jpg";
    }
    if ($oldExt === "webp") {
      $newExt = "webp";
    }
    $dstPath = substr($srcPath, 0, $index) . "/" . $newFileNameWithoutExt . "." . $newExt;

    if (Utils::getNameWithoutExt($dstPath) === Utils::getNameWithoutExt($srcPath)) {
      // This is `default` format request - we need to process the image itself without changing its extension
      $dstPath = $srcPath;
    }

    if ($mode === "IF_EXISTS" && !file_exists($dstPath)) {
      throw new MessageException(Message::createMessage(FMMessage::FM_NOT_ERROR_NOT_NEEDED_TO_UPDATE));
    }

    if ($mode === "DO_NOT_UPDATE" && file_exists($dstPath)) {
      $url = substr($dstPath, strlen($this->dirFiles) + 1);
      if (strpos($url, '/') !== 0)
        $url = '/' . $url;
      return $url;
    }

    $image = NULL;
    switch (FMDiskFileSystem::getMimeType($srcPath)) {
      case 'image/gif':
        $image = @imagecreatefromgif($srcPath);
        break;
      case 'image/jpeg':
        $image = @imagecreatefromjpeg($srcPath);
        break;
      case 'image/png':
        $image = @imagecreatefrompng($srcPath);
        break;
      case 'image/bmp':
        $image = @imagecreatefromwbmp($srcPath);
        break;
      case 'image/webp':
        // If you get problems with WEBP preview creation, please consider updating GD > 2.2.4
        // https://stackoverflow.com/questions/59621626/converting-webp-to-jpeg-in-with-php-gd-library
        $image = @imagecreatefromwebp($srcPath);
        break;
      case 'image/svg+xml':
        // Return SVG as is
        $url = substr($srcPath, strlen($this->dirFiles) + 1);
        if (strpos($url, '/') !== 0)
          $url = '/' . $url;
        return $url;
    }

    // Somewhy it can not read ONLY SOME JPEG files, we've caught it on Windows + IIS + PHP
    // Solution from here: https://github.com/libgd/libgd/issues/206
    if (!$image) {
      $image = imagecreatefromstring(file_get_contents($srcPath));
    }

    if (!$image) {
      throw new MessageException(Message::createMessage(Message::IMAGE_PROCESS_ERROR));
    }
    imagesavealpha($image, TRUE);

    $imageInfo = FMDiskFileSystem::getImageInfo($srcPath);

    $originalWidth = $imageInfo->width;
    $originalHeight = $imageInfo->height;

    $needToFitWidth = $originalWidth > $width && $width > 0;
    $needToFitHeight = $originalHeight > $height && $height > 0;
    if ($needToFitWidth && $needToFitHeight) {
      if ($width / $originalWidth < $height / $originalHeight) {
        $needToFitHeight = FALSE;
      }
      else {
        $needToFitWidth = FALSE;
      }
    }

    if (!$needToFitWidth && !$needToFitHeight) {
      // if we generated the preview in past, we need to update it in any case
      if (!file_exists($dstPath) || ($newFileNameWithoutExt . "." . $oldExt === $oldFileNameWithExt)) {
        // return old file due to it has correct width/height to be used as a preview
        $url = substr($srcPath, strlen($this->dirFiles) + 1);
        if (strpos($url, '/') !== 0)
          $url = '/' . $url;
        return $url;
      }
      else {
        $width = $originalWidth;
        $height = $originalHeight;
      }
    }

    if ($needToFitWidth) {
      $ratio = $width / $originalWidth;
      $height = $originalHeight * $ratio;
    }
    else {
      if ($needToFitHeight) {
        $ratio = $height / $originalHeight;
        $width = $originalWidth * $ratio;
      }
    }

    $resizedImage = imagecreatetruecolor($width, $height);
    imagealphablending($resizedImage, FALSE);
    imagesavealpha($resizedImage, TRUE);
    imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);


    $result = FALSE;
    $ext = strtolower(Utils::getExt($dstPath));
    if ($ext === "png") {
      $result = imagepng($resizedImage, $dstPath);
    }
    else {
      if ($ext === "jpg" || $ext === "jpeg") {
        $result = imagejpeg($resizedImage, $dstPath);
      }
      else {
        if ($ext === "bmp") {
          $result = imagebmp($resizedImage, $dstPath);
        } else {
          if ($ext === "webp") {
            $result = imagewebp($resizedImage, $dstPath);
          } else {
            // do not resize other formats (i. e. GIF)
            $result = TRUE;
          }
        }
      }
    }

    if ($result === FALSE) {
      throw new MessageException(
        FMMessage::createMessage(
          FMMessage::FM_UNABLE_TO_WRITE_PREVIEW_IN_CACHE_DIR,
          $dstPath
        )
      );
    }

    $url = substr($dstPath, strlen($this->dirFiles) + 1);
    if (strpos($url, '/') !== 0)
      $url = '/' . $url;
    return $url;
  }

  /**
   * {@inheritdoc}
   */
  public function deleteFiles($filesPaths) {
    for ($i = 0; $i < count($filesPaths); $i++) {
      $fullPath = $this->getAbsolutePath(str_replace("/", DIRECTORY_SEPARATOR, $filesPaths[$i]));
      $res = is_dir($fullPath) ? rmdir($fullPath) : unlink($fullPath);
      if ($res === FALSE) {
        throw new MessageException(Message::createMessage(Message::UNABLE_TO_DELETE_FILE, $filesPaths[$i]));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function copyFiles($filesPaths, $newPath) {
    for ($i = 0; $i < count($filesPaths); $i++) {
      $fullPathSrc = $this->getAbsolutePath(str_replace("/", DIRECTORY_SEPARATOR, $filesPaths[$i]));

      $index = strrpos($fullPathSrc, DIRECTORY_SEPARATOR);
      $name = $index === FALSE ? $fullPathSrc : substr($fullPathSrc, $index + 1);
      $fullPathDst = $this->getAbsolutePath(str_replace("/", DIRECTORY_SEPARATOR, $newPath) . DIRECTORY_SEPARATOR . $name);

      $res = copy($fullPathSrc, $fullPathDst);
      if ($res === FALSE) {
        throw new MessageException(FMMessage::createMessage(FMMessage::FM_ERROR_ON_COPYING_FILES));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function moveFiles($filesPaths, $newPath) {
    for ($i = 0; $i < count($filesPaths); $i++) {
      $fullPathSrc = $this->getAbsolutePath(str_replace("/", DIRECTORY_SEPARATOR, $filesPaths[$i]));

      $index = strrpos($fullPathSrc, DIRECTORY_SEPARATOR);
      $name = $index === FALSE ? $fullPathSrc : substr($fullPathSrc, $index + 1);
      $fullPathDst = $this->getAbsolutePath(str_replace("/", DIRECTORY_SEPARATOR, $newPath)) . DIRECTORY_SEPARATOR . $name;

      $res = rename($fullPathSrc, $fullPathDst);
      if ($res === FALSE) {
        throw new MessageException(FMMessage::createMessage(FMMessage::FM_ERROR_ON_MOVING_FILES));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function moveDir($dirPath, $newPath) {
    $fullPathSrc = $this->getAbsolutePath(str_replace("/", DIRECTORY_SEPARATOR, $dirPath));

    $index = strrpos($fullPathSrc, DIRECTORY_SEPARATOR);
    $name = $index === FALSE ? $fullPathSrc : substr($fullPathSrc, $index + 1);
    $fullPathDst = $this->getAbsolutePath(str_replace("/", DIRECTORY_SEPARATOR, $newPath)) . DIRECTORY_SEPARATOR . $name;

    $res = rename($fullPathSrc, $fullPathDst);
    if ($res === FALSE) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_ERROR_ON_MOVING_FILES));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function copyDir($dirPath, $newPath) {
    $fullPathSrc = $this->getAbsolutePath(str_replace("/", DIRECTORY_SEPARATOR, $dirPath));

    $index = strrpos($fullPathSrc, DIRECTORY_SEPARATOR);
    $name = $index === FALSE ? $fullPathSrc : substr($fullPathSrc, $index + 1);
    $fullPathDst = $this->getAbsolutePath(str_replace("/", DIRECTORY_SEPARATOR, $newPath)) . DIRECTORY_SEPARATOR . $name;

    $res = $this->copyDirRecurse($fullPathSrc, $fullPathDst);
    if ($res === FALSE) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_ERROR_ON_MOVING_FILES));
    }
  }

  /**
   * Copies a directory recursive function.
   */
  private function copyDirRecurse($src, $dst) {
    $dir = opendir($src);
    mkdir($dst);
    while (FALSE !== ($file = readdir($dir))) {
      if (($file != '.') && ($file != '..')) {
        if (is_dir($src . DIRECTORY_SEPARATOR . $file)) {
          $res = $this->copyDirRecurse($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);
          if ($res === FALSE) {
            return FALSE;
          }
        }
        else {
          $res = copy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);
          if ($res === FALSE) {
            return FALSE;
          }
        }
      }
    }
    closedir($dir);
    return TRUE;
  }

  /**
   * Checkes string ends with.
   */
  private static function endsWith($str, $ends) {
    return substr($str, -strlen($ends)) === $ends;
  }

  /**
   * Gets MIME type by extension.
   */
  private static function getMimeType($filePath) {
    $mimeType = NULL;
    $filePath = strtolower($filePath);
    if (FMDiskFileSystem::endsWith($filePath, '.png')) {
      $mimeType = "image/png";
    }
    if (FMDiskFileSystem::endsWith($filePath, '.gif')) {
      $mimeType = "image/gif";
    }
    if (FMDiskFileSystem::endsWith($filePath, '.bmp')) {
      $mimeType = "image/bmp";
    }
    if (FMDiskFileSystem::endsWith($filePath, '.jpg') || FMDiskFileSystem::endsWith($filePath, '.jpeg')) {
      $mimeType = "image/jpeg";
    }
    if (FMDiskFileSystem::endsWith($filePath, '.webp')) {
      $mimeType = "image/webp";
    }
    if (FMDiskFileSystem::endsWith($filePath, '.svg')) {
      $mimeType = "image/svg+xml";
    }

    return $mimeType;
  }

  /**
   * {@inheritdoc}
   */
  public function getImagePreview($fullPath, $width, $height) {

    $hash = md5($width . $height . filesize($fullPath) . filemtime($fullPath));

    if (!file_exists($this->dirCache)) {
      if (!mkdir($this->dirCache)) {
        throw new MessageException(FMMessage::createMessage(FMMessage::FM_UNABLE_TO_CREATE_DIRECTORY));
      }
    }

    $fileCachedPath = $this->dirCache . DIRECTORY_SEPARATOR . $hash . '.png';
    if (!file_exists($fileCachedPath)) {

      $image = NULL;
      switch (FMDiskFileSystem::getMimeType($fullPath)) {
        case 'image/gif':
          $image = @imagecreatefromgif($fullPath);
          break;

        case 'image/jpeg':
          $image = @imagecreatefromjpeg($fullPath);
          break;

        case 'image/png':
          $image = @imagecreatefrompng($fullPath);
          break;

        case 'image/bmp':
          $image = @imagecreatefromwbmp($fullPath);
          break;

        case 'image/webp':
          $image = @imagecreatefromwebp($fullPath);
          break;

        case 'image/svg+xml':
          return ["image/svg+xml", fopen($fullPath, 'rb')];
      }

      // Somewhy it can not read ONLY SOME JPEG files,
      // we've caught it on Windows + IIS + PHP
      // Solution from here: https://github.com/libgd/libgd/issues/206
      if (!$image) {
        $image = imagecreatefromstring(file_get_contents($fullPath));
      }

      if (!$image) {
        throw new MessageException(Message::createMessage(Message::IMAGE_PROCESS_ERROR));
      }
      imagesavealpha($image, TRUE);

      $imageInfo = FMDiskFileSystem::getImageInfo($fullPath);

      // Ratio thumb.
      $ratio_thumb = $width / $height;
      $xx = $imageInfo->width;
      $yy = $imageInfo->height;
      // Ratio original.
      $ratio_original = $xx / $yy;
      if ($ratio_original >= $ratio_thumb) {
        $yo = $yy;
        $xo = ceil(($yo * $width) / $height);
        $xo_ini = ceil(($xx - $xo) / 2);
        $xy_ini = 0;
      }
      else {
        $xo = $xx;
        $yo = ceil(($xo * $height) / $width);
        $xy_ini = ceil(($yy - $yo) / 2);
        $xo_ini = 0;
      }

      $resizedImage = imagecreatetruecolor($width, $height);
      imagecopyresampled($resizedImage, $image, 0, 0, $xo_ini, $xy_ini, $width, $height, $xo, $yo);

      if (imagepng($resizedImage, $fileCachedPath) === FALSE) {
        throw new MessageException(FMMessage::createMessage(FMMessage::FM_UNABLE_TO_WRITE_PREVIEW_IN_CACHE_DIR, $fileCachedPath));
      }
    }

    $f = fopen($fileCachedPath, 'rb');
    if ($f) {
      return ["image/png", $f];
    }
    throw new MessageException(FMMessage::createMessage(FMMessage::FM_FILE_DOES_NOT_EXIST));
  }

  /**
   * {@inheritdoc}
   */
  public function getImageOriginal($filePath) {

    $filePath = str_replace("/", DIRECTORY_SEPARATOR, $filePath);

    $mimeType = FMDiskFileSystem::getMimeType($filePath);
    if ($mimeType == NULL) {
      throw new MessageException(FMMessage::createMessage(FMMessage::FM_FILE_IS_NOT_IMAGE));
    }

    $fullPath = $this->getAbsolutePath($filePath);

    if (file_exists($fullPath)) {
      $f = fopen($fullPath, 'rb');
      if ($f) {
        return [$mimeType, $f];
      }
    }
    throw new MessageException(FMMessage::createMessage(FMMessage::FM_FILE_DOES_NOT_EXIST));
  }

  /**
   * {@inheritdoc}
   */
  public function getDirZipArchive($dirPath, $out) {
    // TODO: Implement getDirZipArchive() method.
  }

}
