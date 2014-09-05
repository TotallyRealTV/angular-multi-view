<?

	/**
	 *	RetroBrand.php
	 *
	 *	Created:
	 *	2012-07-26
	 *
	 *	Modified:
	 *	2012-07-26
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- encapsulates unique data associated with the Teletoon Retro Brand
	 */


	/**
	 * supporting files
	 */

		include_once('BaseBrand.php');
  	
	
	
		class RetroBrand extends BaseBrand {
		
		
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				parent::setupProps($obj);
				parent::populateBrand($obj);
				$this->populateBrand($obj);
			}
			
			/**
			 *	setupProps
			 *	- sets base
			 *	- defines unique brand properties
			 */
			protected function populateBrand($obj = NULL) {
				
				$this->brand->language = isset($obj['language']) && $obj['language'] != "" ? $obj['language'] : "en";
				
				/*$this->brand->baseFilePath = "/opt1/htdocs/teletoonretro/" . $this->brand->language;						// live
				$this->brand->exportIp = "http://www.teletoonretro.com/" . $this->brand->language;							// live
				$this->brand->exportUrl = "http://www.teletoonretro.com/" . $this->brand->language;	*/					// live */
				
				$this->brand->baseFilePath = $_SERVER['DOCUMENT_ROOT'] . "/teletoonretro/" . $this->brand->language;		// local
				$this->brand->exportIp = "http://localhost/teletoonretro/" . $this->brand->language;						// local
				$this->brand->exportUrl = "http://localhost/teletoonretro/" . $this->brand->language;					// local*/
				
				$this->brand->gamePreviewUrl = $this->brand->exportUrl . "/games/";
				$this->brand->tvPreviewUrl = $this->brand->exportUrl . "/tv/";
				$this->brand->gamesFilePath = $this->brand->baseFilePath . $this->brand->baseGamesUrl;
				$this->brand->tvFilePath = $this->brand->baseFilePath . $this->brand->baseTvUrl;
				
				$this->brand->gamesHtaccessFilePath = $this->brand->gamesFilePath . ".htaccess";
				$this->brand->gamesHtaccessTvFilePath = $this->brand->tvFilePath . ".htaccess";
				$this->brand->highScoresTemplate = ROOT_PATH . "model/games/templates/RetroScoresVO.txt";
				
				$this->brand->gamesMetaTemplate = ROOT_PATH . "model/games/templates/meta/retro_meta_" . $this->brand->language . ".html";
				$this->brand->tvMetaHomeTemplate = ROOT_PATH . "model/tv/templates/meta/retro_meta_home_" . $this->brand->language . ".html";
				$this->brand->tvMetaGamesTemplate = ROOT_PATH . "model/tv/templates/meta/retro_meta_games_" . $this->brand->language . ".html";
				$this->brand->tvMetaVideoTemplate = ROOT_PATH . "model/tv/templates/meta/retro_meta_video_" . $this->brand->language . ".html";
				$this->brand->tvMetaCharactersTemplate = ROOT_PATH . "model/tv/templates/meta/retro_meta_characters_" . $this->brand->language . ".html";
				$this->brand->tvMetaPicturesTemplate = ROOT_PATH . "model/tv/templates/meta/retro_meta_pictures_" . $this->brand->language . ".html";
				
				$this->brand->dbProps->adminDb = "TeletoonRetro";
				$this->brand->dbProps->gamesDb = "TeletoonRetroGames";
				$this->brand->dbProps->archiveGamesDb = "TeletoonRetroGameArchiveFY";
				$this->brand->dbProps->archiveTablePrefix = "ArchiveFY";
				$this->brand->dbProps->scoresTablePrefix = "Score";
				$this->brand->dbProps->gamesTableTemplate = "gametemplate";
				$this->brand->dbProps->showsDb = "TeletoonRetroShows";
				
				$this->brand->trackingProps = new stdClass();
				$this->brand->trackingProps->google = new stdClass();
				$this->brand->trackingProps->google->account_en = "UA-37608533-1";
				$this->brand->trackingProps->google->account_fr = "UA-37608533-2";
				
				// upload directories
				$this->brand->uploadDirectories->basePath = "/retro/images/";
				
				// content rating
				$this->brand->contentRating->type = "star";
				$this->brand->contentRating->filePath = $this->brand->baseFilePath . "/data/ratings/games/";
				
				// include paths
				$this->brand->includePaths->basePath = "/retro/includes/";
				$this->brand->includePaths->gamesPath = $this->brand->includePaths->basePath . "games/";
				$this->brand->includePaths->highlightedGames = $this->brand->includePaths->gamesPath . "games.js";
				$this->brand->includePaths->moreGamesPath = $this->brand->includePaths->basePath . "more-games/";
				$this->brand->includePaths->homeVideosTemplate = ROOT_PATH . "model/video/templates/retro_videos_home_" . $this->brand->language . ".html";
				$this->brand->includePaths->homeVideosItem = ROOT_PATH . "model/video/templates/retro_videos_home_item.html";
				$this->brand->includePaths->homeVideosIncludePath = $this->brand->exportIp . $this->brand->includePaths->basePath . "home/";
				$this->brand->includePaths->homeVideosIncludeFile = $this->brand->includePaths->homeVideosIncludePath . "videos.html";
				$this->brand->brightCove->fileCachePath = $this->brand->baseFilePath . '/data/video/cache/';
				
				$this->brand->gameTracking->legacyScripts->createGamePlayUrl = "/api/utils/games/retro/legacy/createGamePlay.php";
				$this->brand->gameTracking->legacyScripts->updateGamePlayUrl = "/api/utils/games/retro/legacy/updateGamePlay.php";
				$this->brand->gameTracking->legacyScripts->highScoresUrl = "/api/utils/games/retro/legacy/showHighScores.php";
				
				$this->brand->toonFeud->paths->baseURL = "http://www.teletoonretro.com/" . $this->brand->language . "/games/toon-feud/";
				$this->brand->toonFeud->paths->filePath = $this->brand->baseFilePath . "/games/toon-feud/";
				$this->brand->toonFeud->paths->filePathTest = $this->brand->baseFilePath . "/games/toon-feud-test/";
				$this->brand->toonFeud->paths->gamesPath = "games/";
				$this->brand->toonFeud->paths->dataPath = $this->brand->toonFeud->paths->basePath . "data/";
				$this->brand->toonFeud->appIDs = array("en" => array("toonfeud-en", "509159562441589"), "fr" => array("toonfeud-fr", "474441162629700"));
				$this->brand->toonFeud->appConfigFile = "app-config.json";
				$this->brand->toonFeud->adsFile = "ads.json";
				
				$this->brand->gamePageName = "index.php";
			}
		
		}



?>