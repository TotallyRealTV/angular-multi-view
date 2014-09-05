<?

	/**
	 *	RecordVO
	 *
	 *	- implements a strategy pattern to execute MySQL queries related to Games Administration
	 *
	 */
	
	
	//	include requierd strategies
	include_once(PHP_PATH . "database/recordStrategy/InsertRecordStrategy.php");
	include_once(PHP_PATH . "database/recordStrategy/UpdateRecordStrategy.php");
	include_once(PHP_PATH . "database/recordStrategy/SelectRecordStrategy.php");
	include_once(PHP_PATH . "database/recordStrategy/SelectInRecordStrategy.php");
	include_once(PHP_PATH . "database/recordStrategy/SelectLikeRecordStrategy.php");
	include_once(PHP_PATH . "database/recordStrategy/SelectCountRecordStrategy.php");
	include_once(PHP_PATH . "database/recordStrategy/SelectBetweenRecordStrategy.php");
	include_once(PHP_PATH . "database/recordStrategy/ShowCreateRecordStrategy.php");
	include_once(PHP_PATH . "database/recordStrategy/CreateRecordStrategy.php");

	class RecordVO {
		
		private $recordStrategy;
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {  
			
		}
			
		/**
		 *	executeQuery
		 *	- invokes the required query strategy based on incoming type
		 *	- returns result
		 */
		public function executeQuery($obj) {
			switch($obj->type) {
				case "insert":
					$this->recordStrategy = new InsertRecordStrategy($obj);
				break; 
				
				case "update":
					$this->recordStrategy = new UpdateRecordStrategy($obj);
				break;
				
				case "select":
					$this->recordStrategy = new SelectRecordStrategy($obj);
				break;
				
				case "selectIn":
					$this->recordStrategy = new SelectInRecordStrategy($obj);
				break;
				
				case "selectLike":
					$this->recordStrategy = new SelectLikeRecordStrategy($obj);
				break;
				
				case "selectCount":
					$this->recordStrategy = new SelectCountRecordStrategy($obj);
				break;
				
				case "selectBetween":
					$this->recordStrategy = new SelectBetweenRecordStrategy($obj);
				break;
				
				case "showCreate":
					$this->recordStrategy = new ShowCreateRecordStrategy($obj);
				break;
				
				case "create":
					$this->recordStrategy = new CreateRecordStrategy($obj);
				break;
			}
			 
			//return $this->recordStrategy->execute($obj);
			
			try {
				return $this->recordStrategy->execute($obj);
			} catch (Exception $e) {
				echo $e;
				$error = new stdClass();
				$error->errorCode = $this->getErrorCode();
				return $error;	
			}
		}
		
		/**
		 *	getLastInsertId
		 * 	- invokes similar method on BaseRecordStrategy
		 */
		public function getLastInsertId() {
			return $this->recordStrategy->getLastInsertId();	
		}
		
		/**
		 *	getDbErrorCode
		 *	- returns the errorCode of the PDO instantiation
		 */
		public function getDbErrorCode() {
			return $this->recordStrategy->getDbErrorCode();		
		}
		
		/**
		 *	getErrorCode
		 *	- returns the errorCode of the strategy instance
		 */
		public function getErrorCode() {
			return $this->recordStrategy->getErrorCode();		
		}
		
	}

?>