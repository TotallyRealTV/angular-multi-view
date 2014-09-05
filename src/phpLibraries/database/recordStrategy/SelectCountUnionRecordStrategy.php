<?

	/**
	 *	SelectCountUnionRecordStrategy.php
	 *
	 *	Created:
	 *	2012-06-21
	 *
	 *	Modified:
	 *	2012-06-21
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- selects total rows from a table
	 *	- replaced mysqli with PDO
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('RecordStrategyInterface.php');
 		include_once('BaseRecordStrategy.php');
  	
	
	
		class SelectCountUnionRecordStrategy extends BaseRecordStrategy implements RecordStrategyInterface {
		
		/**
		 *	execute
		 *	- construct our SQL statement
		 *	- inserts records into $dbTable
		 *
		 *	Expects:
		 *	$obj->dbTable: our database table
		 *	$obj->conditionalRange (optional): object containing key->value pairings of conditions
		 */	 
			public function execute($obj) {
				
				/*
					SELECT  'adventureboundscores', COUNT( scoreID ) AS gamePlays FROM adventureboundscores WHERE DATETIME >=  '2012-07-01' AND DATETIME <=  '2012-07-19'
					UNION 
					SELECT  'afriendinneedscores', COUNT( scoreID ) AS gamePlays FROM afriendinneedscores WHERE DATETIME >=  '2012-07-01' AND DATETIME <=  '2012-07-19'
				
				*/
				
				$select = '';
				
				foreach ($obj->data as $key=>$value) {
					$select .= $value . ", ";
				}
				
				$select = rtrim($select, ", ");
				
				// set parameter bindings
				$bind = array();
				$lessThanEqualBind = array();
				$greaterThanEqualBind = array();
				
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
				
				if (isset($obj->conditionalRange)) {
					foreach ($obj->conditionalRange as $key=>$value) {
						$where .= $key . "='" . $bind[":".$key] . "' AND ";	
					}
					$where = rtrim($where, "AND ");	
				}
				
				// set optional ORDER BY
				$order = '';
				if (isset($obj->selectOrder)) $order = " ORDER BY " . $obj->selectOrder->orderFields . " " . $obj->selectOrder->orderType;
						
				// execute query and get result
				$result = new stdClass();
				$result->errorCode = 0;
				
				if ($this->errorCode == 0) {
					
					$result->data =  $this->db->selectCountUnion($obj->dbTable, $where, $bind, $select, $obj->dataType, $order);
					if (count($result->data) > 0 && !empty($result->data)) {
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