<?php

class Views {

  public function view($file){
    include (__DIR__.'/../views/'.$file.'.php');
  }

}
