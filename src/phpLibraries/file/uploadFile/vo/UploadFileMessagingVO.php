<?

	
	/**
		-----------------------------------------------------
		
		UploadFileMessagingVO
		
		NOTES:
		messaging pertinent to file uploading
	
		----------------------------------------------------
	*/
	
	
	class UploadFileMessagingVO {
		
		private $messages;
		
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			$this->setupProps();
		}
		
		
		private function setupProps() {
			
			$this->messages = array("",
									"Error: Unable to upload your file(s). Please try again."
									);
		}
		
		
		public function getMessage($num) {
			return $this->messages[$num];
		}
	}

?>