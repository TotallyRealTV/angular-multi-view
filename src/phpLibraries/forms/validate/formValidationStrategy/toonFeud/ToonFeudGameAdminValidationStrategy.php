<?

	/**
	 *	GameAdminValidationStrategy.php
	 *
	 *	Created:
	 *	2012-12-18
	 *
	 *	Modified:
	 *	2012-12-18
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- performs validation on adding / updating TOON FEUD game record admin data
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
		include_once(PHP_PATH . "forms/validate/vo/toonFeud/GameAdminMessagingVO.php");
  		
		class ToonFeudGameAdminValidationStrategy extends BaseAdminValidationStrategy implements FormValidationStrategyInterface {
		
			/**
			 *	validateForm
			 *	- iterates through $obj->data and evaluates each by type 
			 *	- each data type check returns either success (errorCode = 0) or an errorCode, which is then used to 
			 *	retrieve an error message that is pushed to an array
			 */	 
			public function validateForm($obj) {
				$errorCode = 0;
				$errorCode = $this->checkAdminName($obj);
				
				if ($errorCode == 0 && $obj->formAction == "add") $errorCode = $this->checkDuplicateEntry($obj);
				
				if (isset($obj->data->start_date) && $obj->data->start_date != "" && $errorCode == 0) $errorCode = $this->checkDateTime($obj->data->start_date);
				if (isset($obj->data->end_date) && $obj->data->end_date != "" && $errorCode == 0) $errorCode = $this->checkDateTime($obj->data->end_date);
				
				// validation passes
				if ($errorCode == 0) {
					// add success message to return data
					$this->message->addMessage($num = $obj->formAction == "add" ? 0 : 1);
				}
				
				$result = new stdClass();
				$result->errorCode = $errorCode;
				$result->message = $this->message->getMessage();
				
				return $result;
			}
			
			protected function generateMessaging() {
				$this->message = new GameAdminMessagingVO();
			}
			
			/**
			 *	checkAdminName
			 *	- checks admin_name to ensure there are no spaces or special characters
			 */
			protected function checkAdminName($obj) {
				$errorCode = 0;
				if (!preg_match('/^[a-z0-9A-Z-]/', $obj->data->game_name)) {
					$errorCode = 4;
					$this->message->addMessage($errorCode);
				}
				return $errorCode;
			}
		}

?>