<?php

namespace Drupal\n1ed\Flmngr\FlmngrServer;

use Drupal\n1ed\Flmngr\FlmngrServer\resp\Response;
use Exception;

use Drupal\n1ed\Flmngr\FileUploaderServer\FileUploaderServer;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\JsonCodec;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;

use Drupal\n1ed\Flmngr\FlmngrServer\fs\FMDiskFileSystem;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * File Manager server.
 * This is a entry point for processing any of incoming Flmngr client's request.
 * It takes "action" parameter from request and decides which
 * request processor to use and executes it, then returns a result as JSON.
 * Initially being an independent library, it can be run separately,
 * but here is fully integrated in Drupal.
 */
class FlmngrServer {

  /**
   * Processes a request to file manager.
   */
  public static function flmngrRequest($config, RequestStack $request_stack) {

    $action = NULL;

    if ($request_stack->getCurrentRequest()->request->get("action") != NULL) {
      $action = $request_stack->getCurrentRequest()->request->get("action");
    }
      
    if ($action == NULL && $request_stack->getCurrentRequest()->request->get("data") != NULL) {
      $configUploader = [
        "dirFiles" => $config["dirFiles"],
        "dirTmp" => $config["dirTmp"],
        "config" => isset($config["uploader"]) ? $config["uploader"] : [],
      ];
      FileUploaderServer::fileUploadRequest($configUploader, $request_stack, $_FILES);
      return;
    }
    if ($action == NULL && $request_stack->getCurrentRequest()->query->get("action") != NULL) {
      $action = $request_stack->getCurrentRequest()->query->get("action");
    }

    if ((isset($_FILES["file"]) || isset($_FILES["upload"])) && (!$request_stack->getCurrentRequest()->request->get("action")) && (!$request_stack->getCurrentRequest()->request->get('data'))) {
        $json = array(
          "action" => "upload"
        );
        $_POST["data"] = json_encode($json);
        $action = 'upload';
      }

    try {
      switch ($action) {
        case 'dirList':
          $resp = FlmngrServer::reqDirList($config, $request_stack);
          break;

        case 'dirCreate':
          $resp = FlmngrServer::reqDirCreate($config, $request_stack);
          break;

        case 'dirRename':
          $resp = FlmngrServer::reqDirRename($config, $request_stack);
          break;

        case 'dirDelete':
          $resp = FlmngrServer::reqDirDelete($config, $request_stack);
          break;

        case 'dirCopy':
          $resp = FlmngrServer::reqDirCopy($config, $request_stack);
          break;

        case 'dirMove':
          $resp = FlmngrServer::reqDirMove($config, $request_stack);
          break;

        case 'dirDownload':
          $resp = FlmngrServer::reqDirDownload($config, $request_stack);
          break;

        case 'fileList':
          $resp = FlmngrServer::reqFileList($config, $request_stack);
          break;

        case 'fileDelete':
          $resp = FlmngrServer::reqFileDelete($config, $request_stack);
          break;

        case 'fileCopy':
          $resp = FlmngrServer::reqFileCopy($config, $request_stack);
          break;

        case 'fileRename':
          $resp = FlmngrServer::reqFileRename($config, $request_stack);
          break;

        case 'fileMove':
          $resp = FlmngrServer::reqFileMove($config, $request_stack);
          break;

        case 'fileResize':
          $resp = FlmngrServer::reqFileResize($config);
          break;

        case 'fileOriginal':
          // Will die after valid response or throw MessageException.
          $resp = FlmngrServer::reqFileOriginal($config, $request_stack);
          break;

        case 'filePreview':
          // Will die after valid response or throw MessageException.
          $resp = FlmngrServer::reqFilePreview($config, $request_stack);
          break;

        case 'upload':
          $resp = FlmngrServer::upload($config, $request_stack);
          break;

        case 'getVersion':
          $resp = FlmngrServer::getVersion();
          break;

        default:
          $resp = new Response(Message::createMessage(Message::ACTION_NOT_FOUND), NULL);
      }
    }
    catch (MessageException $e) {
      $resp = new Response($e->getFailMessage(), NULL);
    }


    $strResp = JsonCodec::staticToJson($resp);


    try {
      http_response_code(200);
      header('Content-Type: application/json; charset=UTF-8');
      print($strResp);
    }
    catch (Exception $e) {
      error_log($e);
    }

  }

