<?

	/**
	 *	Directory.php
	 *
	 *	Created:
	 *	2012-04-05
	 *
	 *	Modified:
	 *	2012-04-05
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- this static class provides methods to create & delete directories of a location supplied by an implementing class
	 *
	 *	
	 */
	 
	class DirectoryManager {
		 
		private $errorCode;
	
		/**
		 * 	constructor
		 *	$obj expects:
		 *	-> path: directory to create
		 */
		public function __construct($obj = NULL)  {  
			$this->setupProps();
		}
		
		/**
		 *	setupProps
		 *	- sets the properties for this class
		 */
		private function setupProps($obj = NULL) {
			$this->errorCode = 0;
		}
		
		/**
		 *	addDirectory
		 *	- creates a directory (if it does not exist)
		 *	- returns errorCode = 0 (success) or 1 (failure);
		 */
		private function addDirectory($obj = NULL) {
			
			if (!file_exists($obj->directoryPath)) {
				if(!mkdir($obj->directoryPath, 0777, true)) {
					$this->errorCode = 1;
				}
				$this->errorCode = 1;
			}
		}
		
		
		/**
		 *	removeDirectory
		 *	- removes a directory
		 *	- returns errorCode = 0 (success) or 1 (failure);
		 */
		private function removeDirectory ($obj = NULL) {
			if (!file_exists($obj->directoryPath)) {
				if (!rmdir($obj->directoryPath, 0777)) {
					$this->errorCode = 1;
				}
				$this->errorCode = 1;
			}	
		}
		
		/**
		 *	public methods
		 */
		public function createDirectory($obj = NULL) {
			$this->addDirectory($obj);
			return $this->errorCode;	
		}
		
		public function deleteDirectory($obj = NULL) {
			$this->removeDirectory($obj);
			return $this->errorCode;	
		}
		
		/**
		 *	getDirectoryContents
		 */
		public function getDirectoryContents($obj = NULL) {
			$contents = array();
			
			if ($obj->dir = opendir('.')) {
				while (false !== ($entry = readdir($obj->dir))) {
					if ($entry != "." && $entry != "..") {
						array_push($contents, $entry);
					}
				}
				closedir($obj->dir);
			}
			
			return $contents;
		}
		
	}

?>