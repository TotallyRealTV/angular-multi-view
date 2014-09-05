<?

	/**
	 *	BaseUploadStrategy.php
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
	 *	- serves as basic implementation of all upload strategies
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('UploadStrategyInterface.php');
  		include_once('class.upload.php');
	
	
		class BaseUploadStrategy implements UploadStrategyInterface {
		
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				
			}
				
			/**
			 *	execute
			 *	- see strategy overrides for implementation
			 */	 
			public function uploadFile($obj) {
				
			}
		}



?>