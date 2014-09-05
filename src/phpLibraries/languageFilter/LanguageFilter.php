<?

	/**
	 *	LanguageFilter.php
	 *
	 *	Created:
	 *	2012-02-07
	 *
	 *	Modified:
	 *	2012-02-07
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- this instances LanguageFilter, which provides the common methods and properties used in language filtering for both teletoon & night.
	 *	- all data (such as filter arrays), and implementation-specific methods, will be found in extensions to this class. Current extensions include:
	 *		- TeletoonLanguageFilter
	 *		- 
	 *
	 *	Accepts:
	 *	
	 */

	
	/*
		-------------------------------
		include files
		-------------------------------
	*/
		
		include_once("TtLanguageFilter.php");
		include_once("NightLanguageFilter.php");
		
		include_once("filterStrategy/StandardLanguageFilterStrategy.php");
		include_once("filterStrategy/AssociativeLanguageFilterStrategy.php");
		
		
	/*
		-------------------------------
		LanguageFilter
		
		Required:
		$obj->brand: "teletoon", "night"...
		$obj->dataToCheck: an array of strings we want to run our language filter against
		-------------------------------
	*/

	class LanguageFilter {
		
		// define properties
		private $brand;							// "Teletoon", "Night"	
		private $badWords;						// 	array of bad words: implementation specific
		private $filterStrategy;				//	our filtering strategy
		protected $dataToCheck;
	
		// constructor
		public function __construct($obj) {
			
		}
	
	
	
	/*
		-------------------------------
		setup methods
		-------------------------------
	*/
	
		/**
		 *	setupProps
		 *	- sets the properties for a given instance. See specific extensions for implementation-specific properties
		 *	- each class that extends this class calls to this method, so only edit this method if said changes apply to all implementations
		 */
		protected function setupProps($obj) {
			$this->dataToCheck = array();
			$this->dataToCheck = $obj->dataToCheck;
		}
	
	
	/*
		-------------------------------
		generation methods
		-------------------------------
	*/
		/**
		 *	generate
		 *	- invokes FilterStrategy generation method
		 */
		protected function generate($obj) {
			$this->stripData();
			$this->generateFilterStrategy($obj);	
		}
		
		/**
		 *	stripData
		 *	- removes special characters from user input in order to narrow bad language possibilities
		 */
		protected function stripData() {
			//$remove = array(" ", "-", "_", "*", "&", "^", "%", "$", "#", "[", "]", "{", "}", "=", "+");
			$remove = array(" ", "-", "_", "*", "&", "^", "%", "#", "[", "]", "{", "}", "=", "+");
			
			for ($i = 0; $i < count($this->dataToCheck); $i++) {
				$this->dataToCheck[$i] = str_replace($remove, "", $this->dataToCheck[$i]);
			}
		}
		
		
		
		/**
		 * 	generateFilterStrategy
		 *	- sets the filtering strategy for this instance as determined by $obj->filterType
		 *	- valid filterTypes, presently, are: 'standard', 'associative'	
		 *	
		 */
		protected function generateFilterStrategy($obj) {
			
			switch ($obj->filterType) {
				case "standard": 
					$this->filterStrategy = new StandardLanguageFilterStrategy();
					break;
				  
				case "associative": 
					$this->filterStrategy = new AssociativeLanguageFilterStrategy();
					break;
				  
				default:	// full
					echo "filter strategy not recognized. Must be either 'standard' or 'associative'";
					break;
			  }
		}
	
	
	/*
		-------------------------------
		public access methods
		-------------------------------
	*/
		/**
		 *	filterData
		 *	- invokes the filter data method on the filterStrategy instance
		 *
		 *	Accepts:
		 *	$obj: containing dataToCheck
		 *
		 *	Returns:
		 *	- $errorCode: 0 || 1
		 */
		public function filterData() {
			// construct init for strategy. Both props are required.
			$init = (object) NULL;
			$init->badWords = $this->badWords;
			$init->dataToCheck = $this->dataToCheck;
			return $this->filterStrategy->filterData($init);	
		}
	
	
	/*
		-------------------------------
		get / set
		-------------------------------
	*/
		function __set($property, $value) {
			$this->$property = $value;
		}
 
		function __get($property) {
			if (isset($this->$property)) {
				return $this->$property;
			}
		}

	
	/*
		-------------------------------
		destroy
		-------------------------------
	*/
		function __destruct() {
			unset($this->filterStrategy);
			unset($this->dataToCheck);
			unset($this->badWords);
		}

	}



?>