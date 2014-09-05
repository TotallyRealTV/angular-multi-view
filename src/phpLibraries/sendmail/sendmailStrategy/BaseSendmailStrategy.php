<?php

	/**
	 *	BaseSendmailStrategy.php
	 *
	 *	Created:
	 *	2013-04-23
	 *
	 *	Modified:
	 *	2013-04-23
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- serves as basic implementation of all sendmail strategies
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('SendmailStrategyInterface.php');
		include_once(PHP_PATH . "sendmail/vo/SendmailMessagingVO.php");
	
	
		class BaseSendmailStrategy implements SendmailStrategyInterface {
		
			
			protected $messaging;
			protected $errorCode;
			
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				$this->errorCode = 0;
				$this->generateMessaging($obj);	
			}
			
			protected function generateMessaging() {
				$this->messaging = new SendmailMessagingVO();
			}
			
			/**
			 *	loadMailTemplate
			 *	- returns the file at supplied location
			 */
			protected function loadTemplate($src) {
				return file_get_contents($src);	
			}
			
			/**
			 *	generateHeaders
			 *	- generates mail headers
			 */
			protected function generateHeaders($obj = NULL) {
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "From: " . $obj->email . " \r\n";
				$headers .= "To: " . $obj->email . "\r\n";
				$headers .= "Content-Type: multipart/alternative;boundary=" . $obj->boundary . "\r\n";
				$headers .= "X-Mailer: PHP/" . phpversion();
				return $headers;	
			}
			
			protected function generatePlainHeaders($obj = NULL) {
				$headers .= "\n--$boundary\n"; // beginning \n added to separate previous content
				$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
				return $headers;	
			}
			
			protected function startBody($obj) {
				$message = "This is a MIME encoded message.";
				$message .= "\r\n\r\n--" . $obj->boundary . "\r\n";
				
				return $message;	
			}
			
			protected function generatePlainTextBody($obj) {
				
				$template = $this->loadTemplate($obj->stringTemplate);
				$template = str_replace("#data#", $obj->textData, $template);
				$template = str_replace("#user_name#", $obj->salutation_name, $template);
				
				//$message = "Content-type: text/plain;charset=utf-8\r\n\r\n";
				$message .= $template;
				$message .= "\r\n\r\n--" . $obj->boundary . "\r\n";
				
				return $message;
			}
			
			protected function generateHtmlBody($obj = NULL) {
				$template = $this->loadTemplate($obj->htmlTemplate);
				$template = str_replace("#data#", $obj->htmlData, $template);
				$template = str_replace("#user_name#", $obj->salutation_name, $template);
				$template = str_replace("#year#", date("Y"), $template);
				
				$message = "Content-type: text/html;charset=utf-8\r\n\r\n";
				$message .= $template;
				$message .= "\r\n\r\n--" . $obj->boundary . "--";
				
				return $message;	
			}
				
			/**
			 *	sendmail
			 *	- see strategy overrides for implementation
			 */	 
			public function sendmail($obj) {
				
			}
		}


?>