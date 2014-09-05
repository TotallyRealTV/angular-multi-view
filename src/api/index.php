<?php 
	
	
	/**
	 *	Jonathan Blackburn API
	 *
	 *	This is the single POA that all callers should target (ie: "/api/"), passing requisite properties (see each controller) to route request
	 *
	 *	Date Created:	2013-12-30
	 *	Date Modified:	2013-12-30
	 *
	 *	Created by Jonathan Blackburn for Jonathan Blackburn
	 */
	 
	
	
	/**
	 *	include files
	 */
		include_once("config/config.php");
		include_once(ROOT_PATH . "controller/ApiController.php");
	
	/**
	 *	create object from $_REQUEST
	 */
	 	$init = new stdClass();
		$init = retrieveObVars($init);
		
		$controller = new ApiController($init);
?>