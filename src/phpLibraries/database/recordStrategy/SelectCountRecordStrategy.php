<?

	/**
	 *	SelectCountRecordStrategy.php
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
  	
	
	
		class SelectCountRecordStrategy extends BaseRecordStrategy implements RecordStrategyInterface {
		
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
				$dataType = isset($obj->dataType) ? $obj->dataType : "rows";
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
				$selectFieldsBind = array();
				
				if (isset($obj->selectFields)) {
					foreach ($obj->selectFields as $key => $value) {
						$selectFieldsBind[":" . $key] = $value;	
					}
				}
				
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
					foreach ($obj->greaterThanRange as $key => $value) {
						$greaterThanBind[":".$key] = $value;		
					}
				}
				
				$selectFields = "";
				
				if (isset($obj->selectFields)) {
					//if (is_object($obj->selectFields)) {
						foreach ($obj->selectFields as $key => $value) {
							$selectFields .= $value .= ", ";	
						}
					/*} else {
						$selectFields = $obj->selectFields;	
					}*/
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
				
				if (isset($obj->greaterThanRange)) {
					foreach ($obj->greaterThanRange as $key => $value) {
						$where .= $key . " >'" . $greaterThanBind[":".$key] . "' AND ";
					}
				}
				
				if (isset($obj->conditionalRange)) {
					foreach ($obj->conditionalRange as $key=>$value) {
						$where .= $key . "='" . $bind[":".$key] . "' AND ";	
					}
					$where = rtrim($where, "AND ");	
				}
				
				$group = "";
				
				if (isset($obj->group)) {
					$group = $obj->group->group_by;				
				}
				
				// execute query and get result
				$result = new stdClass();
				$result->errorCode = 0;
				$result->dataType = $dataType;
				
				if ($this->errorCode == 0) {
					$result->data =  $this->db->selectCount($obj->dbTable, $where, $bind, $select, $dataType, $group, $selectFields);
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