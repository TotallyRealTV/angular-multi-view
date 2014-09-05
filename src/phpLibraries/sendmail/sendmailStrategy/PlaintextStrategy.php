<?php

	/**
	 *	PlaintextStrategy.php
	 *
	 *	Created:
	 *	2013-12-30
	 *
	 *	Modified:
	 *	2013-12-30
	 *
	 *	Created by:
	 *	Jonathan Blackburn.
	 *
	 *	Purpose:
	 *	- sends a plain text email to recpients
	 *
	 *	$obj expects:
	 *	- data:	array of submitted form data
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('SendmailStrategyInterface.php');
 		include_once('BaseSendmailStrategy.php');
		
  		
		class PlaintextStrategy extends BaseSendmailStrategy implements SendmailStrategyInterface {
		
			/**
			 *	sendmail
			 *	- loads template
			 *	- constructs headers
			 *	- inserts data into template
			 *	- sends mail
			 */	 
			public function sendmail($obj) {
				//error_reporting(E_ERROR | E_PARSE);
				$errorCode = 0;
				
				for ($i = 0; $i < count($obj->recipients); $i++) {
					$obj->boundary = uniqid('np');
					$obj->email = $obj->recipients[$i];
					$headers = $this->generateHeaders($obj);
					$headers .= $this->generatePlainHeaders($obj);
					$message = $this->startBody($obj);				
					$message .= $this->generatePlainTextBody($obj);
					
					if (!mail($obj->email, $obj->subject, $message, $headers)) {
						$errorCode = 1;
						$this->messaging->addMessage($errorCode, $obj->language);
					}
				}
				
				$result = new stdClass();
				$result->errorCode = 0;
				
				if ($errorCode == 0) $this->messaging->addMessage($errorCode, $obj->language);
				else $result->errorCode = 1;
				
				$result->messaging = $this->messaging->getMessage();
				
				return $result;
			}
		}

?>