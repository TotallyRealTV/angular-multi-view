<?

	/**
	 *	testBrand
	 *
	 *	this is a sample implementation of BrandVO
	 */
	
	include_once ($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/global/global.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/debug/output.php");	// testing only	
	
	include_once("BrandVO.php");
	
	
	/**
	 *	set our init object
	 */
	$init = new stdClass();
	$init = retrieveObVars($init);

	
	
	$brand = new BrandVO();
	
	
	
	$returnBrandObject = $brand->getBrandData($init);
	
	if ($returnBrandObject == false) {
		echo "unable to locate brand data";	
	} else {
		echo "brand data:";
		testOutput('obj', $returnBrandObject);
	}


?>