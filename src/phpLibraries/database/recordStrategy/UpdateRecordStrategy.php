<?

	/**
	 *	UpdateRecordStrategy.php
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
  	
	
	
		class UpdateRecordStrategy extends BaseRecordStrategy implements RecordStrategyInterface {
		
		/**
		 *	execute
		 *	- construct our SQL statement
		 *	- inserts records into $dbTable
		 *
		 *	Expects:
		 *	$obj->data: our key/value pairings for the record insert
		 *	$obj->dbTable: our database table
		 *	$obj->row: the row number to update
		 *	$obj->rowIDName: the name of the field for our id
		 */	 
			public function execute($obj) {
				$row = $obj->data->row;
				$rowIDName = $obj->data->rowIDName;
				unset($obj->data->row);
				unset($obj->data->rowIDName);
				
				$update = array();
				
				// loop through object and assign keys as field names
				foreach ($obj->data as $key=>$value) {
					if (is_string($value) && $key != "entryTime" && $key != "dateTime") {
						$pos = strpos($key, "date");
						
						if($pos === false) {
							$update[$key] = urlencode($value);
						} else {
							$update[$key] = $value;
						}
						
					} else {
						$update[$key] = $value;
					}
				}
				
				// generic update only looks as the row to update
				$bind = array(
					":rowName" => $row
				);
				
				$result = (object) NULL;
				$result->data = $this->db->update($obj->dbTable, $update, $rowIDName . " = :rowName", $bind); //{
				
				if ($result->data == 0) {
					$result->message = $this->message->getMessage(3, $obj->language);
					$result->errorCode = 1;
				} else if ($result->data == 1) {
					$result->message = $this->message->getMessage(4, $obj->language);
					$result->errorCode = 0;
				}
				
				return $result;
				
			}
		}



?>