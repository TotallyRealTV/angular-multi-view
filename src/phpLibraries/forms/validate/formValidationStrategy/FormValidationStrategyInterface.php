<?

	/**
	 *	FormValidationStrategyInterface.php
	 *
	 *	Created:
	 *	2012-03-22
	 *
	 *	Modified:
	 *	2012-03-22
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- the Interface to which all FormValidation strategies must conform
	 *
	 *	Accepts:
	 *	
	 */



	/*
		-------------------------------
		interface declaration
		-------------------------------
	*/

		interface FormValidationStrategyInterface {
		  
		  	// interface methods
			public function validateForm($obj);
			public function getMessage();
		}


?>