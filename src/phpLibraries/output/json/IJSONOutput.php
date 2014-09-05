<?
	
	/**
	 * This class provides the interface to which all JsonOutput implementations must conform 
	 */
	
	abstract class IJSONOutput {
  
  		/**
		 *	properties
		 */
    	protected $json;		// 	our final object to output
		protected $props;		//	storage for all incoming properties
  
  		/**
		 *	methods
		 */
		
		abstract protected function setupProps($obj);
		abstract protected function generateDiagnostic();
		abstract protected function generateOutput();		// public method
  	}

?>