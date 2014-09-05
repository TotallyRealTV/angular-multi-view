<?

	/**
	 *	CampTeletoonContestRegistrationValidationStrategy.php
	 *
	 *	Created:
	 *	2013-04-22
	 *
	 *	Modified:
	 *	2013-04-22
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- performs validation on a range of user contest data that is meant to be inserted into the CampTeletoon ContestUsers table
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
		include_once(PHP_PATH . "forms/validate/vo/campTeletoon/CampTeletoonContestRegistrationMessagingVO.php");
		
  		
		class CampTeletoonContestRegistrationValidationStrategy extends BaseValidationStrategy implements FormValidationStrategyInterface {
		
			/**
			 *	validateForm
			 *	- iterates through $obj->data and evaluates each by type 
			 *	- each data type check returns either success (errorCode = 0) or an errorCode, which is then used to 
			 *	retrieve an error message that is pushed to an array
			 */	 
			public function validateForm($obj) {
				$errorCode = 0;
				
				// duplicate entry check
				$obj->conditionalRange = new stdClass();
				$obj->conditionalRange->user_id = urlencode($obj->data->user_id);
				$obj->selectData = new stdClass();
				$obj->selectData->id = "id";
				$errorCode = $this->checkDuplicateEntry($obj);
				$this->setErrorCode($errorCode);
				
				if ($errorCode == 0) {
					// check phone
					$phoneCheck = new stdClass();
					$phoneCheck->phone = $obj->data->phone;
					$phoneCheck->errorCode = 2;
					$phoneCheck->language = $obj->data->language;
					$errorCode = $this->checkPhone($phoneCheck);
					$this->setErrorCode($errorCode);
					unset($phoneCheck);
					
					// check postal code
					/*$postalCheck = new stdClass();
					$postalCheck->dataToCheck = $obj->data->pCode;
					$postalCheck->errorCode = 3;
					$postalCheck->language = $obj->data->language;
					$errorCode = $this->checkPostalCode($postalCheck);
					$this->setErrorCode($errorCode);
					unset($postalCheck);*/
					
					// check email
					$emailCheck = new stdClass();
					$emailCheck->dataToCheck = $obj->data->email;
					$emailCheck->errorCode = 4;
					$emailCheck->language = $obj->data->language;
					$errorCode = $this->checkEmailAddress($emailCheck);
					$this->setErrorCode($errorCode);
					unset($emailCheck);
					
					// age check
					$ageCheck = new stdClass();
					$ageCheck->age = $obj->data->age;
					$ageCheck->province = $obj->data->province;
					$ageCheck->errorCode = 5;
					$ageCheck->language = $obj->data->language;
					$errorCode = $this->checkAge($ageCheck);
					$this->setErrorCode($errorCode);
					unset($ageCheck);
					
					// first name
					$nameCheck = new stdClass();
					$nameCheck->dataToCheck = $obj->data->first_name;
					$nameCheck->errorCode = 6;
					$nameCheck->language = $obj->data->language;
					$errorCode = $this->checkAlpha($nameCheck);
					$this->setErrorCode($errorCode);
					unset($nameCheck);
					
					// last name
					/*if ($errorCode == 0) {
						$nameCheck = new stdClass();
						$nameCheck->dataToCheck = $obj->data->last_name;
						$nameCheck->errorCode = 7;
						$nameCheck->language = $obj->data->language;
						$errorCode = $this->checkAlpha($nameCheck);
						$this->setErrorCode($errorCode);
						unset($nameCheck);
					}*/
				}
				
				$result = new stdClass();
				$result->errorCode = 0;
				
				if ($this->errorCode == 0) $this->messaging->setMessage($this->errorCode, $obj->data->language);
				else $result->errorCode = $this->errorCode;
				
				$result->messaging = $this->messaging->getMessage();
				
				return $result;
			}
			
			protected function generateMessaging() {
				$this->messaging = new CampTeletoonContestRegistrationMessagingVO();
			}
		}

?>