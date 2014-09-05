<?
	/**
	 * 	The Upload library handles file uploads
	 *	The constructor expects an object containing:
	 *	- type: 'single', 'amazon'
	 *	- fileName: the name of the file to upload (taken from $_FILES array in implemeting class)
	 *	- tmpFileName: the temporary file name of upload (taken from $_FILES array in implementing class)
	 *	- targetDirectory: where you want to upload your file
	 *	- uploadField: the name of 'file' field in your upload form
	 *	- awsAccessKey: ('amazon' only), AWS access key
	 *	- awsSecretKey: ('amazon' only), AWS secret key
	 *	- bucketName: ('amazon only'), the AWS bucket name
	 *
	 *	This class validates the file name and, if successful, the implementing class invokes the uploadFile strategy
	 *
	 *	Range of Error Codes Returned:
	 *	0: ok
	 *	1: failed to upload (returned from upload strategy)
	 *	2: failed to find bucket (returned from upload strategy)
	 *	3: invalid file name
	 *
	 *	It is incumbent on the implementing class to match these errorCodes to appropriate messaging	
	 *	
	 */
	
	require_once("uploadStrategy/SingleUploadStrategy.php");
	require_once("uploadStrategy/AmazonUploadStrategy.php");
	
	class UploadController {
		
		protected $props;				//	an object to hold our critical properties required to upload a file
		protected $targetDirectory;		//	location of uploaded file
		protected $uploadStrategy;		//	holds our Upload instance
		protected $errorCode;			//	errorCode to return to implementing class
		
		public function __construct($obj)  { 
			$this->setupProps($obj);
			$this->checkFileName();
			$this->generate();
		}
		
		/**
		 *	setupProps
		 *	- sets the properties common to all Upload types
		 */
		protected function setupProps($obj = NULL) {
			$this->props = new stdClass();
			$this->props->type = isset($obj->type) && $obj->type != "" ? $obj->type : "single";
			$this->props->fileName = isset($obj->fileName) ? $obj->fileName : "";
			$this->props->tmpFileName = isset($obj->tmpFileName) ? $obj->tmpFileName : "";
			$this->props->targetDirectory = isset($obj->targetDirectory) ? $obj->targetDirectory : "";
			$this->props->uploadField = isset($obj->uploadField) && $obj->uploadField != "" ? $obj->uploadField : "fileName";
			$this->props->awsAccessKey = isset($obj->awsAccessKey) ? $obj->awsAccessKey : "";
			$this->props->awsSecretKey = isset($obj->awsSecretKey) ? $obj->awsSecretKey : "";
			$this->props->bucketName = isset($obj->bucketName) ? $obj->bucketName : "";
		}
		
		/**
		 *	generate
		 *	- instance our strategy
		 */
		private function generate() {
			 switch($this->props->type) {
				case "aws":
					$this->uploadStrategy = new AmazonUploadStrategy();
				break;
				
				case "image":
					
				break;
				
				case "multiple":
					
				break; 
				
				default:
					$this->uploadStrategy = new SingleUploadStrategy();
				break;
			 }	
		}
		
		/**
		 *	checkFileName
		 *	- make sure file name is legal (upper & lower case letters, numbers, dashes & underscores only followed by a 3 or 4 letter extension)
		 */
		private function checkFileName() {
			if(preg_match('/^[a-zA-Z0-9-_]+\.[a-zA-Z-_]{3,4}$/', $this->props->fileName)) $this->errorCode = 0;
			else $this->errorCode = 3;
		}
		
		/**
		 *	uploadFile
		 *	- invokes the required upload strategy based on $this->type
		 *	- returns parsed data
		 */
		public function uploadFile() {
			 if ($this->errorCode == 0) $this->errorCode = $this->uploadStrategy->uploadFile($this->props);
			 return $this->errorCode;
		}
		
		public function generateFile() {
			if ($this->errorCode == 0) $this->errorCode = $this->uploadStrategy->generateFile($this->props);
			return $this->errorCode;	
		}
		
		public function generateDirectory() {
			if ($this->errorCode == 0) $this->errorCode = $this->uploadStrategy->generateDirectory($this->props);
			return $this->errorCode;	
		}
		 
		/**
		 *	deleteFile
		 *	- called by the implementing class when our file is parsed into memory and ready to be deleted
		 */
		public function deleteFile() {
		 	$this->errorCode = $this->uploadStrategy->deleteFile($this->props);
			return $this->errorCode;  
		}
		 
		/**
		 *	getFileName
		 *	- get our full URL fileName from our upload strategy
		 */
		public function getFileName() {
			return $this->uploadStrategy->getFileName($this->props);	 
		}
		
		public function setProp($prop, $value) {
			$this->props->$prop = $value;	
		}
		
		public function getProp($prop) {
			return $this->props->$prop;	
		}
		
		/**
		 *	getDirectoryContents
		 *	- return the contents of a given url
		 */
		public function getDirectoryContents() {
			return $this->uploadStrategy->getDirectoryContents($this->props);	
		}
		
		/**
		 *	doesFileExist
		 */
		public function doesFileExist() {
			return $this->uploadStrategy->doesFileExist($this->props);	
		}
		
		public function getDirectoryInfo() {
			return $this->uploadStrategy->getDirectoryInfo($this->props);		
		}
		
		public function getFileInfo() {
			return $this->uploadStrategy->getFileInfo($this->props);		
		}
		
		public function getObject() {
			return $this->uploadStrategy->getObject($this->props);	
		}
		
		public function uploadObject() {
			return $this->uploadStrategy->uploadObject($this->props);	
		}
		
		public function setACP($obj) {
			return $this->uploadStrategy->setACP($obj);	
		}
		
		public function getACP($obj) {
			return $this->uploadStrategy->getACP($obj);	
		}
		
	}
	

?>