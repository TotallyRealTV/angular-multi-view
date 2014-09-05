<?
	
	/**
	 *	This class provides the primary decision making in regards to the type of output
	 *	we want to generate
	 */
	 
	include_once('ISQLOutputFactory.php');
	include_once("UpdateSqlOutput.php");
	
	class SQLOutputFactory extends ISQLOutputFactory {
		
		private $sqlOutput;
		
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
			
			switch ($obj->output->type) {
				
				case "update":
					$this->sqlOutput = new UpdateSqlOutput($obj);	
				break;
				
				case "insert":
				
				break;
				
				case "delete":
				
				break;
				
				default: 
					return NULL;	
				break;
					
			}
			
			$this->sqlOutput->generateOutput();
		}
		
		public function getOutput() {
			return $this->sqlOutput->getOutput();	
		}
  	}

?>