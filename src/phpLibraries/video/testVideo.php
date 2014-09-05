<?

	/**
	 *	testVideo
	 *
	 *	this is a sample implementation of our Video API
	 */
	
	ini_set('max_input_time', 600);
	ini_set('max_execution_time', 600);
	ini_set('memory_limit', '3072M');
	ini_set('upload_max_filesize', '2048M');
	ini_set('post_max_size', '2096M');

	
	
	include_once($_SERVER['DOCUMENT_ROOT'] . "/teletoon/admin/contentAdmin/config/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/global/global.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/debug/output.php");	// testing only	
	
	include_once("VideoApiController.php");
	
	
	/**
	 *	set our init object
	 */
	$init = new stdClass();
	$init = retrieveObVars($init);

	/**
	 *	init object
	 */
	$init->type = "brightCove";
	$init->cacheType = "file";
	$init->brand = "cn";
	
	$videoController = new VideoApiController($init);
	
	//$videos = $videoController->findAllVideos();
	//testOutput('obj', $videos);
	
	$init->videoFile = isset($init->videoFile) ? $init->videoFile : "test-large-video.mpg";
	
	$videoItem = new stdClass();
	$videoItem->display_name = "TEST REMOTE CURL VIDEO @" . date("H:i:s");
	$videoItem->video_description = "This is a test";
	$videoItem->video_refid = "demo-test-video-en";
	//$video->video_tags = "language=en,brand=cn,title=test video";
	
	// create standard tags
	$tags = new stdClass();
	$tags->brand = "cn";
	$tags->language = "en";
	$tags->show = "demo";
	$tags->title = "Test Video";
	$tags->type = "clip";
	$tags = $videoController->createOptionalTags("custom tag =1,custom tag =2", $tags);
	
	testOutput('obj', $tags);
	
	$videoItem->video_tags = array();
	$videoItem->video_tags = $videoController->createStandardTags($tags);
	testOutput('arr', $videoItem->video_tags);
	
	
	$videoItem->file_location = $_SERVER['DOCUMENT_ROOT'] . "/tempUploads/" . $init->videoFile;
	
	$id = $videoController->createVideo($videoItem);
	
	echo "video ID: " . $id . "<br>";
	
	/*function checkStatus($id, $videoController) {
		$status = new stdClass();
		$status->id = $id;
		$status->type = 'video';
		$statusResult = $videoController->getStatus($status);
		
		if ($statusResult == "PROCESSING") {
			sleep(5);
			checkStatus($id, $videoController);
		} else {
			echo $statusResult;	
		}
	}
	
	echo "PROCESSING<br>";
	checkStatus($id, $videoController);*/

?>