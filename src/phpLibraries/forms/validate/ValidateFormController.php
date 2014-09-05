<?
	/**
	 * 	The ValidateForm Controller encapsulates the business logic for validating various flavours of forms
	 *
	 *	Currently-supported form types:
	 *	- contestEntry
	 *
	 *	
	 */
	
	require_once("formValidationStrategy/ContestEntryValidationStrategy.php");
	require_once("formValidationStrategy/admin/AddGamesAdminValidationStrategy.php");
	require_once("formValidationStrategy/admin/EditGamesAdminValidationStrategy.php");
	require_once("formValidationStrategy/admin/AddTvAdminValidationStrategy.php");
	require_once("formValidationStrategy/admin/EditTvAdminValidationStrategy.php");
	require_once("formValidationStrategy/admin/AddVideoAdminValidationStrategy.php");
	require_once("formValidationStrategy/admin/EditVideoAdminValidationStrategy.php");
	require_once("formValidationStrategy/admin/AddPlaylistAdminValidationStrategy.php");
	require_once("formValidationStrategy/admin/EditPlaylistAdminValidationStrategy.php");
	require_once("formValidationStrategy/admin/GroupAdminValidationStrategy.php");
	require_once("formValidationStrategy/toonFeud/ToonFeudGameAdminValidationStrategy.php");
	require_once("formValidationStrategy/toonFeud/ToonFeudBadgeAdminValidationStrategy.php");
	require_once("formValidationStrategy/toonFeud/ToonFeudCategoryAdminValidationStrategy.php");
	require_once("formValidationStrategy/campTeletoon/CampTeletoonRegistrationValidationStrategy.php");
	require_once("formValidationStrategy/campTeletoon/CampTeletoonContestRegistrationValidationStrategy.php");
	require_once("formValidationStrategy/campTeletoon/CampTeletoonContestRegistrationUpdateValidationStrategy.php");
	
	class ValidateFormController {
		
		protected $props;						//	an object to hold our critical properties required to upload a file
		protected $formValidationStrategy;		//	holds our Upload instance
		
		
		public function __construct($obj)  { 
			$this->setupProps($obj);
		}
		
		/**
		 *	setupProps
		 *	- sets the properties common to all Archive types
		 */
		protected function setupProps($obj = NULL) {
			$this->props = new stdClass();
			$this->props->validationType = isset($obj->validationType) && $obj->validationType != "" ? $obj->validationType : "";
			$this->props->data = isset($obj->data) ? $obj->data : NULL;
			$this->props->dbTable = isset($obj->dbTable) ? $obj->dbTable : "";
			$this->props->conditionalRange = isset($obj->conditionalRange) ? $obj->conditionalRange : NULL;
			$this->props->formAction = isset($obj->formAction) ? $obj->formAction : "";
			
			if (isset($obj->host)) $this->props->host = $obj->host;
			if (isset($obj->user)) $this->props->user = $obj->user;
			if (isset($obj->password)) $this->props->password = $obj->password;
			if (isset($obj->dbName)) $this->props->dbName = $obj->dbName;
		}
		
		/**
		 *	validateForm
		 *	- invokes the required archive strategy based on $this->type
		 *	- archives files by $this->props->targetDirectory . '/' . $this->props->data[$i]
		 *	- returns errorCode (0 = succes, 1 = error)
		 */
		public function validateForm() {
			 switch($this->props->validationType) {
				case "contestEntry":
					$this->formValidationStrategy = new ContestEntryValidationStrategy();
				break;
				
				case "login":
					
				break;
				
				case "register":
					
				break;
				
				case "gamesAdminAdd":
					$this->formValidationStrategy = new AddGamesAdminValidationStrategy();
				break;
				
				case "gamesAdminEdit":
					$this->formValidationStrategy = new EditGamesAdminValidationStrategy();
				break;
				
				case "tvAdminAdd":
					$this->formValidationStrategy = new AddTvAdminValidationStrategy();
				break;
				
				case "tvAdminEdit":
					$this->formValidationStrategy = new EditTvAdminValidationStrategy();
				break;
				
				case "videoAdminAdd":
					$this->formValidationStrategy = new AddVideoAdminValidationStrategy();
				break;
				
				case "videoAdminEdit":
					$this->formValidationStrategy = new EditVideoAdminValidationStrategy();
				break;
				
				case "playlistAdminAdd":
					$this->formValidationStrategy = new AddPlaylistAdminValidationStrategy();
				break;
				
				case "playlistAdminEdit":
					$this->formValidationStrategy = new EditPlaylistAdminValidationStrategy();
				break;
				
				case "groupAdmin":
					$this->formValidationStrategy = new GroupAdminValidationStrategy();
				break;
				
				case "toonFeudGame":
					$this->formValidationStrategy = new ToonFeudGameAdminValidationStrategy();
				break;
				
				case "toonFeudBadge":
					$this->formValidationStrategy = new ToonFeudBadgeAdminValidationStrategy();
				break;
				
				case "toonFeudCategory":
					$this->formValidationStrategy = new ToonFeudCategoryAdminValidationStrategy();
				break;
				
				case "campTeletoonRegister":
					$this->formValidationStrategy = new CampTeletoonRegistrationValidationStrategy();
				break;
				
				case "campTeletoonContestRegister":
					$this->formValidationStrategy = new CampTeletoonContestRegistrationValidationStrategy();
				break;
				
				case "campTeletoonContestRegisterUpdate":
					$this->formValidationStrategy = new CampTeletoonContestRegistrationUpdateValidationStrategy();
				break;
				
				default:
					$this->errorCode = 1;
				break;
			 }
			 
			 
			 return $this->formValidationStrategy->validateForm($this->props);
		}
		
		public function getMessage() {
			return $this->formValidationStrategy->getMessage();	
		}
		
	}
	

?>