<?

	/**
	 *	testUpload
	 *	- tests UploacController
	 */
	 
	 include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/global/global.php");
	 include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/debug/output.php");
	 include_once("UploadController.php");


	// test directory creation in bucket
	$init = new stdClass();
	$init->type = "aws";
	$init->bucketName = "toonfeud";
	$init->targetDirectory = "retro/games/test/";
	$data = new stdClass();
	$data->test = 1;
	$init->tmpFileName = json_encode($data);
	$init->fileName = "scratch.json";
	
	
	
	$errorCode = 0;
	
	$uploadController = new UploadController($init);
	
	/*$dir_info = $uploadController->getDirectoryInfo();
	
	testOutput('obj', $dir_info);
	
	if (empty($dir_info)) {
		echo "GENERATE DIR!";
		$errorCode = $uploadController->generateDirectory();
		echo "errorCode: " . $errorCode;		
	} else {
		echo "DIR ALREADY EXISTS";	
	}*/


	$file_info = $uploadController->getFileInfo();
	
	if (empty($file_info)) {
		$errorCode = $uploadController->generateFile();	
		echo "GENERATE FILE!";	
		echo $errorCode;
		
	} else {
		echo "FILE ALREADY EXISTS";
	}
?>