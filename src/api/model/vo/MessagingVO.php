<?php

	
	/**
		-----------------------------------------------------
		
		MessagingVO
		
		NOTES:
		content-independent API messaging only
	
		----------------------------------------------------
	*/
	
	
	class MessagingVO {
		
		private $messages;
		
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			
			$this->setupProps();
		}
		
		
		private function setupProps() {
			
			$this->messages = array( 	array("Error: API Action not recognized.", "Error: API Action not recognized.")
									);
		}
		
		
		public function getMessage($num, $lang) {
			$i = $lang == "en" ? 0 : 1;
			return $this->messages[$num][$i];
		}
		
	}

?>