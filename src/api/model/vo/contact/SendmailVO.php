<?php

	/**
	 *	SendmailVO
	 *
	 *	- the Activity Tracking Value Object. This class provides the properties and methods that are common to all subclasses
	 *	- do not implement the constructor in this class. Only subclasses are meant to instances
	 *	- subclasses: see includes
	 */
	
	class SendmailVO extends BaseVO {
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			parent::setupProps($obj);
			$this->setupProps();
		}
			
		
		/**
		 *	setupProps
		 *	- this method should only be fully implemented in subclasses of ActivityVO
		 *		- set defaults on expected incoming data
		 *		- scope to $this->activityData
		 */	
		protected function setupProps($obj = NULL) {
				$this->dbTable = "contact";
		}
	}

?>