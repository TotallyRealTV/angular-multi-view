<?php

	/**
	 *	Teletoon Inc: database connection
	 *	DATE: September 13, 2011
	 *	
	 *	db_connect.php
	 *	
	 *	NOTES:
	 *	database connection
	 */
	
	
	
	
	/**
	 *	tableConnect
	 *	After either dbConnect method is executed, tableConnect() selects a specified database
	 */
	
		function tableConnect($ob) {
			@ $dbSelect = mysql_select_db($ob->db);
			if (!$dbSelect) {
				$ob->errorCode = 1;	
			} 
			
			return $ob;
		}	
	
	
	
	/**
	 *	dbConnect
	 *	This method returns a successful or failed connection to the database
	 *	
	 */
		function dbConnect($ob) {
			// define db connection
			$ob->connectType = isset($ob->connectType) ? $ob->connectType : "standard";
			@ $ob->dbConn = $ob->connectType == "standard" ? mysql_connect(DB_SERVER,DB_USER,DB_PASS) : mysql_connect(DB_SERVER,DB_USER_FULL,DB_PASS_FULL);
			
			// throw an error if no connection can be made
			if (!$ob->dbConn) {
				$ob->errorCode = 1;	
			} else {
				// success, connect to database
				$ob = tableConnect($ob);
				$ob->errorCode = 0;
			}
			
			return $ob;
		}
	
?>
