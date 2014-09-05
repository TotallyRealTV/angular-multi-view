<?

	/**
	 *	InsertRecordStrategy.php
	 *
	 *	Created:
	 *	2012-02-14
	 *
	 *	Modified:
	 *	2012-03-16
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- inserts a record into a database table.
	 *	- replaced mysqli with PDO
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('RecordStrategyInterface.php');
 		include_once('BaseRecordStrategy.php');
  	
	
	
		class InsertRecordStrategy extends BaseRecordStrategy implements RecordStrategyInterface {
		
		/**
		 *	execute
		 *	- construct our SQL statement
		 *	- inserts records into $dbTable
		 *
		 *	Expects:
		 *	$obj->insertData: our key/value pairings for the record insert
		 *	$obj->dbTable: our database table
		 */	 
			public function execute($obj) {
				
				$insert = array();
				
				// loop through object and assign keys as field names
				foreach ($obj->data as $key=>$value) {
					if (is_string($value) && $key != "entryDate" && $key != "entryTime" && $key != "dateTime" && $key != "date_time") $insert[$key] = urlencode($value);
					else $insert[$key] = $value;
				}
				
				$result = (object) NULL;
				$result->errorCode = 0;
				
				if (!$this->db->insert($obj->dbTable, $insert)) {
					$result->errorCode = 1;	
					$result->data = $this->message->getMessage($result->errorCode, $this->language);
				}
				
				return $result;
				
			}
		}



?>