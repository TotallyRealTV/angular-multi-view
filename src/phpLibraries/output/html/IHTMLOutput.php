<?
	
	/**
	 * This class provides the interface to which all JsonOutput implementations must conform 
	 */
	
	abstract class IHTMLOutput {
  
  		/**
		 *	properties
		 */
    	protected $data;		// 	our final object to output
		protected $props;		//	storage for all incoming properties
  
  		/**
		 *	methods
		 */
		
		abstract protected function setupProps($obj);
		abstract protected function generateOutput();		// public method
		abstract protected function getOutput();			// public method
		abstract protected function deleteOutputFiles();
  	}

?>