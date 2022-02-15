<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\servlet;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\file\UtilsPHP;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\req\ReqError;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\RespFail;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\Actions;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\JsonCodec;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\Uploader;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Uploader servlet (ported from Java).
 * Stores available action processors, routes request to one of them
 * and returns JSON formed by request processor.
 */
class UploaderServlet {

  protected $actions;

  protected $json;

  protected $uploader;

  protected $config;

  /**
   * Creates an instance.
   */
  public function init($config) {
    $this->actions = new Actions();
    $this->json = new JsonCodec($this->actions);
    $this->config = new ServletConfig($config);
    $this->uploader = new Uploader($this->config, $this->actions);
  }

  /**
   * Gets file info.
   */
  public function getFileInfo($vector) {
    $result = [];
    foreach ($vector as $key1 => $value1) {
      foreach ($value1 as $key2 => $value2) {
        $result[$key2][$key1] = $value2;
      }
    }
    return $result;
  }

  /**
   * Gets a request.
   */
  protected function getReq(RequestStack $request_stack, $files) {

 $req = NULL;

    try {
      $data = $request_stack->getCurrentRequest()->request->get('data') ?? json_encode(['action' => 'upload']);
      $req = $this->json->fromJson($data);

      if ($this->config->isTestAllowed()) {
        if (array_key_exists("testServerConfig", $req)) {
          $this->config->setTestConfig($req->testServerConfig);
        }
        if (array_key_exists("testClearAllFiles", $req)) {
          $this->clearAllFiles();
        }
      }

    }
    catch (Exception $e) {
      error_log($e);
      return NULL;
    }

    if (array_key_exists('file', $files) || array_key_exists('upload', $files)) {
      $req->file = $files['file'] ?? $files['upload'];
      $req->fileName = $req->file['name'];
      $req->fileSize = $req->file['size'];
    }

    return $req;
  }

  /**
   * Clears all files.
   */
  protected function clearAllFiles() {
    UtilsPHP::cleanDirectory($this->config->getTmpDir());
    UtilsPHP::cleanDirectory($this->config->getBaseDir());
  }

  /**
   * Adds headers to response.
   */
  protected function addHeaders() {
    if ($this->config->getCrossDomainUrl() != NULL && strlen($this->config->getCrossDomainUrl()) > 0) {
      header("Access-Control-Allow-Origin: " . $this->config->getCrossDomainUrl());
      header("Access-Control-Allow-Methods: POST");
      header("Access-Control-Allow-Headers: accept, content-type");
      header("Access-Control-Max-Age: 1728000");
    }
  }

  /**
   * Processes OPTIONS HTTP request.
   */
  public function doOptions() {
    $this->addHeaders();
  }

  /**
   * Processes POST HTTP request.
   */
  public function doPost(RequestStack $request_stack, $files) {
$this->addHeaders();
        $resp = null;
        $strResp = null;
        try {
            $req = null;

            try {
                $req = $this->getReq($request_stack, $files);
            } catch (Exception $e) {
                error_log($e);
            }

            if ($req === null)
                $req = new ReqError(Message::createMessage(Message::MALFORMED_REQUEST));

            $resp = $this->uploader->run($req);
            if ($resp === null)
                throw new Exception("Null response as result");

            $strResp = $this->json->toJson($resp);
        } catch (Exception $e) {
            error_log($e);
            $resp = new RespFail(Message::createMessage(Message::INTERNAL_ERROR));
            $strResp = $this->json->toJson($resp);
        }

        try {
            http_response_code(200);
            header('Content-Type: application/json; charset=UTF-8');
            print($strResp);
            die();
        } catch (Exception $e) {
            error_log($e);
        }
}

}
