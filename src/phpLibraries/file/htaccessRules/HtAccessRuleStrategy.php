<?
	/**
	 * 	HtAccessRuleStrategy manages variable HtAccess rule generation requests, by brand, by an implementing class
	 *
	 *	This class instances one of the following child strategies: CnHtAccessStrategy... others will be built as required,
	 *	and also provides public methods for an implementing class to be able to access the brand-specific rule creating class
	 *
	 *	Date Created: May 10, 2012
	 *	Date Modified: May 10, 2012
	 *
	 *	Created by: Jonathan Blackburn for TELETOON Canada Inc.
	 */
	
	require_once(PHP_PATH . "file/htaccessRules/strategy/BaseRulesStrategy.php");
	
	class HtAccessRuleStrategy {
		
		protected $ruleStrategy;			//	holds our .htaccess rule strategy instance
		
		
		public function __construct($obj = NULL)  { 
			$this->generateRuleStrategy($obj);
		}
		
		/**
		 *	generateRuleStrategy
		 *	- checks obj->brand to determine which rule strategy class to instance
		 */
		protected function generateRuleStrategy($obj = NULL) {
			$className = ucfirst($obj->brand)."RulesStrategy";
			$this->ruleStrategy = new $className($obj);
		}
		
		
		/**
		 *	public methods
		 */
		public function getRules($obj = NULL) {
			return $this->ruleStrategy->getRules();		
		}
		
	}
	

?>