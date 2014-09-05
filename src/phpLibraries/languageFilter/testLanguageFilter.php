<?

	/**
	 *	testLanguageFilter.php
	 *
	 *	Created:
	 *	2012-02-07
	 *
	 *	Modified:
	 *	2012-02-07
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- this file demonstrates a sample implementation of LanguageFilter.php
	 *
	 *	Sample Usage:
	 *	http://localhost/memeGenerator/php/languageFilter/testLanguageFilter.php?brand=night&filterType=associative&textTop=This%20is%20the%20top%20text&textBottom=This%20is%20the%20bottom%20text%20shit
	 *	
	 */
	
	
	
	
	 
	 
	include "LanguageFilter.php";
	
	
	include $_SERVER['DOCUMENT_ROOT'] . "/teletoon4/includes/global/global.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/teletoon4/includes/debug/output.php";
	
	
	$mtime = microtime(); 
    $mtime = explode(" ",$mtime); 
    $mtime = $mtime[1] + $mtime[0]; 
    $starttime = $mtime; 
	
	
	
	/** BEGIN LanguageFilter implementation example **/
	 
	// define init object . NOTE: dataToCheck & brand are required to instance this class
	$init = (object) NULL;
	$init = retrieveObVars($init);
	$init->dataToCheck = array();
	array_push($init->dataToCheck, $init->textTop);
	array_push($init->dataToCheck, $init->textBottom);
	
	// compose class name
	$className = ucfirst($init->brand) . 'LanguageFilter';
	// instance [Brand]LanguageFilter.php
	$languageFilter = new $className($init);
	// invoke filterData method. Returns errorCode = 0 (no bad language found) or 1 (wash your fucking mouth out with soap).
	$errorCode = $languageFilter->filterData();
	echo "errorCode: " . $errorCode . "<BR><BR>";
	
	// destroy our class instance (you only need to do this if you're running a lengthy script)
	$languageFilter->__destruct();
    unset($languageFilter);
	
	/** END LanguageFilter implementation example **/
	
	
	
	
	
	$mtime = microtime(); 
	$mtime = explode(" ",$mtime); 
   	$mtime = $mtime[1] + $mtime[0]; 
   	$endtime = $mtime; 
   	$totaltime = ($endtime - $starttime); 
   	echo "This page was created in ".$totaltime." seconds";
	
	
?>