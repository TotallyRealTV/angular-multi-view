<?

	/**
	 *	Omniture.php
	 *
	 *	Created:
	 *	2012-04-24
	 *
	 *	Modified:
	 *	2012-04-24
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- encapsulates unique data associated with Site Catalyst
	 */


	/**
	 * supporting files
	 */

		include_once('BaseAnalytics.php');
  	
	
	
		class Omniture extends BaseAnalytics {
		
		
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
				//testOutput('obj', $obj);
				//$this->analyticsData = str_replace("#tracking_account_id#", $obj->googleAccount, $this->analyticsData);
			}
		
		}



?>