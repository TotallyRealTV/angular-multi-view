<?

	/**
	 *	GameDbTableArchiveModel
	 *
	 *	Currently supported functionality:
	 *	- create archive table reference files (.js) for fiscal years, by brand
	 *
	 *	date created:	2012-08-16
	 *	last modified:	2012-08-16
	 *	by:	Jonathan Blackburn
	 *	Copyright 2012 TELETOON CANADA INC.
	 *
	 */
	 
	 include_once($_SERVER['DOCUMENT_ROOT'] . LINK_PATH . "model/vo/RecordVO.php");
	 include_once(PHP_PATH . "site/brand/BrandVO.php");
	 include_once(PHP_PATH . "database/dbArchives/vo/DbArchiveMessagingVO.php");
	 
	 
	 class GameDbTableArchiveModel  {
		
		protected $props;
		protected $brandParameters;
		protected $messages;
		
		/**
		 *	constructor
		 *	- generates the model associated with this controller
		 */
		public function __construct($obj)  {  
			$this->setupProps($obj);
			$this->generate($obj);
		}
		
		/**
		 *	setupProps
		 *	- set properties required for this class
		 *	Required:
		 *	- fiscalYear
		 *	- brand
		 */
		protected function setupProps($obj = NULL) {
			$this->props = new stdClass();
			
			foreach ($obj as $key => $value) {
				$this->props->$key = $value;	
			}
		}
		
		/**
		 *	generate
		 *	- instance any classes we need to work with
		 */
		private function generate($obj = NULL) {
			$brand = new BrandVO();
			
			$init = new stdClass();
			$init->brand = $this->props->brand;
			
			$this->brandParameters = $brand->getBrandData($init);
			$this->messages = new DbArchiveMessagingVO();	
		}
		
		/**
		 *	executeQuery
		 *	- queries a targeted database to return a list of all table names
		 */
		private function executeQuery($obj = NULL) {
			if ($this->brandParameters == NULL) {
				$dataResult = new stdClass();
				$dataResult->errorCode = 1;
				return $dataResult;	
			}
			// select all games from our Content table
			$record = new RecordVO();
			
			// construct our query object
			$query = new stdClass();
			$query->dbTable = "Content";
			$query->type = "select";
			$query->language = "en";	
			$query->data = array("admin_name", "display_name", "entry_date_time");
			$query->dbName = $this->brandParameters->dbProps->adminDb;
			
			$query->conditionalRange = new stdClass();
			$query->conditionalRange->active = 1;
			$query->conditionalRange->content_type = 1;
			
			$query->selectOrder = new stdClass();
			$query->selectOrder->orderFields = "display_name";
			$query->selectOrder->orderType = "ASC";
			
			return $record->executeQuery($query);
		}
		
		/**
		 *	buildData
		 *	- accepts an array of objects in order to create our json data
		 */
		private function buildData($obj = NULL) {
			$gameData = array();
			for ($i = 0; $i < count($obj->data); $i++) {
				$gameItem = new stdClass();
				$gameItem->table = str_ireplace("-", "", $obj->data[$i]['admin_name']) . $this->brandParameters->dbProps->scoresTablePrefix . $this->brandParameters->dbProps->archiveTablePrefix . $this->props->fiscalYear;
				$gameItem->title = $obj->data[$i]['display_name'];
				$gameItem->startDate = strftime("%b %d, %Y", strtotime($obj->data[$i]['entry_date_time']));
				array_push($gameData, $gameItem);
			}
			
			return json_encode($gameData);	
		}
		
		/**
		 *	createFiscalYearData
		 */
		private function createFiscalYearData() {
			// generate fiscal year refs
			$fiscalData = new stdClass();
			
			$fYear = array();
			$fYearByQuarter = array();
			$start = 9;
			$year = $this->props->fiscalYear - 1;
			$q = array();
			
			for ($i = 0; $i < 12; $i++) {
				$startStr = $start < 10 ? "0" . strtolower($start) : strtolower($start);
				$yearStr = strtolower($year);
				array_push($fYear, $yearStr . "-" . $startStr);
				
				if ($start == 12) {
					$year += 1;
					$start = 1;	
				} else {
					$start++;	
				}
				
				array_push($q, $yearStr . "-" . $startStr); 
				
				if (($start % 3) == 0) {
					array_push($fYearByQuarter, $q);
					$q = array();			
				}
				
			}
			
			$fiscalData->fYear = $fYear;
			$fiscalData->fYearByQuarter = $fYearByQuarter;
			
			return json_encode($fiscalData);	
		}
		
		/**
		 *	writeReferenceFile
		 *	- writes the fiscal year's game archive table list
		 */
		private function writeReferenceFile($obj = NULL) {
			
			switch ($obj->type) {
				case "quarters":
					$file = $_SERVER['DOCUMENT_ROOT'] . "/teletoon/admin/statsAdmin/data/gamePlayStats/" . $this->props->fiscalYear . "_fiscal.js"; 
				break;
				
				default:
					$file = $_SERVER['DOCUMENT_ROOT'] . "/teletoon/admin/statsAdmin/data/gamePlayStats/" . $this->props->brand . "/" . $this->props->fiscalYear . ".js"; 
				break;	
			}
			
			$handle = fopen($file, 'w');
			
			if (fwrite($handle, $obj->data)) {
				fclose($handle);
				return 0;
			} else {
				return 1;		
			}
		}
		
		
		
		
		/**
		 *	public-access methods
		 */
		
		/**
		 *	executeArchiveOperation
		 */
		public function executeArchiveOperation($obj = NULL) {
			
			$result = new stdClass();
			$dataResult = $this->executeQuery();
			
			if ($dataResult->errorCode == 0) {
				$result->errorCode = 1;
				$result->status = "success";
				$data = $this->buildData($dataResult);
				
				$result->data = $data;
				$result->type = "all";
				$result->errorCode = $this->writeReferenceFile($result);
				
				if ($result->errorCode == 0) {
					$result->errorCode = 2;
					$result->status = "success";	
					$result->type = "quarters";
					$result->data = $this->createFiscalYearData();
					
					$result->errorCode = $this->writeReferenceFile($result);
					
					if ($result->errorCode == 0) {
						$result->errorCode = 3;	
						$result->status = "success";	
					} else {
						$result->errorCode = 3;	
						$result->status = "error";	
					}
					
				} else {
					$result->errorCode = 2;
					$result->status = "error";	
				}
			} else {
				$result->errorCode = 1;
				$result->status = "error";
			}
			
			$result->message = $this->messages->getMessage($result->errorCode, $result->status);
			$result->fiscalYear = $this->props->fiscalYear;
			
			return $result;	
		}
		 
	}








?>