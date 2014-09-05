<?
	
	/**
	 *	This class generates and returns standard TXT Output structures for TELETOON games:
	 *
	*/
	
	include_once('ITXTOutput.php');
	
	class StandardGamesTxtOutput extends ITXTOutput {
		
		// override properties here as required
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			$this->setupProps($obj);
		}
		
		protected function setupProps($obj) {
			$this->txt = "";
			$this->props = new stdClass();
			
			$this->props->errorCode = 0;
			$this->props->messageCode = 0;
			$this->props->timeStamp = time();
			$this->props->messaging = "";
			$this->props->gameData = "";
			
			foreach ($obj as $key=>$value) {
				$this->props->$key = $value;	
			}

			//testOutput('obj', $this->props);
		}
		
		protected function generateData() {
			$this->txt .= "errorMsg=0&";
			if (is_array($this->props->gameData)) {
				for ($i = 0; $i < count($this->props->gameData); $i++) {
					$this->txt .= "user" . $i . "=" . $this->props->gameData[$i]['userName'];
					$this->txt .= "&points" . $i . "=" . $this->props->gameData[$i]['totalPoints'];
					if ($i < count($this->props->gameData) - 1) $this->txt .= "&"; 	
				}

			} else {
				$this->txt .= "gameData=".$this->props->gameData;
			}

			$this->txt .= "&medal=/fun/games/demo/achievement.swf";
		}
		
		protected function generateMessage() {
			$this->txt .= "&errorMsg=".$this->props->messaging;
			$this->txt .= "&code=".$this->props->messageCode;
			$this->txt .= "&medal=/fun/games/demo/achievement.swf";
		}
		
		/**
		 *	public methods
		 */
		public function generateOutput() {
			if ($this->props->errorCode == 0) $this->generateData();
			else $this->generateMessage();
			echo $this->txt;	
		}
		
  	}

?>