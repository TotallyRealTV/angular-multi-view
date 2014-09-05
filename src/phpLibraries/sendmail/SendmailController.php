<?php
	/**
	 * 	The SendmailController manages the initialization and sending of multi-part emails
	 */
	require_once("sendmailStrategy/MultipartStrategy.php");
	require_once("sendmailStrategy/PlaintextStrategy.php");
	
	
	class SendmailController {
		
		protected $props;					//	an object to hold our critical properties required to upload a file
		protected $sendmailStrategy;		//	holds our mailer strategy
		
		
		public function __construct($obj)  { 
			$this->setupProps($obj);
		}
		
		/**
		 *	setupProps
		 *	- sets the properties common to all mailers
		 */
		protected function setupProps($obj = NULL) {
			$this->props = new stdClass();
			foreach ($obj as $key => $value) $this->props->$key = $value;
		}
		
		/**
		 *	Sendmail
		 *	- invokes the required archive strategy based on $this->props->type
		 */
		public function sendmail() {
			switch($this->props->type) {
				case "multipart":
						 $this->sendmailStrategy = new MultipartStrategy();
				break;
				
				default:
						 $this->sendmailStrategy = new PlaintextStrategy();
				break;
			}
			
			return $this->sendmailStrategy->sendmail($this->props);
		}
		
		public function getMessage() {
			return $this->sendmailStrategy->getMessage();	
		}
	}
	

?>