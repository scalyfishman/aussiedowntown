<?php include 'assets/parsedown.php'; $p = new Parsedown(); $t = $s['themes'][$s['theme']]; ?>
<div class="space">
  <div class="top">
    <img src="<?= $s['avatar'] ?>" alt="" class="<?= ($t[0]['circular']?'circular':'') ?>">
    <span style="font-size: <?= $t[0]['size'] ?>"><?= $t[0]['text'] ?> <?= $s['username'] ?></span>
  </div>
  <div class="mid">
    <div class="left">
      <div class="content">
        <h1 class="title"><?= $t[1]['title'] ?></h1>
        <div class="data align<?= $t[1]['align'] ?>"><?= $p->text($t[1]['data']) ?></div>
      </div>
    </div>
    <div class="middle">
      <div class="content">
        <h1 class="title"><?= $t[2]['title'] ?></h1>
        <div class="info">
          <p><b>Map:</b> <span class="map">Loading...</span></p>
          <p><b>Game mode:</b> <span class="gm">Loading...</span></p>
          <p><b>Players:</b> <span class="players">Loading...</span></p>
        </div>
        <div class="data align<?= $t[2]['align'] ?>"><?= $p->text($t[2]['data']) ?></div>
      </div>
    </div>
    <div class="right">
      <div class="content">
        <h1 class="title"><?= $t[3]['title'] ?></h1>
        <div class="data align<?= $t[3]['align'] ?>"><?= $p->text($t[3]['data']) ?></div>
      </div>
    </div>
  </div>
  <div class="bottom">
    <style>
      .progress {
        background-color: #<?= $t[4]['color'] ?>;
        opacity: <?= $t[4]['opacity']/100 ?>;
      }
    </style>
    <div class="progress"></div>
    <p class="changer">Retrieving server info...</p>
    <div class="quotes">
      <?php $quotes = explode("\n", $t[4]['quotes']); foreach($quotes as $t){ ?>
        <p class="quote"><?= $t ?></p>
      <?php } ?>
    </div>
  </div>
  <script type="text/javascript">
      var quotes = $(".quote");
      var quoteIndex = -1;
      function showNextQuote() {
          ++quoteIndex;
          quotes.eq(quoteIndex % quotes.length).fadeIn({left: 2000}).delay(2000).fadeOut(2000, showNextQuote);
      }
      showNextQuote();
      $(document).ready(function(){
        <?php if($t[2]['count']){ ?>
          $('.players').load("./?pcount&ip=<?= $c->config['ip'] ?>&port=<?= $c->config['port'] ?>");
        <?php } ?>
      });
      var totalFiles, neededFiles, percent;
      function GameDetails( servername, serverurl, mapname, maxplayers, steamid, gamemode ) {
          var newGamemode = gamemode;
          newGamemode = newGamemode.replace("terrortown", "Trouble In Terrorist Town");
          newGamemode = newGamemode.replace("prophunt", "Prophunt");
          newGamemode = newGamemode.replace("stronghold", "F2S: Stronghold");
          newGamemode = newGamemode.replace("sandbox", "Sandbox");
          newGamemode = newGamemode.replace("murder", "Murder");
          newGamemode = newGamemode.replace("darkrp", "DarkRP");
          newGamemode = newGamemode.replace("zombiesurvival", "Zombie Survival");
          newGamemode = newGamemode.replace("jailbreak", "Jailbreak");
        	$(".gm").html(newGamemode);
        	$(".map").html(mapname);
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
</div>
