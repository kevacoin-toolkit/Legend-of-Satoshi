<?php 
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Server\Messages;

use Server\Utils;



class Chat
{
    public $playerId = 0;
    public $message = null;
    public function __construct($player, $message)

    {

			$kname=$player->name;

				
			$commtool=explode('|', $kname);

			$getnum=explode('*', $commtool[0]);

			
		$rpc = new Raven();
		$kpc = new Keva();
		$dpc = new Doge();
		

			 //rpgkey

	 			if(substr($message,0,7)=="/rpgkey")
			{


			$rpgkey=strtoupper(substr($message,1,8));

			$rpgtext=$kpc->keva_get($commtool[2],$rpgkey);

			$giftasset=$rpc->listassetbalancesbyaddress($commtool[3]);

			$gifttag=$rpc->listtagsforaddress($commtool[3]);

			$message=$rpgtext['value'];


		

			if(array_key_exists($rpgtext['value'],$giftasset))
				{

				$listinfo = $rpc->getassetdata($rpgtext['value']);
			
					$message="<a href=\"https://ravencoin.asset-explorer.net/ipfs/".$listinfo["ipfs_hash"]."\"><img src=https://ravencoin.asset-explorer.net/ipfs/".$listinfo["ipfs_hash"]." width=50></a>";
				}

			if(in_array($rpgtext['value'],$gifttag))
				{

				$listinfo = $rpc->getassetdata($rpgtext['value']);
			
					$message="<a href=\"https://ravencoin.asset-explorer.net/ipfs/".$listinfo["ipfs_hash"]."\"><img src=https://ravencoin.asset-explorer.net/ipfs/".$listinfo["ipfs_hash"]." width=50></a>";
				}

				

			
				if(in_array($rpgtext['value'],$gifttag))
				{

				$listinfo = $rpc->getassetdata($rpgtext['value']);
			
					$message="<a href=\"https://ravencoin.asset-explorer.net/ipfs/".$listinfo["ipfs_hash"]."\"><img src=https://ravencoin.asset-explorer.net/ipfs/".$listinfo["ipfs_hash"]." width=50></a>";
				}
			
			if(is_numeric($rpgtext['value']))

				{
				
				if($rpgtext['value']=="62881502"){
				
				$rpgnft=$kpc->keva_get("NUtVW7Psz2GcjhYCeWTUY6sD1pMyyioHk7",$getnum[0]);}

				if($rpgtext['value']=="62884861"){
				
				$rpgnft=$kpc->keva_get("NLbbLeVppyVEMKd5LocLSXEdjaDReaq87z",$getnum[0]);}

				if($rpgnft['value'] !=""){
					
					$rpgimg="KEVA.APP/RPG#".$rpgtext['value'];

					$listinfo = $rpc->getassetdata($rpgimg);
					
					$message="<a href=\"https://ravencoin.asset-explorer.net/ipfs/".$listinfo["ipfs_hash"]."\"><img src=https://ravencoin.asset-explorer.net/ipfs/".$listinfo["ipfs_hash"]." width=50></a>"; }
				

				}
			

			}


		//emoji

		if($message=="/0"){$message="<img src=img/emoji/0.gif width=27>";}

		//time

		
		if($message=="/time")
			
			{
				$timeblock=$kpc->keva_get("NUtVW7Psz2GcjhYCeWTUY6sD1pMyyioHk7",$getnum[0]);
				$timebt=$kpc->getblockheaderbyheight($timeblock["height"]);
				$timepass=intval((time()-$timebt["block_header"]["timestamp"])/86400);
				$message=$timepass." DAYS";
				
			}

		//check

	
		

		if($message=="/check")
			{

					$kname=$player->name;

				
					$commtool=explode('|', $kname);

					
					if(!$commtool[3]){$message="<font color=red>RAVENCOIN</font>";}else{$message="<font color=chartreuse>RAVENCOIN</font>";}	
					if(!$commtool[4]){$message=$message." <font color=red>DOGECOIN </font>";}else{$message=$message." <font color=chartreuse>DOGECOIN</font>";}	
					if(!$commtool[5]){$message=$message." <font color=red>BITCOIN</font>";}else{$message=$message." <font color=chartreuse>BITCOIN</font>";}

					$message=$message." <a href=https://keva.app/?5322812 target=_blank>[ + ]</a>";
			
			}

		//balance


		if($message=="/kva" or $message=="/keva")
			{
			$message=$kpc->getbalance("");
			$message=$message." KVA in the world";
			}

		if($message=="/rvn")
			{
			$message=$rpc->getbalance("");
			$message=$message." RVN in the world";
			}

		if($message=="/doge")
			{
			$message=$dpc->getbalance("");
			$message=$message." DOGE in the world";
			}
		
		/*if($message=="/btc")
			{
			$message=$bpc->getbalance("");
			$message=$message." BTC in the world";
			}
		*/


		//coin
			
			if($message=="/coin")
			{

			if($commtool[1] !=""){$message="<a target=\"_blank\"  href=https://explorer.kevacoin.org/address/".$commtool[1].">[KVA]</a>";}

			if($commtool[3] !=""){$message=$message." <a target=\"_blank\"  href=https://explorer.ravenland.org/address/".$commtool[3].">[RVN]</a>";}

			if($commtool[4] !=""){$message=$message." <a target=\"_blank\"  href=https://blockchair.com/dogecoin/address/".$commtool[4].">[DOGE]</a>";}

			if($commtool[5] !=""){$message=$message." <a target=\"_blank\"  href=https://blockchair.com/bitcoin/address/".$commtool[5].">[BTC]</a>";}

			}



		//space
			
			if($message=="/space")
			{
			$getnum=explode('*', $commtool[0]);

			$message="<a target=\"_blank\"  href=https://keva.app/?".$getnum[0].">keva.app/?".$getnum[0]."</a>";


			}

	   //nft
			
			if($message=="/nft")
			{
			
			$message="<a target=\"_blank\"   href=https://keva.app/?nft".$getnum[0].">[ALL]</a>";

			if($commtool[3] !=""){$message=$message." <a target=\"_blank\"   href=http://galaxyos.io/?lang=&asset=".$commtool[3].">[RVN]</a>";}


			}


			
        $this->playerId = $player->id;
        $this->message = $message ;
    }
    
    public function serialize()
    {
        return array(TYPES_MESSAGES_CHAT, 
                $this->playerId, 
                $this->message
        );
    }
}


class Raven {

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
      //$this->host          = '192.168.152.6'; // Localhost
		 $this->host          = '127.0.0.1'; // Localhost
        $this->port          = '9991';
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
        //$this->host          = '192.168.152.6'; // Localhost
		$this->host          = '127.0.0.1'; // Localhost
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

class Doge {

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
       //$this->host          = '192.168.152.6'; // Localhost
		$this->host          = '127.0.0.1'; // Localhost
        $this->port          = '9993';
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
