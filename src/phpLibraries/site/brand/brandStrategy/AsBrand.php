<?

	/**
	 *	AsBrand.php
	 *
	 *	Created:
	 *	2012-04-20
	 *
	 *	Modified:
	 *	2012-04-20
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- encapsulates unique data associated with the Teletoon Brand
	 */


	/**
	 * supporting files
	 */

		include_once('BaseBrand.php');
  	
	
	
		class AsBrand extends BaseBrand {
		
		
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				parent::setupProps();
				parent::populateBrand($obj);
				$this->populateBrand();
			}
			
			/**
			 *	setupProps
			 *	- sets base
			 *	- defines unique brand properties
			 */
			protected function populateBrand($obj = NULL) {
				/*$this->brand->baseFilePath = "/opt1/htdocs/adultswim";						// live
				$this->brand->exportIp = "http://www.adultswim.ca";								// live
				$this->brand->exportUrl = "http://www.adultswim.ca";*/						// live
				
				$this->brand->baseFilePath = $_SERVER['DOCUMENT_ROOT'] . "/adultswim";			// local
				$this->brand->exportIp = "http://localhost/adultswim";							// local
				$this->brand->exportUrl = "http://localhost/adultswim";						// local
				
				$this->brand->gamePreviewUrl = $this->brand->exportUrl . "/games/";
				$this->brand->tvPreviewUrl = $this->brand->exportUrl . "/tv/";
				$this->brand->gamesFilePath = $this->brand->baseFilePath . $this->brand->baseGamesUrl;
				$this->brand->tvFilePath = $this->brand->baseFilePath . $this->brand->baseTvUrl;
				
				$this->brand->gamesHtaccessFilePath = $this->brand->gamesFilePath . ".htaccess";
				$this->brand->gamesHtaccessTvFilePath = $this->brand->tvFilePath . ".htaccess";
				
				$this->brand->gamesMetaTemplate = ROOT_PATH . "model/games/templates/meta/as_meta.html";
				$this->brand->tvMetaHomeTemplate = ROOT_PATH . "model/tv/templates/meta/as_meta_home.html";
				
				$this->brand->dbProps->adminDb = "AdultSwim";
				$this->brand->dbProps->gamesDb = "AdultSwimGames";
				$this->brand->dbProps->archiveGamesDb = "AdultSwimGameArchiveFY";
				$this->brand->dbProps->scoresTablePrefix = "scores";
				$this->brand->dbProps->archiveTablePrefix = "archivefy";
				
				$this->brand->trackingProps = new stdClass();
				$this->brand->trackingProps->googleAccount = "UA-31053235-2";
				
				// upload directories
				$this->brand->uploadDirectories->basePath = "/as/images/";
				
				$this->brand->contentRating->type = "number";
				$this->brand->contentRating->filePath = $this->brand->baseFilePath . "/data/ratings/games/";
				
				$this->brand->includePaths->gamesPath = "games/";
				$this->brand->includePaths->highlightedGames = $this->brand->includePaths->gamesPath . "games.js";
				
				$this->brand->brightCove->fileCachePath = $this->brand->baseFilePath . '/data/video/cache/';
				
				$this->brand->gamePageName = "index.php";
			}
		}



?>