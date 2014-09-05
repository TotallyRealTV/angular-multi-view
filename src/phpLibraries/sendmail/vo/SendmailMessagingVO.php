<?php

	
	/**
		-----------------------------------------------------
		
		SendmailMessagingVO
		
		NOTES:
		messaging pertinent to validating submitted contest data
	
		----------------------------------------------------
	*/
	
	
	class SendmailMessagingVO {
		
		private $messages;			//	definition of error messages
		private $displayMessage;	// array of messages we return
		
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			$this->setupProps();
		}
		
		
		private function setupProps() {
			
			$this->displayMessages = array();
			
			$this->messages = array(
				array("en" => "An email has been sent to the address provided!", "fr" => "Merci beaucoup!"),
				array("en" => "We are unable to send an email to you at this time!", "fr" => "Zut, alors!")
			);
		}
		
		/**
		 *	addMessage
		 *	invoked by implementing class to add an error message to displayMessages
		 */
		public function addMessage($num, $language) {
			array_push($this->displayMessages, $this->messages[$num][$language]);	
		}
		
		/**
		 *	getMessage
		 *	- invoked by implementing class to return array of error messages
		 */
		public function getMessage() {
			return $this->displayMessages;
		}
	}

?>