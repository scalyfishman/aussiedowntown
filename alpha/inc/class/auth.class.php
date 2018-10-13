<?php

class Auth extends Views {

  public $authed;
  public $sid;

  public $staff;

  function __construct(){
    $install = new Install();

    if(isset($_SESSION['alpha'])){
      $this->authed = true;
      $this->sid = $_SESSION['alpha'];
    }

    if($this->authed&&!$install->new){
      $data = json_decode(file_get_contents(__DIR__."/../../config/main.json"),true);
      if(!count($data['staff'])){
        $temp = $data;
        $temp['staff'][0] = $this->sid;
        $file = fopen(__DIR__."/../../config/main.json", "w");
        fwrite($file, json_encode($temp, JSON_PRETTY_PRINT));
        fclose($file);
      }
      $this->staff = (!count($data['staff'])||in_array($this->sid, $data['staff'])?true:false);
    }
  }

  public function check(){
    if($this->authed){
      if($this->staff){
        $c = new Config();
        $c->panel();
        if(isset($_GET['delete']))
          $c->delete($_GET['delete']);
      } else
        $this->guest();
    } else {
      $this->view("login");
      $this->login();
    }
  }

  public function login(){
    if(isset($_GET['login'])&&!$this->authed){
      include __DIR__."/../openid.php";
      try {
        $openid = new LightOpenID($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        if(!$openid->mode) {
          $openid->identity = 'https://steamcommunity.com/openid';
          header('Location: ' . $openid->authUrl());
        } elseif ($openid->mode == 'cancel') {
          echo 'Canceled auth.';
        } else {
          if($openid->validate()) {
            $id = $openid->identity;
            $url = "/^https:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
            preg_match($url, $id, $match);
            $_SESSION['alpha'] = $match[1];
            header('Location: '.str_replace("?login", "", $_GET['openid_return_to']));
          }
        }
      } catch(ErrorException $e) {
        echo $e->getMessage();
      }
      if(isset($_GET['openid_identity']) && !empty($_GET['openid_identity'])){
        header('Location: '.str_replace("?login", "", $_GET['openid_return_to']));
      }
    }
  }

  public function guest(){
    unset($_SESSION['alpha']);
    header('Location: ./?error=1');
  }

  public function logout(){
    unset($_SESSION['alpha']);
    header('Location: ./');
  }

}

$auth = new Auth();
