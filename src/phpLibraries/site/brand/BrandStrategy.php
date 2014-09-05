<?

	/**
	 *	BrandStrategy.php
	 *
	 *	Created:
	 *	2012-03-23
	 *
	 *	Modified:
	 *	2012-03-23
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- this class is the single point of access for deciding which brand object to return. Should only be implemented by /phpLibraries/site/brand/BrandVO.php
	 */


	/**
	 * supporting files
	 */

		include_once('BrandStrategyInterface.php');
  		include_once('brandStrategy/CnBrand.php'); 
		include_once('brandStrategy/TtBrand.php');
		include_once('brandStrategy/RetroBrand.php');
		include_once('brandStrategy/AsBrand.php');
  	
	
	
		class BrandStrategy implements BrandStrategyInterface {
		
			protected $brandData;		// stored from implementing class
			protected $brand;			// decorated object
			protected $language;
			protected $exportAction;
			
			
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				$this->setupProps($obj);
			}
			
			
			/**
			 *	setupProps
			 *	- set the critical properties required for our Brand Decorator
			 */
			private function setupProps($obj = NULL) {
				$this->brandData = isset($obj->brandData) ? $obj->brandData : NULL;
				$this->language = isset($obj->language) ? $obj->language : "en";
				$this->exportAction = isset($obj->exportAction) && $obj->exportAction != NULL ? $obj->exportAction : "";
			}
				
			
			/**
			 *	public access
			 */
			 
			/**
			 *	getBrandData
			 *	- checks to see if a class with the corresponding brand name exists. Instantiates & returns brand data if yes, returns false if no
			 */
			public function getBrandData() {
				$className = isset($this->brandData['admin_name']) && $this->brandData['admin_name'] != "" ? ucfirst($this->brandData['admin_name']) . "Brand" : "";
				if (class_exists($className)) {
					$this->brandData['language'] = $this->language;
					$this->brandData['exportAction'] = $this->exportAction;
					$this->brand = new $className($this->brandData);
					return $this->brand->getData();	
				} else {
					return false;
				}
			}
			
			
			public function getBaseUrl($type = NULL) {
				return $this->brand->getBaseUrl($type);
			}
			
			public function getUploadUrl($type = NULL, $size = NULL) {
				return $this->brand->getUploadUrl($type, $size);	
			}
			
			public function getBaseUploadPath() {
				return $this->brand->getBaseUploadPath();	
			}
			
			public function getBrandProp($prop = '') {
				return $this->brand->getBrandProp($prop);	
			}
		}



?>