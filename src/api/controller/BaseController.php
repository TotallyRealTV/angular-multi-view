<?php

	/**
	 *	BaseController
	 *
	 *	provides the base functionality for all TELETOON API controllers
	 *
	 */
	
	class BaseController {
		
		protected $model;			//	the model for a controller
		protected $action;			// 	the action specified by a submitted module
		
		
		/**
		 *	constructor
		 *	- sets the properties common to all controllers
		 *	- 
		 */
		public function __construct($obj = NULL)  {  
			
		}
		
		/**
		 *	setupProps
		 *	- we set default values for formAction and section as they're used across all controllers
		 *	- subclass implement their unique props as required
		 */
		protected function setupProps($obj = NULL) {
			$this->action = isset($obj->action) ? strtolower($obj->action) : "";
			$this->output = new stdClass();
			
			unset($obj->action);
			return $obj;
		}
		
		
		/**
		 *	instances the model associated with each controller
		 *	NOTE: do not implement this method. Only subclasses should implement this methods
		 */
		protected function generate($obj = NULL) {
			$this->messaging = new MessagingVO();
		}
	}

?>