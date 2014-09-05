<?

	/**
	 *	TtBrand.php
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
	 *	- encapsulates unique data associated with the Teletoon Brand
	 */


	/**
	 * supporting files
	 */

		include_once('BaseBrand.php');
  	
	
	
		class TtBrand extends BaseBrand {
		
		
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				parent::setupProps();
				parent::populateBrand($obj);
				$this->populateBrand($obj);
			}
			
			/**
			 *	setExportProperties
			 *	- discern between staging and production by virtue of $this->brand->exportAction
			 */
			protected function setExportProperties($obj = NULL) {
				switch ($this->brand->exportAction) {
					case "export-staging":
					case "exportall-staging":
						$this->brand->mainUrl = "http://staging.teletoon.com/";
						$this->brand->baseFilePath = "/opt1/htdocs/teletoonstaging";									// live
						$this->brand->includePaths->basePath = "/opt1/htdocs/teletoonstaging/teletoon4/" . $this->brand->language . "/";
						$this->brand->exportIp = $this->brand->mainUrl . $this->brand->language;					// live
						$this->brand->exportUrl = $this->brand->mainUrl . $this->brand->language;
						/*$this->brand->mainUrl = "http://localhost/teletoonstaging/";
						$this->brand->baseFilePath = $_SERVER['DOCUMENT_ROOT'] . "/teletoonstaging";									// local
						$this->brand->includePaths->basePath = $_SERVER['DOCUMENT_ROOT'] . "/teletoon4/" . $this->brand->language . "/";
						$this->brand->exportIp = $this->brand->mainUrl . $this->brand->language;						// local
						$this->brand->exportUrl = $this->brand->mainUrl . $this->brand->language;*/
					break;
					
					default:
						$this->brand->mainUrl = "http://www.teletoon.com/";
						$this->brand->baseFilePath = "/opt1/htdocs/teletoon";									// live
						$this->brand->includePaths->basePath = "/opt1/htdocs/teletoon/teletoon4/" . $this->brand->language . "/";
						$this->brand->exportIp = "http://web07.teletoon.com/" . $this->brand->language;					// live
						$this->brand->exportUrl = $this->brand->mainUrl . $this->brand->language;		// live
						/*$this->brand->mainUrl = "http://localhost/teletoon/";
						$this->brand->baseFilePath = $_SERVER['DOCUMENT_ROOT'] . "/teletoon";									// local
						$this->brand->includePaths->basePath = $_SERVER['DOCUMENT_ROOT'] . "/teletoon4/" . $this->brand->language . "/";
						$this->brand->exportIp = $this->brand->mainUrl . $this->brand->language;						// local
						$this->brand->exportUrl = $this->brand->mainUrl . $this->brand->language;*/		// local
					break;	
				}
			}
			
			/**
			 *	setupProps
			 *	- sets base
			 *	- defines unique brand properties
			 */
			protected function populateBrand($obj = NULL) {
				//testOutput("obj", $obj);
				$this->brand->language = isset($obj['language']) && $obj['language'] != "" ? $obj['language'] : "en";
				$this->brand->exportAction = isset($obj['exportAction']) && $obj['exportAction'] != "" ? $obj['exportAction'] : "";
				$this->setExportProperties();
				
				$this->brand->gamePreviewUrl = $this->brand->exportUrl . "/games/";
				$this->brand->tvPreviewUrl = $this->brand->exportUrl . "/tv/";
				$this->brand->baseGamesUrl = "/fun/games/";	
				$this->brand->gamesFilePath = $this->brand->baseFilePath . $this->brand->baseGamesUrl;
				$this->brand->tvFilePath = $this->brand->baseFilePath . $this->brand->baseTvUrl;
				
				$this->brand->gamesHtaccessFilePath = $this->brand->gamesFilePath . ".htaccess";
				$this->brand->gamesHtaccessTvFilePath = $this->brand->tvFilePath . ".htaccess";
				$this->brand->highScoresTemplate = ROOT_PATH . "model/games/templates/TeletoonScoresVO.txt";
				
				$this->brand->gamesMetaTemplate = ROOT_PATH . "model/games/templates/meta/tt_meta_" . $this->brand->language . ".html";
				$this->brand->tvMetaHomeTemplate = ROOT_PATH . "model/tv/templates/meta/tt_meta_home_" . $this->brand->language . ".html";
				
				$this->brand->dbProps->adminDb = "Teletoon";
				$this->brand->dbProps->gamesDb = "TeletoonGames";
				$this->brand->dbProps->archiveGamesDb = "TeletoonGameArchiveFY";
				$this->brand->dbProps->archiveTablePrefix = "ArchiveFY";
				$this->brand->dbProps->scoresTablePrefix = "Score";
				$this->brand->dbProps->gamesTableTemplate = "gametemplate";
				$this->brand->dbProps->showsDb = "TeletoonShows";
				$this->brand->dbProps->gamesListTable = "tt_gamesList";
				
				$this->brand->trackingProps = new stdClass();
				$this->brand->trackingProps->google = new stdClass();
				$this->brand->trackingProps->google->account_en = "UA-234253235-1";
				$this->brand->trackingProps->google->account_fr = "UA-234253235-2";
				
				// upload directories
				$this->brand->uploadDirectories->basePath = "/tt/images/";
				
				// content rating
				$this->brand->contentRating->type = "star";
				$this->brand->contentRating->filePath = $this->brand->baseFilePath . "/data/ratings/games/";
				
				// include paths
				$this->brand->includePaths->gamesPath = $this->brand->includePaths->basePath . "games/";
				$this->brand->includePaths->highlightedGames = $this->brand->includePaths->gamesPath . "games.js";
				$this->brand->includePaths->moreGamesPath = $this->brand->includePaths->basePath . "relatedGames/";
				$this->brand->includePaths->gamesIndexMoreGamesPath = $this->brand->includePaths->basePath . "data/games/";
				$this->brand->includePaths->relatedGamesItemPath = ROOT_PATH . "model/games/templates/relatedGames/tt_relatedGameItem.html";
				$this->brand->includePaths->gamesIndexMoreGamesInclude = ROOT_PATH . "model/games/templates/relatedGames/tt_gamesIndexMoreGamesInclude.html";
				$this->brand->includePaths->gamesIndexTextGamesInclude = ROOT_PATH . "model/games/templates/relatedGames/tt_gamesIndexTextGamesInclude.html";
				$this->brand->includePaths->gamesIndexTopGamesInclude = ROOT_PATH . "model/games/templates/relatedGames/tt_gamesIndexTopGamesInclude_" . $this->brand->language . ".html";
				$this->brand->includePaths->gamesIndexMoreGamesItem = ROOT_PATH . "model/games/templates/relatedGames/tt_gamesIndexTextGamesItem.html";
				
				$this->brand->includePaths->gamesIndexMoreGamesPath = $this->brand->includePaths->basePath . "data/games/";
				$this->brand->includePaths->topGamesIncludePath = $this->brand->includePaths->gamesIndexMoreGamesPath;
				$this->brand->includePaths->topGamesIncludeFile = $this->brand->includePaths->topGamesIncludePath . "games_topgames_index.php";
				
				$this->brand->includePaths->gamesBoxesIncludePath = $this->brand->includePaths->gamesIndexMoreGamesPath;
				$this->brand->includePaths->gamesBoxesIncludeFile = $this->brand->includePaths->gamesBoxesIncludePath . "games_boxes_index.php";
				
				$this->brand->includePaths->gamesTextBoxesIncludePath = $this->brand->includePaths->gamesIndexMoreGamesPath;
				$this->brand->includePaths->gamesTextBoxesIncludeFile = $this->brand->includePaths->gamesTextBoxesIncludePath . "games_textboxes_index.php";
				
				$this->brand->includePaths->gamesIndexMetaIncludePath = $this->brand->includePaths->basePath . "meta/";
				$this->brand->includePaths->gamesIndexMetaFilePath = $this->brand->includePaths->gamesIndexMetaIncludePath . "games_meta.html";
				
				$this->brand->includePaths->homeVideosTemplate = ROOT_PATH . "model/video/templates/tt_videos_home_" . $this->brand->language . ".html";
				$this->brand->includePaths->homeVideosItem = ROOT_PATH . "model/video/templates/tt_videos_home_item.html";
				$this->brand->includePaths->homeVideosIncludePath = $this->brand->exportIp . $this->brand->includePaths->basePath . "home/";
				$this->brand->includePaths->homeVideosIncludeFile = $this->brand->includePaths->homeVideosIncludePath . "videos.html";
				$this->brand->brightCove->fileCachePath = $this->brand->baseFilePath . '/data/video/cache/';
				
				$this->brand->gameTracking->legacyScripts->createGamePlayUrl = "/api/utils/games/tt/legacy/createGamePlay.php";
				$this->brand->gameTracking->legacyScripts->updateGamePlayUrl = "/api/utils/games/tt/legacy/updateGamePlay.php";
				$this->brand->gameTracking->legacyScripts->highScoresUrl = "/api/utils/games/tt/legacy/showHighScores.php";
				
				$this->brand->gamePageName = "game_" . $this->brand->language . ".php";
				
				if ($this->brand->language == "en") {
					$this->brand->crtc_ratings = array('Children' => 'C', 'Children Under 8' => 'C8', 'Children Over 8' => 'C8plus', 'General' => 'G', 'Parental Guidance' => 'PG', '14+' => '14plus', '18+' => '18plus');
				} else {
					$this->brand->crtc_ratings = array('Children' => 'C', 'Children Under 8' => 'C8', 'Children Over 8' => 'C8plus', 'General' => 'G', 'Parental Guidance' => 'PG', '13+' => '13plus', '14+' => '14plus', '16+' => '16plus', '18+' => '18plus');	
				}
			}
		}
?>