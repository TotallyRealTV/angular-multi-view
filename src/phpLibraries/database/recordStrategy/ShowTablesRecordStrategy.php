<?

	/**
	 *	ShowTablesRecordStrategy.php
	 *
	 *	Created:
	 *	2012-04-12
	 *
	 *	Modified:
	 *	2012-04-12
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- returns the CREATE syntax of a database table
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('RecordStrategyInterface.php');
 		include_once('BaseRecordStrategy.php');
  	
	
	
		class ShowTablesRecordStrategy extends BaseRecordStrategy implements RecordStrategyInterface {
		
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
				
				$result = (object) NULL;
				$result->errorCode = 0;
				
				$result->data = $this->db->showTables($obj->dbName);
				
				if (count($result->data) == 0) {	
					$result->errorCode = 1;
				}
				return $result;
				
			}
		}



?>