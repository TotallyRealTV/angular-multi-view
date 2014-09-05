<?

	/**
	 *	SelectInRecordStrategy.php
	 *
	 *	Created:
	 *	2012-02-14
	 *
	 *	Modified:
	 *	2012-02-14
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- selects data from a database
	 *	- replaced mysqli with PDO
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('RecordStrategyInterface.php');
 		include_once('BaseRecordStrategy.php');
  	
	
	
		class SelectInRecordStrategy extends BaseRecordStrategy implements RecordStrategyInterface {
		
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
				
				// set optional IN clause
				$where = '';
				
				if (isset($obj->conditionalRange)) {
					$selectIn = '';
					foreach ($obj->conditionalRange->values as $key=>$value) {
						$selectIn .= $value . ", ";
					}
					
					$selectIn = rtrim($selectIn, ", ");
					
					$bind[":".$obj->conditionalRange->field] = $selectIn;
					
					
					$where .= " " . $obj->conditionalRange->field . " IN (" . $bind[":" . $obj->conditionalRange->field] . ")";
				}
				
				// set optional ORDER BY FIELD(id, 5,4,3,1,6)
				$order = '';
				if (isset($obj->order)) $order = " ORDER BY FIELD(" . $obj->order->fieldKey . ", " . $obj->order->fieldValue . ")";
				
				// set optional LIMIT
				$limit = '';
				if (isset($obj->limit)) $limit = " LIMIT " . $obj->limit;
				
				// execute query and get result
				$result = new stdClass();
				$result->errorCode = 0;
				$result->data = array();
				
				if ($this->errorCode == 0) {
					$result->data =  $this->db->selectIn($obj->dbTable, $where, $bind, $select, $order, $limit);
					
					if (isset($result->data) && $result->data != "") {
						if (count($result->data) > 0) {
							foreach ($result->data as $key=>$value) {
								if (array_key_exists($key, $result->data)) {
									foreach ($value as $subKey=>$subValue) {
										if (array_key_exists($subKey, $value)) {
											$result->data[$key][$subKey] = stripslashes(urldecode($subValue));
										}
									}
								}
							}
						}
					} else {
						$result->errorCode = 2;
						$result->data = $this->message->getMessage($result->errorCode, $obj->language);	
					}
					
				} else {
					$result->errorCode = $this->errorCode;
					$result->data = $this->message->getMessage($this->errorCode, $obj->language);	
				}
				
				return $result;
			}
		}



?>