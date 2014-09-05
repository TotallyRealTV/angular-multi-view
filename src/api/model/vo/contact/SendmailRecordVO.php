<?php

	/**
	 *	SendmailRecordVO
	 *
	 *	- implements a strategy pattern to execute a range of MySQL queries while keeping them decoupled from their calling classes
	 *
	 */
	
	
	//	include strategies required for High Scores
	include_once(PHP_PATH . "database/recordStrategy/InsertRecordStrategy.php");

	class SendmailRecordVO {
		
		private $recordStrategy;
		
		/**
		 * constructor
		 */
		public function __construct($obj = NULL)  {}
			
		/**
		 *	executeQuery
		 *	- invokes the required query strategy
		 *	- returns result
		 */
		public function executeQuery($obj) {
			$this->recordStrategy = new InsertRecordStrategy();
			return $this->recordStrategy->execute($obj);
		}
	}

?>