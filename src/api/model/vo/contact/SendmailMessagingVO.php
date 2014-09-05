<?php

	
	/**
	 *	SendmailMessagingVO
	 *	
	 *	NOTES:
	 *	activity tracking messaging only
	 */
	
	
	class SendmailMessagingVO {
		
		private $messages;
		
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			
			$this->setupProps();
		}
		
		
		private function setupProps() {
			
			$this->messages = array( 	
												array("Message has been successfully sent!", ""),
												array("Unable to send message at this time.", "")
									);
		}
		
		
		public function getMessage($num, $lang) {
			$i = $lang == "en" ? 0 : 1;
			return $this->messages[$num][$i];
		}
		
	}

?>