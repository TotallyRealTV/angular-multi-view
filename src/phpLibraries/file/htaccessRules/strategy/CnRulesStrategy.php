<?

	/**
	 *	CnRulesStrategy.php
	 *
	 *	Cartoon Network-specific implementation of .htaccess rules generation
	 *
	 *	date created: 2012-05-10
	 *	date modified: 2012-05-10
	 *
	 *	author: Jonathan Blackburn for TELETOON Canada Inc.
	 */
	 
	include_once("BaseRulesStrategy.php");
	include_once(PHP_PATH . "utilities/string.php"); 
	 
  	class CnRulesStrategy extends BaseRulesStrategy {
    
		/**
		 *	constructor
		 */
		public function __construct($obj = NULL) {
			$this->setupProps($obj);
			$this->generateRules($obj);
    	}
		
		/**
		 *	generateRules
		 *	- generates specific rules, based on content type, and returns them
		 */
		protected function generateRules($obj = NULL) {
			$directory = "";
			$count = count($this->props->directories);
			$totalCases = array();
			
			for ($i = 0; $i < $count; $i++) {
				$cases = array();
				$childCases = array();
				// build all cases as an array
				array_push($cases, $this->buildRewriteCases($this->props->directories[$i][0]));
				
				$subCount = count($this->props->directories[$i][1]);
				
				for ($j = 0; $j < $subCount; $j++) {
					array_push($childCases, $this->buildRewriteCases($this->props->directories[$i][1][$j]));
				}
				
				array_push($totalCases, array($cases, $childCases));
			}
			
			// append to rules
			$this->rules = $this->generateFinalRules($totalCases);
			$this->rules .= $this->writeCatchallRule();
		}
		
		/**
		 *	buildRewriteCases
		 *	- creates iterations of directory name for rewrite rules
		 *	- returns as an array
		 */
		protected function buildRewriteCases($directory = NULL) {
			$case = array();
			
			if ($directory != NULL) {
				if (!contains("-", $directory)) $dirToCheck = $this->alphaNumericSplit($directory);
				else $dirToCheck = $directory;
				
				$case = $this->generateDirectoryVariances($dirToCheck);
			}
			
			return $case;
		}
		
		protected function generateDirectoryVariances($dir) {
			$case = array();
			
			$tmp = explode("-", $dir);
			$count = count($tmp);
			
			$mixedCase = $tmp[0];
			$underScores = $tmp[0];
			$lowerCase = strtolower($tmp[0]);
			$ucFirst = ucfirst($tmp[0]);
			$upperCase = strtoupper($tmp[0]);
			$allUcFirst = $ucFirst;
			
			$dashMixedCase = $mixedCase;
			$dashMixedUcFirst = $ucFirst;
			$dashUpperCase = $upperCase;
			$dashAllUcFirst = $allUcFirst;
			
			for($i = 1; $i < $count; $i++) {
				$mixedCase .= ucfirst($tmp[$i]);
				$underScores .= "_".$tmp[$i];
				$lowerCase .= strtolower($tmp[$i]);
				$ucFirst .= strtolower($tmp[$i]);
				$upperCase .= strtoupper($tmp[$i]);	 
				$allUcFirst .= ucfirst($tmp[$i]);
				
				$dashMixedCase .= "-" . ucfirst($tmp[$i]);
				$dashMixedUcFirst .= "-" . strtolower($tmp[$i]);
				$dashUpperCase .= "-" . strtoupper($tmp[$i]);
				$dashAllUcFirst .= "-" . ucfirst($tmp[$i]);
				
			}
			
			array_push($case, $mixedCase, $underScores, $lowerCase, $ucFirst, $allUcFirst, $upperCase, $dashMixedCase, $dashMixedUcFirst, $dashUpperCase, $dashAllUcFirst, $dir);
			$case = array_unique($case);
			return array_values($case);
		}
		
		/**
		 *	generateRules
		 *	creates a string of rewrite rules from incoming array
		 *	returns a string
		 */
		protected function generateFinalRules($arr = NULL) {
			$rules = "";
			
			if ($arr != NULL) {
				$count = count($arr);
				
				for ($i = 0; $i < $count; $i++) {
					$parentCount = count($arr[$i][0][0]);	// number of iterations of the parent directory
					$parentVariations = implode("|", $arr[$i][0][0]);
					$childDirectoryCount = count($arr[$i][1]);		// number of child directories
					
					if ($this->props->section == "tv") $rules .= $this->writeRule($parentVariations, NULL, $this->props->directories[$i][0], NULL);
					
					for ($j = 0; $j < $childDirectoryCount; $j++) {
						$childItemCount = count($arr[$i][1][$j]);
						$childVariations = implode("|", $arr[$i][1][$j]);
						$rules .= $this->writeRule($parentVariations, $childVariations, $this->props->directories[$i][0], $this->props->directories[$i][1][$j]);
					}
				}
			}
			
			return $rules;
		}
		
		/**
		 *	writeRule
		 *	- writes an individual rule
		 *	- returns a string
		 */
		protected function writeRule($parentVariations = NULL, $childVariations = NULL, $targetParent = NULL, $targetChild = NULL) {
			$rule = "";
			
			if ($parentVariations != NULL) {
				switch ($this->props->section) {
					case "games":
						if ($childVariations == NULL) $childVariations = "([A-Za-z0-9-]+)";
						$rule .= "RewriteRule ^(" . $parentVariations . ")/(" . $childVariations . ")/?$ /".$this->props->section."/".$targetParent."/". $targetChild ."/index.php [QSA,R,L]\r\n";	
					break;
						
					case "tv":
						if ($childVariations == NULL) {
							$rule .= "RewriteRule ^(".$parentVariations.")/?$ /".$this->props->section."/".$targetParent."/index.php [QSA,R,L]\r\n";		
						} else {
							$rule .= "RewriteRule ^(" . $parentVariations . ")/(" . $childVariations . ")/?$ /".$this->props->section."/".$targetParent."/". $targetChild ."/index.php [QSA,R,L]\r\n";
						}
					break;
					
					default:
					
					break;	
				}
			}
			
			return $rule;
		}
		
		protected function writeCatchallRule() {
			return "RewriteRule ^([A-Za-z0-9-]+)/([A-Za-z0-9-]+)/?$ /".$this->props->section."/index.php [QSA,R,L]\r\n";		
			
		}
		
		/**
		 *	getRules
		 */
		public function getRules($obj = NULL) {
			return $this->rules;	
		}
	}

?>