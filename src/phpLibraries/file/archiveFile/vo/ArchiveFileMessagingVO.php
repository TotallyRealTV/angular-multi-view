<?

	
	/**
		-----------------------------------------------------
		
		ArchiveFileMessagingVO
		
		NOTES:
		messaging pertinent to file archiving
	
		----------------------------------------------------
	*/
	
	
	class ArchiveFileMessagingVO {
		
		private $messages;
		
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			$this->setupProps();
		}
		
		
		private function setupProps() {
			
			$this->messages = array("",
									"Error: File not Found. Unable to archive your file.",
									"Error: Unable to open a new archive file type. Please try again.",
									"Error: No valid files found to put into your archive. Please try again."
									);
		}
		
		
		public function getMessage($num) {
			return $this->messages[$num];
		}
	}

?>