<?
	
	/**
	 * This class provides the interface to which all JsonOutput implementations must conform 
	 */
	
	abstract class ISQLOutput {
  
  		/**
		 *	properties
		 */
    	protected $data;		// 	our final object to output
		protected $props;		//	storage for all incoming properties
		protected $whereClause;
		protected $whereLikeClause;
  
  		/**
		 *	methods
		 */
		
		abstract protected function setupProps($obj);
		abstract protected function generateOutput();		// public method
		abstract protected function getOutput();			// public method
  	}

?>