<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\file;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;
use Exception;

/**
 * Commited file (data structure about the file of finished upload transaction).
 * Has method for resizing images (applying sizes when finishing transaction).
 */
class FileCommited extends AFile {

  const SIZE_PREVIEW = "preview";

  const SIZE_FULL = "full";

  protected $mainFile;

  protected $modificationName;

  /**
   * {@inheritdoc}
   */
  public function getBaseDir() {
    return $this->config->getBaseDir();
  }

  /**
   * Gets specified file modification.
   */
  protected function getFileModification($modificationName) {
    if (!$this->isImage() || $this->mainFile != NULL) {
      throw new Exception("Unable to get modification for not image or main image");
    }
    $name = $this->getNameWithoutExt() . "-" . $modificationName . "." . $this->getExt();
    $file = new FileCommited($this->config, $this->getDir(), $name);
    $file->modificationName = $modificationName;
    $file->mainFile = $this;
    return $file;
  }

  /**
   * Gets original file modification.
   */
  public function getFileOriginal() {
    return $this->getFileModification("original");
  }

  /**
   * Gets a preview for file.
   */
  public function getFilePreview() {
    return $this->getFileModification("preview");
  }

  /**
   * {@inheritdoc}
   */
  public function getModificationName() {
    return $this->modificationName;
  }

  /**
   * {@inheritdoc}
   */
  public function getModifications() {
    $modifications = [];
    $f = $this->getFilePreview();
    if ($f->exists()) {
      $modifications[] = $f;
    }
    $f = $this->getFileOriginal();
    if ($f->exists()) {
      $modifications[] = $f;
    }
    return $modifications;
  }

  /**
   * Apply sized method.
   */
  public function applySizes($sizes) {
    if (!$this->isImage()) {
      return;
    }

    $currPreviewWidth = -1;
    $currPreviewHeight = -1;
    $filePreview = $this->getFilePreview();
    if ($filePreview->exists()) {
      $currPreviewWidth = $filePreview->getImageWidth();
      $currPreviewHeight = $filePreview->getImageHeight();
    }

    $currFullWidth = $this->getImageWidth();
    $currFullHeight = $this->getImageHeight();

    $fileOriginal = $this->getFileOriginal();
    $fileOriginalOrFull = $this;
    if ($fileOriginal->exists()) {
      $fileOriginalOrFull = $fileOriginal;
    }

    $currOriginalWidth = $fileOriginalOrFull->getImageWidth();
    $currOriginalHeight = $fileOriginalOrFull->getImageHeight();

    if (array_key_exists(FileCommited::SIZE_PREVIEW, $sizes)) {
      if (!$filePreview->exists()) {
        $fileOriginalOrFull->copyTo($filePreview);
      }
      $sizeName = FileCommited::SIZE_PREVIEW;
      $targetSize = $sizes->$sizeName;
      // Target size differs from current.
      if ($targetSize->width != $currPreviewWidth || $targetSize->height != $currPreviewHeight) {
        // Not fully auto.
        if ($targetSize->width > 0 || $targetSize->height > 0) {
          // We reduce size of image or have enlarge allowed.
          if (($targetSize->width < $currOriginalWidth || $targetSize->height < $currOriginalHeight) || $targetSize->enlarge) {
            $filePreview->resizeImage($targetSize);
          }
        }
      }
    }

    if (array_key_exists(FileCommited::SIZE_FULL, $sizes)) {
      $sizeName = FileCommited::SIZE_FULL;
      $targetSize = $sizes->$sizeName;
      if ($targetSize->width != $currFullWidth || $targetSize->height != $currFullHeight) {
        if ($targetSize->width > 0 || $targetSize->height > 0) {
          if (($targetSize->width < $currOriginalWidth || $targetSize->height < $currOriginalHeight) || $targetSize->enlarge) {
            $originalExisted = $fileOriginal->exists();
            if (!$originalExisted) {
              $this->copyTo($fileOriginal);
            }
            if (!$this->resizeImage($targetSize) && !$originalExisted) {
              $fileOriginal->delete();
            }
          }
        }
      }
    }
  }

  /**
   * Gets sizes of image.
   */
  public function getSizes() {
    $thisFileFullPath = $this->getFullPath();
    $thisName = $this->getNameWithoutExt();
    $thisFileDir = dirname($this);
    $files = array_diff(scandir($thisFileDir), ['..', '.']);
    $sizes = [];
    for ($i = 0; $i < count($files); $i++) {
      $file = $files[$i];
      $name = basename($file);
      $ext = Utils::getExt($name);
      if ($ext != NULL) {
        $name = substr($name, 0, strlen($name) - strlen($ext) - 1);
      }
      if ($thisFileFullPath !== $file && strpos($name, $thisName . "-") === 0) {
        $sizes[] = substr($name, strlen($thisName) + 1);
      }
    }
    return $sizes;
  }

