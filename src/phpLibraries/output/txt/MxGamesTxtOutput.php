<?
	
	/**
	 *	This class generates and returns standard TXT Output structures for TELETOON games:
	 *
	*/
	
	include_once('ITXTOutput.php');
	
	class MxGamesTxtOutput extends ITXTOutput {
		
		// override properties here as required
		
		/*
		
		user0=shayneharper&date0=2012-11-03&time0=13:00:05&points0=2900&totalPoints0=2900&user1=shayneharper&date1=2012-11-03&time1=12:56:37&points1=1600&totalPoints1=1600&user2=shayneharper&date2=2012-11-03&time2=12:54:40&points2=350&totalPoints2=350&user3=shayneharper&date3=2012-11-03&time3=12:55:06&points3=50&totalPoints3=50&errorMsg=0
		
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
				$dateTime = explode(" ", $this->props->gameData[$i]['dateTime']);
				$this->txt .= "user" . $i . "=" . $this->props->gameData[$i]['userName'];
				$this->txt .= "&date" . $i . "=" . $dateTime[0];
				$this->txt .= "&time" . $i . "=" . $dateTime[1];
				$this->txt .= "&points" . $i . "=" . $this->props->gameData[$i]['totalPoints'];
				$this->txt .= "&totalPoints" . $i . "=" . $this->props->gameData[$i]['totalPoints'];
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