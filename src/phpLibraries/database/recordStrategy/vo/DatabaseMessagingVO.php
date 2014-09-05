<?

	
	/**
		-----------------------------------------------------
		
		DatabaseMessagingVO
		
		NOTES:
		messaging pertinent to PDO connections
	
		----------------------------------------------------
	*/
	
	
	class DatabaseMessagingVO {
		
		private $messages;			//	definition of error messages
		
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			$this->setupProps();
		}
		
		
		private function setupProps() {
			$this->messages = array(
					array("en" => "", "fr" => ""),
					array("en" => "Error Connecting to Database", "fr" => "ErrorConnecting to Database"),
					array("en" => "No records found", "fr" => "No records found"),
					array("en" => "No data has changed. Update not performed", "fr" => "No data has changed. Update not performed"),
					array("en" => "Your record has been updated", "fr" => "Your record has been updated")
			);
		}
		
		
		/**
		 *	getMessage
		 *	- invoked by implementing class to return array of error messages
		 */
		public function getMessage($num, $lang) {
			return $this->messages[$num][$lang];
		}
	}

?>