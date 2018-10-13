<?php
// ini_set("display_errors", "-1");

session_start();
ob_start();

include 'class/views.class.php';
include 'class/install.class.php';
include 'class/auth.class.php';
include 'class/config.class.php';
include 'class/theme.class.php';

if($install->new)
  $install->execute();
else
  $theme->check($auth);

if(isset($_GET['logout']))
  $auth->logout();
