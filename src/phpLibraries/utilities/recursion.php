<?

	/**
	 *	php recursion test
	 *
	 *	iterate through a nested structure and reach every simple data type
	 */
	 
	include_once ($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/global/global.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/debug/output.php");	// testing only	
	
	include $_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/utilities/string.php";
	 
	$init = new stdClass();
	$init->errorCode = 0;
    $init->data = array(
					array(	"id" => "43", 
							"content_type" => "2", 
							"brand" => "4", 
							"language" => "en", 
							"active" => "1", 
							"admin_name" => "adventure-time", 
							"display_name" => "Adventure Time", 
							"entry_date_time" => "212-5-3 17:30",
							"edit_date_time" => "212-5-3 17:30",
							"related_group_id" => "adventure-time")
					);
	$init->data[0]["content_details"] = new stdClass();
	$init->data[0]["content_details"]->show_synopsis = "It%27s+ADVENTURE+TIME%21+Come+on%2C+grab+your+friends%2C+we%27ll+go+to+very+distant+lands.+With+Jake+the+dog+and+Finn+the+num%2C+the+fun+will+never+end.+Play+free+online+games+from+the+TV+Show.+Heck+yeah%21+Adventure+Time+with+Finn+%26+Jake+is+totally+mathematical%21+Only+on+Cartoon+Network+Canada.";
	$init->data[0]["content_details"]->home = new stdClass();
	$init->data[0]["content_details"]->home->mega_promo = new stdClass();
	$init->data[0]["content_details"]->home->mega_promo->src = "mega_promo.swf";
	$init->data[0]["content_details"]->home->extras = array(
														array("Cutouts", "test.jpg", "Go Now", "/tv/adventure-time/extras/cutouts/"),
														array("Screensavers", "test.jpg", "Download", "/tv/adventure-time/extras/screensavers/"));
	$init->data[0]["content_details"]->games = new stdClass();
	$init->data[0]["content_details"]->videos = new stdClass();
	
	$init->data[0]["content_details"]->tracking_type = new stdClass();
	$init->data[0]["content_details"] = json_encode($init->data[0]["content_details"]);
	
	//testOutput('obj', $init);
	//testOutput('obj', $init->data[0]["content_details"]);
	
	$data = prepareDataObject($init);
	
	testOutput('obj', $data);
	
	
	
	
	
	
	function prepareDataObject($obj = NULL) {
			
		for ($i = 0; $i < 1; $i++) {
			$data = new stdClass();
			$data = replaceObjBadChars($obj->data[$i]);
		}
		return $data;
	}
		
	function replaceObjBadChars($obj = NULL) {
		//testOutput('obj', $obj);
		$data = new stdClass();
		
		foreach ($obj as $key => $value) {
			if ($key == "content_details" || $key == "tracking_type" && is_object($key)) {
				$value = json_decode($value);
			}
			
			if (is_object($value)) {
				//echo $key . " is object<BR>";
				$data->$key = replaceObjBadChars($value);
			} else if (is_array($value)) {
				//echo $value . " is array<BR>";
				$data->$key = replaceArrBadChars($value);
			} else {
				//echo $value . " is simple type<BR>";
				$data->$key = replaceBadChars($value);	
			}
			
			//echo "<BR><BR>";
		}
		return $data;
	}
	
	function replaceArrBadChars($arr = NULL) {
		foreach ($arr as $key => $value) {
			if (is_array($value)) $key = replaceArrBadChars($value);
			else $key = replaceBadChars($value);
		}
		
		return $arr;
	}
        					
?>