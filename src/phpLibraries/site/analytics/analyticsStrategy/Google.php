<?

	/**
	 *	Google.php
	 *
	 *	Created:
	 *	2012-04-12
	 *
	 *	Modified:
	 *	2012-04-12
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- encapsulates unique data associated with Google Analytics
	 */


	/**
	 * supporting files
	 */

		include_once('BaseAnalytics.php');
  	
	
	
		class Google extends BaseAnalytics {
		
		
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				parent::setupProps($obj);
				$this->populateAnalytics($obj);
			}
			
			/**
			 *	populateAnalytics
			 *	- performs string replacements on google analytics template and returns result
			 */
			protected function populateAnalytics($obj = NULL) {
				switch ($obj->site) {
					case "retro":
						$account = 'account_' . $obj->language;
						$this->analyticsData = str_replace("#tracking_account_id#", $obj->google->$account, $this->analyticsData);
					break;
					
					case "cn":
					case "as":
					default:
						$this->analyticsData = str_replace("#tracking_account_id#", $obj->googleAccount, $this->analyticsData);
					break;
				}
			}
		}



?>