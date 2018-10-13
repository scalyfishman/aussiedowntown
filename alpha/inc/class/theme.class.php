<?php

class Theme extends Views {

  public function check($auth){
    if(isset($_GET['pcount']))
      $this->view("query");
    elseif(isset($_GET['steamid'])&&isset($_GET['server']))
      $this->view("loading");
    else
      $auth->check();
  }

}
$theme = new Theme();
