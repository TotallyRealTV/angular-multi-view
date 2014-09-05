<?	
	/**	 
	 *	testHtAccessRulesStrategy	 
	 *	 
	 *	provides unit testing for the HtAccessRuleStrategy class package	 
	 *	 
	 */	 	

	include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/utilities/string.php");	
	include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/global/global.php");		
	include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/debug/output.php");	
	include_once($_SERVER['DOCUMENT_ROOT'] . "/api/config/config.php");
	
	
	include_once("HtAccessRuleStrategy.php");
	
	$dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : "C:/xampp/htdocs/cartoonnetwork/games/";
	$section = isset($_REQUEST['section']) ? $_REQUEST['section'] : "games";
	$directories = readDirectory($dir);
	$finalDirectories = readSubDirectory($directories, $dir);
	
	
	$init = new stdClass();	
	$init->directories = $finalDirectories;
	
	$init->brand = "cn";
	$init->section = $section;
	
	$rulesStrategy = new HtAccessRuleStrategy($init);
	$accessRules = $rulesStrategy->getRules();
	
	echo $accessRules;
	
	
	
	function readDirectory($dir){ 
		  $dh = opendir($dir); 
		  $files = array();
		  
		  while (($file = readdir($dh)) !== false) { 
			  if($file !== '.' && $file !== '..' && (!contains(".", $file))) { 
				  $files[] = $file; 
			  }
		  }
		  return $files; 
	  } 
	  
	  function readSubDirectory($arr, $dir) {
		  $finalFiles = array();
		  
		  for ($i = 0; $i < count($arr); $i++) {
			  $dh = opendir($dir . $arr[$i]);
			  $files = array();
			  while (($file = readdir($dh)) !== false) { 
				  if ($file !== '.' && $file !== '..' && (!contains(".", $file))) {
					  $files[] = $file;	
				  }
			  }
			  
			  array_push($finalFiles, array($arr[$i], $files));			
		  }
		  
		  return $finalFiles;
	  }
	
	
	?>