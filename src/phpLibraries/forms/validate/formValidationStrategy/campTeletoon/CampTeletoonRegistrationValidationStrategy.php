<?

	/**
	 *	CampTeletoonRegistrationValidationStrategy.php
	 *
	 *	Created:
	 *	2013-04-19
	 *
	 *	Modified:
	 *	2013-04-19
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- performs validation on a range of user data that is meant to be inserted into the CampTeletoon Users table
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
 		include_once(PHP_PATH . "forms/validate/formValidationStrategy/BaseValidationStrategy.php");
		include_once(PHP_PATH . "forms/validate/vo/campTeletoon/CampTeletoonRegistrationMessagingVO.php");
		
  		
		class CampTeletoonRegistrationValidationStrategy extends BaseValidationStrategy implements FormValidationStrategyInterface {
		
			/**
			 *	validateForm
			 *	- iterates through $obj->data and evaluates each by type 
			 *	- each data type check returns either success (errorCode = 0) or an errorCode, which is then used to 
			 *	retrieve an error message that is pushed to an array
			 */	 
			public function validateForm($obj) {
				$errorCode = 0;
				
				$obj->conditionalRange = new stdClass();
				//$obj->conditionalRange->email = urlencode($obj->data->email);
				$obj->conditionalRange->user_name = urlencode($obj->data->user_name);
				$obj->selectData = new stdClass();
				$obj->selectData->id = "id";
				
				$errorCode = $this->checkDuplicateEntry($obj);
				$this->setErrorCode($errorCode);
				
				if ($errorCode == 0) {		
					// check user_name
					$alphaNumCheck = new stdClass();
					$alphaNumCheck->dataToCheck = html_entity_decode($obj->data->user_name);
					$alphaNumCheck->errorCode = 3;
					$alphaNumCheck->language = $obj->data->language;
					$errorCode = $this->checkUserName($alphaNumCheck);
					$this->setErrorCode($errorCode);
					
					// check password
					$alphaNumCheck->dataToCheck = $obj->data->password;
					$alphaNumCheck->errorCode = 4;
					$errorCode = $this->alphaNumericCheck($alphaNumCheck);
					$this->setErrorCode($errorCode);
					unset($alphaNumCheck);
					
					// check email
					$emailCheck = new stdClass();
					$emailCheck->dataToCheck = $obj->data->email;
					$emailCheck->errorCode = 2;
					$emailCheck->language = $obj->data->language;
					$errorCode = $this->checkEmailAddress($emailCheck);
					$this->setErrorCode($errorCode);
					unset($emailCheck);
					
					// check bad language in user_name
					$badLanguage = new stdClass();
					$badLanguage->dataToCheck = array($obj->data->user_name);
					$badLanguage->brand = $obj->data->brand;
					$badLanguage->filterType = "associative";
					
					// if bad language is found, set default display name
					$isBadLanguage = $this->checkBadLanguage($badLanguage);
					$obj->data->display_name = $isBadLanguage == 1 ? $this->setDefaultDisplayName($obj->data) : $obj->data->user_name;
					$obj->data->is_username_obscene = $isBadLanguage == 1 ? 1 : 0;
				}
				
				$result = new stdClass();
				$result->errorCode = 0;
				
				if ($this->errorCode == 0) $this->messaging->setMessage($this->errorCode, $obj->data->language);
				else $result->errorCode = 1;
				
				$result->messaging = $this->messaging->getMessage();
				
				
				if (count($result->messaging) == 1 && $result->messaging[0][1] == "") {
					$result->data = $result->messaging[0][0];
					unset($result->messaging);	
				}
				
				return $result;
			}
			
			protected function generateMessaging() {
				$this->messaging = new CampTeletoonRegistrationMessagingVO();
			}
		}

?>