  /**
   * Resizes an image.
   */
  public function resizeImage($targetSize) {
    if ($this->config->getMaxImageResizeWidth() > 0 && $targetSize->width > $this->config->getMaxImageResizeWidth()) {
      throw new MessageException(
        Message::createMessage(
          Message::MAX_RESIZE_WIDTH_EXCEEDED,
          "" . $targetSize->width,
          $this->getName(),
          "" . $this->config->getMaxImageResizeWidth()
        )
      );
    }

    if ($this->config->getMaxImageResizeHeight() > 0 && $targetSize->height > $this->config->getMaxImageResizeHeight()) {
      throw new MessageException(
        Message::createMessage(
          Message::MAX_RESIZE_HEIGHT_EXCEEDED,
          "" . $targetSize->height,
          $this->getName(),
          "" . $this->config->getMaxImageResizeHeight()
        )
      );
    }

    $fileSrc = $this;
    // If this is just a size of main file.
    if ($this->mainFile != NULL) {
      $fileSrc = $this->mainFile;
    }
    $fileOriginal = $fileSrc->getFileOriginal();
    if ($fileOriginal->exists()) {
      $fileSrc = $fileOriginal;
    }

    $imageWidth = $this->getImageWidth();
    $imageHeight = $this->getImageHeight();

    if ($targetSize->width == 0 && $targetSize->height == 0) {
      return FALSE;
    }
    if ($targetSize->width == 0 && $targetSize->height == $imageHeight) {
      return FALSE;
    }
    if ($targetSize->height == 0 && $targetSize->width == $imageWidth) {
      return FALSE;
    }
    if ($targetSize->width > 0 && $targetSize->height > 0 && $targetSize->width == $imageWidth && $targetSize->height == $imageHeight) {
      return FALSE;
    }

    // Calc full target size of image (with paddings)
    $scaleWWithPadding = -1;
    $scaleHWithPadding = -1;
    if ($targetSize->width > 0 && $targetSize->height > 0) {
      $scaleWWithPadding = $targetSize->width;
      $scaleHWithPadding = $targetSize->height;
    }
    else {
      if ($targetSize->width > 0) {
        $scaleWWithPadding = $targetSize->width;
        $scaleHWithPadding = floor(($scaleWWithPadding / $imageWidth) * $imageHeight);
      }
      else {
        if ($targetSize->height > 0) {
          $scaleHWithPadding = $targetSize->height;
          $scaleWWithPadding = floor(($scaleHWithPadding / $imageHeight) * $imageWidth);
        }
      }
    }

    if (($scaleWWithPadding > $imageWidth || $scaleHWithPadding > $imageHeight) && !$targetSize->enlarge) {
      $scaleWWithPadding = $imageWidth;
      $scaleHWithPadding = $imageHeight;
    }

    // Check we have not exceeded max width/height.
    if (
      ($this->config->getMaxImageResizeWidth() > 0 && $scaleWWithPadding > $this->config->getMaxImageResizeWidth())
      ||
      ($this->config->getMaxImageResizeHeight() > 0 && $scaleHWithPadding > $this->config->getMaxImageResizeHeight())
    ) {
      $coef = max(
        $scaleWWithPadding / $this->config->getMaxImageResizeWidth(),
        $scaleHWithPadding / $this->config->getMaxImageResizeHeight()
      );
      $scaleWWithPadding = floor($scaleWWithPadding / $coef);
      $scaleHWithPadding = floor($scaleHWithPadding / $coef);
    }

    // Calc actual size of image (without paddings)
    $scaleW = -1;
    $scaleH = -1;
    if ($scaleWWithPadding / $imageWidth < $scaleHWithPadding / $imageHeight) {
      $scaleW = $scaleWWithPadding;
      $scaleH = floor(($scaleW / $imageWidth) * $imageHeight);
    }
    else {
      $scaleH = $scaleHWithPadding;
      $scaleW = floor(($scaleH / $imageHeight) * $imageWidth);
    }

    if ($scaleWWithPadding == $imageWidth && $scaleW == $imageWidth && $scaleHWithPadding == $imageHeight && $scaleH == $imageHeight) {
      return FALSE;
    } // no resize is needed
    $fitMode = FileCommited::FIT_EXACT;
    if ($targetSize->width == 0) {
      $fitMode = FileCommited::FIT_TO_HEIGHT;
    }
    else {
      if ($targetSize->height == 0) {
        $fitMode = FileCommited::FIT_TO_WIDTH;
      }
    }
    $image = FileCommited::resizeImageNative($this->getImage(), $scaleW, $scaleH, $fitMode);

    if ($scaleWWithPadding > $scaleW || $scaleHWithPadding > $scaleH) {
      $image = $this->addPaddingsToImageNative($image, $scaleW, $scaleH, $scaleWWithPadding, $scaleHWithPadding);
    }

    $this->writeImage($image);

    return TRUE;
  }

