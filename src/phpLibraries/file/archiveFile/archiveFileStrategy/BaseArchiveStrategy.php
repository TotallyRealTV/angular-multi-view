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

		include_once('ArchiveStrategyInterface.php');
 
	
	
		class BaseArchiveStrategy implements ArchiveStrategyInterface {
		
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				
			}
				
			/**
			 *	archiveFiles
			 *	- see strategy overrides for implementation
			 */	 
			public function archiveFiles($obj) {
				
			}
			
			/**
			 *	deleteArchive
			 *	- see strategy overrides for implementation
			 */	 
			public function deleteArchive($obj) {
				
			}
			
			/**
			 *	getFileName
			 *	- see strategy overrides for implementation
			 */	 
			public function getFileName($obj) {
				
			}
		}



?>