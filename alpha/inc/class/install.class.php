<?php

class Install extends Views {

  public $new;

  public $writable;

  function __construct(){
    $this->new = (!is_writeable(__DIR__."/../../config")||file_exists(__DIR__."/../../config/new")||!file_exists(__DIR__."/../../config/main.json")?true:false);
  }

  public function execute(){
    $this->view("install");
    $this->install();
  }

  public function install(){
    if(isset($_GET['install'])&&$this->new){
      unlink(__DIR__."/../../config/new");

      // create default json
      $main = fopen(__DIR__."/../../config/main.json", "w");
      $defaults = [
        "changelog" => "- Something for you server owners\n- Add a to-do list\n- or just keep track of changes to your loading screen here",
        "servers" => [
          [
            "SUP &sdot; Clone Wars",
            "149.56.67.156:27015"
          ],
          [
            "SUP &sdot; Danktown",
            "149.56.67.128:27015"
          ],
          [
            "Icefuse",
            "192.99.239.50:27015"
          ]
        ],
        "staff" => [],
      ];
      $json = json_encode($defaults, JSON_PRETTY_PRINT);
      fwrite($main, $json);
      fclose($main);

      header('Location: ./');
    }
  }

}

$install = new Install();
