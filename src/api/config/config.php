<?php

	
	/*
		-----------------------------------------------------
		
		config.php
		
		NOTES:
		sets JB API common values
	
		----------------------------------------------------
	*/
	
		
		
		/*
			-----------------------------------------------------	
			critical paths
			----------------------------------------------------
		*/
			
			// path to root directory of meme generator admin
			define('ROOT_PATH', "/home/a9592706/public_html/api/");
			
			// app root
			define('APP_PATH', "/home/a9592706/public_html/");
			
			// path to root directory of php helper functions
			define("PHP_PATH", "/home/a9592706/public_html/phpLibraries/");
			
			
		/*
			-----------------------------------------------------	
			php helper includes
			----------------------------------------------------
		*/
		
			include_once(PHP_PATH . "global/global.php");
			include_once(PHP_PATH . "debug/output.php");
?>