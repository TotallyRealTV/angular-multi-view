<?

	/**
	 *	EditGamesAdminValidationStrategy.php
	 *
	 *	Created:
	 *	2012-04-02
	 *
	 *	Modified:
	 *	2012-04-02
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- performs validation on updating game record admin data
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
		include_once(PHP_PATH . "forms/validate/vo/admin/GamesAdminMessagingVO.php");
  		
		class EditGamesAdminValidationStrategy extends BaseAdminValidationStrategy implements FormValidationStrategyInterface {
		
			/**
			 *	validateForm
			 *	- iterates through $obj->data and evaluates each by type 
			 *	- each data type check returns either success (errorCode = 0) or an errorCode, which is then used to 
			 *	retrieve an error message that is pushed to an array
			 */	 
			public function validateForm($obj) {
				$errorCode = 0;
				
				// check admin_name integrity
				if ($errorCode == 0) $errorCode = $this->checkAdminName($obj);
				
				// check date / time fields
				if (isset($obj->data->start_date_time) && $obj->data->start_date_time != "" && $errorCode == 0) $errorCode = $this->checkDateTime($obj->data->start_date_time);
				if (isset($obj->data->end_date_time) && $obj->data->end_date_time != "" && $errorCode == 0) $errorCode = $this->checkDateTime($obj->data->end_date_time);
				if (isset($obj->data->edit_date_time) && $obj->data->edit_date_time != "" && $errorCode == 0) $errorCode = $this->checkDateTime($obj->data->edit_date_time);
				
				// check file name
				//if ($errorCode == 0 && $obj->data->content_details->template_type == "embed") $errorCode = $this->checkFileName($obj);
				
				// check file dimensions (if appropriate)
				if (isset($obj->data->content_details->width) && $errorCode == 0) $errorCode = $this->checkNumber($obj->data->content_details->width);
				if (isset($obj->data->content_details->height) && $errorCode == 0) $errorCode = $this->checkNumber($obj->data->content_details->height);
				
				// validation passes
				if ($errorCode == 0) {
					// add success message to return data
					$this->message->addMessage(1);
				}
				
				$result = new stdClass();
				$result->errorCode = $errorCode;
				$result->message = $this->message->getMessage();
				
				return $result;
			}
			
			protected function generateMessaging() {
				$this->message = new GamesAdminMessagingVO();
			}
		}

?>