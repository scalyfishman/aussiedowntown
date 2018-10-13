<?php

require __DIR__.'/sourcequery/SourceQuery.class.php';

define('SQ_SERVER_ADDR',$_GET['ip']);
define('SQ_SERVER_PORT',$_GET['port']);

$q = new SourceQuery();

$info = [];

try {

  $q->Connect(SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE);

  $info = $q->GetInfo();

} catch(Exception $e){

  echo $e->getMessage();

}

$q->Disconnect();

echo $info['Players'].'/'.$info['MaxPlayers'];
