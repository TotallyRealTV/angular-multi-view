<?

	
	/**
		-----------------------------------------------------
		
		DbArchive
		
		NOTES:
		messaging pertinent to DB Table archive reference creation
	
		----------------------------------------------------
	*/
	
	
	class DbArchiveMessagingVO {
		
		private $messages;			//	definition of error messages
		
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			$this->setupProps();
		}
		
		
		private function setupProps() {
			$this->messages = array(
							array("success" => "Valid Controller found.",  "error" => "Invalid Controller specified."),
							array("success" => "Database records found.",  "error" => "Unable to retrieve data. Please check that the submitted Brand code is valid."),
							array("success" => "Reference File (list) generated.",  "error" => "Unable to write reference file"),
							array("success" => "FY Reference files have been generated.",  "error" => "Unable to write reference file")
			);
		}
		
		
		/**
		 *	getMessage
		 *	- invoked by implementing class to return array of error messages
		 */
		public function getMessage($num, $key) {
			return $this->messages[$num][$key];
		}
	}

?>