<?php $c = new Config(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Alpha</title>
    <link rel="stylesheet" href="assets/admin.min.css">
    <script src="assets/jquery.js" charset="utf-8"></script>
    <script src="assets/semantic.min.js" charset="utf-8"></script>
    <script src="assets/admin.min.js" charset="utf-8"></script>
  </head>
  <body>
    <div class="ui top inverted fixed menu">
      <div class="ui container">
        <a href="./" class="header item">
          <b>&alpha;</b> Alpha
        </a>
        <div class="ui inverted dropdown item">
          Servers
          <i class="dropdown icon"></i>
          <div class="ui inverted menu">
            <?php foreach($c->json['servers'] as $k => $s){ ?>
              <a href="./?server=<?= $k+1 ?>" class="item"><?= $s[0] ?></a>
            <?php } ?>
            <!-- <div class="ui divider"></div>
            <a href="./?servers" class="item">Manage</a> -->
          </div>
        </div>
        <div class="ui right inverted menu">
          <a href="./?logout" class="item">Logout</a>
        </div>
      </div>
    </div>

    <div class="ui container">
      <h1 class="ui inverted header">Alpha settings</h1>
      <div class="ui inverted divider"></div>
      <br/>
      <form class="ui inverted form" id="mainForm" method="POST">
        <div class="ui grid stackable">
          <!-- <div class="row">
            <div class="four wide column">
              <p>Community name</p>
              <div class="ui inverted field">
                <input type="text" name="community" value="">
              </div>
            </div>
          </div> -->
          <h4 class="ui inverted header">Separate the following config entries by new lines</h4>
          <div class="row">
            <div class="six wide column">
              <p>Changelog</p>
              <div class="ui inverted field">
                <textarea name="changelog"><?= $c->json['changelog'] ?></textarea>
              </div>
            </div>
            <div class="six wide column">
              <p>Servers &sdot; <u>Syntax</u>: <small>SERVER NAME<b>-</b>IP:PORT</small></p>
              <div class="ui inverted field">
                <textarea name="servers"><?php foreach($c->json['servers'] as $v)echo htmlspecialchars($v[0])."-".$v[1]."\n"; ?></textarea>
              </div>
            </div>
            <div class="four wide column">
              <p>Staff</p>
              <div class="ui inverted field">
                <textarea name="staff"><?php foreach($c->json['staff'] as $s) echo $s."\n"; ?></textarea>
              </div>
            </div>
          </div>
        </div>
        <p></p>
        <div class="button">
          <a class="bordered succ" onclick="$('#mainForm').submit()"><span>Save</span></a>
        </div>
      </form>
      <div class="ui inverted divider"></div>
      <h1>Uploads</h1>
      <div class="ui grid stackable">
        <div class="eight wide column">
          <h3>Image/Video backgrounds and music uploads</h3>
          <p>To save time, upload <a href="http://atomik.info/downloads" target="_blank">the custom alpha video backgrounds</a> through an ftp client.<br/>Upload them to &quot;alpha/config/uploads&quot; in order for them to show up here.</p>
          <table class="ui inverted table">
            <thead>
              <tr>
                <th>File</th>
                <th style="text-align:center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $files = scandir("config/uploads/"); foreach($files as $f){ ?>
                <tr>
                  <?php if($f!=="."&&$f!==".."&&$f!=="icons"){
                    $file = explode(".", $f);
                    $ignore = ['php'];
                    if(!in_array(end($file), $ignore)){ ?>
                      <td><a href="config/uploads/<?= $f ?>" target="_blank"><?= $f ?></a></td>
                      <td style="text-align:center"><a href="?delete=<?= $f ?>" class="mini ui red button">Delete</a></td>
                    <?php } ?>
                  <?php } ?>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="eight wide column">
          <h3>Logo/Icon uploads</h3>
          <p>You can include the file names of uploaded logos/icons in different themes.<br/>Ex. CS:GO hint icon, CS:GO map icon, Simplicity logo, etc.</p>
          <table class="ui inverted table">
            <thead>
              <tr>
                <th>File</th>
                <th style="text-align:center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $files = scandir("config/uploads/icons/"); foreach($files as $f){ ?>
                <tr>
                  <?php if($f!=="."&&$f!==".."&&$f!=="icons"){
                    $file = explode(".", $f);
                    $ignore = ['php', 'mp3', 'ogg', '3gp'];
                    if(!in_array(end($file), $ignore)){ ?>
                      <td><a href="config/uploads/icons/<?= $f ?>" target="_blank"><?= $f ?></a></td>
                      <td style="text-align:center"><a href="?delete=<?= $f ?>" class="mini ui red button">Delete</a></td>
                    <?php } ?>
                  <?php } ?>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="ui grid stackable">
        <div class="centered eight wide column">
          <h3>Upload</h3>
          <form method="post" class="ui inverted form" enctype="multipart/form-data">
            <div class="ui grid stackable">
              <div class="eight wide column">
                <div class="inverted field">
                  <label>File</label>
                  <input type="file" name="upload">
                </div>
              </div>
              <div class="eight wide column">
                <div class="field">
                  <label>Type</label>
                  <div class="ui selection dropdown">
                    <input name="type" type="hidden" value="0">
                    <i class="dropdown icon"></i>
                    <div class="default text"></div>
                    <div class="menu">
                      <div class="item" data-value="0">Image/Video/Music</div>
                      <div class="item" data-value="1">Logo/Icon</div>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <input type="submit" class="ui button green" value="Upload">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
