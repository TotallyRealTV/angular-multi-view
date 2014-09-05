<?

	/**
	 *	BaseAnalytics.php
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
	 *	- common methods and properties that all subclasses implement
	 */


	/**
	 * supporting files
	 */

		class BaseAnalytics {
		
			/**
			 *	class properties
			 */
			protected $analyticsTemplate;		// 	analytics template file
			protected $analyticsData;			//	final analytics data to write to page
			
			
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
			
			}
			
			/**
			 *	defines $this->brand
			 */
			protected function setupProps($obj = NULL) {
				$this->analyticsTemplate = ROOT_PATH . "model/games/templates/analytics/" . strtolower($obj->type) . ".txt";
				$this->analyticsData = file_get_contents($this->analyticsTemplate);
			}
			
			public function getAnalyticsData() {
				return $this->analyticsData;	
			}
		}



?>