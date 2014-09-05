<?
	
	/**
	 *	This class provides the primary decision making in regards to the type of output
	 *	we want to generate
	 */
	 
	include_once('IJSONOutputFactory.php');
	include_once("StandardGamesJsonOutput.php");
	include_once("CampTeletoonGamesJsonOutput.php");
	include_once("StandardActivityJsonOutput.php");
	include_once("StandardLinksJsonOutput.php");
	include_once("StandardPollsJsonOutput.php");
	include_once("StandardImageGalleryJsonOutput.php");
	include_once("StandardContestEntryJsonOutput.php");
	include_once("ViewRatingJsonOutput.php");
	
	class JSONOutputFactory extends IJSONOutputFactory {
		
		private $jsonOutput;
		
		/**
		 *	generateOutput
		 *	- checks $obj->outputType to instance the correct type of output factory required.
		 *	- valid options are currently:
		 *		"json"
		 *	- future implementations may extend to:
		 *		"xml"
		 *		"txt"
		 *		"soap"
		 */
		public function generateOutput($obj) {
			
			switch ($obj->output->type) {
				
				case "standardGames":
					$this->jsonOutput = new StandardGamesJsonOutput($obj);	
				break;
				
				case "campTeletoonGames":
					$this->jsonOutput = new CampTeletoonGamesJsonOutput($obj);	
				break;
				
				case "standardActivity":
					$this->jsonOutput = new StandardActivityJsonOutput($obj);
				break;
				
				case "standardContestEntry":
					$this->jsonOutput = new StandardContestEntryJsonOutput($obj);
				break;
				
				case "viewRating":
				case "setRating":
					$this->jsonOutput = new ViewRatingJsonOutput($obj);
				break;
				
				case "standardLinks":
					$this->jsonOutput = new StandardLinksJsonOutput($obj);
				break;
				
				case "standardPolls":
					$this->jsonOutput = new StandardPollsJsonOutput($obj);
				break;
				
				case "standardImageGallery":
					$this->jsonOutput = new StandardImageGalleryJsonOutput($obj);
				break;
				
				default: 
					return NULL;	
				break;
					
			}
			
			$this->jsonOutput->generateOutput();
		}
  	}

?>