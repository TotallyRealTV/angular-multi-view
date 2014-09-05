<?
	/**
	 * 	The Archive File Controller encapsulates the business logic for archiving a file / groups of files
	 *
	 *	Only multiple files of the same directory can be archived.
	 *
	 *	Currently-supported formats:
	 *	- zip
	 *
	 *	It is incumbent on the implementing class to match these errorCodes to appropriate messaging	
	 *	
	 */
	
	require_once("archiveFileStrategy/ZIPArchiveStrategy.php");
	require_once("vo/ArchiveFileMessagingVO.php");
	
	class ArchiveFileController {
		
		protected $props;					//	an object to hold our critical properties required to upload a file
		protected $archiveFileStrategy;		//	holds our Upload instance
		protected $messaging;				//	holds error messaging unique to this module
		protected $errorCode;				//	errorCode to return to implementing class
		
		public function __construct($obj)  { 
			$this->setupProps($obj);
			$this->generateMessaging();
		}
		
		/**
		 *	setupProps
		 *	- sets the properties common to all Archive types
		 */
		protected function setupProps($obj = NULL) {
			$this->props = new stdClass();
			$this->props->type = isset($obj->type) && $obj->type != "" ? $obj->type : "zip";
			$this->props->archiveName = isset($obj->archiveName) && $obj->archiveName != "" ? $obj->archiveName . "." . $this->props->type : "archive." . $this->props->type;
			$this->props->targetDirectory = isset($obj->targetDirectory) ? $obj->targetDirectory : "";
			$this->props->data = isset($obj->data) && count($obj->data) > 0 ? $obj->data : array();
			$this->props->overwrite = isset($obj->overwrite) ? $obj->overwrite : true;
		}
		
		protected function generateMessaging() {
			$this->messaging = new ArchiveFileMessagingVO();
		}
		
		/**
		 *	archiveFiles
		 *	- invokes the required archive strategy based on $this->type
		 *	- archives files by $this->props->targetDirectory . '/' . $this->props->data[$i]
		 *	- returns errorCode (0 = succes, 1 = error)
		 */
		public function archiveFiles() {
			 switch($this->props->type) {
				case "zip":
					$this->archiveFileStrategy = new ZipArchiveStrategy();
				break;
				
				case "tar":
					
				break;
				
				default:
					$this->errorCode = 1;
				break;
			 }
			 
			 
			 if ($this->errorCode == 0) $this->errorCode = $this->archiveFileStrategy->archiveFiles($this->props);
			 return $this->errorCode;
		}
		 
		/**
		 *	deleteFile
		 *	- called by the implementing class when our file is parsed into memory and ready to be deleted
		 */
		public function deleteArchive() {
		 	$this->errorCode = $this->archiveFileStrategy->deleteArchive($this->props);
			return $this->errorCode;  
		}
		 
		/**
		 *	getFileName
		 *	- get our full URL fileName from our upload strategy
		 */
		public function getFileName() {
			return $this->props->archiveName;
		}
		
		public function getFileLocation() {
			return $this->props->targetDirectory;	
		}
		
		public function getMessage($num) {
			return $this->messaging->getMessage($num);	
		}
		
	}
	

?>