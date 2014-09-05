<?

	/**
	 *	CampTeletoonContestRegistrationUpdateValidationStrategy.php
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
		
  		
		class CampTeletoonContestRegistrationUpdateValidationStrategy extends BaseValidationStrategy implements FormValidationStrategyInterface {
		
			/**
			 *	validateForm
			 *	- iterates through $obj->data and evaluates each by type 
			 *	- each data type check returns either success (errorCode = 0) or an errorCode, which is then used to 
			 *	retrieve an error message that is pushed to an array
			 */	 
			public function validateForm($obj) {
				$errorCode = 0;
				
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
					
				$result = new stdClass();
				$result->errorCode = 0;
				
				if ($this->errorCode == 0) $this->messaging->setMessage(8, $obj->data->language);
				else $result->errorCode = $this->errorCode;
				
				$result->messaging = $this->messaging->getMessage();
				
				return $result;
			}
			
			protected function generateMessaging() {
				$this->messaging = new CampTeletoonContestRegistrationMessagingVO();
			}
		}

?>