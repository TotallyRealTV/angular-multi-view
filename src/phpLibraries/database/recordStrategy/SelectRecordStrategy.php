<?

	/**
	 *	SelectRecordStrategy.php
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
  	
	
	
		class SelectRecordStrategy extends BaseRecordStrategy implements RecordStrategyInterface {
		
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
				$lessThanEqualBind = array();
				$greaterThanEqualBind = array();
				$greaterThanBind = array();
				$lessThanBind = array();
				
				if (isset($obj->conditionalRange)) {
					foreach ($obj->conditionalRange as $key=>$value) {
						$bind[":".$key] = $value;
					}	
				}
				
				if (isset($obj->lessThanEqualRange)) {
					foreach ($obj->lessThanEqualRange as $key => $value) {
						$lessThanEqualBind[":".$key] = $value;	
					}
				}
				
				if (isset($obj->greaterThanEqualRange)) {
					foreach ($obj->greaterThanEqualRange as $key => $value) {
						$greaterThanEqualBind[":".$key] = $value;	
					}
				}
				
				if (isset($obj->greaterThanRange)) {
					foreach($obj->greaterThanRange as $key => $value) {
						$greaterThanBind[":".$key] = $value;		
					}
				}
				
				if (isset($obj->lessThanRange)) {
					foreach($obj->lessThanRange as $key => $value) {
						$lessThanBind[":".$key] = $value;	
					}
				}
				
				// set optional WHERE clause
				$where = '';
				
				if (isset($obj->lessThanEqualRange)) {
					foreach ($obj->lessThanEqualRange as $key=>$value) {
						$where .= $key . " <='" . $lessThanEqualBind[":".$key] . "' AND ";
					}
				}
				
				if (isset($obj->greaterThanEqualRange)) {
					foreach ($obj->greaterThanEqualRange as $key=>$value) {
						$where .= $key . " >='" . $greaterThanEqualBind[":".$key] . "' AND ";
					}
				}
				
				if (isset($obj->lessThanRange)) {
					foreach ($obj->lessThanRange as $key=>$value) {
						$where .= $key . " <'" . $lessThanBind[":".$key] . "' AND ";
					}
				}
				
				if (isset($obj->greaterThanRange)) {
					foreach ($obj->greaterThanRange as $key=>$value) {
						$where .= $key . " >'" . $greaterThanBind[":".$key] . "' AND ";
					}
				}
				
				if (isset($obj->conditionalRange)) {
					foreach ($obj->conditionalRange as $key=>$value) {
						$where .= $key . "='" . $bind[":".$key] . "' AND ";	
					}
					$where = rtrim($where, "AND ");	
				}
				
				// set optional ORDER BY
				$order = '';
				if (isset($obj->selectOrder)) $order = " ORDER BY " . $obj->selectOrder->orderFields . " " . $obj->selectOrder->orderType;
				
				// set optional LIMIT
				$limit = '';
				if (isset($obj->limit)) $limit = " LIMIT " . $obj->limit;
				
				// execute query and get result
				$result = new stdClass();
				$result->errorCode = 0;
				$result->data = array();
				
				if ($this->errorCode == 0) {
					$result->data =  $this->db->select($obj->dbTable, $where, $bind, $select, $order, $limit);
					
					if (is_array($result->data) && count($result->data) > 0) {
						foreach ($result->data as $key=>$value) {
							if (array_key_exists($key, $result->data)) {
								foreach ($value as $subKey=>$subValue) {
									if (array_key_exists($subKey, $value)) {
										$result->data[$key][$subKey] = stripslashes(urldecode($subValue));
									}
								}
							}
						}
					} else {
						$result->errorCode = 2;
						$result->data = $this->message->getMessage($result->errorCode, $this->language);	
					}
				} else {
					$result->errorCode = 1;
					$result->data = $this->message->getMessage($this->errorCode, $this->language);	
				}
				
				return $result;
			}
		}



?>