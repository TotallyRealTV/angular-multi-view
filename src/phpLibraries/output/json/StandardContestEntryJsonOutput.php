<?
	
	/**
	 *	This class generates and returns standard JSON Output structures for TELETOON games:
	 *
	 *	Structure:
	 *	$json = (object) NULL;
		$json->diagnostic = (object) NULL;
		$json->diagnostic->success = $isSuccess;
		$json->diagnostic->timeStamp = time();
		if ($isSuccess == true) {
			$json->returnData = (object) NULL;
			$json->returnData->contestData = $contestData;
		}

		echo json_encode($json);
	 */
	
	include_once('IJSONOutput.php');
	
	class StandardContestEntryJsonOutput extends IJSONOutput {
		
		// override properties here as required
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			$this->setupProps($obj);
			$this->generateDiagnostic();
		}
		
		protected function setupProps($obj) {
			$this->json = new stdClass();
			$this->props = new stdClass();
			
			$this->props->errorCode = 0;
			$this->props->messageCode = 0;
			$this->props->timeStamp = time();
			$this->props->messaging = "";
			
			foreach ($obj as $key=>$value) {
				$this->props->$key = $value;	
			}
		}
		
		protected function generateDiagnostic() {
			$this->json->diagnostic = new stdClass();
			$this->json->diagnostic->errorCode = $this->props->errorCode;
			$this->json->diagnostic->timeStamp = $this->props->timeStamp;	
		}
		
		protected function generateMessage() {
			$this->json->message = new stdClass();
			
			if (is_array($this->props->messaging)) {
				foreach($this->props->messaging as $key=>$value) {
					$this->json->message->text .= $value;	
				}
			} else {
				$this->json->message->text = $this->props->messaging;		
			}
				
			$this->json->message->code = $this->props->messageCode;
		}
		
		/**
		 *	public methods
		 */
		public function generateOutput() {
			$this->generateMessage();
			echo json_encode($this->json);	
		}
		
  	}

?>