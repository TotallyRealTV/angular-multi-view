<?

	
	/**
		-----------------------------------------------------
		
		CampTeletoonContestRegistrationMessagingVO
		
		NOTES:
		messaging pertinent to validating submitted contest data
	
		----------------------------------------------------
	*/
	
	
	class CampTeletoonContestRegistrationMessagingVO {
		
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
				array("en" => array("You are now registered to enter the Camp Teletoon Contest!", ""), "fr" => array("Tu es maintenant enregistré au concours Camp Télétoon!", "")),
				array("en" => array("You have already registered for the Camp Teletoon Contest.", ""), "fr" => array("Tu es déjà enregistré au concours Camp Télétoon!", "")),
				array("en" => array("Please enter a valid phone number.", "phone"), "fr" => array("S'il te plait, entre un numéro de téléphone valide", "phone")),
				array("en" => array("Please enter a valid postal code.", "pCode"), "fr" => array("Code postal non valide.", "pCode")),
				array("en" => array("Email address is invalid.", "email"), "fr" => array("L'adresse courriel est invalide.", "email")),
				array("en" => array("Users under the age of 13 who reside in Quebec are restricted by provincial regulations from entering this contest", "year|month|day|province"), "fr" => array("La loi provinciale interdit aux utilisateurs &acirc;g&eacute;s de moins de 13 ans r&eacute;sidant au Qu&eacute;bec de s'inscrire &agrave ce concours", "year|month|day|province")),
				array("en" => array("Your name should really only contain letters.", "first_name|last_name"), "fr" => array("Ton nom doit contenir seulement des lettres", "first_name|last_name")),
				array("en" => array("Your name should really only contain letters.", "first_name|last_name"), "fr" => array("Ton nom doit contenir seulement des lettres", "first_name|last_name")),
				array("en" => array("Your information has been successfully updated!", ""), "fr" => array("Tes informations ont été mis à jours!", ""))
				//array("en" => array("Sorry, you can only enter once per day.", ""), "fr" => array("D&eacute;sol&eacute;! Tu peux participer qu'une fois par jour.", ""))
			);
		}
		
		/**
		 *	addMessage
		 *	invoked by implementing class to add an error message to displayMessages
		 */
		public function addMessage($num, $language) {
			array_push($this->displayMessages, $this->messages[$num][$language]);
		}
		
		public function setMessage($num, $language) {
			//$this->displayMessages = array();
			$this->addMessage($num, $language);
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