<?
	/**
	 * 	The Upload File Controller encapsulates the business logic for uploadinf a file / groups of files
	 *
	 *	This is a simple, first-phase implementation and does not contain APC hooks for tracking progress
	 *
	 *	Currently-supported formats:
	 *
	 *	It is incumbent on the implementing class to match errorCodes herein to appropriate messaging	
	 *	
	 */
	
	require_once("vo/UploadFileMessagingVO.php");
	
	class UploadFileController {
		
		protected $props;					//	an object to hold our critical properties required to upload a file
		protected $errorCode;				//	errorCode to return to implementing class
		protected $message;					//	holds file upload related messages
		
		public function __construct($obj)  { 
			$this->setupProps($obj);
			$this->generateMessaging();
		}
		
		/**
		 *	setupProps
		 *	- sets the properties common to all Archive types
		 */
		protected function setupProps($obj = NULL) {
			$this->errorCode = 0;
			
			$this->props = new stdClass();
			$this->props->files = isset($obj->files) ? $obj->files : array();
			$this->props->fileNames = $this->generateFileNames();
			$this->props->uploadPath = isset($obj->uploadPath) ? $obj->uploadPath : "";
			$this->props->tvUploadPath = isset($obj->tvUploadPath) ? $obj->tvUploadPath : "";
			$this->props->prevFiles = isset($obj->prevFiles) ? $obj->prevFiles : array();
			//testOutput('obj', $this->props);
		}
		
		protected function generateMessaging() {
			$this->messaging = new UploadFileMessagingVO();
		}
		
		private function generateFileNames() {
			$fileNames = array();
			
			foreach ($this->props->files as $key=>$value) {
				$uploadType = "";
				if (contains("extra", $key)) $uploadType = "extra";
				else if (contains("mega_promo", $key)) $uploadType = "mega_promo"; 
				
				array_push($fileNames, array("fileName" => $key, "uploadType" => $uploadType));	
			}
			
			return $fileNames;
		}
		
		
		/**
		 *	archiveFiles
		 *	- invokes the required archive strategy based on $this->type
		 *	- archives files by $this->props->targetDirectory . '/' . $this->props->data[$i]
		 *	- returns errorCode (0 = succes, 1 = error)
		 */
		public function upload() {
			$count = count($this->props->files);
			$uploadPath = "";
			
			for ($i = 0; $i < $count; $i++) {
				switch ($this->props->fileNames[$i]["uploadType"]) {
					case "mega_promo":
						$uploadPath = $this->props->tvUploadPath;
					break;
					
					default:
						$uploadPath = $this->props->uploadPath;
					break;	
				}
				
				$this->deleteFile($uploadPath, $this->props->prevFiles[$i]);
				
				if (!move_uploaded_file($this->props->files[$this->props->fileNames[$i]['fileName']]['tmp_name'], $uploadPath . $this->props->files[$this->props->fileNames[$i]['fileName']]['name'])) {
					$this->errorCode = 1;	
				}
			}
			 
			return $this->errorCode;
		}
		 
		/**
		 *	deleteFile
		 *	- called by the implementing class when our file is parsed into memory and ready to be deleted
		 */
		public function deleteFile($path, $file) {
			if (file_exists($path . $file) && !is_dir($path . $file)) unlink($path . $file);  
		}
		
		public function getMessage($num) {
			return $this->messaging->getMessage($num);	
		}
	}
	

?>