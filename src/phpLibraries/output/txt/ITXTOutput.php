<?
	
	/**
	 * This class provides the interface to which all TxtOutput implementations must conform 
	 */
	
	abstract class ITXTOutput {
  
  		/**
		 *	properties
		 */
    	protected $txt;			// 	our final object to output
		protected $props;		//	storage for all incoming properties
  
  		/**
		 *	methods
		 */
		
		abstract protected function setupProps($obj);
		abstract protected function generateOutput();		// public method
  	}

?>