<?php
error_reporting(0);




$_REQ = array_merge($_GET, $_POST);




//data

$ns=trim($_REQ["ns"]);
$scode=trim($_REQ["scode"]);
$sname=hex2bin($_REQ["gname"]);

$rvn=trim($_REQ["rvn"]);
$keva=trim($_REQ["keva"]);
$doge=trim($_REQ["doge"]);
$btc=trim($_REQ["btc"]);
$chia=trim($_REQ["chia"]);


$kpc = new Keva();

$checkkey="PLAYER";


$checknew=$kpc->keva_get($ns,$checkkey);


	
if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP") , "unknown")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR") , "unknown")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR") , "unknown")) {
        $ip = getenv("REMOTE_ADDR");
    } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = "unknown";
    }

	
if($checknew['value']!=""){$ipshow=$ip;}
	
	

if(!$scode){$in="";}else{$in=$scode."*".$sname;if(!$keva){$url ="https://keva.app/?rpg".$scode;echo "<script>window.location.href=decodeURIComponent('".$url."')</script>";}}

if(!$scode){$serv="";}else{$serv=$scode."*".$sname."|".$keva."|".$ns."|".$rvn."|".$doge."|".$btc."|".$chia;}

if($checknew['value']==$ipshow){$do=1;}else{$scode="";$in="";$serv="";$ipwarn="Your IP must be ".$checknew['value'];}

class Keva {

    private $proto;

    private $url;
    private $CACertificate;

    public $status;
    public $error;
    public $raw_response;
    public $response;

    private $id = 0;

    public function __construct($url = null) {
		
        $this->username      = 'galaxy'; // RPC Username
        $this->password      = 'frontier'; // RPC Password
		$this->host          = '192.168.152.6'; // Localhost
		//$this->host          = '127.0.0.1'; // Localhost
        $this->port          = '9992';
        $this->url           = $url;

        $this->proto         = 'http';
        $this->CACertificate = null;
    }

    public function setSSL($certificate = null) {
        $this->proto         = 'https';
        $this->CACertificate = $certificate;
    }

    public function __call($method, $params) {
        $this->status       = null;
        $this->error        = null;
        $this->raw_response = null;
        $this->response     = null;

        $params = array_values($params);

        $this->id++;

        $request = json_encode(array(
            'method' => $method,
            'params' => $params,
            'id'     => $this->id
        ));

        $curl    = curl_init("{$this->proto}://{$this->host}:{$this->port}/{$this->url}");
        $options = array(
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_USERPWD        => $this->username . ':' . $this->password,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_HTTPHEADER     => array('Content-type: text/plain'),
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $request
        );

        if (ini_get('open_basedir')) {
            unset($options[CURLOPT_FOLLOWLOCATION]);
        }

        if ($this->proto == 'https') {
            if (!empty($this->CACertificate)) {
                $options[CURLOPT_CAINFO] = $this->CACertificate;
                $options[CURLOPT_CAPATH] = DIRNAME($this->CACertificate);
            } else {
                $options[CURLOPT_SSL_VERIFYPEER] = false;
            }
        }

        curl_setopt_array($curl, $options);

        $this->raw_response = curl_exec($curl);
        $this->response     = json_decode($this->raw_response, true);

        $this->status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $curl_error = curl_error($curl);

        curl_close($curl);

        if (!empty($curl_error)) {
            $this->error = $curl_error;
        }

        if ($this->response['error']) {
            $this->error = $this->response['error']['message'];
        } elseif ($this->status != 200) {
            switch ($this->status) {
                case 400:
                    $this->error = 'HTTP_BAD_REQUEST';
                    break;
                case 401:
                    $this->error = 'HTTP_UNAUTHORIZED';
                    break;
                case 403:
                    $this->error = 'HTTP_FORBIDDEN';
                    break;
                case 404:
                    $this->error = 'HTTP_NOT_FOUND';
                    break;
            }
        }

        if ($this->error) {
			return false;
        }

        return $this->response['result'];
    }
}


?>


<!DOCTYPE html>
<!-- 

 , __                                   __                      
