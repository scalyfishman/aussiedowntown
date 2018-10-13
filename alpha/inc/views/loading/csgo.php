<?php include 'assets/parsedown.php'; $p = new Parsedown(); $t = $s['themes'][$s['theme']]; ?>
<div class="csgo">
  <div class="wrap">
    <div class="top">
      <img src="<?= ($t[0]['icon']!=="hint.png"?"config/uploads/icons/".$t[0]['icon']:"assets/img/hint.png") ?>" alt="">
      <div class="hints">
        <?php $hints = explode("\n", $t[0]['hints']); foreach($hints as $hint){ ?>
          <span class="hint"><?= $hint ?></span>
        <?php } ?>
      </div>
    </div>
    <div class="main">
      <div class="map">
        <img class="<?= (!$t[1]['map']?"mapImage":"") ?>" src="<?= (!$t[1]['map']?"":($t[1]['map']=="8"?"config/uploads/".$t[1]['custom']:"assets/img/csgo/csgo".$t[1]['map'].".png")) ?>" alt="">
      </div>
      <div class="mid">
        <h1><?= $t[1]['title'] ?></h1>
        <p><?= $t[1]['subtitle'] ?></p>
        <img src="<?= (!$t[1]['map']?"config/uploads/icons/".$t[1]['icon']:"assets/img/csgo".$t[1]['map'].".png") ?>" alt="">
      </div>
      <hr/>
      <div class="data">
        <?= $p->text($t[2]['data']) ?>
      </div>
      <div class="loading">
        <p class="changer">Retrieving server info...</p>
        <div class="bar"><div class="progress" style="background-color:<?= $t[2]['color'] ?>"></div></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var quotes = $(".hint");
  var quoteIndex = -1;
  function showNextQuote() {
      ++quoteIndex;
      quotes.eq(quoteIndex % quotes.length).fadeIn({left: 2000}).delay(2000).fadeOut(2000, showNextQuote);
  }
  showNextQuote();
  function GameDetails( servername, serverurl, mapname, maxplayers, steamid, gamemode ) {
    $(".mapImage").attr("src", "http://image.gametracker.com/images/maps/160x120/garrysmod/"+mapname+".jpg");
  }
  function SetFilesTotal( total ) {
    totalFiles = total;
  }
  function SetFilesNeeded( needed ) {
    neededFiles = needed;
    percent = Math.round((totalFiles - neededFiles)/totalFiles * 100);
    $('.progress').width(percent+'%');
  }
  function SetStatusChanged( status ) {
    status = status;
    $('.changer').innerHTML(status);
    if(status = "Sending client info..."){
      $('.progress').width('100%');
    }
  }
</script>
