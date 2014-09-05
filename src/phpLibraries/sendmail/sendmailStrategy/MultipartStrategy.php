<?php

	/**
	 *	ContestEntryValidationStrategy.php
	 *
	 *	Created:
	 *	2012-03-09
	 *
	 *	Modified:
	 *	2012-03-09
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- performs validation on a range of data that is meant to be inserted into a contest database table
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
		
  		
		class MultipartStrategy extends BaseSendmailStrategy implements SendmailStrategyInterface {
		
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
					$message = $this->startBody($obj);				
					$message .= $this->generatePlainTextBody($obj);
					$message .= $this->generateHtmlBody($obj);
					
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