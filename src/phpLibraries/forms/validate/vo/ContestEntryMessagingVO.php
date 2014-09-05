<?

	
	/**
		-----------------------------------------------------
		
		ContestEntryMessagingVO
		
		NOTES:
		messaging pertinent to validating submitted contest data
	
		----------------------------------------------------
	*/
	
	
	class ContestEntryMessagingVO {
		
		private $messages;			//	definition of error messages
		private $displayMessage;	// array of messages we return
		
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			$this->setupProps();
		}
		
		
		private function setupProps() {
			
			$this->displayMessages = array();
			
			$this->messages = array(
					array("en" => "Thank you for entering the contest!", "fr" => "Merci beaucoup!"),
					array("en" => "Please enter a valid phone number.", "fr" => "Inscris un num&eacute;ro de t&eacute;l&eacute;phone valide s.v.p."),
					array("en" => "Email address is invalid.", "fr" => "Adresse de courriel non valide."),
					array("en" => "Sorry, you can only enter once per day.", "fr" => "D&eacute;sol&eacute;! Tu peux participer qu'une fois par jour."),
					array("en" => "You have already reached the contest entry submission limit for today!", "fr" => "Tu as atteint la limite d'inscription du concours pour aujourd'hui!"),
					array("en" => "Invalid referer", "fr" => "Referer inadmissible"),
					array("en" => "Please enter a valid postal code.", "fr" => "Code postal non valide."),
					array("en" => "Users under the age of 13 who reside in Quebec are restricted by provincial regulations from entering this contest", "fr" => "La loi provinciale interdit aux utilisateurs &acirc;g&eacute;s de moins de 13 ans r&eacute;sidant au Qu&eacute;bec de s'inscrire &agrave ce concours"),
					array("en" => "Users under the age of 18 are not eligible to enter this contest", "")
			);
		}
		
		/**
		 *	addMessage
		 *	invoked by implementing class to add an error message to displayMessages
		 */
		public function addMessage($num, $language) {
			array_push($this->displayMessages, $this->messages[$num][$language]);	
		}
		
		/**
		 *	getMessage
		 *	- invoked by implementing class to return array of error messages
		 */
		public function getMessage() {
			return $this->displayMessages;
		}
	}

?>