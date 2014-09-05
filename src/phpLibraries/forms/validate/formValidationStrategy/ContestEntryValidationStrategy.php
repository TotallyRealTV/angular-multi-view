<?

	/**
	 *	ContestEntryValidationStrategy.php
	 *
	 *	Created:
	 *	2012-03-09
	 *
	 *	Modified:
	 *	2012-03-09
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- performs validation on a range of data that is meant to be inserted into a contest database table
	 *
	 *	$obj expects:
	 *	- data:	array of submitted form data
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('FormValidationStrategyInterface.php');
 		include_once('BaseValidationStrategy.php');
		include_once(PHP_PATH . "forms/validate/vo/ContestEntryMessagingVO.php");
  		
		class ContestEntryValidationStrategy extends BaseValidationStrategy implements FormValidationStrategyInterface {
		
			/**
			 *	validateForm
			 *	- iterates through $obj->data and evaluates each by type 
			 *	- each data type check returns either success (errorCode = 0) or an errorCode, which is then used to 
			 *	retrieve an error message that is pushed to an array
			 */	 
			public function validateForm($obj) {
				
				$errorCode = 0;
				
				$errorCode = $this->checkPhone($obj->data);
				
				if ($errorCode == 0) $errorCode = $this->checkEmail($obj->data);
				if ($errorCode == 0) $errorCode = $this->checkAge($obj->data);
				if ($errorCode == 0) $errorCode = $this->checkDuplicateEntry($obj);
				
				if ($errorCode == 0) {
					// encrypt sensitive data
					$obj->data->fname = $this->encryptData($obj->data->fname);
					$obj->data->lname = $this->encryptData($obj->data->lname);
					
					// add success message to return data
					$this->messaging->addMessage($errorCode, $obj->data->language);
				}
				
				$result = new stdClass();
				$result->errorCode = $errorCode;
				$result->messaging = $this->messaging->getMessage();
				
				return $result;
			}
			
			protected function generateMessaging() {
				$this->messaging = new ContestEntryMessagingVO();
			}
		}

?>