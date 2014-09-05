<?php

	/**
	 *	SendmailModel.php
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
	 *	- this class provides the model for sending an email
	 *
	 *	
	 */
	
	include_once("model/BaseModel.php");
	include_once(PHP_PATH . "sendmail/SendmailController.php");
	

	class ContactModel extends BaseModel {
		
		/**
		 *	constructor
		 */
		public function __construct($obj) {
			parent::setupProps();
			$this->setupProps($obj);
		}
		
		/**
		 * 	setupProps
		 *	- prepare all common, critical highscore-related data
		 *
		 *	Accepts:
		 *	$obj, which should contain:
		 *		- gameID
		 */
		protected function setupProps($obj = NULL) {
			foreach ($obj as $key => $value) $this->props->$key = $value;
							
			$this->props->dateTime = date("Y-m-d H:i:s");
			$this->props->language = "en";
			$this->props->ip = $_SERVER['REMOTE_ADDR'];
		}
		
		
		
		/**
		 *	private methods
		 */
		
		/**
		 *	generateModel
		 *	- if we have a gameID
		 *	- instance our RecordVO, so that we have the 'executeQuery' strategy pattern available for this model
		 */
		public function execute($obj = NULL) {
			$init = new stdClass();
			$init->type = "multipart";
			$init->email = $this->props->email;
			$init->subject = "Portfolio Contact Form Submission";
			$init->textData = $this->props->text;
			$init->htmlData = "<p>" . $this->props->text . "</p>";
			$init->salutation_name = $this->props->name . " (" . $this->props->email . ")";
			$init->stringTemplate = APP_PATH . "data/email.txt";
			$init->htmlTemplate = APP_PATH . "data/email.html";
			$init->language = "en";
			$init->recipients = array("info@jblackburn.comoj.com");
			
			$sendmail = new SendmailController($init);
			$result = $sendmail->sendmail();
			
			return $result;
		}
	}

?>