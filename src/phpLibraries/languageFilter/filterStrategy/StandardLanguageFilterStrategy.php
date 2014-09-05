<?

	/**
	 *	StandardLanguageFilter.php
	 *
	 *	Created:
	 *	2012-02-07
	 *
	 *	Modified:
	 *	2012-02-07
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- accepts an array of data (user-input) to check, and an array of language to check against.
	 *	- returns
	 *
	 *	Accepts:
	 *	$obj:
	 *		->dataToCheck (array): user input to check
	 *		->badWords (array): bad words to check against
	 *
	 *	Returns:
	 *	$errorCode: 0 (success), 1 (fail)	
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('FilterStrategyInterface.php');
  
  	
	
	
		class StandardLanguageFilterStrategy implements FilterStrategyInterface {
		
			// interface props
			protected $errorCode;
			
			
			/**
			 *	filterData
			 *	- does simple check of each element of $obj->dataToCheck against $obj->badWords
			 */
			public function filterData($obj) {
				
				// set user-input to lower-case
				$obj->dataToCheck = array_map('strtolower', $obj->dataToCheck);
				$obj->badWords = array_map('strtolower', $obj->badWords); 
				
				//basic check
				$this->errorCode = $this->wordCheck($obj);
				
				return $this->errorCode;
			}
			
			/**
			 *	basicWordCheck
			 *	- does simple check of each element of $obj->dataToCheck against $obj->badWords
			 */
			private function wordCheck($obj) {
				$errorCode = 0;
				
				$dataTotal = count($obj->dataToCheck);
				$badWordsTotal = count($obj->badWords);
				
				for ($i = 0; $i < $dataTotal; $i++) {
					for ($j = 0; $j < $badWordsTotal; $j++) {
						$pos = strrpos($obj->dataToCheck[$i], $obj->badWords[$j]);
						if ($pos === false) {
							
						} else {
							$errorCode = 1;
							break;	
						}
					}
				}
				
					
				return $errorCode;	
			}
		}



?>