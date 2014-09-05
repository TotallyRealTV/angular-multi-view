<?
	
	/**
	 *	This class provides the primary decision making in regards to the type of output
	 *	we want to generate
	 */
	 
	include_once('IHTMLOutputFactory.php');
	include_once("MetaHtmlOutput.php");
	
	class HTMLOutputFactory extends IHTMLOutputFactory {
		
		private $htmlOutput;
		
		/**
		 *	generateOutput
		 *	- checks $obj->outputType to instance the correct type of HTML output required.
		 */
		public function generateOutput($obj) {
			
			switch ($obj->output->type) {
				
				case "meta":
					$this->htmlOutput = new MetaHtmlOutput($obj);	
				break;
				
				default: 
					return NULL;	
				break;
					
			}
			
			$this->htmlOutput->generateOutput();
		}
		
		public function getOutput() {
			return $this->htmlOutput->getOutput();	
		}
		
		public function deleteOutputFiles() {
			$this->htmlOutput->deleteOutputFiles();	
		}
  	}

?>