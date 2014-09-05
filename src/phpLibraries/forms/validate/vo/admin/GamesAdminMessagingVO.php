<?

	
	/**
		-----------------------------------------------------
		
		GamesAdminMessagingVO
		
		NOTES:
		messaging pertinent to validating submitted games admin data
	
		----------------------------------------------------
	*/
	
	
	class GamesAdminMessagingVO {
		
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
			
			$this->messages = array("Your game record has been created.", "Your game record has been updated.", "Update not performed. No data has changed.", "A game with that ID already exists.", "The game ID you entered is not valid.", "The Game file / url you entered is not valid.", "All of your date_time fields must be in the format: yyyy-mm-dd hh:mm:ss (ie: 2013-03-30 12:15:25)", "Your file dimensions must be valid numbers (no letters or special characters).");
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