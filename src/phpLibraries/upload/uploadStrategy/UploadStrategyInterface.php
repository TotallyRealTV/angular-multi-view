<?

	/**
	 *	UploadStrategyInterface.php
	 *
	 *	Created:
	 *	2012-03-06
	 *
	 *	Modified:
	 *	2012-03-06
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- the Interface to which all upload strategies must conform
	 *
	 *	Accepts:
	 *	
	 */



	/*
		-------------------------------
		interface declaration
		-------------------------------
	*/

		interface UploadStrategyInterface {
		  
		  	// interface methods
			public function uploadFile($obj);
		}


?>