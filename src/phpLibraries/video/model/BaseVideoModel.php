<?

	/**
	 *	BaseVideoModel
	 *
	 *	This class is the basic implementation of of a model class instantiated through VideoApiController.
	 *	It provides the properties and methods common to all video API types
	 *
	 *	Initialization expects:
	 *	brand (required)
	 *
	 *	Date Created:	2012-08-02
	 *	Date Modified:	2012-08-02
	 *
	 *	Author:	Jonathan Blackburn for TELETOON Canada Inc.
	 */
	 
	 include_once(PHP_PATH . "site/brand/BrandVO.php");
	 
	 class BaseVideoModel {
		
		protected $api;							//	holds API instance
		protected $brand;						//	holds brand instance
		protected $brandParameters;				//	holds brand-specific data, in this case pertaining to specific caching settings	 
		protected $messaging;
		 
		/**
		 *	setupProps
		 *	Instantiate classes required in this model
		 */
		protected function setupProps($obj = NULL) {
			$this->brand = new BrandVO();
			$this->brandParameters = $this->brand->getBrandData($obj);
			
			$this->props = new stdClass();
			$this->props->type = isset($obj->type) ? $obj->type : "brightCove";
		}
		
		public function getMessage() {
			return $this->messaging->getMessage();	
		}
		
		public function addMessage($num) {
			return $this->messaging->addMessage($num);	
		}
	}




?>