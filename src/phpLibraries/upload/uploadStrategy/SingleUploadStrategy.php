<?

	/**
	 *	SingleUploadStrategy.php
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
	 *	- uploads a file to a given location
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('UploadStrategyInterface.php');
 		include_once('BaseUploadStrategy.php');
  		
	
	
		class SingleUploadStrategy extends BaseUploadStrategy implements UploadStrategyInterface {
		
			/**
			 *	uploadFile
			 *	- instances upload
			 *	- returns error code (0 = success, 1 = error)
			 */	 
			public function uploadFile($obj) {
				
				$errorCode = 0;
				
				$handle = new Upload($_FILES[$obj->uploadField]);
				$handle->no_script = false;
				
				if ($handle->uploaded) {
					$handle->Process($obj->targetDirectory);
					$errorCode = $handle->processed ? 0 : 1;
				}
        		
				$handle->clean();
				
				return $errorCode;
			}
			
			/**
			 *	deleteFile
			 *	- deletes fileName from a location on the server as determined by $obj
			 */
			public function deleteFile($obj) {
				$errorCode = 0;
				return $errorCode;	
			}
			
			
			/**
			 *	getFileName
			 *	- returns a fully-qualified file name from our upload location
			 */
			public function getFileName($obj) {
				$fileName = "https://www.uploadLocation.com/" . $obj->targetDirectory . $obj->fileName;
				return $fileName;			
			}
			
			/**
			 *	doesFileExist
			 */
			public function doesFileExist($obj = NULL) {
				return file_exists($obj->targetDirectory . $obj->fileName) ? 1 : 0;	
			}
		}
?>