  /**
   * Writes image to disc.
   */
  private function writeImage($image) {
    switch (strtolower($this->getExt())) {
      case 'gif':
        imagegif($image, $this->getFullPath());
        break;

      case 'jpeg':
      case 'jpg':
        imagejpeg($image, $this->getFullPath(), $this->config->getJpegQuality());
        break;

      case 'png':
        imagepng($image, $this->getFullPath());
        break;

      case 'bmp':
        imagewbmp($image, $this->getFullPath());
        break;
    }
  }

  const FIT_EXACT = 0;

  const FIT_TO_WIDTH = 1;

  const FIT_TO_HEIGHT = 2;

  /**
   * Resizes image (native PHP code).
   */
  public static function resizeImageNative($image, $scaleW, $scaleH, $fitMode) {
    $newW = $scaleW;
    $newH = $scaleH;
    if ($fitMode == FileCommited::FIT_TO_WIDTH) {
      $newH = round($newW * $scaleH / $scaleW);
    }
    else {
      if ($fitMode == FileCommited::FIT_TO_HEIGHT) {
        $newW = round($newH * $scaleW / $scaleH);
      }
    }

    $newImage = imagecreatetruecolor($newW, $newH);
    imagealphablending($newImage, FALSE);
    imagesavealpha($newImage, TRUE);
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newW, $newH, imagesx($image), imagesy($image));

    return $newImage;
  }

  /**
   * Adds paddings to image.
   */
  private function addPaddingsToImageNative($image, $scaleW, $scaleH, $scaleWWithPadding, $scaleHWithPadding) {
    $imageWithPaddings = imagecreatetruecolor($scaleWWithPadding, $scaleHWithPadding);
    imagesavealpha($imageWithPaddings, TRUE);

    if (!FileCommited::isTransparent($image)) {
      $bgColor = imagecolorallocate($imageWithPaddings, 255, 255, 255);
    }
    else {
      $bgColor = imagecolorallocatealpha($imageWithPaddings, 0, 0, 0, 127);
    }
    imagefill($imageWithPaddings, 0, 0, $bgColor);

    $left = floor(($scaleWWithPadding - $scaleW) / 2.0);
    $top = floor(($scaleHWithPadding - $scaleH) / 2.0);
    imagecopy($imageWithPaddings, $image, $left, $top, 0, 0, imagesx($image), imagesy($image));
    return $imageWithPaddings;
  }

  /**
   * Is file transoarent.
   */
  public static function isTransparent($image) {
    $w = imagesx($image) - 1;
    $w2 = floor($w / 2.0);
    $h = imagesy($image) - 1;
    $h2 = floor($w / 2.0);
    if (FileCommited::isPixelTransparent($image, 0, 0)) {
      return TRUE;
    }
    if (FileCommited::isPixelTransparent($image, $w, 0)) {
      return TRUE;
    }
    if (FileCommited::isPixelTransparent($image, 0, $h)) {
      return TRUE;
    }
    if (FileCommited::isPixelTransparent($image, $w, $h)) {
      return TRUE;
    }
    if ($w2 != $w || $h2 != $h) {
      if (FileCommited::isPixelTransparent($image, $w2, 0)) {
        return TRUE;
      }
      if (FileCommited::isPixelTransparent($image, $w, $h2)) {
        return TRUE;
      }
      if (FileCommited::isPixelTransparent($image, $w2, $h)) {
        return TRUE;
      }
      if (FileCommited::isPixelTransparent($image, 0, $h2)) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Is pixel transparent.
   */
  public static function isPixelTransparent($image, $x, $y) {
    $rgba = imagecolorat($image, $x, $y);
    $alpha = ($rgba & 0x7F000000) >> 24;
    return $alpha > 0;
  }

  /**
   * {@inheritdoc}
   */
  public function isCommited() {
    return TRUE;
  }

}
