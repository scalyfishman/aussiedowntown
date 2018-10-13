<?php

class Config extends Views {

  public $json;

  public $config;

  function __construct(){
    $this->json = json_decode(file_get_contents(__DIR__."/../../config/main.json"), true);

    if(isset($_POST['changelog']))
      $this->save();

    if(isset($_GET['server']))
      $this->config = $this->get($_GET['server']);
  }

  public function panel(){
    if(isset($_GET['server'])){
      if(isset($_POST['theme']))
        $this->save($_POST);
      else
        $this->view("server");
    } else {
      if(isset($_FILES["upload"]))
        $this->upload();
      else
        $this->view("admin");
    }
  }

  public function save($post = 0){

    if(isset($_POST['servers']) && !$post){
      $file = fopen(__DIR__."/../../config/main.json", "w");
      $servers = explode("\r\n", trim($_POST['servers']));
      $staff = explode("\r\n", trim($_POST['staff']));
      $temp = [];
      for($i=0;$i<2;$i++){
        foreach((!$i?$servers:$staff) as $s){
          if(!$i){
            $server = explode('-', $s);
            $temp[0][] = [$server[0], $server[1]];
            if(!file_exists(__DIR__."/../../config/".$server[1].".json"))
              $this->create($server[1]);
          } else
            $temp[1][] = $s;
        }
      }
      $data = [
        // 'community' => $_POST['community'],
        'changelog' => $_POST['changelog'],
        'servers' => $temp[0],
        'staff' => $temp[1]
      ];
      $data = json_encode($data, JSON_PRETTY_PRINT);

      fwrite($file, $data);
      fclose($file);
      header('Location: ./');
    } else {

      // replace general checkboxes with true/false
      $checkboxes = [
        'background' => [
          'solid', 'video', 'slideshow', 'pattern', 'randomize'
        ],
        'music' => [
          'enabled', 'randomize'
        ]
      ];
      foreach($checkboxes as $key => $val){
        foreach($val as $c){
          $_POST[$key][$c] = (isset($_POST[$key][$c])?1:0);
        }
      }
      // replace theme checkboxes manually because it's 3 am and ill make a loop later.
      if(isset($_POST['themes'][0])){
        $_POST['themes'][0][1]['gametracker'] = (isset($_POST['themes'][0][1]['gametracker'])?1:0);
        $_POST['themes'][0][2]['loading'] = (isset($_POST['themes'][0][1]['gametracker'])?1:0);
      }
      if(isset($_POST['themes'][1])){
        $_POST['themes'][1][0]['circular'] = (isset($_POST['themes'][1][0]['circular'])?1:0);
        $_POST['themes'][1][2]['count'] = (isset($_POST['themes'][1][2]['count'])?1:0);
      }
      if(isset($_POST['themes'][2])){
        $_POST['themes'][2][0]['border'] = (isset($_POST['themes'][2][0]['border'])?1:0);
      }
      $replacement = array_replace_recursive($this->config, $_POST);
      $file = fopen(__DIR__."/../../config/".$replacement['ip'].":".$replacement['port'].".json", "w");
      // delete redundant shit AFTER we open the damn file
      unset($replacement['steamid'], $replacement['avatar'], $replacement['username'], $replacement['ip'], $replacement['port']);

      $encoded = json_encode($replacement, JSON_PRETTY_PRINT);
      fwrite($file, $encoded);
      fclose($file);

      header('Location: ./?server='.$_GET['server']);

    }

  }

