<?

	
	/**
		-----------------------------------------------------
		
		PlaylistAdminMessagingVO
		
		NOTES:
		messaging pertinent to validating submitted tv admin data
	
		----------------------------------------------------
	*/
	
	
	class PlaylistAdminMessagingVO {
		
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
			
			$this->messages = array("Your Playlist record has been created.", "Your Playlist record has been updated.", "Update not performed. No data has changed.", "A Playlist with that ID already exists.", "The playlist file you are attempting to upload is not the correct type (.flv only).", "Your thumbnail is incorrectly sized.", "Your thumbnail is not the correct type.");
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