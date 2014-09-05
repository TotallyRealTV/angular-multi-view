<?
	
	/**
	 *	This class generates and returns an array of UPDATE SQL statements
	 *
	 *	Structure:
	 *	
	 */
	
	include_once("ISQLOutput.php");
	include_once(PHP_PATH . "utilities/string.php");
	
	class UpdateSqlOutput extends ISQLOutput {
		
		// override properties here as required
		
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			$this->setupProps($obj);
		}
		
		protected function setupProps($obj) {
			$this->data = array();
			$this->whereClause = array();
			$this->whereLikeClause = array();
			$this->props = new stdClass();
			
			$this->props->errorCode = 0;
			
			foreach ($obj as $key=>$value) {
				$this->props->$key = $value;
			}
			
			// set where... and clause
			if (strlen($this->props->output->whereClause) > 0) {
				$this->whereClause = explode(":", $this->props->output->whereClause);
			}
			
			// set where ... like clause
			if (contains(":", $this->props->output->whereLikeClause)) {
				$tmp = explode("|", $this->props->output->whereLikeClause);
			
				for ($i = 0; $i < count($tmp); $i++) {
					$subTmp = explode(":", $tmp[$i]);
					
					$clauseTmp = array(
						$subTmp[0] => $subTmp[1]
					);
					
					if (array_push($this->whereLikeClause, $clauseTmp)) {
						$this->props->errorCode = 0;
					} else {
						$this->props->errorCode = 1;
						break;	
					}
				}
			}
			
			unset($this->props->output->whereClause);
			unset($this->props->output->whereLikeClause);
		}
		
		
		
		protected function generateData() {
			$count = count($this->props->data);
			
			for ($i = 0; $i < $count; $i++) {
				$dataItem = $this->props->data[$i];
				array_push($this->data, $this->generateDataItem($dataItem));
			}
		}
		
		private function generateDataItem($arr) {
			$sql = "UPDATE " . $this->props->output->dbTable . " SET ";
			foreach ($arr as $key=>$value) {
				if (!in_array($key, $this->whereClause) && !in_array($key, $this->whereLikeClause)) {
					$sql .= $key . "=\"" . urlencode($value) . "\", ";		
				}
			}
			
			$sql .= "editDate=\"" . $this->props->output->editDate . "\", ";
			$sql .= "editTime=\"" . $this->props->output->editTime . "\"";
			$sql = trimStringEnd($sql, ", ");
			
			$whereClauseLength = count($this->whereClause);
			$whereLikeClauseLength = count($this->whereLikeClause);
			
			if ($whereClauseLength > 0 || $whereLikeClauseLength > 0) $sql .= " WHERE ";
			
			if ($whereClauseLength > 0) {
				foreach ($this->whereClause as $key=>$value) {
					$sql .= $value . "=\"" . $arr[$value] . "\" AND ";
				}
			}
			
			if ($whereLikeClauseLength == 0) {
				$sql = trimStringEnd($sql, " AND ");
			} else {
				foreach($this->whereLikeClause as $key=>$value) {
					foreach($value as $subKey=>$subValue) {
						$sql .= $subKey . " LIKE \"" . $subValue . "\" OR ";
					}
				}
				
				$sql = trimStringEnd($sql, " OR ");	
			}
			
			$sql .= ";";
			
			return $sql;
		}
		
		
		/**
		 *	public methods
		 */
		public function generateOutput() {
			$this->generateData();
		}
		
		public function getOutput() {
			$output = new stdClass();
			$output->data = $this->data;
			$output->errorCode = $this->props->errorCode;
			return $output;	
		}
		
  	}

?>