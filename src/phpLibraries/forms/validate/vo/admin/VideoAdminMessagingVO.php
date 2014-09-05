<?

	
	/**
		-----------------------------------------------------
		
		VideoAdminMessagingVO
		
		NOTES:
		messaging pertinent to validating submitted tv admin data
	
		----------------------------------------------------
	*/
	
	
	class VideoAdminMessagingVO {
		
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
			
			$this->messages = array("Your Video record has been created.", "Your Video record has been updated.", "Update not performed. No data has changed.", "A Video with that ID already exists.", "The video file you are attempting to push to Brightcove is too large. Please upload your video directly through the Brightcove FTP and paste the videoID into this form to complete the creation of this record.", "Your thumbnail is incorrectly sized.", "Your thumbnail is not the correct type.", "The video keywords field can contain only letters, numbers and spaces.");
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
		
		public function clearMessages() {
			$this->displayMessages = array();	
		}
	}

?>