  public function create($name){
    $defaults = [
      'theme' => 2,
      'background' => [
        'solid' => true,
        'color' => "#000",
        'video' => false,
        'slideshow' => true,
        'randomize' => true,
        'delay' => 6000,
        'pattern' => true,
        'image' => 2,
        'alpha' => [
          // video alpha
          "100",
          // image alpha
          "40",
          // pattern alpha
          "80"
        ]
      ],
      'music' => [
        'enabled' => true,
        'randomize' => true,
        'type' => 2,
        'volume' => "30",
        'youtube' => "https://www.youtube.com/watch?v=QmSnWyTkTAs",
        'playlist' => "https://www.youtube.com/watch?v=XaWb3KuEURg&list=PL3mfssteAbYoK_cwTNFBpaRQwdprPh2QL"
      ],
      'themes' => [
        // csgo
        [
          [
            'icon' => "hint.png",
            'hints' => "Turning away from a Flashbang Grenade with lessen its effects on you\nThis is Garry's Mod though...\nWhatever.\nCheck out our forums located at: killme.com/forums\nAAAUUUGHGHGH THERE'S A SPIDER IN MY COMPUTER\nUnlimited hints you can configure!"
          ],
          [
            'title' => "Dust II",
            'subtitle' => "Deathmatch",
            'map' => 3,
            'custom' => "",
            'icon' => ""
          ],
          [
            'data' => "All weapons are free and selectable for a time after spawning.\n\nWin the match by having the highest score when the round time ends.\n\nSettings:\n\n- Instant random respawn\n- Friendly fire is OFF\n- Team collision is OFF\n- 10 minute match length",
            'loading' => true,
            'color' => "#D33434"
          ]
        ],
        // space
        [
          // top
          [
            'circular' => true,
            'text' => "Welcome back ",
            'size' => "32pt"
          ],
          // left
          [
            'title' => "Donor Info",
            'align' => 0,
            'data' => "$5 Donor\n- a player model\r\n- 1000 ps points\r\n- extra stuff\r\n\r\n$10 VIP\r\n- 2 player models\r\n- 50,000 ps points\r\n- unrestricted porn\r\n\r\n$25 God\r\n- inifinite bitches\r\n- zeus bows to you\r\n- make people explode"
          ],
          // mid
          [
            'title' => "Server Title",
            'align' => 1,
            'data' => "## Welcome to the server\r\nWe hope that you have a blast!\r\nThe download shouldn't be too long,\r\nso sit back, listen to this glorious music, and drool over our orgasmic visuals.",
            'count' => true
          ],
          // right
          [
            'title' => "Rules",
            'align' => 0,
            'data' => "1. Do not RDM\r\n1. now kill me\r\n1. no seriously do it\r\n1. gj idiot now you're banned."
          ],
          // bottom
          [
            'color' => '#00ff21',
            'opacity' => '30',
            'quotes' => "Welcome to our server!\nDid you know garry is actually a woman?\nHelp my family is being held hostage by a weeb named Nookyava\nOur server is better than yours\nWhat else can we sperg into this section?"
          ],
        ],
        // simplicity
        [
          [
            'background' => '147, 194, 236',
            'opacity' => '40'
          ],
          [
            'title' => 'Welcome back,',
            'align' => 1
          ],
          [
            'title' => 'About Us',
            'data' => "Our server is better than yours.\n\nWe lather our staff members with coats of vaseline before putting them to work.\n\nCheck out our website http://SuperiorServers.co.\n\nWhat else... Here's a cat.\n\n![](https://i.atomik.info/d626ad.png)"
          ],
          [
            'logo' => 'sup.png'
          ],
          [
            'map' => 1,
            'custom' => "sup2.png",
            'type' => 1
          ],
          [
            'title' => 'Rules',
            'data' => "1. (Hello, Nickelodeon headquarters\n1. Hi, sorry to disturb you this late in the night\n1. I have a serious inquiry directed toward Nickelodeon\n1. My question is WHAT THE FUCK ARE YOU DOING\n1. You know y'all used to have some fire bitches\n1. When I turn on the TV I'm trying to see my favorite bitches\n1. Zoey101? Jennette McCurdy? Oh my God\n1. And now all you got is these preteens\n1. Bruh, I'm not a pedo\n1. I'm not trying to look at these little kids and get aroused"
          ]
        ]
      ]
    ];
    $encoded = json_encode($defaults, JSON_PRETTY_PRINT);
    $new = fopen(__DIR__."/../../config/".$name.".json", "w");
    fwrite($new, $encoded);
    fclose($new);
  }

  public function get($server){
    $get = $this->json['servers'][$server - 1][1];
    $sdata = explode(':',$get);
    $data = json_decode(file_get_contents(__DIR__."/../../config/".$get.".json"), true);
    $data['steamid'] = strval($_GET['steamid']);
      $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://steamcommunity.com/profiles/".$data['steamid']."?xml=1");
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
      $response = curl_exec($ch);
      $xml = simplexml_load_string($response);
    $data['avatar'] = strval($xml->avatarMedium);
    $data['username'] = strval($xml->steamID);
    $data['ip'] = $sdata[0];
    $data['port'] = $sdata[1];
    return $data;
  }

  public function delete($file){
    if(file_exists(__DIR__."/../../config/uploads/".$file))
      unlink(__DIR__."/../../config/uploads/".$file);
    else
      unlink(__DIR__."/../../config/uploads/icons/".$file);
    header('Location: ./');
  }

  public function upload(){
    if(!$_POST['type']){
      if (move_uploaded_file($_FILES["upload"]["tmp_name"], __DIR__."/../../config/uploads/".basename($_FILES["upload"]["name"])))
        header('Location: ./');
    } else {
      if (move_uploaded_file($_FILES["upload"]["tmp_name"], __DIR__."/../../config/uploads/icons/".basename($_FILES["upload"]["name"])))
        header('Location: ./');
    }
    die("Error during upload!<br/>Make sure your webserver's upload_max_filesize is set higher than the file you're attempting to upload!");
  }

}
