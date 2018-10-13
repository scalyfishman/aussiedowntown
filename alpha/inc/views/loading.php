<?php
  $c = new Config();
  $s = $c->config;
  echo (!isset($s['theme'])?'<h1 style="color:#eee">Server '.$_GET['server'].' does not exist!</h1>':'');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Alpha</title>
    <link rel="stylesheet" href="assets/<?= $s['theme'] ?>.min.css">
    <style>
      body {
        background-color: <?= ($s['background']['solid']?$s['background']['color']:"#000") ?>;
      }
      .backgrounds {
        opacity: <?= $s['background']['alpha'][1]/100 ?>;
      }
      .video {
        opacity: <?= $s['background']['alpha'][0]/100 ?>;
      }
    </style>
    <script src="assets/jquery.js" charset="utf-8"></script>

    <?php if($s['background']['slideshow']){ ?>

      <script>$(document).ready(function(){$(".backgrounds > div:gt(0)").hide();setInterval(function() {var slide1 = $('.backgrounds > div:first');var slide2 = $('.backgrounds > div:nth-child(2)');slide1.fadeIn(200).appendTo('.backgrounds');slide1.fadeOut(200, function(){slide2.fadeIn(200);});}, <?= $s['background']['delay'] ?>);});</script>

    <?php } ?>

  </head>
  <body>

    <?php if($s['background']['pattern']){ ?>

      <style>.pattern{background:url('assets/img/pattern<?= $s['background']['image']+1 ?>.png') repeat;opacity:<?= $s['background']['alpha'][2]/100 ?>}</style>
      <div class="pattern"></div>

    <?php } if($s['background']['slideshow']){ ?>

      <div class="backgrounds">
        <?php $files = scandir("config/uploads/");
          $bgs = [];
          foreach($files as $f){
            if($f!=="."&&$f!==".."&&$f!=="icons"){
              $file = explode(".", $f);
              $include = ['jpg', 'png', 'jpeg'];
              if(in_array(end($file), $include))
                $bgs[] = $f;
            }
          }
          if($s['background']['randomize']){
            shuffle($bgs);
          }
          foreach($bgs as $bg){
            echo '<div><img src="config/uploads/'.$bg.'" alt=""></div>';
          }
        ?>
      </div>

    <?php } if($s['background']['video']){
      $bgs = [];
      $files = scandir("config/uploads/");
      foreach($files as $f){
        if($f!=="."&&$f!==".."&&$f!=="icons"){
          $file = explode(".", $f);
          $include = ['webm', 'mp4', 'avi', '3gp'];
          if(in_array(end($file), $include))
            $bgs[] = $f;
        }
      }
      $t = mt_rand(0, sizeof($bgs)-1);
    ?>

      <div class="video">
        <video src="config/uploads/<?= $bgs[$t] ?>" loop muted autoplay></video>
      </div>

    <?php } include __DIR__."/loading/".(!$s['theme']?"csgo":($s['theme']==1?"space":($s['theme']==2?"simplicity":""))).".php";

      if($s['music']['enabled']){
        if($s['music']['type']==0){
          $music = [];
          $songs = scandir("config/uploads/");
          foreach($songs as $song){
            if($song!=="."&&$song!==".."&&$song!=="icons"){
              $file = explode(".", $song);
              $include = ['mp3', 'wav', 'ogg'];
              if(in_array(end($file), $include))
                $music[] = $song;
            }
          }
      ?>
        <audio id="music" autoplay></audio>
        <script type="text/javascript">
          var songs = <?= json_encode($music) ?>;
          var index = (<?= intval($s['music']['randomize']) ?>)?Math.floor(Math.random()*songs.length):0;
          document.getElementById("music").src = "config/uploads/"+songs[index];
          document.getElementById("music").volume = <?= intval($c->config['music']['volume'])/100 ?>;
          checkEnd();
          function checkEnd(){
            var music = document.getElementById("music");
            setInterval(function(){
              if(music.ended){
                changeSong();
                return;
              }
            }, 1000);
          }
          function changeSong(){
            var music = document.getElementById("music");
            if(<?= intval($s['music']['randomize']) ?>){
              var song = songs[Math.floor(Math.random()*songs.length)];
            } else {
              index++;
              if(!songs[index])
                index = 0;
              var song = songs[index];
            }
            music.src = "config/uploads/"+song;
            checkEnd();
          }
        </script>
      <?php } elseif($s['music']['type']==1){ ?>
        <div id="player" style="position:fixed;top:0;left:0;z-index:6"></div>
        <script src="https://www.youtube.com/iframe_api"></script>
        <script>var player;function onYouTubeIframeAPIReady() {player = new YT.Player('player', {width: 1,height: 1,videoId: '<?= substr($s['music']['youtube'], -11) ?>',events: {'onReady': onPlayerReady,'onStateChange': onStateChange}});}function onPlayerReady(event) {event.target.setVolume(<?= $s['music']['volume'] ?>);event.target.setLoop(1);event.target.playVideo();}function onStateChange(event){if(event.data == 0){event.target.playVideo();}}</script>
      <?php } else { ?>
        <div id="player" style="position:fixed;top:0;left:0;z-index:6"></div>
        <script src="https://www.youtube.com/iframe_api"></script>
        <script>var player;function onYouTubePlayerAPIReady() {player = new YT.Player('player', {height: '1',width: '1',playerVars: {'autoplay': 1,listType: 'playlist',list: '<?= substr($s['music']['playlist'], -34) ?>'},events: {'onReady': onPlayerReady,'onStateChange':onStateChange}});}
        function onPlayerReady(event) {
          event.target.setVolume(<?= $s['music']['volume'] ?>);
          event.target.setLoop(true);
          event.target.playVideo();
          setTimeout(function(){
            event.target.setShuffle(1);
          },2000);
        }
        function onStateChange(event){
          if(event.data == 0&&<?= $s['music']['randomize'] ?>){
            event.target.setShuffle(1);
          }
        }
        </script>
      <?php } ?>
    <?php } ?>


  </body>
</html>