/|/  \                                 /  \                     
 | __/ ,_    __           ,   _   ,_  | __ |          _   , _|_ 
 |   \/  |  /  \_|  |  |_/ \_|/  /  | |/  \|  |   |  |/  / \_|  
 |(__/   |_/\__/  \/ \/   \/ |__/   |_/\__/\_/ \_/|_/|__/ \/ |_/

Mozilla presents an HTML5 mini-MMORPG by Little Workshop http://www.littleworkshop.fr

* Client libraries used: RequireJS, Underscore.js, jQuery, Modernizr
* Server-side: Node.js, Worlize/WebSocket-Node, miksago/node-websocket-server
* Should work in latest versions of Firefox, Chrome, Safari, Opera, Safari Mobile and Firefox for Android

 -->
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width, initial-scale=0.56, maximum-scale=0.56, user-scalable=no">
        <link rel="icon" type="image/png" href="img/common/favicon.png">
        <meta property="og:title" content="Legend of Satoshi">
        <meta property="og:type" content="website">
        <meta property="og:url" content="http://browserquest.mozilla.org/">
        <meta property="og:image" content="http://browserquest.mozilla.org/img/common/promo-title.jpg">
        <meta property="og:site_name" content="Legend of Satoshi">
        <meta property="og:description" content="Play Legend of Satoshi on blockchain">
        <link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="css/achievements.css" type="text/css">
        <script src="js/lib/modernizr.js" type="text/javascript"></script>
        <!--[if lt IE 9]>
                <link rel="stylesheet" href="css/ie.css" type="text/css">
                <script src="js/lib/css3-mediaqueries.js" type="text/javascript"></script>
                <script type="text/javascript">
                document.getElementById('parchment').className = ('error');
                </script>
        <![endif]-->
        <script src="js/detect.js" type="text/javascript"></script>
        <title>Legend of Satoshi</title>
	</head>
    <!--[if lt IE 9]>
	<body class="intro upscaled">
    <![endif]-->



	<body class="intro">
	    <noscript>
	       <div class="alert">
	           You need to enable JavaScript to play Legend of Satoshi.
	       </div>
	    </noscript>
	    <a id="moztab" class="clickable" target="_blank" href="http://www.mozilla.org/"></a>
	    <div id="intro">
	        <h1 id="logo">
	           <span id="logosparks">
	               
	           </span>
	        </h1>
	        <article id="portrait">
	            <p>
	               Please rotate your device to landscape mode
				  
	            </p>

	            <div id="tilt"></div>
				<p>
					Server KVA Donation Address

							62829552

							<a target="_blank" class="clickable" href="https://explorer.kevacoin.org/address/VDoPgLVrLJqDUv14x56CNgptLwJBCB8BPc"><font color=white>VDoPgLVrLJqDUv14x56CNgptLwJBCB8BPc</font></a>

				</p>
				<p>
				<br>RVN Donation Address

							<a target="_blank" class="clickable" href="https://ravencoin.network/address/RBsTqvvXwHzpP8SndUufnSeDmVxkjLioMr"><font color=white>RBsTqvvXwHzpP8SndUufnSeDmVxkjLioMr</font></a>

							</p>

							<p>
				<br>CHIA Donation Address

							<a target="_blank" class="clickable" href="https://www.chiaexplorer.com/blockchain/address/xch1n92we22h9leh9u69ps0uv3frqg2axeah0wcksv4z6qynjlcrgxds59qnag"><font color=white>xch1n92we22h9leh9u69ps0uv3frqg2axeah0wcksv4z6qynjlcrgxds59qnag</font></a>

							</p>


	        </article>
	        <section id="parchment" class="createcharacter">
	            <div class="parchment-left"></div>
	            <div class="parchment-middle">
                    <article id="createcharacter">
          	           <h1>
          	               <span class="left-ornament"></span>
          	               A Blockchain Multiplayer Adventure <?php echo $ip; ?>
          	               <span class="right-ornament"></span>
                         </h1>
                         <div id="character" class="disabled">
                             <div></div>
                         </div>

						 <?php echo $ipwarn; ?>

	 			<!--	

						 SYSTEM <a target="_blank" class="clickable" href="https://keva.app/?62108412"><font color=white>62108412</font></a>
<br><br>
						 Server in Maintenance and Upgrading...サーバーのメンテナンス ...서버 유지 관리 服务器正在升级维护 обслуживание сервера 
						 
                         
	
						 --> 				
						

	

                         <form action="none" method="get" accept-charset="utf-8">
						
						 <input type="text" id="nameinputx" class="stroke" name="player-namex"  value="<?php echo $in; ?>" readonly="readonly">
                             <input type="hidden" id="nameinput" class="stroke" name="player-name"  value="<?php echo $serv; ?>" readonly="readonly">
                         </form>
	 
                         <div class="play button disabled">
                             <div></div>
                             <img src="img/common/spinner.gif" alt="">
                         </div>
                         <div class="ribbon">
                            <div class="top"></div>
                            <div class="bottom"></div>
                         </div>
                    </article>
                    <article id="loadcharacter">
          	           <h1>
          	               <span class="left-ornament"></span>
          	               Load your character
          	               <span class="right-ornament"></span>
                         </h1>
                         <div class="ribbon">
                            <div class="top"></div>
                            <div class="bottom"></div>
                         </div>
                         <img id="playerimage" src="">
                         <div id="playername" class="stroke">
                         </div>
                         <div class="play button">
                             <div></div>
                             <img src="img/common/spinner.gif" alt="">
                         </div>
                         <div id="create-new">
                            <span></span>
                         </div>
                    </article>
                    <article id="confirmation">
          	           <h1>
          	               <span class="left-ornament"></span>
          	               Delete your character?
          	               <span class="right-ornament"></span>
                         </h1>
                         <p>
                             All your items and achievements will be lost.<br>
                             Are you sure you wish to continue?
                         </p>
                         <div class="delete button"></div>
                         <div id="cancel">
                            <span>cancel</span>
                         </div>
                    </article>
    	            <article id="credits">
        	            <h1>
         	               <span class="left-ornament"></span>
         	               <span class="title">
         	                   Made for Mozilla by <a target="_blank" class="stroke clickable" href="http://www.littleworkshop.fr/">Little Workshop</a>
         	               </span>
         	               <span class="right-ornament"></span>
                        </h1>
                        <div id="authors">
                            <div id="guillaume">
                                <div class="avatar"></div>
                                Pixels by
                                <a class="stroke clickable" target="_blank" href="http://twitter.com/glecolliLegend of Satoshi">Guillaume Lecolli Legend of Satoshi</a>
                            </div>
                            <div id="franck">
                                <div class="avatar"></div>
                                Code by
                                <a class="stroke clickable" target="_blank" href="http://twitter.com/whatthefranck">Franck LecolliLegend of Satoshi</a>
                            </div>
                        </div>
                        <div id="seb">
                            
                            <span id="note"></span>
                            Music by <a class="clickable" target="_blank" href="http://soundcloud.com/gyrowolf/sets/gyrowolfs-rpg-maker-music-pack/">Gyrowolf</a>, <a class="clickable" target="_blank" href="http://blog.dayjo.org/?p=335">Dayjo</a>, <a class="clickable" target="_blank" href="http://soundcloud.com/freakified/what-dangers-await-campus-map">Freakified</a>, &amp; <a target="_blank" class="clickable" href="http://www.newgrounds.com/audio/listen/349734">Camoshark</a>
                           
                        </div>
	                    <div id="close-credits">
	                        <span>- click anywhere to close -</span>
                        </div>
    	            </article>
    	            <article id="about">
        	            <h1>
         	               <span class="left-ornament"></span>
         	               <span class="title">
         	                   Legend of Satoshi
         	               </span>
         	               <span class="right-ornament"></span>
                        </h1>
                       <br>
                        <div class="left">
                            
                            <p>
							   /hotkey1 RPGKEY1-9 in space (alt+1~9)<br>
							   /0 like (alt+0)<br>
                               /time days you play<br>
                               /check rvn/doge/btc address (alt+c)<br>
							   /coin address balance link (alt+v)<br>
							   /nft NFTs list link (alt+t)<br>
							   /shop open cat.sale shop (alt+s)<br>
							   /space namespace link<br>
							   /kva server balance (alt+k)<br>
							   /rvn server balance (alt+r)<br>

							   
						
                            </p>

							
                            <span class="link">
                                <span class="ext-link"></span>
                                <a target="_blank" class="clickable" href="https://keva.app/?62108412">Learn more</a> 62108412
                            </span>
                        </div>
                        <div class="right">
                            <div class="img"></div>
                            <p>
							
							Server KVA Donation<br>

							You can follow and reward this namespace <a target="_blank" class="clickable" href="https://keva.app/?62829552">62829552</a> or find more server coins address.

							<a target="_blank" class="clickable" href="https://explorer.kevacoin.org/address/VDoPgLVrLJqDUv14x56CNgptLwJBCB8BPc">KVA</a> <a target="_blank" class="clickable" href="https://ravencoin.network/address/RBsTqvvXwHzpP8SndUufnSeDmVxkjLioMr">RVN</a> <a target="_blank" class="clickable" href="https://blockchair.com/dogecoin/address/DQw9LVhEwnHahSDHgvmAsSzD2uMtkV6HoU">DOGE</a><br>

							62881502 First Step<br>
							62884861 Goblin's Treasure<br>
							62945041 Let's Emoji<br>
							62945384 Hero<br>
							62961741 You have messengers




							</p>
                          <br>
                        </div>
	                    <div id="close-about">
	                        <span>- click anywhere to close -</span>
                        </div>
    	            </article>
    	            <article id="death">
                        <p>You are dead...</p>
    					<div id="respawn" class="button"></div>
    	            </article>
                    <article id="error">
          	           <h1>
          	               <span class="left-ornament"></span>
          	               Your browser cannot run Legend of Satoshi!
          	               <span class="right-ornament"></span>
                         </h1>
                         <p>
                             We're sorry, but your browser does not support WebSockets.<br>
                             In order to play, we recommend using the latest version of Firefox, Chrome or Safari.
                         </p>
                    </article>
	            </div>
	            <div class="parchment-right"></div>
	        </section>
	    </div>
		<div id="container">
		    <div id="canvasborder">
		        <article id="instructions" class="clickable">
		            <div class="close"></div>
		            <h1>
     	               <span class="left-ornament"></span>
     	               How to play
     	               <span class="right-ornament"></span>
	                </h1>
	                <ul>
	                   <li><span class="icon"></span>Left click or tap to move, attack and pick up items.</li>
	                   <li><span class="icon"></span>Press ENTER to chat. Input /afk to keep online</li>

	                   <li><span class="icon"></span>Your character is automatically saved as you play.</li>
	                </ul>
	                    <p>- click anywhere to close -</p>
		        </article>
		        <article id="achievements" class="page1 clickable">
		            <div class="close"></div>
		            <div id="achievements-wrapper">
		                <div id="lists">
        		        </div>
    		        </div>
    		        <div id="achievements-count" class="stroke">
    		            Completed
    		            <div>
    		                <span id="unlocked-achievements">0</span>
    		                /
    		                <span id="total-achievements"></span>
    		            </div> 
    		        </div>
		            <nav class="clickable">
		                <div id="previous"></div>
		                <div id="next"></div>
		            </nav>
		        </article>
    			<div id="canvas">
    				<canvas id="background"></canvas>
    				<canvas id="entities"></canvas>
    				<canvas id="foreground" class="clickable"></canvas>
    			</div>
    			<div id="bubbles">				
    			</div>
    			<div id="achievement-notification">
    			    <div class="coin">
    			        <div id="coinsparks"></div>
    			    </div>
    			    <div id="achievement-info">
        			    <div class="title">New Achievement Unlocked!</div>
        			    <div class="name"></div>
    			    </div>
    			</div>
    			<div id="bar-container">
					<div id="healthbar">
					</div>
					<div id="hitpoints">
					</div>
					<div id="weapon"></div>
					<div id="armor"></div>
					<div id="notifications">
					    <div>
					       <span id="message1"></span>
					       <span id="message2"></span>
					    </div>
					</div>
                    <div id="playercount" class="clickable">
                        <span class="count">0</span> <span>players</span>
                    </div>
                    <div id="barbuttons">
                        <div id="chatbutton" class="barbutton clickable"></div>
                        <div id="achievementsbutton" class="barbutton clickable"></div>
                        <div id="helpbutton" class="barbutton clickable"></div>
                        <div id="mutebutton" class="barbutton clickable active"></div>
                    </div>
    			</div>
				<div id="chatbox">
				    <form action="none" method="get" accept-charset="utf-8">
					    <input id="chatinput" class="gp" type="text" maxlength="60">
				    </form>
				</div>
                <div id="population">
                    <div id="instance-population" class="">
                        <span>0</span> <span>players</span> in your instance
                    </div>
                    <div id="world-population" class="">
                        <span>0</span> <span>players</span> total
                    </div>
                </div>
		    </div>
		</div>
		<footer>
		    <div id="sharing" class="clickable">
		        
          
              KEVACOIN & RAVENCOIN 


		    </div>
		    <div id="credits-link" class="clickable">
		      – <span id="toggle-credits">Credits</span>
		    </div>
		</footer>
		
		<ul id="page-tmpl" class="clickable" style="display:none">
        </ul>
        <ul>
            <li id="achievement-tmpl" style="display:none">
                <div class="coin"></div>
                <span class="achievement-name">???</span>
                <span class="achievement-description">???</span>
                <div class="achievement-sharing">
                  <a href="" class="twitter"></a>
                </div>
            </li>
        </ul>
        
        <img src="img/common/thingy.png" alt="" class="preload">
        
        <div id="resize-check"></div>
		
        <script type="text/javascript">
            var ctx = document.querySelector('canvas').getContext('2d'),
                parchment = document.getElementById("parchment");
            
            if(!Detect.supportsWebSocket()) {
                parchment.className = "error";
            }
            
            if(ctx.mozImageSmoothingEnabled === undefined) {
                document.querySelector('body').className += ' upscaled';
            }
            
            if(!Modernizr.localstorage) {
                var alert = document.createElement("div");
                    alert.className = 'alert';
                    alertMsg = document.createTextNode("You need to enable cookies/localStorage to play Legend of Satoshi");
                    alert.appendChild(alertMsg);

                target = document.getElementById("intro");
                document.body.insertBefore(alert, target);
            } 
        </script>
        
        <script src="js/lib/log.js"></script>
        <script>
                var require = { waitSeconds: 60 };
function click (){
							document.getElementById('respawn').click();
							
							}
        </script>
        <script data-main="js/home" src="js/lib/require-jquery.js"></script>
	</body>
</html>
