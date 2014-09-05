<?php

	/**
	 *	class.database.php
	 *
	 *	Created:
	 *	2012-03-16
	 *
	 *	Modified:
	 *	2012-03-16
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- this is the Data Object abstraction layer between implementing classes and our database(s)
	 */

	class database extends PDO {
		
		private $error;
		private $errorCode;
		private $sql;
		private $bind;
		private $errorCallbackFunction;
		private $errorMsgFormat;
	
		
		/**
		 *	constructor
		 *	- implementing class must submit critical connection params
		 */
		public function __construct($dsn, $user="", $passwd="") {
			$options = array(PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
			$this->errorCode = 0;
			
			try {
				parent::__construct($dsn, $user, $passwd, $options);
			} catch (PDOException $e) {
				return false;
			}
		}
		
		/**
		 *	debug
		 *	- present error messages
		 */
		private function debug() {
			if(!empty($this->errorCallbackFunction)) {
				$error = array("Error" => $this->error);
				if(!empty($this->sql))
					$error["SQL Statement"] = $this->sql;
				if(!empty($this->bind))
					$error["Bind Parameters"] = trim(print_r($this->bind, true));
	
				$backtrace = debug_backtrace();
				if(!empty($backtrace)) {
					foreach($backtrace as $info) {
						if($info["file"] != __FILE__)
							$error["Backtrace"] = $info["file"] . " at line " . $info["line"];	
					}		
				}
	
				$msg = "";
				if($this->errorMsgFormat == "html") {
					if(!empty($error["Bind Parameters"]))
						$error["Bind Parameters"] = "<pre>" . $error["Bind Parameters"] . "</pre>";
					$css = trim(file_get_contents(dirname(__FILE__) . "/error.css"));
					$msg .= '<style type="text/css">' . "\n" . $css . "\n</style>";
					$msg .= "\n" . '<div class="db-error">' . "\n\t<h3>SQL Error</h3>";
					foreach($error as $key => $val)
						$msg .= "\n\t<label>" . $key . ":</label>" . $val;
					$msg .= "\n\t</div>\n</div>";
				}
				elseif($this->errorMsgFormat == "text") {
					$msg .= "SQL Error\n" . str_repeat("-", 50);
					foreach($error as $key => $val)
						$msg .= "\n\n$key:\n$val";
				}
	
				$func = $this->errorCallbackFunction;
				$func($msg);
			}
		}
	
		
		/**
		 *	delete
		 *	- perform a DELETE query
		 */
		public function delete($table, $where, $bind="") {
			$sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
			return $this->run($sql, $bind);
		}
	
		
		/**
		 *	filter record data to insert against a schema to validate it
		 */
		private function filter($table, $info) {
			$driver = $this->getAttribute(PDO::ATTR_DRIVER_NAME);
			if($driver == 'sqlite') {
				$sql = "PRAGMA table_info('" . $table . "');";
				$key = "name";
			}
			elseif($driver == 'mysql') {
				$sql = "DESCRIBE " . $table . ";";
				$key = "Field";
			}
			else {	
				$sql = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $table . "';";
				$key = "column_name";
			}	
	
			if(false !== ($list = $this->run($sql))) {
				$fields = array();
				foreach($list as $record)
					$fields[] = $record[$key];
				return array_values(array_intersect($fields, array_keys($info)));
			}
			return array();
		}
	
		
		/**
		 *	cleanup
		 *	- clean our parameter binding
		 */
		private function cleanup($bind) {
			if(!is_array($bind)) {
				if(!empty($bind))
					$bind = array($bind);
				else
					$bind = array();
			}
			return $bind;
		}
	
		
		/**
		 *	select
		 *	- executes an INSERT query
		 */
		public function insert($table, $info) {
			$fields = $this->filter($table, $info);
			
			$sql = "INSERT INTO " . $table . " (" . implode($fields, ", ") . ") VALUES (:" . implode($fields, ", :") . ");";
			$bind = array();
			
			foreach($fields as $field)
				$bind[":$field"] = $info[$field];
			
			return $this->run($sql, $bind);
		}
		
		/**
		 *	showCreate
		 *	- executes a SHOW CREATE query
		 */
		public function showCreate($templateTable) {
			$sql = "SHOW CREATE TABLE ".$templateTable.";";
			$bind = array();
			return $this->run($sql, $bind);
		}
		
		/**
		 *	showTables
		 *	- executes a SHOW TABLES FROM query
		 */
		public function showTables($dbName) {
			$sql = "SHOW TABLES;";
			$bind = array();
			return $this->run($sql, $bind);	
		}
		
		public function create($table, $templateTable, $sql) {
			$sql = str_replace($templateTable, $table, $sql);
			$bind = array();
			return $this->run($sql, $bind);
		}
	
		
		/**
		 *	run
		 *	- execute a query
		 */
		public function run($sql, $bind="") {
			$this->sql = trim($sql);
			$this->bind = $this->cleanup($bind);
			$this->error = "";
	
			try {
				$pdostmt = $this->prepare($this->sql);
				if($pdostmt->execute($this->bind) !== false) {
					if(preg_match("/^(" . implode("|", array("select", "describe", "pragma", "show", "create")) . ") /i", $this->sql))
						return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
					elseif(preg_match("/^(" . implode("|", array("delete", "insert", "update", "selectCount")) . ") /i", $this->sql))
						return $pdostmt->rowCount();
				}	
			} catch (PDOException $e) {
				$this->error = $e->getMessage();
				$this->errorCode = 1;	
				$this->debug();
				return false;
			}
		}
	
		
		/**
		 *	select
		 *	- executes a SELECT query
		 */
		public function select($table, $where="", $bind="", $fields="*", $order="", $limit="") {
			$sql = "SELECT " . $fields . " FROM " . $table;
			if(!empty($where)) $sql .= " WHERE " . $where;
			if(!empty($order)) $sql .= $order;
			if(!empty($limit)) $sql .= $limit;
			$sql .= ";";
			return $this->run($sql, $bind);
		}
		
		/**
		 *	select...count()
		 */
		public function selectCount($table, $where="", $bind="", $fields="*", $dataType, $group="", $selectFields="*") {
			$sql = "SELECT " . $selectFields . " count(" . $fields . ") AS " . $dataType . " FROM " . $table;
			if (!empty($where)) $sql .= " WHERE " . $where;
			if (!empty($group)) $sql .= " GROUP BY " . $group;
			
			$sql .= ";";
			return $this->run($sql, $bind);	
		}
		
		public function selectCountUnion($table, $where="", $bind="", $fields, $dataType, $order="") {
			$sql = "";
			
			foreach ($table as $dbTable) {
				$sql .= "SELECT COUNT(" . $fields . ") AS " . $dataType . " FROM " . $dbTable;
				
				if(!empty($where)) $sql .= " WHERE " . $where;
				
				$sql .= " UNION ALL ";
			}
			
			$sql = rtrim($sql, " UNION ALL ");
			
			if(!empty($order)) $sql .= $order;
			$sql .= ";";
			
			//echo $sql . "<BR><BR>";
			
			return $this->run($sql, $bind);	
		}
		
		/**
		 *	selectIn
		 *	- executes a SELECT ... WHERE...IN query
		 */
		public function selectIn($table, $where="", $bind="", $fields="*", $order="", $limit="") {
			$sql = "SELECT " . $fields . " FROM " . $table;
			if(!empty($where)) $sql .= " WHERE " . $where;
			if(!empty($order)) $sql .= $order;
			if(!empty($limit)) $sql .= $limit;
			
			$sql .= ";";
			
			return $this->run($sql, $bind);
		}
		
		/**
		 *	set callback function for an instance of this class
		 *	- $errorCallbackFunction is a user-defined function that lives in the implementing class
		 */
		public function setErrorCallbackFunction($errorCallbackFunction, $errorMsgFormat="html") {
			//Variable functions for won't work with language constructs such as echo and print, so these are replaced with print_r.
			if(in_array(strtolower($errorCallbackFunction), array("echo", "print")))
				$errorCallbackFunction = "print_r";
	
			if(function_exists($errorCallbackFunction)) {
				$this->errorCallbackFunction = $errorCallbackFunction;	
				if(!in_array(strtolower($errorMsgFormat), array("html", "text")))
					$errorMsgFormat = "html";
				$this->errorMsgFormat = $errorMsgFormat;	
			}	
		}
	
		
		/**
		 *	update a record
		 */
		public function update($table, $info, $where, $bind="") {
			$fields = $this->filter($table, $info);
			$fieldSize = sizeof($fields);
			
			$sql = "UPDATE " . $table . " SET ";
			for($f = 0; $f < $fieldSize; ++$f) {
				if($f > 0)
					$sql .= ", ";
				$sql .= $fields[$f] . " = :update_" . $fields[$f]; 
			}
			$sql .= " WHERE " . $where . ";";
			
			$bind = $this->cleanup($bind);
			
			foreach($fields as $field)
				$bind[":update_$field"] = $info[$field];
			
			return $this->run($sql, $bind);
		}
		
		
		/**
		 *	getLastInsertId
		 *	- access method to return id of most recent inserted record
		 */
		public function getLastInsertId() {
			return $this->lastInsertId();		
		}
		
		/**
		 *	getErrorCode
		 *	- returns error code from 
		 */
		public function getErrorCode() {
			return $this->errorCode; 
		}
		
		public function getError() {
			return $this->error;	
		}
	}
	
		
?>
