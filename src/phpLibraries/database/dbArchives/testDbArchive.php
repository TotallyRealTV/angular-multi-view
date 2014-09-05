<?

	/**
	 *	testDbArchive
	 *
	 *	informal unit tests for DbArchiveController
	 *
	 */

	include_once($_SERVER['DOCUMENT_ROOT'] . "/teletoon/admin/contentAdmin/config/config.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/global/global.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/debug/output.php");	// testing only
	
	include_once(PHP_PATH . "database/dbArchives/DbArchiveController.php");


	/**
	 *	grab $_POST / $_REQUEST
	 */
	$vars = new stdClass(); 
	$vars = retrieveObVars($vars);
	$vars->testCases = array('correct', 'failControllerType', 'failBrandType');
	$vars->fiscalYear = isset($vars->fiscalYear) ? $vars->fiscalYear : "2012";
	$vars->brand = isset($vars->brand) ? $vars->brand : "cn";
	
	/**
	 *	test cases
	 */
	
	$output = "TEST CASES TO RUN (Brand: " . $vars->brand . ", FY: " . $vars->fiscalYear . "):<BR>"; 
	
	$init = new stdClass();
	
	for ($i = 0; $i < count($vars->testCases); $i++) {
		$output .= "<A HREF=\"?testCase=".$vars->testCases[$i]."\">".$vars->testCases[$i]."</A><BR>";	
	}
	
	echo $output . "<BR><BR><BR><BR><BR>";
	
	
	if (isset($vars->testCase)) {
		
		echo "RESULTS OF TEST CASE: " . $vars->testCase . "<BR><BR>";
		
		switch ($vars->testCase) {
	
			case "correct":
				$init->type = "gameDbTable";
				$init->fiscalYear = $vars->fiscalYear;		// 2010 - 2013
				$init->brand = $vars->brand;
				executeCorrectTest($init);
			break;
			
			case "failControllerType":
				$init->type = "badController";
				$init->fiscalYear = $vars->fiscalYear;		// 2010 - 2013
				$init->brand = $vars->brand;
				executeControllerFailTest($init);
			break;
			
			case "failBrandType":
				$init->type = "gameDbTable";
				$init->fiscalYear = $vars->fiscalYear;	// 2010 - 2013
				$init->brand = "xx";
				executeBrandFailTest($init);
			break;
			
			default:
			
			break;
		}
	}
	
	/**
	 *	Testing methods
	 */
	function executeCorrectTest($init) {
		// instance
		$dbArchive = new DbArchiveController($init);
		
		// check status
		$dbArchive->message = $dbArchive->getStatus();
		echo 'TEST CONTROLLER STATUS: ' . $dbArchive->message . "<BR><BR>";
	
		// executeArchiveOperation
		$archiveResult = $dbArchive->executeArchiveOperation();	
		echo 'ARCHIVE OPERATION RESULT: ' . $archiveResult->message. '<BR><BR>';
	}

	function executeControllerFailTest($init) {
		// instance
		$dbArchive = new DbArchiveController($init);
		
		// check status
		$dbArchive->message = $dbArchive->getStatus();
		echo 'TEST CONTROLLER STATUS: ' . $dbArchive->message . "<BR><BR>";
	}
	
	function executeBrandFailTest($init) {
		// instance
		$dbArchive = new DbArchiveController($init);
		
		// check status
		$dbArchive->message = $dbArchive->getStatus();
		echo 'TEST CONTROLLER STATUS: ' . $dbArchive->message . "<BR><BR>";
		
		// executeArchiveOperation
		$archiveResult = $dbArchive->executeArchiveOperation();
		echo 'TEST BRAND STATUS: ' . $archiveResult->message . "<BR><BR>";
	}
	
	function executeYearFailTest($init) {
		// instance
		$dbArchive = new DbArchiveController($init);
		
		// check status
		$dbArchive->message = $dbArchive->getStatus();
		echo 'TEST CONTROLLER STATUS: ' . $dbArchive->message . "<BR><BR>";
		
		// executeArchiveOperation
		$archiveResult = $dbArchive->executeArchiveOperation();
		echo 'TEST YEAR STATUS: ' . $archiveResult->message . "<BR><BR>";
	}

?>