<?php
  $c = new Config();
  $server = $this->json['servers'][$_GET['server'] - 1];
  $config = $c->config;
  $theme = $config['themes'][$config['theme']];
?>
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
            <?php foreach($c->json['servers'] as $k => $v){ ?>
              <a href="./?server=<?= $k+1 ?>" class="item"><?= $v[0] ?></a>
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
      <?php if(!isset($config['theme'])){ die("<h1>Please save your main <a href='./'>alpha settings</a>.</h1>"); } ?>
      <h1 class="ui inverted header"><?= $server[0] ?> settings <span class="floated right"><div class="button"><a class="bordered succ" href="./?steamid=<?= $c->json['staff'][0] ?>&server=<?= $_GET['server'] ?>"><span>View</span></a></div></span></h1>
      <p class="ui inverted subheader"><code>sv_loadingurl &quot;<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>&steamid=%s&quot;</code></p>
      <div class="ui inverted divider"></div>
      <form method="post" class="ui inverted form">
        <div class="ui grid stackable">
          <!-- start general settings -->
          <div class="eight wide column">
            <h3>General settings</h3>
            <div class="field">
              <label>Theme</label>
              <div class="ui selection dropdown">
                <input name="theme" type="hidden" value="<?= $config['theme'] ?>">
                <i class="dropdown icon"></i>
                <div class="default text"></div>
                <div class="menu">
                  <div class="item" data-value="0">CS:GO</div>
                  <div class="item" data-value="1">Space</div>
                  <div class="item" data-value="2">Simplicity</div>
                </div>
              </div>
            </div>
            <div class="ui inverted horizontal divider">Background</div>
            <h4>You can have multiple backgrounds enabled.</h4>
            <p>They will appear in the order they're enabled in.</p>
            <div class="ui grid stackable">
              <div class="row">
                <div class="four wide column">
                  <div class="inline field">
                    <div class="ui toggle checkbox">
                      <input tabindex="0" class="hidden" <?= ($config['background']['pattern']?'checked':'') ?> name="background[pattern]" type="checkbox">
                      <label>Pattern</label>
                    </div>
                  </div>
                </div>
                <div class="three wide column">
                  <img class="pattern" style="opacity:<?= $config['background']['alpha'][2]/100 ?>" src="assets/img/pattern<?= (intval($config['background']['image']) + 1) ?>.png">
                </div>
                <div class="five wide column">
                  <div class="field">
                    <label>Pattern image</label>
                    <div class="ui fluid selection dropdown">
                        <input name="background[image]" type="hidden" value="<?= $config['background']['image'] ?>">
                        <i class="dropdown icon"></i>
                        <div class="default text"></div>
                        <div class="menu">
                            <div class="item" data-value="0">pattern1.png</div>
                            <div class="item" data-value="1">pattern2.png</div>
                            <div class="item" data-value="2">pattern3.png</div>
                            <div class="item" data-value="3">pattern4.png</div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="right floated four wide column">
                  <div class="field">
                    <label>Opacity <small class="floated right">0 - 100</small></label>
                    <input type="text" name="background[alpha][2]" value="<?= $config['background']['alpha'][2] ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="eight wide column">
                  <div class="inline field">
                    <div class="ui inverted toggle checkbox">
                      <input tabindex="0" name="background[video]" class="hidden" <?= ($config['background']['video']?'checked':'') ?> type="checkbox">
                      <label>Video background</label>
                    </div>
                  </div>
                </div>
                <div class="right floated four wide column">
                  <div class="field">
                    <label>Opacity <small class="floated right">0 - 100</small></label>
                    <input type="text" name="background[alpha][0]" value="<?= $config['background']['alpha'][0] ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="six wide column">
                  <div class="inline field">
                    <div class="ui inverted toggle checkbox">
                      <input tabindex="0" name="background[slideshow]" <?= ($config['background']['slideshow']?'checked':'') ?> class="hidden" type="checkbox">
                      <label>Image slideshow</label>
                    </div>
                  </div>
                </div>
                <div class="four wide column">
                  <div class="inline field">
                    <div class="ui inverted toggle checkbox">
                      <input tabindex="0" name="background[randomize]" <?= (!isset($config['background']['randomize'])||$config['background']['randomize']?'checked':'') ?> class="hidden" type="checkbox">
                      <label>Randomize</label>
                    </div>
                  </div>
                </div>
                <div class="three wide column">
                  <div class="field">
                    <label>Delay <small class="floated right">ms</small></label>
                    <input type="text" name="background[delay]" value="<?= $config['background']['delay'] ?>">
                  </div>
                </div>
                <div class="three wide column">
                  <div class="field">
                    <label>Opacity</label>
                    <input type="text" name="background[alpha][1]" placeholder="0 - 100" value="<?= $config['background']['alpha'][1] ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="eight wide column">
                  <div class="inline field">
                    <div class="ui inverted toggle checkbox">
                      <input tabindex="0" class="hidden" name="background[solid]" <?= ($config['background']['solid']?'checked':'') ?> type="checkbox">
                      <label>Solid background</label>
                    </div>
                  </div>
                </div>
                <div class="right floated four wide column">
                  <div class="field">
                    <label>Color</label>
                    <input type="text" name="background[color]" value="<?= $config['background']['color'] ?>">
                  </div>
                </div>
                <div class="right floated four wide column">
                  <center>
                    <div class="colorBlock" style="background: <?= $config['background']['color'] ?>"></div>
                  </center>
                </div>
              </div>
            </div>
            <div class="ui inverted horizontal divider">Music</div>
            <div class="ui grid stackable">
              <div class="row">
                <div class="four wide column">
                  <div class="inline field">
                    <div class="ui inverted toggle checkbox">
                      <input tabindex="0" class="hidden" name="music[enabled]" <?= ($config['music']['enabled']?'checked':'') ?> type="checkbox">
                      <label>Enabled</label>
                    </div>
                  </div>
                </div>
                <div class="eight wide column">
                  <div class="field">
                    <label>Type</label>
                    <div class="ui fluid selection dropdown">
                      <input name="music[type]" type="hidden" value="<?= $config['music']['type'] ?>">
                      <i class="dropdown icon"></i>
                      <div class="default text"></div>
                      <div class="menu">
                        <div class="item" data-value="0">Loop through uploads</div>
                        <div class="item" data-value="1">YouTube link</div>
                        <div class="item" data-value="2">YouTube playlist</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="four wide column">
                  <div class="field">
                    <label>Volume <small class="floated right">0 - 100</small></label>
                    <input type="text" name="music[volume]" value="<?= $config['music']['volume'] ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="four wide column">
                  <div class="inline field">
                    <div class="ui inverted toggle checkbox">
                      <input tabindex="0" class="hidden" name="music[randomize]" <?= (!isset($config['music']['randomize'])||$config['music']['randomize']?'checked':'') ?> type="checkbox">
                      <label>Randomize</label>
                    </div>
                  </div>
                </div>
                <div class="six wide column">
                  <div class="field">
                    <label>YouTube video link</label>
                    <input type="text" name="music[youtube]" value="<?= $config['music']['youtube'] ?>">
                  </div>
                </div>
                <div class="six wide column">
                  <div class="field">
                    <label>YouTube playlist link</label>
                    <input type="text" name="music[playlist]" value="<?= $config['music']['playlist'] ?>">
                  </div>
                </div>
              </div>
            </div>
            <br/>
            <p>In order to randomize your playlist from the start, add these two videos to the beginning of your playlist: <a href="https://www.youtube.com/watch?v=Vbks4abvLEw" target="_blank">first video.</a> <a href="https://www.youtube.com/watch?v=jhFDyDgMVUI" target="_blank">second video.</a><br/>&sdot; Use this to bypass YouTube's shitty api and randomize your playlist from the beginning.</p>

          </div>
          <!-- theme specific settings -->
          <div class="eight wide column">
            <h3><?= (!$config['theme']?"CS:GO":($config['theme']==1?"Space":($config['theme']==2?"Simplicity":"Unknown theme"))) ?> settings</h3>
            <?php if(!$config['theme']){ ?>
              <div class="ui inverted horizontal divider">top section</div>
              <div class="ui grid stackable">
                <div class="four wide column">
                  <div class="field">
                    <label>Icon</label>
                    <input type="text" name="themes[0][0][icon]" value="<?= $theme[0]['icon'] ?>">
                  </div>
                  <p><small>You can change this to an <a href="./">uploaded icon</a>.<br/>Ex: logo.png</small></p>
                </div>
                <div class="twelve wide column">
                  <div class="field">
                    <label>Hints <small class="floated right">Separate by a new line</small></label>
                    <textarea name="themes[0][0][hints]"><?= $theme[0]['hints'] ?></textarea>
                  </div>
                </div>
              </div>
              <div class="ui inverted horizontal divider">mid section</div>
              <div class="ui grid stackable">
                <div class="row">
                  <div class="eight wide column">
                    <div class="field">
                      <label>Main title</label>
                      <input type="text" name="themes[0][1][title]" value="<?= $theme[1]['title'] ?>">
                    </div>
                  </div>
                  <div class="eight wide column">
                    <div class="field">
                      <label>Sub title</label>
                      <input type="text" name="themes[0][1][subtitle]" value="<?= $theme[1]['subtitle'] ?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="sixteen wide column">
                    <div class="field">
                      <label>Map type</label>
                      <div class="ui selection dropdown">
                        <input name="themes[0][1][map]" type="hidden" value="<?= $theme[1]['map'] ?>">
                        <i class="dropdown icon"></i>
                        <div class="default text"></div>
                        <div class="menu">
                          <div class="item" data-value="0">Gametracker map</div>
                          <div class="ui divider"></div>
                          <div class="item" data-value="1">cache</div>
                          <div class="item" data-value="2">cobblestone</div>
                          <div class="item" data-value="3">dust2</div>
                          <div class="item" data-value="4">inferno</div>
                          <div class="item" data-value="5">mirage</div>
                          <div class="item" data-value="6">nuke</div>
                          <div class="item" data-value="7">overpass</div>
                          <div class="ui divider"></div>
                          <div class="item" data-value="8">Custom map image</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="eight wide column">
                        <div class="field">
                            <label>Custom map icon</label>
                            <input type="text" name="themes[0][1][custom]" value="<?= $theme[1]['custom'] ?>">
                        </div>
                    </div>
                  <div class="eight wide column">
                    <div class="field">
                      <label>Icon <small class="floated right">Blank = auto csgo icon</small></label>
                      <input type="text" name="themes[0][1][icon]" value="<?= $theme[1]['icon'] ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="ui inverted horizontal divider">bottom section</div>
              <div class="ui grid stackable">
                <div class="six wide column">
                  <div class="inline field">
                    <div class="ui toggle checkbox">
                      <input type="checkbox" name="themes[0][2][loading]" <?= ($theme[2]['loading']?'checked':'') ?>>
                      <label>Loading bar</label>
                    </div>
                  </div>
                  <div class="field" style="margin-top:40px">
                    <label>Color <span class="floated right loadingbar" style="background-color:<?= $theme[2]['color'] ?>"></span></label>
                    <input type="text" name="themes[0][2][color]" value="<?= $theme[2]['color'] ?>">
                  </div>
                </div>
                <div class="ten wide column">
                  <div class="field">
                    <label>Description <small class="floated right">Markdown supported</small></label>
                    <textarea name="themes[0][2][data]" rows="8" cols="80"><?= $theme[2]['data'] ?></textarea>
                  </div>
                </div>
              </div>
            <?php } ?>
            <?php if($config['theme']==1){ ?>
              <div class="ui inverted horizontal divider">top</div>
              <div class="ui grid stackable">
                <div class="six wide column">
                  <div class="inline field">
                    <div class="ui inverted toggle checkbox">
                      <input tabindex="0" class="hidden" name="themes[1][0][circular]" <?= ($theme[0]['circular']?'checked':'') ?> type="checkbox">
                      <label>Circular avatar</label>
                    </div>
                  </div>
                </div>
                <div class="six wide column">
                  <div class="field">
                    <label>Welcome msg</label>
                    <input type="text" name="themes[1][0][text]" value="<?= $theme[0]['text'] ?>">
                  </div>
                </div>
                <div class="four wide column">
                  <div class="field">
                    <label>Font size</label>
                    <input type="text" name="themes[1][0][size]" value="<?= $theme[0]['size'] ?>">
                  </div>
                </div>
              </div>
              <div class="ui grid stackable">
                <div class="ui inverted horizontal divider">left box</div>
                <div class="row">
                  <div class="four wide column">
                    <div class="field">
                      <label>Title</label>
                      <input type="text" name="themes[1][1][title]" value="<?= $theme[1]['title'] ?>">
                    </div>
                    <div class="field">
                      <label>Align</label>
                      <div class="ui fluid selection dropdown">
                        <input name="themes[1][1][align]" type="hidden" value="<?= $theme[1]['align'] ?>">
                        <i class="dropdown icon"></i>
                        <div class="default text"></div>
                        <div class="menu">
                          <div class="item" data-value="0">Left align</div>
                          <div class="item" data-value="1">Center align</div>
                          <div class="item" data-value="2">Right align</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="twelve wide column">
                    <div class="field">
                      <label>Data</label>
                      <textarea name="themes[1][1][data]"><?= $theme[1]['data'] ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="ui grid stackable">
                <div class="ui inverted horizontal divider">middle box</div>
                <div class="row">
                  <div class="four wide column">
                    <div class="field">
                      <label>Title</label>
                      <input type="text" name="themes[1][2][title]" value="<?= $theme[2]['title'] ?>">
                    </div>
                    <div class="field">
                      <label>Align</label>
                      <div class="ui fluid selection dropdown">
                        <input name="themes[1][2][align]" type="hidden" value="<?= $theme[2]['align'] ?>">
                        <i class="dropdown icon"></i>
                        <div class="default text"></div>
                        <div class="menu">
                          <div class="item" data-value="0">Left align</div>
                          <div class="item" data-value="1">Center align</div>
                          <div class="item" data-value="2">Right align</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="twelve wide column">
                    <div class="field">
                      <label>Data</label>
                      <textarea name="themes[1][2][data]"><?= $theme[2]['data'] ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="six wide column">
                    <div class="inline field">
                      <div class="ui inverted toggle checkbox" style="top:0">
                        <input tabindex="0" class="hidden" name="themes[1][2][count]" <?= ($theme[2]['count']?'checked':'') ?> type="checkbox">
                        <label>Player count</label>
                      </div>
                    </div>
                  </div>
                  <div class="eight wide column">
                    <div class="field">
                      <p><small>This will enable a source query to your server retrieving its live player count.</small></p>
                      <p><b>Current players:</b> <span class="players">Loading...</span></p>
                      <p><small>If you don't see a player count above, then this features is either not compatible with your server or you have inputted the wrong ip:port address.</small></p>
                      <script type="text/javascript">
                        $(document).ready(function(){$('.players').load("./?pcount&ip=<?= $config['ip'] ?>&port=<?= $config['port'] ?>")});
                      </script>
                    </div>
                  </div>
                </div>
              </div>
              <div class="ui grid stackable">
                <div class="ui inverted horizontal divider">right box</div>
                <div class="row">
                  <div class="four wide column">
                    <div class="field">
                      <label>Title</label>
                      <input type="text" name="themes[1][3][title]" value="<?= $theme[3]['title'] ?>">
                    </div>
                    <div class="field">
                      <label>Align</label>
                      <div class="ui fluid selection dropdown">
                        <input name="themes[1][3][align]" type="hidden" value="<?= $theme[3]['align'] ?>">
                        <i class="dropdown icon"></i>
                        <div class="default text"></div>
                        <div class="menu">
                          <div class="item" data-value="0">Left align</div>
                          <div class="item" data-value="1">Center align</div>
                          <div class="item" data-value="2">Right align</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="twelve wide column">
                    <div class="field">
                      <label>Data</label>
                      <textarea name="themes[1][3][data]"><?= $theme[3]['data'] ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="ui grid stackable">
                <div class="ui inverted horizontal divider">bottom</div>
                <div class="row">
                  <div class="four wide column">
                    <div class="field">
                      <label>Color</label>
                      <input type="text" name="themes[1][4][color]" value="<?= $theme[4]['color'] ?>">
                    </div>
                    <div class="field">
                      <label>Opacity</label>
                      <input type="text" name="themes[1][4][opacity]" value="<?= $theme[4]['opacity'] ?>">
                    </div>
                  </div>
                  <div class="twelve wide column">
                    <div class="field">
                      <label>Quotes <small class="floated right">Separate each by a new line</small></label>
                      <textarea name="themes[1][4][quotes]"><?= $theme[4]['quotes'] ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
            <?php if($config['theme']==2){ ?>
              <div class="ui inverted horizontal divider">design</div>
              <div class="ui grid stackable">
                <!-- <div class="six wide column">
                  <div class="inline field">
                    <div class="ui toggle checkbox">
                      <input type="checkbox" name="themes[2][0][border]" <?= ($theme[0]['border']?'checked':'') ?>>
                      <label>Corner borders</label>
                    </div>
                  </div>
                </div> -->
                <div class="eight wide column">
                  <div class="field">
                    <label>Background color</label>
                    <input type="text" name="themes[2][0][background]" value="<?= $theme[0]['background'] ?>">
                  </div>
                </div>
                <div class="eight wide column">
                  <div class="field">
                    <label>Opacity</label>
                    <input type="text" name="themes[2][0][opacity]" value="<?= $theme[0]['opacity'] ?>">
                  </div>
                </div>
              </div>
              <div class="ui inverted horizontal divider">top left box</div>
              <div class="ui grid stackable">
                <div class="eight wide column">
                  <div class="field">
                    <label>Welcome</label>
                    <input type="text" name="themes[2][1][title]" value="<?= $theme[1]['title'] ?>">
                  </div>
                </div>
                <div class="eight wide column">
                  <div class="field">
                    <label>Align</label>
                    <div class="ui fluid selection dropdown">
                      <input name="themes[2][1][align]" type="hidden" value="<?= $theme[1]['align'] ?>">
                      <i class="dropdown icon"></i>
                      <div class="default text"></div>
                      <div class="menu">
                        <div class="item" data-value="0">Left align</div>
                        <div class="item" data-value="1">Center align</div>
                        <div class="item" data-value="2">Right align</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="ui inverted horizontal divider">bottom left box</div>
              <div class="ui grid stackable">
                <div class="four wide column">
                  <div class="field">
                    <label>Title</label>
                    <input type="text" name="themes[2][2][title]" value="<?= $theme[2]['title'] ?>">
                  </div>
                </div>
                <div class="twelve wide column">
                  <div class="field">
                    <label>Content</label>
                    <textarea name="themes[2][2][data]"><?= $theme[2]['data'] ?></textarea>
                  </div>
                </div>
              </div>
              <div class="ui inverted horizontal divider">center icon</div>
              <div class="field">
                <label>Center Logo/Icon <small class="floated right">Uploaded to the <a href="./">icons section</a></small></label>
                <input type="text" name="themes[2][3][logo]" value="<?= $theme[3]['logo'] ?>">
              </div>
              <div class="ui inverted horizontal divider">top right box</div>
              <div class="ui grid stackable">
                <div class="six wide column">
                  <div class="field">
                    <label>Map type</label>
                    <div class="ui fluid selection dropdown">
                      <input name="themes[2][4][map]" type="hidden" value="<?= $theme[4]['map'] ?>">
                      <i class="dropdown icon"></i>
                      <div class="default text"></div>
                      <div class="menu">
                        <div class="item" data-value="0">Gametracker map</div>
                        <div class="item" data-value="1">Custom map icon</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="five wide column">
                  <div class="field">
                    <label>Custom map icon</label>
                    <input type="text" name="themes[2][4][custom]" value="<?= $theme[4]['custom'] ?>">
                  </div>
                </div>
                <div class="five wide column">
                  <div class="field">
                    <label>Server info</label>
                    <div class="ui fluid selection dropdown">
                      <input name="themes[2][4][type]" type="hidden" value="<?= $theme[4]['type'] ?>">
                      <i class="dropdown icon"></i>
                      <div class="default text"></div>
                      <div class="menu">
                        <div class="item" data-value="0">Gamemode, mapname</div>
                        <div class="item" data-value="1">Player count, gamemode, mapname</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="ui inverted horizontal divider">bottom right box</div>
              <div class="ui grid stackable">
                <div class="four wide column">
                  <div class="field">
                    <label>Title</label>
                    <input type="text" name="themes[2][5][title]" value="<?= $theme[5]['title'] ?>">
                  </div>
                </div>
                <div class="twelve wide column">
                  <div class="field">
                    <label>Content</label>
                    <textarea name="themes[2][5][data]"><?= $theme[5]['data'] ?></textarea>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <br/><br/>
        <div class="floated right field">
          <input type="submit" value="Save" class="ui green save button">
        </div>
      </form>
      <div class="ui inverted divider" style="margin-top:60px"></div>

    </div>
  </body>
</html>
