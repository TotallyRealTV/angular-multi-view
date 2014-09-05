<?
	
	/**
	 *	This class generates and returns standard TXT Output structures for TELETOON games:
	 *
	*/
	
	include_once('ITXTOutput.php');
	
	class LegacyGamesTxtOutput extends ITXTOutput {
		
		// override properties here as required
		
		/*
		
		user0=lufc4ever&points0=4450&user1=lufc4ever&points1=4350&user2=lufc4ever&points2=4350&user3=lufc4ever&points3=4350&user4=lufc4ever&points4=4300&user5=lufc4ever&points5=4300&user6=lufc4ever&points6=4300&user7=lufc4ever&points7=4300&user8=lufc4ever&points8=4300&user9=lufc4ever&points9=4300&errorMsg=0
		
		*/
		
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
		}
		
		protected function generateData() {
			for ($i = 0; $i < count($this->props->gameData); $i++) {
				$this->txt .= "user" . $i . "=" . $this->props->gameData[$i]['userName'];
				$this->txt .= "&points" . $i . "=" . $this->props->gameData[$i]['totalPoints'];
				$this->txt .= "&"; 	
			}

			$this->txt .= "errorMsg=" . $this->props->errorCode;
		}
		
		protected function generateMessage() {
			$this->txt .= "&msg=".$this->props->messaging;
			$this->txt .= "&code=".$this->props->messageCode;
		}
		
		/**
		 *	public methods
		 */
		public function generateOutput() {
			$this->generateData();
			echo $this->txt;	
		}
		
  	}

?>