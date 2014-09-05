<?

	/**
	 *	BaseBrand.php
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
	 *	- common methods and properties that all subclasses implement
	 */


	/**
	 * supporting files
	 */

		class BaseBrand {
		
			/**
			 *	class properties
			 */
			protected $brand;
			protected $language;
			
			
			
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
			
			}
			
			/**
			 *	defines $this->brand
			 */
			protected function setupProps($obj = NULL) {
				$this->brand = new stdClass();
				$this->brand->language = isset($obj->language) && $obj->language != "" ? $obj->language : "en";
			}
			
			/**
			 *	populateBrand
			 *	- populates $this->brand with properties common to all brands
			 */
			protected function populateBrand($obj = NULL) {
				foreach ($obj as $key => $value) {
					$this->brand->$key = $value;	
				}
				
				// top-level paths
				$this->brand->baseGamesUrl = "/games/";								
				$this->brand->baseTvUrl = "/tv/";
				
				// define common props for all brands
				$this->brand->dbProps = new stdClass();
				$this->brand->dbProps->adminTable = "Content";
				$this->brand->dbProps->contentTypesDb = "ContentTypes";
				$this->brand->dbProps->contentRatingDb = "ContentRatings";
				$this->brand->dbProps->contentCategoryDb = "ContentCategories";
				$this->brand->dbProps->groupsTable = "Groups";
				$this->brand->dbProps->gamesTableTemplate = "gametemplate";
				
				// common tempaltes
				$this->brand->htaccessTemplate = ROOT_PATH . "model/games/templates/htaccess.txt";
				$this->brand->htaccessTvTemplate = ROOT_PATH . "model/tv/templates/htaccess.txt";
				$this->brand->highScoresTemplate = ROOT_PATH . "model/games/templates/ScoresVO.txt";
				
				// common directory locations
				$this->brand->uploadDirectories = new stdClass();
				$this->brand->uploadDirectories->medium = new stdClass();
				$this->brand->uploadDirectories->medium->str = "medium/";
				$this->brand->uploadDirectories->medium->extra = "extras/";
				$this->brand->uploadDirectories->medium->game = "games/";
				$this->brand->uploadDirectories->medium->contest = "contests/";
				$this->brand->uploadDirectories->medium->show = "shows/";
				$this->brand->uploadDirectories->medium->other = "other/";
				$this->brand->uploadDirectories->medium->video = "video/";
				
				$this->brand->uploadDirectories->small = new stdClass();
				$this->brand->uploadDirectories->small->str = "small/";
				$this->brand->uploadDirectories->small->nav = "nav/";
				$this->brand->uploadDirectories->small->extra = "extras/";
				$this->brand->uploadDirectories->small->game = "games/";
				$this->brand->uploadDirectories->small->video = "video/";
				$this->brand->uploadDirectories->small->contest = "contests/";
				$this->brand->uploadDirectories->small->show = "shows/";
				$this->brand->uploadDirectories->small->schedule = "schedule/";
				$this->brand->uploadDirectories->small->other = "other/";
				
				// common objects
				$this->brand->contentRating = new stdClass();
				$this->brand->includePaths = new stdClass();
				
				$this->brand->crtc_ratings = array('Children' => 'C', 'Children Under 8' => 'C8', 'Children Over 8' => 'C8plus', 'General' => 'G', 'Parental Guidance' => 'PG', '13+' => '13plus', '14+' => '14plus', '16+' => '16plus', '18+' => '18plus');
				
				$this->brand->violence_ratings = array('Yes' => 'violence', 'No' => '');
				$this->brand->closed_captions = array('Yes' => 'CC', 'No' => '');
				
				//	brightcove settings
				$this->brand->brightCove = new stdClass();
				$this->brand->brightCove->readToken = "9GZYO4HIboQ05kDpRZ46oxND16zqfm8bwZ0XhdrNyog.";
				$this->brand->brightCove->writeToken = "HhrvM_T74LyTa18cuwA662Usf5wKoKeYP1FhkYwvKWtqaCBHaOFb6Q..";
				$this->brand->brightCove->videoDirectory = $_SERVER['DOCUMENT_ROOT'] . "/tmp/";	
				// brightcove paths
				$this->brand->brightCove->memCachePath = 'localhost';
				
				// game tracking
				$this->brand->gameTracking = new stdClass();
				$this->brand->gameTracking->legacyScripts = new stdClass();
				$this->brand->gameTracking->legacyScripts->createGamePlayUrl = "/fun/games/common/createGamePlay.php";
				$this->brand->gameTracking->legacyScripts->updateGamePlayUrl = "/fun/games/common/updateGamePlay.php";
				$this->brand->gameTracking->legacyScripts->highScoresUrl = "/fun/games/common/showHighScores.php";
				$this->brand->gameTracking->api = new stdClass();
				$this->brand->gameTracking->api->apiUrl = "/api/";
				
				// toon feud
				$this->brand->toonFeud = new stdClass();
				$this->brand->toonFeud->dbName = "ToonFeud";
				$this->brand->toonFeud->gamesDbName = "ToonFeudGames";
				$this->brand->toonFeud->gamesTableTemplate = "gametemplate";
				$this->brand->toonFeud->leaderboardTable = "leaderboard";
				$this->brand->toonFeud->scoresTablePrefix = "Score";
				$this->brand->toonFeud->archiveGamesDb = "ToonFeudGameArchiveFY";
				$this->brand->toonFeud->archiveTablePrefix = "ArchiveFY";
				$this->brand->toonFeud->gamesTable = "Games";
				$this->brand->toonFeud->gameslistTable = "GamesList";
				$this->brand->toonFeud->mediaObjectsTable = "MediaObjects";
				$this->brand->toonFeud->questionObjectsTable = "QuestionObjects";
				$this->brand->toonFeud->questionSetsTable = "QuestionSets";
				$this->brand->toonFeud->badgesTable = "Badges";
				$this->brand->toonFeud->usersTable = "Users";
				$this->brand->toonFeud->categoriesTable = "Categories";
				$this->brand->toonFeud->highScoresTemplate = ROOT_PATH . "model/game/templates/ScoresVO.txt";
				
				// TOON FEUD Cloud
				$this->brand->toonFeud->cloud = new stdClass();
				$this->brand->toonFeud->cloud->bucketID = "toonfeud";
				$this->brand->toonFeud->cloud->baseURL = "https://" . $this->brand->toonFeud->cloud->bucketID . ".s3.amazonaws.com/";
				$this->brand->toonFeud->cloud->basePath = "retro/";
				$this->brand->toonFeud->cloud->gamesURL = $this->brand->toonFeud->cloud->basePath . "games/";
				
				// TOON FEUD Paths
				$this->brand->toonFeud->paths = new stdClass();
				$this->brand->toonFeud->paths->basePath = "toonFeud/";
				$this->brand->toonFeud->paths->assetPath = "/" . $this->brand->language . "/games/toon-feud/";
				
				$this->brand->toonFeud->paths->imagePath = $this->brand->toonFeud->paths->basePath . "images/";
				$this->brand->toonFeud->paths->iconPath = $this->brand->toonFeud->paths->imagePath . "icons/";
				$this->brand->toonFeud->paths->mediaobjectPath = $this->brand->toonFeud->paths->imagePath . "mediaobjects/";
				
				$this->brand->toonFeud->paths->mainIncludesPath = $this->brand->toonFeud->paths->basePath . "promos/main/";
				$this->brand->toonFeud->paths->bottomIncludesPath = $this->brand->toonFeud->paths->basePath . "promos/bottom/";
				$this->brand->toonFeud->paths->defaultIncludeFile = "default.html";
				$this->brand->toonFeud->paths->badgeImagePath = $this->brand->toonFeud->paths->basePath . "badges/images/";
				$this->brand->toonFeud->paths->badgeExportPath = $this->brand->toonFeud->paths->basePath . "badges/html/";
				
				$this->brand->toonFeud->paths->userPath = "users/";
			}
			
			/**
			 *	getBrandData
			 *	- returns the full brand object
			 */
			public function getData() {
				return $this->brand;	
			}
			
			public function getBrandObject($prop = '') {
				return $this->brand->$prop;	
			}
			
			public function getBaseUrl($type = NULL) {
				switch ($type) {
					case "games":
						return $this->brand->baseGamesUrl;
					break;
					
					case "tv":
						return $this->brand->baseTvUrl;
					break;
					
					default:
						return $this->brand->baseFilePath;	
					break;	
				}	
			}
			
			public function getBaseUploadPath() {
				return $this->brand->baseFilePath;	
			}
			
			public function getBrandProp($prop = '') {
				foreach ($this->brand as $key =>$value) {
					if ($prop == $key) return $value;	
				}
				
				return $this->getData();
			}
			
			/**
			 *	getUploadUrl
			 *	returns upload URL (if applicable)
			 */
			public function getUploadUrl($type = NULL, $size = NULL) {
				switch ($type) {
					case "home":
						if ($size == "medium") {
							return $this->brand->baseFilePath . $this->brand->uploadDirectories->basePath . $this->brand->uploadDirectories->medium->str . $this->brand->uploadDirectories->medium->extra;
						} else {
							return $this->brand->baseFilePath . $this->brand->uploadDirectories->basePath . $this->brand->uploadDirectories->small->str . $this->brand->uploadDirectories->medium->extra;
						}
					break;	
					
					case "games":
						if ($size == "medium") {
							return $this->brand->baseFilePath . $this->brand->uploadDirectories->basePath . $this->brand->uploadDirectories->medium->str . $this->brand->uploadDirectories->medium->game;
						} else {
							return $this->brand->baseFilePath . $this->brand->uploadDirectories->basePath . $this->brand->uploadDirectories->small->str . $this->brand->uploadDirectories->medium->game;	
						}
					break;
					
					default:
						return "";
					break;
				}
			}
		}
?>