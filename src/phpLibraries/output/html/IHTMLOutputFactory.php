<?
	
	/**
	 * This class provides the interface to which all JSONOutputFactory implementations must conform 
	 */
	
	abstract class IHTMLOutputFactory {
  
    	abstract function generateOutput($obj);
		abstract function getOutput();
		abstract function deleteOutputFiles();
  
  	}

?>