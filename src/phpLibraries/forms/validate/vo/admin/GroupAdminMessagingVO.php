<?

	
	/**
		-----------------------------------------------------
		
		GroupAdminMessagingVO
		
		NOTES:
		messaging pertinent to validating submitted tv admin data
	
		----------------------------------------------------
	*/
	
	
	class GroupAdminMessagingVO {
		
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
			
			$this->messages = array("Your Content Group record has been created.", "Your Content Group record has been updated.", "Update not performed. No data has changed.", "A Content Group with that ID already exists.");
		}
		
		/**
		 *	addMessage
		 *	invoked by implementing class to add an error message to displayMessages
		 */
		public function addMessage($num) {
			array_push($this->displayMessages, $this->messages[$num]);
		}
		
		/**
		 *	getMessage
		 *	- invoked by implementing class to return array of error messages
		 */
		public function getMessage() {
			$messages = "";
			
			foreach ($this->displayMessages as $key=>$value) {
				$messages .= trim($value, " ") . "\n";
			}
			
			rtrim($messages, "\n");
			
			return $messages;
		}
	}

?>