<?

	/**
	 *	FileParser.php
	 *
	 *	Created:
	 *	2012-03-06
	 *
	 *	Modified:
	 *	2012-03-06
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- this class accepts a URL of a file to parse, currently supports the following formats:
	 *	
	 *	XLS: returns an array
	 *	CSV: returns an array
	 *
	 *	
	 */
	 
	require_once("fileParseStrategy/XLSParseStrategy.php");
	require_once("fileParseStrategy/CSVParseStrategy.php");

	
	class FileParser {
		
		private $type;					// file type
		private $fileName;
		private $fileParseStrategy;
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			$this->setupProps($obj);
		}
		
		
		/**
		 *	setupProps
		 *	- sets the properties common to all FileParse types
		 */
		protected function setupProps($obj = NULL) {
			$this->fileName = $obj->fileName;
			$this->type = $this->setFileExtension($obj);
			
			
		}
		
		/**
		 *	setFileExtension
		 *	- checks $obj->fileName for its extension
		 *	- returns extension if found, empty string otherwise
		 */
		private function setFileExtension($obj = NULL) {
			$paths = explode(".", $obj->fileName);
			$extension = count($paths) > 1 ? $paths[count($paths) - 1] : "";
			return $extension;	
		}
			
		/**
		 *	parseFile
		 *	- invokes the required parsing strategy based on incoming type
		 *	- returns parsed data
		 */
		 public function parseFile() {
			 switch($this->type) {
				case "xls":
					$this->fileParseStrategy = new XLSParseStrategy();
				break;
				
				case "csv":
					$this->fileParseStrategy = new CSVParseStrategy();
				break; 
				
				case "xml":
					//$this->fileParseStrategy = new ApprovalsfileParseStrategy();
				break;
				
				default:
					echo "file type not recognized.";
				break;
			 }
			 
			 
			 return $this->fileParseStrategy->parseFile($this->fileName);
		 }
	}




?>