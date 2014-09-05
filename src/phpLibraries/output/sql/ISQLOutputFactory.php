<?
	
	/**
	 * This class provides the interface to which all JSONOutputFactory implementations must conform 
	 */
	
	abstract class ISQLOutputFactory {
  
    	abstract function generateOutput($obj);
		abstract function getOutput();
  
  	}

?>