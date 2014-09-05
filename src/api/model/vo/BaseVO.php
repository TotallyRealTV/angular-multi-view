<?php
	/**
	 *	BaseVO.php
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
	 *	- this class provides the basic implementation to which all Value Objects must conform
	 *
	 *	
	 */
	
	class BaseVO {
	
		protected $language;		//	holds language version
		protected $props;				//	an object holding submitted data (rather than properties matching specific table fields)
		protected $dbTable;			//	holds our dbTable (set in a specific subclass)
		
		
		/**
		 *	setupProps
		 *	- set properties common to all VO classes
		 */	
		protected function setupProps($obj = NULL) {
				$this->language = "en";
				$this->props = isset($obj) && $obj != NULL ? $this->assignProps($obj) : new stdClass();	
		}
		
		/**
		 * get
		 */
		public function get($prop) {
			   return !property_exists($this->$prop) ? NULL : $this->$prop;
		}
		
		/**
		 * set
		 */
		public function set($prop, $val) {
				 $this->$prop = !property_exists($this->$prop) ? NULL : $val;
		}
	}

?>