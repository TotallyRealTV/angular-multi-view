<?

	/**
	 *	BaseRulesStrategy.php
	 *
	 *	this class implements properties/methods common to all brand-specific .htaccess rules classes
	 *
	 *	date created: 2012-05-10
	 *	date modified: 2012-05-10
	 *
	 *	author: Jonathan Blackburn for TELETOON Canada Inc.
	 */
	
	include_once("CnRulesStrategy.php");
	 
  	class BaseRulesStrategy {
    
		protected $props;
		protected $rules;
	
    	/**
		 *	constructor
		 */
		public function __construct($obj = NULL) {
      		
    	}
		
		/**
		 *	setupProps
		 *	scopes incoming props to this instance
		 */
		protected function setupProps($obj = NULL) {
			$this->props = new stdClass();
			
			foreach ($obj as $key => $value) {
				$this->props->$key = $value;
			}
			
			$this->rules = "";
		}
		
		/**
		 *	alphaNumbericSplit
		 *	- checks to see if a string needs to be split alpha-numerically
		 *	- returns re-formed string
		 */
		protected function alphaNumericSplit($value) {
			$tempArray = str_split($value);
			$strArray;
			$curStr = "";
			$isNum = $this->isCharInt($value[0]);
			$count = 0;
			
			foreach($tempArray as $char) {
			
				if($isNum != $this->isCharInt($char)) {
					$strArray[$count] = $curStr;
					$curStr="";
					$count++;
				}
				$isNum = $this->isCharInt($char);
				$curStr .= $char;
				//echo "<br />$char=".$this->isCharInt($char);
			}
			
			$strArray[$count]=$curStr;
			
			$newStr = "";
			foreach ($strArray as $str) {
				$newStr .= $str . "-";			
			}
			
			$newStr = rtrim($newStr, "-");
			
			return $newStr;	
		}
		
		/**
		 *	isCharInt
		 *	- evaluates a character and return true if an integer, false otherwise
		 */
		protected function isCharInt($var) {
			
			switch($var) {
				case "0":
					  return true;
				break;
				case "1":
					  return true;
				break;
				case "2":
					  return true;
				break;
				case "3":
					  return true;
				break;
				case "4":
					return true;
				break;
				case "5":
					  return true;
				break;
				case "6":
					  return true;
				break;
				case "7":
					  return true;
				break;
				case "8":
					  return true;
				break;
				case "9":
					  return true;
				break;
				case "0":
					  return true;
				break;
				default:
					return false;
				break;
			}
		}
		
   }

?>