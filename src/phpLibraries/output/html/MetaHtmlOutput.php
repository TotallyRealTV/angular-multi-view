<?
	
	/**
	 *	This class generates and returns an array of UPDATE SQL statements
	 *
	 *	Structure:
	 *	
	 */
	
	include_once("IHTMLOutput.php");
	include_once(PHP_PATH . "utilities/string.php");
	
	class MetaHtmlOutput extends IHTMLOutput {
		
		// override properties here as required
		
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			$this->setupProps($obj);
		}
		
		protected function setupProps($obj) {
			$this->data = array();
			$this->props = new stdClass();
			
			$this->props->errorCode = 0;
			$this->props->filePath = '';
			
			foreach ($obj as $key=>$value) {
				$this->props->$key = $value;
			}
		}
		
		protected function generateData() {
			$count = count($this->props->data);
			
			for ($i = 0; $i < $count; $i++) {
				$dataItem = $this->props->data[$i];
				$this->props->filePath = $this->props->output->basePath . $this->props->output->type . '/' . $this->props->output->htmlBrand . '_' . $this->props->output->htmlSection;
				
				$fileContents = $this->generateDataItem($dataItem, $this->props->filePath);
				$this->props->filePath .= '_' . $this->props->output->language . '/';
				$fileName =  $dataItem['fileName'] . "_meta.html";
				
				array_push($this->data, $this->props->filePath . $fileName);
				
				if ($fp = fopen($this->props->filePath . $fileName,"w")) { 
					fwrite($fp, $fileContents); 
					fclose($fp);
				} else {
					$this->props->errorCode = 1;	
				}
			}
		}
		
		/**
		 *	generateDataItem
		 *	- constructs fileName
		 *	- draws in the appropriate template
		 *	- iterates through each array key, replacing placeholders in the template string
		 *	- returns the string to the calling method
		 */
		private function generateDataItem($arr, $filePath) {
			$filePath .= '.' . $this->props->output->format;
			$template = file_get_contents($filePath);
			
			foreach ($arr as $key=>$value) {
				$value = urlencode($value);
				$value = replaceBadChars($value);
				$template = str_replace('#'.$key.'#', $value, $template);	
			}
			
			return $template;
		}
		
		
		/**
		 *	public methods
		 */
		public function generateOutput() {
			$this->generateData();
		}
		
		public function getOutput() {
			$output = new stdClass();
			$output->data = $this->data;
			$output->targetDirectory = $this->props->output->targetPath . '/' . $this->props->output->type . '/';
			$output->archiveName = $this->props->output->htmlBrand . '_' . $this->props->output->htmlSection . '_' . $this->props->output->language;	// set this for our ZIP archive
			$output->errorCode = $this->props->errorCode;
			return $output;	
		}
		
		public function deleteOutputFiles() {
			foreach($this->data as $key=>$value) {
				unlink($value);	
			}
		}
		
  	}

?>