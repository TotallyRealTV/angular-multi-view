<?php

	
	/**-
		
		directory.php
		
		NOTES:
		Search, create, delete directory methods
	
		----------------------------------------------------
	*/
	
		include_once(PHP_PATH . "utilities/array.php");
		
		/**
		 *	getFilesFromDir
		 *	- recursively checks $dir for files, returns an array
		 */
		function getFilesFromDir($dir) { 
			$files = array();
			 
		  		if ($handle = opendir($dir)) { 
					while (false !== ($file = readdir($handle))) { 
						if ($file != "." && $file != "..") { 
							if(is_dir($dir.'/'.$file)) { 
								$dir2 = $dir.'/'.$file; 
								$files[] = getFilesFromDir($dir2); 
							} else { 
					  			$files[] = $dir.$file; 
							} 
						} 
					} 
					closedir($handle); 
		  		}
				 
			return array_flat($files); 
		} 
	
?>