  /**
   * Processes request to copy a directory.
   */
  private static function reqDirCopy($config, RequestStack $request_stack) {
    $dirPath = $request_stack->getCurrentRequest()->request->get("d");
    $newPath = $request_stack->getCurrentRequest()->request->get("n");
    try {
      $fileSystem = new FMDiskFileSystem($config);
      $fileSystem->copyDir($dirPath, $newPath);
      return new Response(NULL, TRUE);
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  /**
   * Processes request to create a directory.
   */
  private static function reqDirCreate($config, RequestStack $request_stack) {
    $dirPath = $request_stack->getCurrentRequest()->request->get("d");
    $name = $request_stack->getCurrentRequest()->request->get("n");
    try {
      $fileSystem = new FMDiskFileSystem($config);
      $fileSystem->createDir($dirPath, $name);
      return new Response(NULL, TRUE);
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  /**
   * Processes request to delete a directory.
   */
  private static function reqDirDelete($config, RequestStack $request_stack) {
    $dirPath = $request_stack->getCurrentRequest()->request->get("d");
    try {
      $fileSystem = new FMDiskFileSystem($config);
      $fileSystem->deleteDir($dirPath);
      return new Response(NULL, TRUE);
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  /**
   * Processes request to download directory.
   */
  private static function reqDirDownload($config, RequestStack $request_stack) {
    // TODO:
  }

  /**
   * Processes request to get directory listing.
   */
  private static function reqDirList($config, RequestStack $request_stack) {
    try {
      $fileSystem = new FMDiskFileSystem($config);
      $dirs = $fileSystem->getDirs();
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
    return new Response(NULL, $dirs);
  }

  /**
   * Processes request to move a directory.
   */
  private static function reqDirMove($config, RequestStack $request_stack) {
    $dirPath = $request_stack->getCurrentRequest()->request->get("d");
    $newPath = $request_stack->getCurrentRequest()->request->get("n");
    try {
      $fileSystem = new FMDiskFileSystem($config);
      $fileSystem->moveDir($dirPath, $newPath);
      return new Response(NULL, TRUE);
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  /**
   * Processes request to rename a directory.
   */
  private static function reqDirRename($config, RequestStack $request_stack) {
    $dirPath = $request_stack->getCurrentRequest()->request->get("d");
    $newName = $request_stack->getCurrentRequest()->request->get("n");
    try {
      $fileSystem = new FMDiskFileSystem($config);
      $fileSystem->renameDir($dirPath, $newName);
      return new Response(NULL, TRUE);
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  /**
   * Processes request to copy files.
   */
  private static function reqFileCopy($config, RequestStack $request_stack) {
    $files = $request_stack->getCurrentRequest()->request->get("fs");
    $newPath = $request_stack->getCurrentRequest()->request->get("n");

    $filesPaths = preg_split("/\|/", $files);

    try {
      $fileSystem = new FMDiskFileSystem($config);
      $fileSystem->copyFiles($filesPaths, $newPath);
      return new Response(NULL, TRUE);
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  /**
   * Processes request to delete files.
   */
  private static function reqFileDelete($config, RequestStack $request_stack) {
    $files = $request_stack->getCurrentRequest()->request->get("fs");

    $filesPaths = preg_split("/\|/", $files);

    try {
      $fileSystem = new FMDiskFileSystem($config);
      $fileSystem->deleteFiles($filesPaths);
      return new Response(NULL, TRUE);
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  /**
   * Processes request to get files list.
   */
  private static function reqFileList($config, RequestStack $request_stack) {
    $path = $request_stack->getCurrentRequest()->request->get("d");

    try {
      $fileSystem = new FMDiskFileSystem($config);
      $files = $fileSystem->getFiles($path);
      return new Response(NULL, $files);
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  /**
   * Processes request to move files.
   */
  private static function reqFileMove($config, RequestStack $request_stack) {
    $files = $request_stack->getCurrentRequest()->request->get("fs");
    $newPath = $request_stack->getCurrentRequest()->request->get("n");

    $filesPaths = preg_split("/\|/", $files);

    try {
      $fileSystem = new FMDiskFileSystem($config);
      $fileSystem->moveFiles($filesPaths, $newPath);
      return new Response(NULL, TRUE);
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  /**
   * Processes request to get file original.
   */
  private static function reqFileOriginal($config, RequestStack $request_stack) {
    $filePath = $request_stack->getCurrentRequest()->query->get('f');

    try {
      $fileSystem = new FMDiskFileSystem($config);
      list($mimeType, $f) = $fileSystem->getImageOriginal($filePath);
      header('Content-Type:' . $mimeType);
      fpassthru($f);
      die;
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  private static function upload($config, RequestStack $request_stack){
        try {
      $configUploader = [
          'dirFiles' => $config['dirFiles'],
          'dirTmp' => $config['dirTmp'],
          'config' => isset($config['uploader'])
              ? $config['uploader']
              : [],
      ];

      $post = [
        'action' =>  $request_stack->getCurrentRequest()->request->get('action'),
        'dir' => $request_stack->getCurrentRequest()->request->get('dir'),
        'data' => JsonCodec::s_toJson(['action' => $request_stack->getCurrentRequest()->request->get('action'), 'dir' => $request_stack->getCurrentRequest()->request->get('dir')])
      ];
      FileUploaderServer::fileUploadRequest($configUploader,$request_stack, $_FILES);
  } catch (MessageException $e) {
      return new Response($e->getFailMessage(), null);
  }
  }

  /**
   * Processes request to get file preview.
   */
  private static function reqFilePreview($config, RequestStack $request_stack) {
    $filePath = $request_stack->getCurrentRequest()->query->get('f');
    $width = $request_stack->getCurrentRequest()->query->get('width');
    $height = $request_stack->getCurrentRequest()->query->get('height');

    try {
      $fileSystem = new FMDiskFileSystem($config);
      list($mimeType, $f) = $fileSystem->getImagePreview($fileSystem->getAbsolutePath(str_replace("/", DIRECTORY_SEPARATOR, $filePath)), $width, $height);
      header('Content-Type:' . $mimeType);
      fpassthru($f);
      die;
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  /**
   * Processes request to rename a file.
   */
  private static function reqFileRename($config, RequestStack $request_stack) {
    $filePath = $request_stack->getCurrentRequest()->request->get("f");
    $newName = $request_stack->getCurrentRequest()->request->get("n");

    try {
      $fileSystem = new FMDiskFileSystem($config);
      $fileSystem->renameFile($filePath, $newName);
      return new Response(NULL, TRUE);
    }
    catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  /**
   * Processes a request for resiging image.
   * Used for creating previews for galleries and responsive images.
   */
  private static function reqFileResize($config) {
    $filePath = $_POST['f'];
    $newFileNameWithoutExt = $_POST['n'];
    $maxWidth = $_POST['mw'];
    $maxHeight = $_POST['mh'];

    $mode = $_POST['mode'];

    try {
      $fileSystem = new FMDiskFileSystem($config);
      $resizedFilePath = $fileSystem->resizeFile($filePath, $newFileNameWithoutExt, $maxWidth, $maxHeight, $mode);
      return new Response(NULL, $resizedFilePath);
    } catch (MessageException $e) {
      return new Response($e->getFailMessage(), NULL);
    }
  }

  /**
   * Sends current backend version to client to highlight own feature list.
   */
  private static function getVersion() {
    return new Response(NULL, ["version" => "3", "language" => "php"]);
  }

}
