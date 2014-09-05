<?

	/**
	 *	ParseStrategyInterface.php
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
	 *	- the Interface to which all record strategies must conform
	 *
	 *	Accepts:
	 *	
	 */



	/*
		-------------------------------
		interface declaration
		-------------------------------
	*/

		interface ParseStrategyInterface {
		  
		  	// interface methods
			public function parseFile($obj);
		}


?>