<?

	/**
	 *	AnalyticsStrategy.php
	 *
	 *	Created:
	 *	2012-04-09
	 *
	 *	Modified:
	 *	2012-04-09
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- this class is the single point of access for deciding which analytics object(s) to return
	 */


	/**
	 * supporting files
	 */

		include_once('AnalyticsStrategyInterface.php');
  		include_once(PHP_PATH . 'site/analytics/analyticsStrategy/Google.php'); 
		include_once(PHP_PATH . 'site/analytics/analyticsStrategy/Omniture.php');
  	
	
	
		class AnalyticsStrategy implements AnalyticsStrategyInterface {
		
			protected $types;			// an object of chosen analytics types
			protected $analytics;		// decorated analytics object
			protected $tracking;		// object of critical tracking data harvested from incoming;
			
			
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
				$this->analytics = new stdClass();
				$this->types = isset ($obj->tracking_type) ? $obj->tracking_type : new stdClass();
			}
			
			/**
			 *	constructTrackingObject
			 *	- accepts current tracking type about to be instanced ($value), as well as our incoming object to return a well-formed object of data critical to instancing
			 *	- a given tracking type
			 */
			private function constructTrackingObject($type, $obj = NULL) {
				$tracking = $obj->brandParameters->trackingProps;
				$tracking->site = $obj->brand;
				$tracking->section = isset($obj->related_group_id) ? $obj->related_group_id : "";
				$tracking->page = $obj->admin_name;
				$tracking->title = $obj->display_name;
				$tracking->type = $type;
				$tracking->language = $obj->language;
				
				return $tracking;	
			}
			
			
			/**
			 *	generate
			 *	- returns required analytics data from strategy pattern
			 */
			public function generate($obj = NULL) {
				foreach ($this->types as $key=>$value) {
					$className = ucfirst($value);
					if (class_exists($className)) {
						$this->tracking = $this->constructTrackingObject($value, $obj);
						$analytics = new $className($this->tracking);
						$this->analytics->$className = $analytics->getAnalyticsData();
					}
				}
				
				return $this->analytics;
			}
		}



?>