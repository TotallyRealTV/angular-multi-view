<?

	/**
	 *	configure your local phpMyAdmin settings here
	 */
	define('DB_HOST', 'localhost');
	define('DB_HOST_ALT', 'localhost');
	define('DB_USER', 'root');		//
	define('DB_PASS', 'g0j1ra');
	
	define('DB_USER_FULL', 'root');
	define('DB_PASS_FULL', 'g0j1ra');
	
	/**
	 *	path settings
	 */
	define("PHP_PATH", $_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/");
	
	include_once(PHP_PATH . "debug/output.php");
	
?>