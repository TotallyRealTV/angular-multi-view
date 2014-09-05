<?

	/**
	 *	ArchiveStrategyInterface.php
	 *
	 *	Created:
	 *	2012-03-09
	 *
	 *	Modified:
	 *	2012-03-09
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- the Interface to which all archive strategies must conform
	 *
	 *	Accepts:
	 *	
	 */



	/*
		-------------------------------
		interface declaration
		-------------------------------
	*/

		interface ArchiveStrategyInterface {
		  
		  	// interface methods
			public function archiveFiles($obj);
			public function deleteArchive($obj);
			public function getFileName($obj);
		}


?>