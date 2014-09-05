<?

	/**
	 *	DuplicateEntryRecordStrategy.php
	 *
	 *	Created:
	 *	2012-03-21
	 *
	 *	Modified:
	 *	2012-03-21
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- looks for a duplicate record entry in a given dbTable
	 *	- replaced mysqli with PDO
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once(PHP_PATH . "database/recordStrategy/RecordStrategyInterface.php");
 		include_once(PHP_PATH . "database/recordStrategy/BaseRecordStrategy.php");
		
  	
		class DuplicateEntryRecordStrategy extends BaseRecordStrategy implements RecordStrategyInterface {
		
		/**
		 *	execute
		 *	- construct our SQL statement
		 *	- inserts records into $dbTable
		 *
		 *	Expects:
		 *	$obj->data: our range of data to select
		 *	$obj->dbTable: our database table
		 *	$obj->conditionalRange (optional): object containing key->value pairings of conditions
		 *	$obj->selectOrder (optional): object containing key->value pairings to affect order of data
		 *	$obj->limit (optional): the maximum number of records to return
		 */	 
			public function execute($obj) {
				// set select field range
				$select = '';
				
				foreach ($obj->data as $key=>$value) {
					$select .= $value . ", ";
				}
				
				$select = rtrim($select, ", ");
				
				// set parameter bindings
				$bind = array();
				
				if (isset($obj->conditionalRange)) {
					foreach ($obj->conditionalRange as $key=>$value) {
						$bind[":".$key] = $value;
					}	
				}
				
				// set optional WHERE clause
				$where = '';
				
				if (isset($obj->conditionalRange)) {
					foreach ($obj->conditionalRange as $key=>$value) {
						
						if ($key == "dateTime" || $key == "date_time") {
							$where .= $key . " >='" . $bind[":".$key] . "' AND ";
						} else {
							$where .= $key . "='" . $bind[":".$key] . "' AND ";	
						}
					}
					$where = rtrim($where, "AND ");	
				}
				
				// set default ORDER / LIMIT
				$order = '';
				$limit = '';
				
				// execute query and get result
				$result = (object) NULL;
				
				$result->data =  $this->db->select($obj->dbTable, $where, $bind, $select, $order, $limit);
				
				$result->errorCode = is_array($result->data) && count($result->data > 0) ? 1 : 0;
				
				return $result;
			}
		}



?>