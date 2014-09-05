<?php

	
	/**-
		
		global.php
		
		NOTES:
		Common, implementation-agnostic functions
	
		----------------------------------------------------
	*/
	
		function retrieveObVars($ob) {
			//echo 'retrieve obj vars';
			if (isset($_POST)) {
				foreach($_POST as $key=>$value) {
					if (is_string($value)) $ob->$key = utf8_decode(urldecode($value));
					else $ob->$key = $value;
				}
			} 
			
			if (isset($_REQUEST)) {
				foreach($_REQUEST as $key=>$value) {
					if (is_string($value)) $ob->$key = utf8_decode(urldecode($value));
					else $ob->$key = $value;
				}
			}
			
			return $ob;
		}
		
		
	/**-
		encryption / decryption
		----------------------------------------------------
	*/
		function simpleEncrypt($string, $key) {
			$result = '';
			
			for($i=0; $i<strlen ($string); $i++) {
				$char = substr($string, $i, 1);
			  	$keychar = substr($key, ($i % strlen($key))-1, 1);
			  	$char = chr(ord($char)+ord($keychar));
			  	$result.=$char;
			}     
			return base64url_encode($result);
		}
		 
		function simpleDecrypt($string, $key) {
			$result = '';
			$string = base64url_decode($string);    
			for($i=0; $i<strlen($string); $i++) {
			  	$char = substr($string, $i, 1);
			  	$keychar = substr($key, ($i % strlen($key))-1, 1);
			  	$char = chr(ord($char)-ord($keychar));
			  	$result.=$char;
			}     
			return $result;
		}
		 
		function base64url_encode($plainText) {
			$base64 = base64_encode($plainText);  
			$base64url = strtr($base64, '+/', '-_');  
			return ($base64url);  
		}  
		 
		function base64url_decode($plainText) {
			$base64 = strtr($plainText, '-_', '+/');
			return base64_decode($base64);      
		}
	
	
	/**-----
		URL
		---------------------------------------------------------
	*/	
		function getCurrentURL(){
			$current_page_URL =(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]== "on") ? "https://" : "http://";
			$current_page_URL .= $_SERVER["SERVER_NAME"];
			return $current_page_URL;
		}
		
		function getHost() {
			if (!$host = $_SERVER['HTTP_HOST'])
			{
				if (!$host = $_SERVER['SERVER_NAME'])
				{
					$host = !empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
				}
			}
		
			// Remove port number from host
			$host = preg_replace('/:\d+$/', '', $host);
		
			return trim($host);
		}
	
		
		
		
	/**-----
		implementation-specific methods
		---------------------------------------------------------
	*/
		
		/**
		 *	search a multi-dimensional array by a value + index and return by returnIndex
		 *	Sample usage:
		 *	$myVal = getCharacterTitle($myVar, $keyValue, 0, 1);
		 */
		
		function getValueFromArrayKey($arr, $key, $searchIndex, $returnIndex) {
			$items = count($arr);
			
			$value = "";
			
			for ($i = 0; $i < $items; $i++) {
				if ($arr[$i][$searchIndex] == $key) {
					$value = $arr[$i][$returnIndex];	
					break;
				}	
			}
		
			return $value;
		}
?>