<?

	/**
	 *	CnBrand.php
	 *
	 *	Created:
	 *	2012-03-23
	 *
	 *	Modified:
	 *	2012-03-23
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- encapsulates unique data associated with the Cartoon Network Brand
	 */


	/**
	 * supporting files
	 */

		include_once('BaseBrand.php');
  	
	
	
		class CnBrand extends BaseBrand {
		
		
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
				/*$this->brand->baseFilePath = "/opt1/htdocs/cartoonnetwork";						// live
				$this->brand->exportIp = "http://www.cartoonnetwork.ca";								// live
				$this->brand->exportUrl = "http://www.cartoonnetwork.ca";*/		// live
				
				$this->brand->baseFilePath = $_SERVER['DOCUMENT_ROOT'] . "/cartoonnetwork";		// local
				$this->brand->exportIp = "http://localhost/cartoonnetwork";							// local
				$this->brand->exportUrl = "http://localhost/cartoonnetwork";				// local
				
				$this->brand->gamePreviewUrl = $this->brand->exportUrl . "/games/";
				$this->brand->tvPreviewUrl = $this->brand->exportUrl . "/tv/";
				$this->brand->gamesFilePath = $this->brand->baseFilePath . $this->brand->baseGamesUrl;
				$this->brand->tvFilePath = $this->brand->baseFilePath . $this->brand->baseTvUrl;
				
				$this->brand->gamesHtaccessFilePath = $this->brand->gamesFilePath . ".htaccess";
				$this->brand->gamesHtaccessTvFilePath = $this->brand->tvFilePath . ".htaccess";
				
				$this->brand->gamesMetaTemplate = ROOT_PATH . "model/games/templates/meta/cn_meta.html";
				$this->brand->tvMetaHomeTemplate = ROOT_PATH . "model/tv/templates/meta/cn_meta_home.html";
				$this->brand->tvMetaGamesTemplate = ROOT_PATH . "model/tv/templates/meta/cn_meta_games.html";
				$this->brand->tvMetaVideoTemplate = ROOT_PATH . "model/tv/templates/meta/cn_meta_video.html";
				$this->brand->tvMetaCharactersTemplate = ROOT_PATH . "model/tv/templates/meta/cn_meta_characters.html";
				$this->brand->tvMetaPicturesTemplate = ROOT_PATH . "model/tv/templates/meta/cn_meta_pictures.html";
				
				$this->brand->dbProps->adminDb = "CartoonNetwork";
				$this->brand->dbProps->gamesDb = "CartoonNetworkGames";
				$this->brand->dbProps->archiveGamesDb = "CartoonNetworkGameArchiveFY";
				$this->brand->dbProps->scoresTablePrefix = "scores";
				$this->brand->dbProps->archiveTablePrefix = "archivefy";
				$this->brand->dbProps->gamesTableTemplate = "gametemplate";
				$this->brand->dbProps->showsDb = "CartoonNetworkShows";
				
				$this->brand->trackingProps = new stdClass();
				$this->brand->trackingProps->googleAccount = "UA-31053235-1";
				
				// upload directories
				$this->brand->uploadDirectories->basePath = "/cn/images/";
				
				// content rating
				$this->brand->contentRating->type = "star";
				$this->brand->contentRating->filePath = $this->brand->baseFilePath . "/data/ratings/games/";
				
				// include paths
				$this->brand->includePaths->gamesPath = "games/";
				$this->brand->includePaths->highlightedGames = $this->brand->includePaths->gamesPath . "games.js";
				
				$this->brand->brightCove->fileCachePath = $this->brand->baseFilePath . '/data/video/cache/';
				
				$this->brand->gamePageName = "index.php";
			}
		}
?>