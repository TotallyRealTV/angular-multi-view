<?

	/**
	 *	DbArchiveController
	 *
	 *	this class routes requests made to create / update reference files so that our content and stats admin tools have an up-to-date table reference list
	 *
	 *	Currently supported functionality:
	 *	- create archive table reference files (.js) for fiscal years
	 *
	 *	date created:	2012-08-16
	 *	last modified:	2012-08-16
	 *	by:	Jonathan Blackburn
	 *	Copyright 2012 TELETOON CANADA INC.
	 *
	 */
	 
	 
	 include_once(PHP_PATH . "database/dbArchives/GameDbTableArchiveModel.php");
	 include_once(PHP_PATH . "database/dbArchives/vo/DbArchiveMessagingVO.php");
	 
	 
	 class DbArchiveController {
		
		protected $type;
		protected $model;
		protected $messages;
		protected $result;
		
		
		/**
		 *	constructor
		 *	- generates the model associated with this controller
		 */
		public function __construct($obj)  {  
			$this->setupProps($obj);
			$this->generate();
			$this->generateModel($obj);
		}
		
		/**
		 *	setupProps
		 */
		private function setupProps($obj = NULL) {
			$this->type = isset($obj->type) ? $obj->type : "default";	
			
			$this->result = new stdClass();
			$this->result->errorCode = 0;
			$this->result->status = 'error';
		}
		
		/**
		 *	generate
		 *	- instances complimentary classes, such as messaging
		 */
		private function generate($obj = NULL) {
			$this->messages = new DbArchiveMessagingVO();	
		}
		
		/**
		 *	generateModel
		 *	- instances the type of model we want to work with
		 *	Valid types:
		 *	- "gameDbTable"
		 */
		protected function generateModel($obj = NULL) {
			$className = ucfirst($this->type) . "ArchiveModel";
	
			if (class_exists($className)) {
				$this->model = new $className($obj);
				$this->result->errorCode = 0;
				$this->result->status = 'success';
			} 
		}
		
		/**
		 *	getStatus
		 *	- return status of controller
		 */
		public function getStatus() {
			return $this->messages->getMessage($this->result->errorCode, $this->result->status);
		}
		
		/**
		 *	executeArchiveOperation
		 *	- regardless of what model we instance, this method is the only publically-available method of each
		 */
		public function executeArchiveOperation() {
			return $this->model->executeArchiveOperation();	
		}
	}








?>