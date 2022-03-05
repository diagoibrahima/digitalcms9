<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib;

use Exception;

/**
 * JSON coder/decoder.
 * Converting objects to JSON and back with fixing some common encoding errors.
 */
class JsonCodec {

  protected $actions;

  /**
   * Creates a codec.
   */
  public function __construct($actions) {
    $this->actions = $actions;
  }

  /**
   * Parses request JSON.
   */
  public function fromJson($json) {
    
    $jsonObj = json_decode($json, FALSE);
    
    if ($jsonObj === NULL) {
      throw new Exception('Unable to parse JSON');
    }

    if (!isset($jsonObj->action)) {
      throw new Exception('"Unable to detect action in JSON"');
    }

    $action = $this->actions->getAction($jsonObj->action);
  
    if ($action === NULL) {
      throw new Exception("JSON action is incorrect: " . $action);
    }

    return $jsonObj;
  }

  /**
   * Stringifies response to JSON.
   */
  public function toJson($resp) {
    return JsonCodec::staticToJson($resp);
  }

  /**
   * Encodes and escapes JSON.
   */
  public static function staticToJson($resp) {
    $json = json_encode($resp);
    $json = str_replace('\\u0000*\\u0000', '', $json);
    $json = str_replace('\\u0000', '', $json);
    return $json;
  }

      public static function s_toJson($resp) {
        $json = json_encode($resp);
        $json = str_replace('\\u0000*\\u0000', '', $json);
        $json = str_replace('\\u0000', '', $json);
        return $json;
    }

}
