<?php
	
	/**
	 * This class provides the interface to which all OutputFactory implementations must conform 
	 */
	
	abstract class IOutputFactory {
  
    	abstract function generateOutput($obj);
  		abstract function getOutput();
		abstract function deleteOutputFiles();
		
  	}

?>