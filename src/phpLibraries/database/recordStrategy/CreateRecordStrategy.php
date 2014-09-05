<?

	/**
	 *	CreateRecordStrategy.php
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
	 *	- creates a database table based on the structure of a given template
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('RecordStrategyInterface.php');
 		include_once('BaseRecordStrategy.php');
  	
	
	
		class CreateRecordStrategy extends BaseRecordStrategy implements RecordStrategyInterface {
		
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
				$result = new stdClass();
				$result->errorCode = 0;
				$result->data = $this->db->create($obj->dbTable, $obj->templateTable, $obj->sql);
				
				return $result;
				
			}
		}



?>