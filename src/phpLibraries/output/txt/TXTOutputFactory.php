<?
	
	/**
	 *	This class provides the primary decision making in regards to the type of output
	 *	we want to generate
	 */
	 
	include_once('ITXTOutputFactory.php');
	include_once("StandardGamesTxtOutput.php");
	include_once("MxGamesTxtOutput.php");
	include_once("LegacyGamesTxtOutput.php");
	
	class TXTOutputFactory extends ITXTOutputFactory {
		
		private $txtOutput;
		
		/**
		 *	generateOutput
		 *	- checks $obj->outputType to instance the correct type of output factory required.
		 *	- valid options are currently:
		 *		"json"
		 *	- future implementations may extend to:
		 *		"xml"
		 *		"txt"
		 *		"soap"
		 */
		public function generateOutput($obj) {
			//testOutput('obj', $obj);
			switch ($obj->output->type) {
				
				case "standardGames":
					$this->txtOutput = new StandardGamesTxtOutput($obj);	
				break;
				
				case "mxGames":
					$this->txtOutput = new MxGamesTxtOutput($obj);
				break;
				
				case "legacyGames":
					$this->txtOutput = new LegacyGamesTxtOutput($obj);
				break;
				
				default: 
					return NULL;	
				break;
					
			}
			
			$this->txtOutput->generateOutput();
		}
  	}

?>