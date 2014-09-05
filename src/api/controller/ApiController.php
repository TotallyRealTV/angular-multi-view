<?php

	/**
	 *	ApiController
	 *
	 *	routes all data requests, and corresponding views for TELETOON API.
	 *
	 *	Critical vars for this controller are:
	 *	- section (the portion of the API you wish to access)
	 *	- section (what you specifically want to do in said section)
	 *
	 *	1. High Scores:
	 *		- create a new game play
	 *		- update an existing game play with a score
	 *		- return a list of high-scores
	 *
	 */
	
	
	include_once("BaseController.php");
	include_once(ROOT_PATH . "model/vo/MessagingVO.php");
	
	class ApiController {
		
		private $controller;	// 	holds page-specific controller instance
		private $messaging;		//	holds error / success messaging
		
		
		/**
		 *	constructor
		 *	- instance the required controller, based on $obj->section
		 */
		public function __construct($obj)  {  
			$this->generateMessaging();
			$this->generateController($obj);
		} 
		
		/**
		 *	generateMessaging
		 *	- instances MessagingVO so that we can retrieve an appropriate message should the $controller not correctly instance
		 */
		private function generateMessaging() {
			$this->messaging = new MessagingVO();	
		}
		
		/**
		 *	instance a Controller for a specific portion of the API
		 *
		 *	Accepts:
		 *	$obj
		 */
		private function generateController($obj) {
			
			$section = isset($obj->section) && $obj->section != "" ? $obj->section : "";
			$className = ucfirst($obj->section) . "Controller";
			
			include_once($section . "/" . $className . ".php");
			
			// unset section & action, as they're scoped
			unset($obj->section);
			
			if ($section != "") {
				$this->controller = new $className($obj);
			} else {
				echo $this->messaging->getMessage(0, $obj->language);
			}
			
		}
	}

?>