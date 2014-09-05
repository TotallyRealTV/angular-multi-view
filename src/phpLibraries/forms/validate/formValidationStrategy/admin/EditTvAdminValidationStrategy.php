<?

	/**
	 *	EditTvAdminValidationStrategy.php
	 *
	 *	Created:
	 *	2012-04-25
	 *
	 *	Modified:
	 *	2012-04-25
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- performs validation on updating tv record admin data
	 *
	 *	$obj expects:
	 *	- data:	array of submitted form data
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once(PHP_PATH . "forms/validate/formValidationStrategy/FormValidationStrategyInterface.php");
 		include_once(PHP_PATH . "forms/validate/formValidationStrategy/admin/BaseAdminValidationStrategy.php");
		include_once(PHP_PATH . "forms/validate/vo/admin/TvAdminMessagingVO.php");
  		
		class EditTvAdminValidationStrategy extends BaseAdminValidationStrategy implements FormValidationStrategyInterface {
		
			/**
			 *	validateForm
			 *	- iterates through $obj->data and evaluates each by type 
			 *	- each data type check returns either success (errorCode = 0) or an errorCode, which is then used to 
			 *	retrieve an error message that is pushed to an array
			 */	 
			public function validateForm($obj) {
				$errorCode = 0;
				
				// check admin_name integrity
				if (isset($obj->admin_name)) {
					$errorCode = $this->checkAdminName($obj);
				} else if (isset($obj->data->extra_title)) {
					$errorCode = $this->checkExtras($obj);	
				}
				
				// check date / time fields
				if (isset($obj->data->start_date_time) && $obj->data->start_date_time != "" && $errorCode == 0) $errorCode = $this->checkDateTime($obj->data->start_date_time);
				if (isset($obj->data->end_date_time) && $obj->data->end_date_time != "" && $errorCode == 0) $errorCode = $this->checkDateTime($obj->data->end_date_time);
				if (isset($obj->data->edit_date_time) && $obj->data->edit_date_time != "" && $errorCode == 0) $errorCode = $this->checkDateTime($obj->data->edit_date_time);
				
				// validation passes
				if ($errorCode == 0) {
					// add success message to return data
					$this->message->addMessage(1);
				} else {
					$this->message->addMessage($errorCode);	
				}
				
				$result = new stdClass();
				$result->errorCode = $errorCode;
				$result->message = $this->message->getMessage();
				
				return $result;
			}
			
			protected function generateMessaging() {
				$this->message = new TvAdminMessagingVO();
			}
			
			/**
			 *	checkExtras
			 *	- if an extra object exists, make sure all fields are populated
			 */
			protected function checkExtras($obj) {
				$errorCode = 0;
				$count = count($obj->data->extra_title);
				for ($i = 0; $i < $count; $i++) {
					if (isset($obj->data->extra_img_post[$i])) {
						if ($obj->data->extra_img_post[$i] == "") $errorCode = 8;
					}
					
					if (isset($obj->data->extra_img_post_over[$i])) {
						if ($obj->data->extra_img_post_over[$i] == "") $errorCode = 8;	
					}
					
					if (isset($obj->data->extra_button_text[$i])) {
						if ($obj->data->extra_button_text[$i] == "") $errorCode = 8;
					}
					
					if (isset($obj->data->extra_url[$i])) {
						if ($obj->data->extra_url[$i] == "") $errorCode = 8;
					}
				}
				
				return $errorCode;
			}
		}

?>