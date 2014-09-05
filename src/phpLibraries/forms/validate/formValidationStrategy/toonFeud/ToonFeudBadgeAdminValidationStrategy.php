<?

	/**
	 *	ToonFeudBadgeAdminValidationStrategy.php
	 *
	 *	Created:
	 *	2012-12-21
	 *
	 *	Modified:
	 *	2012-12-21
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
		include_once(PHP_PATH . "forms/validate/vo/toonFeud/ToonFeudBadgeAdminMessagingVO.php");
  		
		class ToonFeudBadgeAdminValidationStrategy extends BaseAdminValidationStrategy implements FormValidationStrategyInterface {
		
			/**
			 *	validateForm
			 *	- iterates through $obj->data and evaluates each by type 
			 *	- each data type check returns either success (errorCode = 0) or an errorCode, which is then used to 
			 *	retrieve an error message that is pushed to an array
			 */	 
			public function validateForm($obj) {
				$errorCode = 0;
				$errorCode = $this->checkAdminName($obj);
				
				// check admin_name integrity
				if ($obj->data->formAction == "add" && $errorCode == 0) $errorCode = $this->checkDuplicateEntry($obj);
				
				// set error code
				if ($errorCode == 0) {
					$num = $obj->data->formAction == "add" ? 0 : 1;
					$this->message->addMessage($num);
				}
				
				$result = new stdClass();
				$result->errorCode = $errorCode;
				$result->message = $this->message->getMessage();
				
				return $result;
			}
			
			protected function generateMessaging() {
				$this->message = new ToonFeudBadgeAdminMessagingVO();
			}
			
			/**
			 *	checkAdminName
			 *	- checks admin_name to ensure there are no spaces or special characters
			 */
			protected function checkAdminName($obj) {
				$errorCode = 0;
				if (!preg_match('/^[a-z0-9A-Z-]/', $obj->data->admin_name)) {
					$errorCode = 4;
					$this->message->addMessage($errorCode);
				}
				return $errorCode;
			}
		}

?>