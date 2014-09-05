<?

	/**
	 *	ToonFeudCategoryAdminValidationStrategy.php
	 *
	 *	Created:
	 *	2013-01-08
	 *
	 *	Modified:
	 *	2013-01-08
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- performs validation on adding / updating TOON FEUD category record admin data
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
		include_once(PHP_PATH . "forms/validate/vo/toonFeud/ToonFeudCategoryAdminMessagingVO.php");
  		
		class ToonFeudCategoryAdminValidationStrategy extends BaseAdminValidationStrategy implements FormValidationStrategyInterface {
		
			/**
			 *	validateForm
			 *	- iterates through $obj->data and evaluates each by type 
			 *	- each data type check returns either success (errorCode = 0) or an errorCode, which is then used to 
			 *	retrieve an error message that is pushed to an array
			 */	 
			public function validateForm($obj) {
				$errorCode = 0;
				
				// check admin_name integrity
				$errorCode = $this->checkAdminName($obj);

				if ($errorCode == 0 && $obj->data->formAction == "add") $errorCode = $this->checkDuplicateEntry($obj);
				
				// validation passes
				if ($errorCode == 0) {
					// add success message to return data
					$this->message->addMessage($num = $obj->data->formAction == "add" ? 0 : 1);
				}
				
				$result = new stdClass();
				$result->errorCode = $errorCode;
				$result->message = $this->message->getMessage();
				
				return $result;
			}
			
			protected function generateMessaging() {
				$this->message = new ToonFeudCategoryAdminMessagingVO();
			}
			
			/**
			 *	checkAdminName
			 *	- checks admin_name to ensure there are no spaces or special characters
			 */
			protected function checkAdminName($obj) {
				$errorCode = 0;
				
				if (preg_match('/[^A-Za-z0-9-]+/', $obj->data->admin_name)) {
					$errorCode = 4;
					$this->message->addMessage($errorCode);
				}
				
				return $errorCode;
			}
		}

?>