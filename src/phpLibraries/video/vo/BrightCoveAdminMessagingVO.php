<?

	
	/**
		-----------------------------------------------------
		
		BrightCoveAdminMessagingVO
		
		NOTES:
		messaging pertinent to validating BrightCove API interaction
	
		----------------------------------------------------
	*/
	
	
	class BrightCoveAdminMessagingVO {
		
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
			
			$this->messages = array("BrightCove Media successfully updated.", "The media ID you submitted is not recognized in the BrightCove system. Please verify that a media asset with this ID exists in the BrightCove System.", "The reference ID you submitted is not recognized in the BrightCove system. Please verify that it is correct.", "BrightCove Playlist successfully created.", "Unable to create BrightCove Playlist.", "BrightCove Playlist successfully updated.", "Unable to update BrightCove Playlist.", "Video IDs successfully removed from Playlist.", "Unable to remove video IDs from Playlist.", "The BrightCove System is unable to process this video.");
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