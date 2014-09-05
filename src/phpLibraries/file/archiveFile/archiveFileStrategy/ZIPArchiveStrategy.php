<?

	/**
	 *	ZIPArchiveStrategy.php
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
	 *	- archives all data references contained in incoming obj into a ZIP file
	 *
	 *	$obj expects:
	 *	- data:	array of file name references
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('ArchiveStrategyInterface.php');
 		include_once('BaseArchiveStrategy.php');
  		
		class ZIPArchiveStrategy extends BaseArchiveStrategy implements ArchiveStrategyInterface {
		
			/**
			 *	archiveFiles
			 *	- creates a ZIP archive
			 *	- iterates through data, opening each file URL and then MOVES it into our new zip
			 *	- returns error code (0 = success, 1 = error)
			 */	 
			public function archiveFiles($obj) {
				
				$errorCode = 0;
				$valid_files = array();
				
				if (file_exists($obj->archiveName) && !$obj->overwrite) { 
					$errorCode = 1; 
				} else {
				
					foreach ($obj->data as $key=>$value) {
						if(file_exists($value)) {
							$valid_files[] = $value;
						}	
					}
					
					if (count($valid_files)) {
						
						$zip = new ZipArchive();
						
						if($zip->open($obj->targetDirectory . $obj->archiveName, $obj->overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
							$errorCode = 2; 
						} else {
							
							//add the files, but make sure we have a local name for the archive itself to avoid writing entire directory structure
							foreach($valid_files as $file) {
								$tmp = explode("/", $file);
								$fileWithoutDirectory = $tmp[count($tmp) - 1];
								$zip->addFile($file, $fileWithoutDirectory);
							}
							
							//debug
							//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
			
							$zip->close();
						}
					} else {
						$errorCode = 3; 
					}
					
				}
				
				return $errorCode;
			}
			
			
			
		
			/**
			 *	deleteFile
			 *	- deletes archive from server
			 */
			public function deleteFile($obj) {
				
				$errorCode = 0;
				
				
				
				return $errorCode;	
			}
			
			/**
			 *	getFileName
			 *	- returns a fully-qualified file name from an amazon bucket
			 */
			public function getFileName($obj) {
				$fileName = '';
				return $fileName;			
			}
		}

?>