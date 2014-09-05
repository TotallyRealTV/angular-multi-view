<?

	/**
	 *	BaseRecordStrategy.php
	 *
	 *	Created:
	 *	2012-02-21
	 *
	 *	Modified:
	 *	2012-02-21
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- serves as the base implementation which all query strategies must extend
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('RecordStrategyInterface.php');
  		include_once(PHP_PATH . "database/drivers/class.database.php");
		include_once('vo/DatabaseMessagingVO.php');
  	
	
	
		class BaseRecordStrategy implements RecordStrategyInterface {
		
			protected $db;
			protected $host;
			protected $port;
			protected $dbName;
			protected $user;
			protected $password;
			protected $error;
			protected $errorCode;
			protected $message;
			protected $language;
			
			
			/**
			 * constructor
			 */
			public function __construct($obj = NULL)  {  
				$this->setupProps($obj);
				$this->generate();
			}
			
			
			/**
			 *	setupProps
			 *	- set the critical properties required for our PDO layer to execute
			 */
			private function setupProps($obj = NULL) {
				$this->host = isset($obj->host) && $obj->host != "" ? $obj->host : DB_HOST;
				$this->user = isset($obj->user) && $obj->user != "" ? $obj->user : DB_USER;
				$this->password = isset($obj->password) && $obj->password != "" ? $obj->password : DB_PASS;
				$this->dbName = isset($obj->dbName) && $obj->dbName != "" ? $obj->dbName : DB_DATABASE;
				$this->port = isset($obj->port) ? $obj->port : NULL;
				$this->language = isset($obj->language) ? $obj->language : "en";
			}
				
			
			/**
			 *	generate
			 *	- instances db
			 */
			private function generate() {
				$this->db = new database("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbName, $this->user, $this->password);
				if ($this->db == false) $this->errorCode = 1;
				
				$this->message = new DatabaseMessagingVO();
			}
			
			
			/**
			 *	execute
			 *	- see strategy overrides for implementation
			 */	 
			public function execute($obj) {
				
			}
			
			
			/**
			 *	getLatestID
			 *	- returns the latest database record ID
			 */
			public function getLastInsertId() {
				return $this->db->getLastInsertId();		
			}
			
			
			/**
			 *	getErrorCode
			 *	- returns error code from 
			 */
			public function getErrorCode() {
				return $this->errorCode; 
			}
			
			/**
			 *	getMessage
			 */
			public function getMessage($num, $lang) {
				return $this->message->getMessage($num, $lang);	
			}
		}



?>