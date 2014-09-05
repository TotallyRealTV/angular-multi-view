<?php
	
	/**
	 *	This class provides the primary decision making in regards to the type of output
	 *	we want to generate
	 */
	
	include_once('IOutputFactory.php');
	include_once('json/JSONOutputFactory.php');
	include_once('sql/SQLOutputFactory.php');
	include_once('html/HTMLOutputFactory.php');
	include_once('txt/TXTOutputFactory.php');
	
	class OutputFactory extends IOutputFactory {
		
		private $output;			// holds sub-factory we want to instance;
		
		/**
		 *	generateOutput
		 *	- checks $obj->outputType to instance the correct type of output factory required.
		 *	- valid options are currently:
		 *		"json"
		 *		"sql"
		 *	- future implementations may extend to:
		 *		"xml"
		 *		"txt"
		 *		"soap"
		 */
		public function generateOutput($obj) {
			//testOutput('obj', $obj);
			switch ($obj->output->format) {
				
				case "json":
					$this->output = new JSONOutputFactory();	
				break;
				
				case "sql":
					$this->output = new SQLOutputFactory();
				break;
				
				case "html":
					$this->output = new HTMLOutputFactory();
				break;
				
				case "txt":
					$this->output = new TXTOutputFactory();
				break;
				
				default: 
					
				break;
					
			}
			
			$this->output->generateOutput($obj);
			
		}
		
		public function getOutput() {
			return $this->output->getOutput();	
		}
		
		public function deleteOutputFiles() {
			$this->output->deleteOutputFiles();	
		}
		
  	}

?>