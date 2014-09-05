<?

	
	/**
		-----------------------------------------------------
		
		CampTeletoonRegistrationMessagingVO
		
		NOTES:
		messaging pertinent to validating submitted contest data
	
		----------------------------------------------------
	*/
	
	
	class CampTeletoonRegistrationMessagingVO {
		
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
				array("en" => array("You have successfully registered for Camp Teletoon!", ""), "fr" => array("Tu es enregistré avec succès au Camp Télétoon!", "")),
				array("en" => array("A user with this account information already exists. Please try again.", ""), "fr" => array("Un compte utilisateur avec ces informations existe déjà. Essaie de nouveau.", "")),
				array("en" => array("Email address is invalid.", "email_register"), "fr" => array("L'adresse courriel est invalide", "email_register")),
				array("en" => array("A username can only contain letters and numbers.", "user_name_register"), "fr" => array("Le nom d'utilisateur doit contenir seulement des lettres et des chiffres", "user_name_register")),
				array("en" => array("A password can only contain letters and numbers.", "password_register"), "fr" => array("Le mot de passe doit contenir seulement des lettres et des chiffres", "password_register"))
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
			$this->displayMessages = array();
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