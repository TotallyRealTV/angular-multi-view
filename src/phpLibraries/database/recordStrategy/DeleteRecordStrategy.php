<?

	/**
	 *	DeleteRecordStrategy.php
	 *
	 *	Created:
	 *	2013-04-08
	 *
	 *	Modified:
	 *	2013-04-08
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- deletes a record from a supplied table in a database BY ID
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('RecordStrategyInterface.php');
 		include_once('BaseRecordStrategy.php');
  	
	
	
		class DeleteRecordStrategy extends BaseRecordStrategy implements RecordStrategyInterface {
		
		/**
		 *	execute
		 *	- construct our SQL statement
		 *	- inserts records into $dbTable
		 *
		 *	Expects:
		 *	$obj->data: our range of data to delete (string = "*")
		 *	$obj->dbTable: our database table
		 *	$obj->conditionalRange (optional): object containing key->value pairings of conditions (where id = $id)
		 */	 
			public function execute($obj) {
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
				
				
				
				// set optional WHERE clause
				$where = '';
				
				if (isset($obj->conditionalRange)) {
					foreach ($obj->conditionalRange as $key=>$value) {
						$where .= $key . "='" . $bind[":".$key] . "' AND ";	
					}
					$where = rtrim($where, "AND ");	
				}
				
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
				
				$where = rtrim($where, "AND ");
				
				// execute query and get result
				$result = new stdClass();
				$result->errorCode = 0;
				
				if ($this->errorCode == 0) {
					$result->errorCode =  $this->db->delete($obj->dbTable, $where, $bind);
					
				} else {
					$result->errorCode = $this->errorCode;
					$result->data = $this->message->getMessage($this->errorCode, $obj->language);	
				}
				
				return $result;
			}
		}



?>