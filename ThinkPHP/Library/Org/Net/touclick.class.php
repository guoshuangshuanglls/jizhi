<?php

namespace Org\Net;

class touclick{

	public function touclickCheck($publicKey, $privateKey, $check_key, $check_address, $uname="0", $uid="0"){
		$url = "";
		$path = "";
		
		if(empty($publicKey) || empty($privateKey) || empty($check_key) ||empty($check_address) ) {
			return false;
		}
	
		if(!$this->filterUrl($url, $path, $check_address)){
			return false;
		}
		
		$path = $path
		."?b=".$publicKey
		."&z=".$privateKey
		."&i=".$check_key
		."&p=".$this->getClientIp()
		."&un=".urldecode($uname)
		."&ud=".$uid;
		
		$getres = $this->requestGet($url, $path, array(),80);
		
        return !!strpos($getres['content'], "[yes]");
	}

	private function filterUrl(&$url, &$path, $check_address) {
		$check_address_arr = explode ( ",", $check_address );
		if (! is_array ( $check_address_arr ) || count ( $check_address_arr ) != 2) {
			return false;
		}
		$url_arr = explode ( ".", $check_address_arr [0] );
		if (! is_array ( $url_arr ) || count ( $url_arr ) != 3) {
			return false;
		}
		$path_arr = explode ( ".", $check_address_arr [1] );
		if (! is_array ( $path_arr ) || count ( $path_arr ) != 2) {
			return false;
		}
		if (! $this->filterStr ( $url_arr [0] ) || ! $this->filterStr ( $path_arr [0] )) {
			return false;
		}
		$url = "http://" . $url_arr [0] . ".touclick.com";
		
		$path = "/" . $path_arr [0] . ".touclick";
		return true;
	}

	private function filterStr($str){
		if (preg_match("/^[a-z0-9]+$/", $str) ) {
			return true;
		} else {
			return false;
		}
	}
	
	private function requestGet($url, $path, $data, $port) {
		$data = http_build_query($data);
		$url = parse_url($url);
		if ($url['scheme'] != 'http') {
			die('Error: Only HTTP request are supported !');
		}
		$host = $url['host'];
		$fp = $this->sendGet($host, $port, $errno, $errstr, 15);
		if ($fp){
			fputs($fp, "GET $path HTTP/1.1\r\n");
			fputs($fp, "Host: $host\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ". strlen($data) ."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $data);
			$result = '';
			while(!feof($fp)) {
				$result .= fgets($fp, 1028);
			}
		}
		else {
			return array(
					'status' => 'err',
					'error' => "$errstr ($errno)"
			);
		}
		fclose($fp);
		$result = explode("\r\n\r\n", $result, 2);
		$header = isset($result[0]) ? $result[0] : '';
		$content = isset($result[1]) ? $result[1] : '';
		return array(
				'status' => 'ok',
				'content' => $content,
		);
	}
	
	private function sendGet($hostname, $port = 80, &$errno, &$errstr, $timeout = 15) {
		$fp = '';
		if(function_exists('fsockopen')) {
			$fp = @fsockopen($hostname, $port, $errno, $errstr, $timeout);
		} elseif(function_exists('pfsockopen')) {
			$fp = @pfsockopen($hostname, $port, $errno, $errstr, $timeout);
		} elseif(function_exists('stream_socket_client')) {
			$fp = @stream_socket_client($hostname.':'.$port, $errno, $errstr, $timeout);
		}
		return $fp;
	}
	
	private function getClientIp() {
	    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
	        $clientip = $_SERVER["HTTP_CLIENT_IP"];
	    } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
	        $clientip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	    } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
	        $clientip = $_SERVER["REMOTE_ADDR"];
	    } else {
	        $clientip = '0.0.0.0';
	    }
	    return $clientip;
	}
}