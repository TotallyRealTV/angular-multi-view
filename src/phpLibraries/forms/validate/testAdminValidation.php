<?

	/**
	 *	testAdminValidation
	 *	- isolated test instance for ValidateFormController package
	 *
	 *	Cases:
	 *	1. Games Admin
	 *	expected date object:
	 {
			"display_name":"My Test Game",
			"admin_name":"myTestGame",
			"language":"en",
			"brand":"cartoonNetwork",
			"related_group_id":"test_game_group",
			"content_type":"1",
			"content_details":{
				"templateType":"embed",
				"embedType":"flash",
				"version":"as3",
				"fileName":"game.swf",
				"width":"700",
				"height":"470",
				"params":"xVar:myVal,anotherVar:anotherVal"
			},
			"active":0,
			"entry_date_time":"2012-03-29 20:05:06",
			"edit_date_time":"2012-03-29 20:05:06",
			"start_date_time":"",
			"end_date_time":""
		}
	 	
	 */


	// includes
	include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/debug/output.php");	// testing only	
	include_once($_SERVER['DOCUMENT_ROOT'] . "/api/config/config.php");
	//include_once($_SERVER['DOCUMENT_ROOT'] . "/api/config/contestEntry/config.php");
	include_once("ValidateFormController.php");


	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', 'g0j1ra');
	define('DB_DATABASE', 'CartoonNetwork');
	
	define('DB_USER_FULL', 'root');
	define('DB_PASS_FULL', 'g0j1ra');


	/**
	 *	sample implementation: contest entry
	 */
	$query = new stdClass();
	$query->data = new stdClass();
	$query->data->display_name = "My Test Game";
	$query->data->admin_name = "myTestGame2";
	$query->data->brand = "cartoonNetwork";
	$query->data->related_group_id = "test_game_group";
	$query->data->content_type = "1";
	$query->data->start_date_time = "2012-03-29 23:12:34";
	$query->data->end_date_time = "2012-04-12 13:12:34";
	$query->data->content_details = new stdClass();
	$query->data->content_details->template_type = "embed";
	$query->data->content_details->embed_type = "flash";
	$query->data->content_details->version = "as3";
	$query->data->content_details->file_name = "game.unity3d";
	$query->data->content_details->width = "700";
	$query->data->content_details->height = "470";
	$query->data->content_details->params = "xVar:myVal,anotherVar:anotherVal";
						
	$query->dbTable = "content";
	$query->validationType = "adminAdd"; 
	
	// conditionalRange is set in a specific contest VO class
	$query->conditionalRange = new stdClass();
	$query->conditionalRange->admin_name = $query->data->admin_name;
	 
	$controller = new ValidateFormController($query);
	$result = $controller->validateForm();
	
	testOutput('obj', $result);

?>