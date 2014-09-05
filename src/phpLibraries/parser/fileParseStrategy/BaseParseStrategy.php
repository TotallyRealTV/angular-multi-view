<?

	/**
	 *	BasicRecordStrategy.php
	 *
	 *	Created:
	 *	2012-02-14
	 *
	 *	Modified:
	 *	2012-02-14
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- serves as basic implementation of all query strategies
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('ParseStrategyInterface.php');
  		
  	
	
	
		class BaseParseStrategy implements ParseStrategyInterface {
		
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				
			}
				
			/**
			 *	execute
			 *	- see strategy overrides for implementation
			 */	 
			public function parseFile($obj) {
				
			}
		}



?>