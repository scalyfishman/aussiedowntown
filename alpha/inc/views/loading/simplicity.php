<?php include 'assets/parsedown.php'; $p = new Parsedown(); $t = $s['themes'][$s['theme']]; ?>
<style>
  .top, .bottom {
    background-color: rgba(<?= $t[0]['background'] ?>, <?= $t[0]['opacity']/100 ?>)
  }
</style>
<div class="left">
  <div class="top animated zoomIn">
    <div class="bordered">
      <img src="<?= $s['avatar'] ?>" alt="">
      <h3><?= $t[1]['title'] ?></h3>
      <h3><?= $s['username'] ?></h3>
    </div>
  </div>
  <div class="bottom animated zoomIn">
    <div class="bordered">
      <h1><?= $t[2]['title'] ?></h1>
      <hr/>
      <div class="data"><?= $p->text($t[2]['data']) ?></div>
    </div>
  </div>
</div>
<div class="mid animated fadeIn">
  <img src="config/uploads/icons/<?= $t[3]['logo'] ?>" alt="">
</div>
<div class="right">
  <div class="top animated zoomIn">
    <div class="bordered">
      <img class="<?= (!$t[4]['map']?"mapImage":"") ?>" src="<?= (!$t[4]['map']?"":"config/uploads/icons/".$t[4]['custom']) ?>" alt="">
      <?php if($t[4]['type']){ ?>
        <h4><span id="plys"></span> players</h4>
        <h4 id="map">Mapname</h4>
        <h4 id="gm">Gamemode</h4>
      <?php } else { ?>
        <h3 id="map">Mapname</h3>
        <h3 id="gm">Gamemode</h3>
      <?php } ?>
    </div>
  </div>
  <div class="bottom animated zoomIn">
    <div class="bordered">
      <h1><?= $t[5]['title'] ?></h1>
      <hr>
      <div class="data"><?= $p->text($t[5]['data']) ?></div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function GameDetails( servername, serverurl, mapname, maxplayers, steamid, gamemode ) {
    gamemode = gamemode.replace("terrortown", "Trouble In Terrorist Town");
    gamemode = gamemode.replace("clonewars", "Clone Wars");
    gamemode = gamemode.replace("prophunt", "Prophunt");
    gamemode = gamemode.replace("stronghold", "F2S: Stronghold");
    gamemode = gamemode.replace("sandbox", "Sandbox");
    gamemode = gamemode.replace("murder", "Murder");
    gamemode = gamemode.replace("darkrp", "DarkRP");
    gamemode = gamemode.replace("zombiesurvival", "Zombie Survival");
    gamemode = gamemode.replace("jailbreak", "Jailbreak");
    $(".mapImage").attr("src", "http://image.gametracker.com/images/maps/160x120/garrysmod/"+mapname+".jpg");
    $("#map").html(mapname);
    $("#gm").html(gamemode);
  }
  $(document).ready(function(){
    // GameDetails(0,0,"rp_liberator_sup_b4",0,0,"clonewars");
    <?php if($t[4]['type']){ ?>
      $('#plys').load("./?pcount&ip=<?= $c->config['ip'] ?>&port=<?= $c->config['port'] ?>");
    <?php } ?>
  });
</script>
