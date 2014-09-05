<?

	/**
	 *	BaseValidationStrategy.php
	 *
	 *	Created:
	 *	2012-02-14
	 *
	 *	Modified:
	 *	2012-02-14
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- serves as basic implementation of all validation strategies
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('FormValidationStrategyInterface.php');
		include_once(PHP_PATH . "database/recordStrategy/SelectRecordStrategy.php");
		include_once(PHP_PATH . "languageFilter/LanguageFilter.php");
	
	
		class BaseValidationStrategy implements FormValidationStrategyInterface {
		
			
			protected $messaging;
			protected $errorCode;
			
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				$this->errorCode = 0;
				$this->generateMessaging($obj);	
			}
				
			/**
			 *	validateForm
			 *	- see strategy overrides for implementation
			 */	 
			public function validateForm($obj) {
				
			}
			
			public function getMessage() {
				return $this->messaging->getMessage();	
			}
			
			protected function setErrorCode($errorCode) {
				if ($errorCode != 0) $this->errorCode = $errorCode;	
			}
			
			/**
			 *	validate methods common to most contests, and implemented by ContestEntryValidationStrategy
			 *	- custom contest validation will either new validation strategy classes to be implemented
			 */
			protected function checkAlpha($obj) {
				$errorCode = 0;
				if (!preg_match('/^\pL+$/u', $obj->dataToCheck)) {
					$errorCode = $obj->errorCode;
					$this->messaging->addMessage($errorCode, $obj->language);
				}
				
				return $errorCode;		
			}
			
			
			/**
			 *	alphaNumericCheck
			 *	- checks that a supplied string contains only alpha-numeric characters and one underscore
			 *	- this method expects a utf8_encoded string ($obj->dataToCheck)
			 *	The regex is as follows:
			 *	Start of the string
			 *	[ ... ]*  Zero or more of the following:
			 *	\p{L}     Unicode letter characters
			 *	-         dashes
			 *	0-9       numbers
			 *	$         End of the string
			 *	/u        Enable Unicode mode in PHP
			 */
			protected function alphaNumericCheck($obj) {
				$errorCode = 0;
				if (!preg_match ("/^[\p{L}-0-9]*$/u", $obj->dataToCheck)) {
					$errorCode = $obj->errorCode;
					$this->messaging->addMessage($errorCode, $obj->language);
				}
				return $errorCode;
			}
			
			protected function checkUserName($obj) {
				$errorCode = 0;
				if (!preg_match ("/^[\p{L}-0-9]*$/", $obj->dataToCheck)) {
					$errorCode = $obj->errorCode;
					$this->messaging->addMessage($errorCode, $obj->language);
				}
				return $errorCode;
			}
			
			/**
			 *	phoneCheck
			 *	- checks structure of a submitted phone number
			 */
			protected function checkPhone($obj) {
				$errorCode = 0;
				if (!preg_match ("/^\D*\d{3}?\D*\d{3}?\D*\d{4}?\D*$/",$obj->phone)) {
					$errorCode = $obj->errorCode;
					$this->messaging->addMessage($errorCode, $obj->language);
				}
				return $errorCode;
			}
			
			/**
			 *	checkPostalCode
			 *	- checks a Canadian Postal Code format. Does not authenticate whether code exists
			 */
			protected function checkPostalCode($obj) {
				$errorCode = 0;
				$obj->dataToCheck = str_replace(' ', '', $obj->dataToCheck);
 
    			if (!preg_match("/^([a-ceghj-npr-tv-z]){1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}$/i" , $obj->dataToCheck)) {
      				$errorCode = $obj->errorCode;
					$this->messaging->addMessage($errorCode, $obj->language);
				}
 
 				return $errorCode;
			}
			
			/**
			 *	checkEmailAddress
			 *	- checks structure of email only. This is not an MX record lookup.
			 *	- if the check fails, push to displayMessages property of $this->messaging
			 */
			protected function checkEmailAddress($obj) {
				$errorCode = 0;
				if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $obj->dataToCheck)) {
					$errorCode = $obj->errorCode;
					$this->messaging->addMessage($errorCode, $obj->language);
				}
				return $errorCode; 
			}
			
			/**
			 *	checkEmail
			 *	- checks structure of email only. This is not an MX record lookup.
			 *	- if the check fails, push to displayMessages property of $this->messaging
			 *	NOTE: this method is deprecated. Use checkUserEmail
			 */
			protected function checkEmail($obj) {
				$errorCode = 0;
				if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $obj->email)) {
					$errorCode = 2;
					$this->messaging->addMessage($errorCode, $obj->language);
				}
				return $errorCode; 
			}
			
			/**
			 *	checkBadLanguage
			 *	- scans an array of fields for offensive language
			 *	
			 *	returns:
			 *	$errorCode (1 = bad language found, 0 = ok)
			 */
			protected function checkBadLanguage($obj = NULL) {
				// compose class name
				$className = ucfirst($obj->brand) . 'LanguageFilter';
				// instance [Brand]LanguageFilter.php
				$languageFilter = new $className($obj);
				// invoke filterData method. Returns errorCode = 0 (no bad language found) or 1 (wash your fucking mouth out with soap).
				$errorCode = $languageFilter->filterData();
				// destroy our class instance (you only need to do this if you're running a lengthy script)
				$languageFilter->__destruct();
				unset($languageFilter);	
				
				return $errorCode;
			}
			
			/**
			 *	setDefaultDisplayName
			 *	- returns a default display name based on language
			 */
			protected function setDefaultDisplayName($obj = NULL) {
				return $obj->language == "en" ? "User" : "Utilisateur";
			}
			
			/**
			 *	yearCheck
			 *	- invoked if we want to screen entrants who are under 18
			 */
			protected function checkYear($obj) {
				$errorCode = 0;
				if ($obj->age < 18) {
					$errorCode = $obj->errorCode;
					$this->messaging->addMessage($errorCode, $obj->language);
				}
				
				return $errorCode;
			}
			
			/**
			 *	ageCheck
			 *	- invoked if we want to screen entrants under the age of 13 in Quebec
			 */
			protected function checkAge($obj) {
				$errorCode = 0;
				if ($obj->age < 13 && $obj->province == 'QC') {
					$errorCode = $obj->errorCode;
					$this->messaging->addMessage($errorCode, $obj->language);
				}
				
				return $errorCode;
			}
			
			/**
			 *	encryptData
			 *	- encrypt sensitive data
			 */
			protected function encryptData($data){
				$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
				$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
				$key = "Pink Tylenol Martini";
				$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $iv);
			
				return $crypttext;
			}
			
			/**
			 *	duplicateEntryCheck
			 *	- Ensures each contest entry has a different phone, age & test name combination by:
			 *		- queryiing the contest table for an entry WHERE phone numbers, displayName, dateTime and type match
			 *		- if a result is found, instruct messaging to add the appropriate message to its displayMessages array
			 */
			protected function checkDuplicateEntry($obj) {
				$query = new stdClass();
				$query->data = !isset($obj->selectData) ? $this->getDefaultSelectData() : $obj->selectData;
				$query->conditionalRange = $obj->conditionalRange;
				$query->dbTable = $obj->dbTable;
				if (isset($obj->host) && $obj->host != NULL && $obj->host != "") $query->host = $obj->host;
				if (isset($obj->dbName) && $obj->dbName != NULL && $obj->dbName != "") $query->dbName = $obj->dbName;
				if (isset($obj->user) && $obj->user != NULL && $obj->user != "") $query->user = $obj->user;
				if (isset($obj->password) && $obj->password != NULL && $obj->password != "") $query->password = $obj->password;

				$recordStrategy = new SelectRecordStrategy($obj);
				$result = $recordStrategy->execute($query);
				$result->errorCode = is_array($result->data) && array_key_exists("0", $result->data) ? 1 : 0;
				if ($result->errorCode != 0) $this->messaging->addMessage($result->errorCode, $obj->data->language);	
				
				return $result->errorCode;
			}
			
			/**
			 *	getDefaultSelectData
			 *	- returns default select data object for duplicate entry check
			 */
			protected function getDefaultSelectData() {
				$data = new stdClass();
				$data->entryID = "entryID";	
				return $data;
			}
		}


?>