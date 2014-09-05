<?

	/**
	 *	testValidation
	 *	- isolated test instance for ValidateFormController package
	 *
	 *	Cases:
	 *	1. ContestEntry
	 *	expected array of data:
	 	$data = array(	$query->data->fname = Jonathan
	 					$query->data->lname = Blackburn;
						$query->data->email = jonathan.m.blackburn%40email.com;
						$query->data->phone = 416-951-7088;
						$query->data->province = NU;
						$query->data->age = 37;
						$query->data->gender = M;
						$query->data->extras2 = Y;
						$query->data->type = regular;
						$query->data->language = en;
						$query->data->extras2 = ;
						$query->data->UPC = ")
					);
	 */


	// includes
	include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/debug/output.php");	// testing only	
	include_once($_SERVER['DOCUMENT_ROOT'] . "/api/config/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/api/config/contestEntry/config.php");
	include_once("ValidateFormController.php");



	/**
	 *	sample implementation: contest entry
	 */
	$query = new stdClass();
	$query->data = new stdClass();
	$query->data->displayName = "jonathan";
	$query->data->fname = "Jonathan";
	$query->data->lname = "Blackburn";
	$query->data->email = "jonathan.m.blackburn@gmail.com";
	$query->data->phone = "416-951-7088";
	$query->data->province = "QC";
	$query->data->age = "13";
	$query->data->gender = "M";
	$query->data->extras2 = "Y";
	$query->data->type = "regular";
	$query->data->language = "en";
	$query->data->extras2 = "";
	$query->data->UPC = "";
						
	$query->dbTable = "2012_03_testContest";
	$query->validationType = "contestEntry"; 
	
	// conditionalRange is set in a specific contest VO class
	$query->conditionalRange = new stdClass();
	$query->conditionalRange->phone = $query->data->phone;
	$query->conditionalRange->displayName = $query->data->displayName;
	$query->conditionalRange->dateTime = date("Y-m-d");
	$query->conditionalRange->type = $query->data->type;
	 
	$controller = new ValidateFormController($query);
	$result = $controller->validateForm();
	
	testOutput('obj', $result);

?>