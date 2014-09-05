<?

	
	/**
	 *	BrandVO
	 *	
	 *	NOTES:
	 *	defines the list of brands in an array, and holds reference to our brand strategy
	 */
	
		include_once('BrandStrategy.php'); 
	
	
		class BrandVO {
			
			private $brands;			//	define brands
			private $brandStrategy;		// 	holds brand strategy
			private $fiscalEnd;		// when a fiscal year ends
			
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				$this->setupProps();
			}
			
			
			/**
			 *	setupProps
			 *	- defines our master brand list
			 */
			private function setupProps() {
				
				$this->brands = array(
									"tt" => array("id" => 0, "display_name" => "Teletoon", "admin_name" => "tt"),
									"retro" => array("id" => 2, "display_name" => "Retro", "admin_name" => "retro"),
									//"night" =>array("id" => 3, "display_name" => "At Night", "admin_name" => "night"),
									"cn" => array("id" => 4, "display_name" => "Cartoon Network", "admin_name" => "cn"),
									"as" => array("id" => 5, "display_name" => "Adult Swim", "admin_name" => "as")
								);
								
				$this->fiscalEnd = date("Y-08-31");
			}
			
			/**
			 *	public access methods
			 */
			
			
			/**
			 *	getBrandData
			 *	- a facade method to its implementing class, this method:
			 *		1. instances $this->brandStrategy
			 *		2. if the strategy is legal, invokes the public bs method getBrandData
			 *		3. returns the result
			 */
			public function getBrandData($obj = NULL) {
				if (!isset($obj->brand) || !array_key_exists($obj->brand, $this->brands)) return false;
				$obj->brandData = $this->brands[$obj->brand];
				
				$this->brandStrategy = new BrandStrategy($obj);
				
				return $this->brandStrategy->getBrandData();
				
			}
			
			/**
			 *	polymorphism to return baseUrl depending on section
			 */
			public function getBaseUrl($type = NULL) {
				return $this->brandStrategy->getBaseUrl($type);	
			}
			
			/**
			 *	returns brand number by virtue of admin_name
			 */
			public function getIntForId($obj) {
				foreach ($this->brands as $brand) {
					if ($brand['admin_name'] == $obj->brand) {
						return $brand['id'];
						break;	
					}
				}
			}
			
			/**
			 *	returns id based on int
			 */
			public function getIdForInt($obj) {
				foreach ($this->brands as $brand) {
					if ($brand['id'] == $obj->brand) {
						return $brand['admin_name'];
						break;	
					}
				}
			}
			
			/**
			 *	returns master brand list to caller
			 */
			public function getBrandsList() {
				return $this->brands;	
			}
			
			public function getFiscalEnd() {
				return $this->fiscalEnd;	
			}
		
			public function getUploadUrl($type = NULL, $size = NULL) {
				return $this->brandStrategy->getUploadUrl($type, $size);	
			}
			
			public function getBaseUploadPath() {
				return $this->brandStrategy->getBaseUploadPath();	
			}
			
			public function getBrandProp($prop = '') {
				return $this->brandStrategy->getBrandProp($prop);	
			}
		}

?>