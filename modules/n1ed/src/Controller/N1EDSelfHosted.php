<?php

namespace Drupal\n1ed\Controller;

final class N1EDSelfHosted {

  private $plugins = ['Widgets', 'Flmngr', 'ImgPen', 'BootstrapEditor', 'Translator'];

  public function __construct($plugin_file,$self_hosted_URL, $plugins_folder) {
    $this->plugin_file = $plugin_file;
    $this->self_hosted_URL = $self_hosted_URL;
    $this->plugins_folder = $plugins_folder;
  }

  public function getPluginsAvailable(): array{
    $plugins = [];
    foreach($this->plugins as $plugin_name){
      if(file_exists($this->plugins_folder . $plugin_name)){
        $plugins[] =  $plugin_name;
      }

    }
    return $plugins;
  }

  public function rebuildDependencies(): void{

    $plugin_file = file_get_contents($this->plugin_file);
    preg_match('/\/\*N1ED-ECO-CONFIG-START\*\/(.*?)\/\*N1ED-ECO-CONFIG-END\*\//s', $plugin_file, $match);
    if($match[1]){
          $n1ed_conf = json_decode($match[1], true);
    }
    $plugins = [];

    foreach($this->getPluginsAvailable() as $plugin_name){
      if(array_key_exists('enabled' . $plugin_name,$n1ed_conf)){
        $plugins[$plugin_name] = $n1ed_conf['enabled' . $plugin_name] ? $this->self_hosted_URL . '/' . $plugin_name . '/plugin.js' : null;
      } else {
        $plugins[$plugin_name] = $this->self_hosted_URL . '/' . $plugin_name . '/plugin.js';
      }
    }
    $search = '/\/\*N1ED-ECO-DEPENDENCIES-START\*\/(.*?)\/\*N1ED-ECO-DEPENDENCIES-END\*\//s';
    $replace = "/*N1ED-ECO-DEPENDENCIES-START*/" . json_encode($plugins) . "/*N1ED-ECO-DEPENDENCIES-END*/";
    $new_plugin = preg_replace($search,$replace,$plugin_file);
    file_put_contents($this->plugin_file, $new_plugin);
  }

  public function checkSelfHostedFiles():bool{
    return file_exists($this->plugin_file);
  }

  public function getSelfHostedConfig():array{
    $config = [];

    if($this->checkSelfHostedFiles()){
        $plugin_file = file_get_contents($this->plugin_file);
        preg_match('/\/\*N1ED-ECO-CONFIG-START\*\/(.*?)\/\*N1ED-ECO-CONFIG-END\*\//s', $plugin_file, $match);
        if($match[1]){
          $n1ed_conf = json_decode($match[1], true);
        }
        $arr = [];
        foreach($this->getPluginsAvailable() as $plugin_name){

            $arr[] = $plugin_name;
            if($plugin_name == 'Widgets'){
              array_push($arr, 'CustomTemplates' , 'ConfigEditor', 'Include', 'Structure');
            }
            if($plugin_name == 'BootstrapEditor'){
              array_push($arr, 'BootstrapWidgets', 'BootstrapBlocks', 'BootstrapTheme');
            }

        }

         return ['error' => null, 'data' => ['conf' => $n1ed_conf, 'pluginsAvailable' => $arr]];
      } else {
        return $this->noFilesResponse();
      }
      
    return $config;
  }

  public function noFilesResponse(): array{
    return ["error"=> "NO_SELF_HOSTED_INSTALLED", "data" => null];
  }


  public function setSelfHostedConfig(string $new_config): array{
    if($this->checkSelfHostedFiles()){
      $plugin_file = file_get_contents($this->plugin_file);
      $search = '/\/\*N1ED-ECO-CONFIG-START\*\/(.*?)\/\*N1ED-ECO-CONFIG-END\*\//s';
      $replace = "/*N1ED-ECO-CONFIG-START*/" . $new_config . "/*N1ED-ECO-CONFIG-END*/";
      $new_plugin = preg_replace($search,$replace,$plugin_file);
      file_put_contents($this->plugin_file, $new_plugin);
      $this->rebuildDependencies();
      return ['error' => null, 'data' => 'ok'];
    } else {
      return $this->noFilesResponse();
    }
  }

}
