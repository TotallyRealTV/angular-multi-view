<?

	/**
	 *	AssociativeLanguageFilter.php
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
	 *	- also runs a second check whereby original badWords has letters substituted for numbers & special characters in order 
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
  
  	
	
	
		class AssociativeLanguageFilterStrategy implements FilterStrategyInterface {
		
			// interface props
			private $errorCode;
			private $passCount;
			private $alphaNumericAssociations;		//	array of numbers -> letters, special chars -> letters
			private $newBadWords;					//	stores newly-created bad words for use as source on next pass
			
			/**
			 *	filterData
			 *	- sets up our special chars array
			 *	- does basic word check
			 *	- if basic check is cleared, do associative check
			 *	- return result
			 */
			public function filterData($obj) {
				$this->errorCode = 0;
				$this->passCount = 0;
				$this->newBadWords = array();
				
				// set user-input to lower-case
				$obj->dataToCheck = array_map('strtolower', $obj->dataToCheck);
				$obj->badWords = array_map('strtolower', $obj->badWords); 
				
				$this->setupProps();
				
				//basic check
				$this->errorCode = $this->wordCheck($obj);
				
				// send in original array of badwords on first associative check
				if ($this->errorCode == 0) $this->errorCode = $this->associativeWordCheck($obj);
				
				// set badWords as newly-created bad words from first pass. This is the basis of our recursion
				$obj->badWords = array();
				$obj->badWords = array_values(array_unique($this->newBadWords));
				
				//testOutput('arr', $obj->badWords);
				
				if ($this->errorCode == 0) $this->errorCode = $this->recursiveWordCheck($obj, 1);	
				
				return $this->errorCode;
			}
			
			
			/**
			 *	setupProps
			 *	- defines and populates our alphanumberic / special character check for the second pass
			 */
			private function setupProps() {
				$this->alphaNumericAssociations = array(
													  array('a', '4'),
													  array('a', '@'),
													  array('i', '!'),
													  array('i', '1'),
													  array('e', '3'),
													  array('o', '0'),
													  array('o', '()'),
													  array('u', 'v'),
													  array('g', '6'),
													  array('g', '9'),
													  array('l', '1'),
													  array('l', '!'),
													  array('s', '5'),
													  array('s', '$'),
													  array('q', '9')
												);
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
			
			/**
			 *	individualWordCheck
			 *	- checks user-input against an individual word (used to decrease looping during permutations)
			 */
			private function individualWordCheck($obj) {
				$errorCode = 0;
				
				foreach ($obj->dataToCheck as $key=>$value) {
					$data = explode(" ", $value);
					
					foreach ($data as $subKey=>$subValue) {
						$pos = strrpos($subValue, $obj->badPermutation);
						
						if ($pos === false) {
							
						} else {
							$errorCode = 1;
							break;	
						}	
					}
				}
				
				return $errorCode;	
			}
			
			/**
			 *	associativeWordCheck
			 *	- iterates, horizontall through alphaNumericAssociations and replaces a single corresponding letter to a word in $obj->badwords
			 *	- at the end of each child array of alphaNumericAssociations, the bad words are reset to their original states
			 *	- words with substituted characters are pushed to a $newBadWords for use in second (recursive) check phase
			 */
			private function associativeWordCheck($obj) {
				
				$errorCode = 0;
				$badWordsTotal = count($obj->badWords);
				
				for ($i = 0; $i < $badWordsTotal; $i++) {
					
					$count = count($this->alphaNumericAssociations);
					
					for ($j = 0; $j < $count; $j++) {
						
						$subCount = count($this->alphaNumericAssociations[$j]);
						
						for ($k = 1; $k < $subCount; $k++) {
							
							if ($obj->badWords[$i] = str_ireplace($this->alphaNumericAssociations[$j][$k - 1], $this->alphaNumericAssociations[$j][$k], $obj->badWords[$i])) {
								$errorCode = $this->wordCheck($obj);
								if ($errorCode == 1) break;
								else array_push($this->newBadWords, $obj->badWords[$i]);
							}
						}
						
						$obj->badWords[$i] = str_ireplace($this->alphaNumericAssociations[$j][$k - 1], $this->alphaNumericAssociations[$j][0], $obj->badWords[$i]);
						
						
						if ($errorCode == 1) break;
						
					}
					
					if ($errorCode == 1) break;	
				}
				
				$this->passCount++;
				
				return $errorCode;
			}
			
			
			
			/**
			 *	secondAssociativeWordCheck
			 *	- recursive function that iterates the columns of $this->alphaNumericAssociations, pushing new potential bad words into a fresh array that is used as the original comparison point should
			 *	this method need to call itself again until either a bad word is found or the interations are complete
			 *
			 *	Accepts:
			 *	$obj: containing badwords source
			 *	$index: the column of $this->alphaNumericAssociations we are checking
			 *
			 *	Returns:
			 *	$errorCode: 0 = no bad words, 1 = bad words
			 */
			private function recursiveWordCheck($obj, $index) {
				
				$errorCode = 0;
				$newBadWords = array();
				$badWordsTotal = count($obj->badWords);
				
				$count = count($this->alphaNumericAssociations);
				
				for ($i = 0; $i < $badWordsTotal; $i++) {
					
					for ($j = 0; $j < $count; $j++) {
						if (isset($this->alphaNumericAssociations[$j][$index])) {
							$obj->badPermutation = str_ireplace($this->alphaNumericAssociations[$j][$index - 1], $this->alphaNumericAssociations[$j][$index], $obj->badWords[$i]);
							$errorCode = $this->individualWordCheck($obj);
							if ($errorCode == 1) break;
							else array_push($newBadWords, $obj->badPermutation);
						}
					}
					
					if ($errorCode == 1) break;
				}
				
				
				
				if ($errorCode == 0 && $index < $count) {
					$obj->badWords = array();
					$obj->badWords = array_values(array_unique($newBadWords));
					
					$index++;
					$this->recursiveWordCheck($obj, $index);	
				}
				
				return $errorCode;
			}
		}



?>