<?

	/**
	 *	ErrorTrackingActivityVO
	 *
	 *	this class provides specific parameters for ErrorTracking
	 *	this class is instantiated in case a tracking request is made without a valid ID
	 *	It extends ActivityVO in order to create a single point of all properties we need to perform a database action for this tracking implementation
	 */
	
	class ErrorTrackingActivityVO extends ActivityVO {
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			parent::setupProps($obj);
			$this->setupProps($obj);
			
		}
	
		/**
		 *	setupProps
		 *	- this method should only be fully implemented in subclasses of HighScoresVO
		 */	
		protected function setupProps($obj = NULL) {
			$this->output = new stdClass();
			$this->output->format = "json";
			$this->output->type = "standardActivity";
		}
		
	}

?>