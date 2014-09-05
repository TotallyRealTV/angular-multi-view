<?

	
	/**
		-----------------------------------------------------
		
		TvAdminMessagingVO
		
		NOTES:
		messaging pertinent to validating submitted tv admin data
	
		----------------------------------------------------
	*/
	
	
	class TvAdminMessagingVO {
		
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
			
			$this->messages = array("Your TV show definition record has been created.", "Your TV show content has been updated.", "Update not performed. No data has changed.", "A TV show with that ID already exists.", "The TV show ID you entered is not valid.", "The file / url you entered is not valid.", "All of your date_time fields must be in the format: yyyy-mm-dd hh:mm:ss (ie: 2013-03-30 12:15:25)", "Your file dimensions must be valid numbers (no letters or special characters).", "All fields of a Content Window must be filled out.");
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