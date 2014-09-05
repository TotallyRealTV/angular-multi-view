<?php

	/**
	 *	BaseModel
	 *
	 *	Created:
	 *	2013-12-30
	 *
	 *	Modified:
	 *	2013-12-30
	 *
	 *	Created by:
	 *	Jonathan Blackburn.
	 *
	 *	Purpose:
	 *	- this class provides all properties and methods common to all Model implementations
	 *
	 *	
	 */
	
	include_once("vo/BaseVO.php");

	class BaseModel {
		
		protected $errorCode;				// has business logic succeeded?
		protected $props;		 				// stores incoming properties
		
		/**
		 * setupProps
		 */
		protected function setupProps($obj = NULL) {
				$this->errorCode = 0;
				$this->props = new stdClass();
		}
		
		/**
		 * get
		 */
		public function get($prop) {
			   return !isset($this->$prop) ? NULL : $this->$prop;
		}
		
		/**
		 * set
		 */
		public function set($prop, $val) {
				 $this->$prop = !isset($this->$prop) ? NULL : $val;
		} 
	}

?>