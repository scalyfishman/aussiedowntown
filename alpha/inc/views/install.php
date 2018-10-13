<?php $n = new Install(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Alpha</title>
    <link rel="stylesheet" href="assets/install.min.css">
    <script src="assets/install.min.js" charset="utf-8"></script>
  </head>
  <body>
    <div class="installer">
      <div id="step0" class="step">
        <div class="wrapper">
          <h1>Welcome to Alpha!</h1>
          <h3>This installer will guide you through the installation!</h3>
          <p>Thank you so much for your support.</p>
          <p>If you think Alpha meets its expectations, please leave a review <a href="https://scriptfodder.com/scripts/view/1157/reviews" target="_blank">here</a>!</p>
          <hr/>
          <p>If you need support, do not add me on steam. <a href="https://scriptfodder.com/dashboard/support/tickets/create/1157" target="_blank">Use the support ticket system on ScriptFodder!</a></p>
          <hr/>
          <div class="button">
            <a class="succ" href="#next1">Next</a>
          </div>
        </div>
      </div>
      <div id="step1" class="step">
        <div class="wrapper">
          <h1>Prerequisites</h1>
          <table style="width:100%">
            <thead>
              <tr>
                <th>Type</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr class="<?= (version_compare(phpversion(), '5.6', '>=')?"succ":"dang") ?>">
                <td><code>PHP 5.6 +</code></td>
                <td><?= (version_compare(phpversion(), '5.6', '>=')?"OK":"Nope :c") ?></td>
              </tr>
              <tr class="<?= (version_compare(phpversion(), '5.6', '<')?"dang":"succ") ?>">
                <td><code>cURL</code></td>
                <td><?= (function_exists("curl_version")?"OK":"Nope :c") ?></td>
              </tr>
            </tbody>
          </table>
          <hr/>
          <?php if(version_compare(phpversion(), '5.6', '>=')&&function_exists("curl_version")){ ?>
            <div class="button">
              <a class="succ" href="#next2">Next</a>
            </div>
          <?php } ?>
        </div>
      </div>
      <?php $config = substr(sprintf('%o', fileperms("config")), -4); $uploads = substr(sprintf('%o', fileperms("config")), -4); ?>
      <div id="step2" class="step">
        <div class="wrapper">
          <h1>Folder permissions</h1>
          <table>
            <thead>
              <tr>
                <th>Folder</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr class="<?= ($config=="0777"&&$uploads=="0777"?"succ":"dang") ?>">
                <td><code>config/</code></td>
                <td><?= ($config=="0777"&&$uploads=="0777"?"OK":"Nope :c") ?></td>
              </tr>
            </tbody>
          </table>
          <?php if($config!=="0777"){ ?>
            <hr/>
            <h3>Uh-oh!</h3>
            <p>You can fix this by setting your &quot;config/&quot; folder to<br/>777 as depicted through FileZilla below:</p>
            <img src="https://i.atomik.info/2f5881.png" alt="">
            Refresh this page afterwards.
          <?php } else { ?>
            <hr/>
            <div class="button">
              <a class="succ" href="?install">Install</a>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </body>
</html>
