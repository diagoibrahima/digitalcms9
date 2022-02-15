<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\file;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;

/**
 * Downloaded URL representation.
 */
class DownloadedURL {

  public $fileName = NULL;

  public $contentType = NULL;

  public $contentLength = -1;

}
/**
 * URL downloader.
 */
class URLDownloader {

  /**
   * Downlaods URL to directory.
   */
  public static function download($url, $dir) {
    $result = URLDownloader::downloadUrl($url, $dir);
    return $result;
  }

  /**
   * Downloads URL.
   */
  private static function downloadUrl($url, $dir) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11");
    curl_setopt($curl, CURLOPT_FAILONERROR, FALSE);
    // For not redirecting response to stdout.
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    // Allow redirects.
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    $headers = [];
    curl_setopt($curl, CURLOPT_HEADERFUNCTION,
      function ($curl_, $header) use (&$headers) {
        $len = strlen($header);
        $header = explode(':', $header, 2);
        // Ignore invalid headers.
        if (count($header) < 2) {
          return $len;
        }
        $name = strtolower(trim($header[0]));
        if (!array_key_exists($name, $headers)) {
          $headers[$name] = [trim($header[1])];
        }
        else {
          $headers[$name][] = trim($header[1]);
        }
        return $len;
      }
    );

    $result = new DownloadedURL();
    $fileName = "";
    $response = curl_exec($curl);

    if ($response !== FALSE) {

      $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      if ($responseCode == '200') {
        if (array_key_exists("Content-Type", $headers)) {
          $result->contentType = $headers["Content-Type"];
        }
        if (array_key_exists("Content-Length", $headers)) {
          $result->contentLength = $headers["Content-Length"];
        }
        if (array_key_exists("Content-Disposition", $headers)) {
          $contentDisposition = $headers["Content-Disposition"];
          $index = strpos($contentDisposition, "filename=");
          if ($index !== FALSE) {
            $fileName = substr($contentDisposition, $index + 10);
          }
        }
        if (strlen(trim($fileName)) == 0) {
          $index = strrpos($url, "/");
          $fileName = substr($url, $index + 1);
          $index = strpos($fileName, "?");
          if ($index !== FALSE) {
            $fileName = substr($fileName, 0, $index);
          }
        }
        if (strlen(trim($fileName)) === 0) {
          $fileName = "url";
        }
        $fileName = Utils::fixFileName($fileName);
        $fileName = Utils::getFreeFileName($dir, $fileName, FALSE);
      }
      else {
        throw new MessageException(Message::createMessage(Message::DOWNLOAD_FAIL_CODE, $responseCode));
      }
    }
    else {
      throw new MessageException(Message::createMessage(Message::DOWNLOAD_FAIL_IO, curl_error($curl)));
    }

    $saveFilePath = $dir . DIRECTORY_SEPARATOR . $fileName;
    file_put_contents($saveFilePath, $response);
    curl_close($curl);

    $result->fileName = $fileName;
    return $result;
  }

}
