<?

	/**
	 *	BaseAdminValidationStrategy.php
	 *
	 *	Created:
	 *	2012-03-29
	 *
	 *	Modified:
	 *	2012-03-29
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- serves as basic implementation of all content admin validation strategies
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once(PHP_PATH . "forms/validate/formValidationStrategy/FormValidationStrategyInterface.php");
		include_once(PHP_PATH . "forms/validate/formValidationStrategy/recordStrategy/DuplicateEntryRecordStrategy.php");
	
	
		class BaseAdminValidationStrategy implements FormValidationStrategyInterface {
		
			
			protected $message;
			protected $formAction;
			
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				$this->generateMessaging($obj);
				$this->setupProps($obj);	
			}
			
			protected function setupProps($obj = NULL) {
				$this->formAction = isset($obj->formAction) ? $obj->formAction : "";	
			}
				
			/**
			 *	validateForm
			 *	- see strategy overrides for implementation
			 */	 
			public function validateForm($obj) {
				
			}
			
			public function getMessage() {
				return $this->message->getMessage();	
			}
			
			/**
			 *	validate methods common to most contests, and implemented by ContestEntryValidationStrategy
			 *	- custom contest validation will either new validation strategy classes to be implemented
			 */
			/**
			 *	checkDuplicateEntry
			 *	- Ensures each contest entry has a different phone, age & test name combination by:
			 *		- queryiing the contest table for an entry WHERE admin_name matches
			 *		- if a result is found, instruct messaging to add the appropriate message to its displayMessages array
			 */
			protected function checkDuplicateEntry($obj) {
				$errorCode = 0;
				// prepare query object
				$query = new stdClass();
				$query->data = new stdClass();
				$query->data->id = "id";
				$query->conditionalRange = $obj->conditionalRange;
				$query->dbTable = $obj->dbTable;
				$query->host = $obj->host;
				$query->user = $obj->user;
				$query->password = $obj->password;
				$query->dbName = $obj->dbName;
				
				$recordStrategy = new DuplicateEntryRecordStrategy($query);
			
				$result = $recordStrategy->execute($query);
				
				if (is_array($result->data) && count($result->data) > 0) {
					$errorCode = 3;
					$this->message->addMessage($errorCode);	
				}
				
				return $errorCode;
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
			
			/**
			 *	checkAlphaNumericSpace
			 *	- checks admin_name to ensure there are no special characters
			 */
			protected function checkAlphaNumericSpace($str) {
				$errorCode = 0;
				
				if (!preg_match('/^[a-zA-Z0-9 ]/', $str)) {
					$errorCode = 9;
					$this->message->addMessage($errorCode);
				}
				return $errorCode;
			}
			
			/**
			 *	checkFileName
			 *	- checks fileName to ensure it fits a correct structure 
			 */
			protected function checkFileName($obj) {
				$errorCode = 0;
				
				if (!preg_match('/^[a-z0-9_.-]+$/i', $obj->data->content_details->file_name)) {
					$errorCode = 5;
					$this->message->addMessage($errorCode);	
				}
				return $errorCode;
			}
			 
			/**
			 *	checkDateTime
			 *	- checks that any / all date time values conform to Y-m-d H:i:s
			 */
			protected function checkDateTime($dateTime) {
				$errorCode = 0;
				
				if (!preg_match('/^[0-9]{4,}[.\-][0-9]{2,}[.\-][0-9]{2,} [0-9]{2,}:[0-9]{2,}:[0-9]{2,}$/', $dateTime)) {
					$errorCode = 6;
				} else {
					$dateArr = explode(" ", $dateTime);
					list($year, $month, $day) = explode('-', $dateArr[0]);
					list($hour, $minute, $second) = explode(":", $dateArr[1]);
					
      				if (!checkdate($month, $day, $year)) $errorCode = 6;
					if ($errorCode == 0 && $hour > 23 || $minute > 59 || $second > 59) $errorCode = 4;
				}
				
				if ($errorCode == 6) $this->message->addMessage($errorCode);
				
				return $errorCode;
			}
			
			/**
			 *	checkNumber
			 *	- checks that value contains only numbers
			 */
			protected function checkNumber($number) {
				$errorCode = 0;
				
				if (!preg_match('/^[0-9]{1,}$/', $number)) {
					$errorCode = 7;
					$this->message->addMessage($errorCode);	
				}
				
				return $errorCode;
			}
			
			/**
			 *	checkVideoFileSize
			 *	- checks that a video file being accessed is below a certain size in megabytes
			 *	- if true, returns $errorCode = 0, else $errorCode = 4;
			 */
			protected function checkVideoFileSize($obj = NULL) {
				$errorCode = 0;
				
				$size = filesize($obj->data->video_path . $obj->data->video_file);
				$size = number_format($size / 1024 / 1024, 2);
				
				if ($size > 240) {
					$errorCode = 8;
					$this->message->addMessage($errorCode);		
				}
				
				return $errorCode;
			}
		}


?>