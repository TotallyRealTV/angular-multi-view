<?
	/**
	 * The MySQL Improved driver extends the Database_Library to provide 
	 * interaction with a MySQL database
	 */
	 
	class MysqlImproved_Driver extends Database_Library {
		
		private $connection;	// Connection holds MySQLi resource
		private $query; // Query to perform
		private $result; // Result holds data retrieved from server
		
		/**
		 * 	Create new connection to database
		 *	Expects:
		 *	$obj (optional) - iterate, if present,to create $db. Apply defaults after. This gives us the flexbility of changing databasess & tables per query
		 */ 
		public function connect($obj = NULL) {
			//connection parameters
			$db = (object) NULL;
			
			$db->host = isset($obj->host) && $obj->host != "" ? $obj->host : DB_HOST;
			$db->user = isset($obj->user) && $obj->user != "" ? $obj->user : DB_USER;
			$db->password = isset($obj->password) && $obj->password != "" ? $obj->password : DB_PASS;
			$db->database = isset($obj->database) && $obj->database != "" ? $obj->database : DB_DATABASE;
			
			//your implementation may require these...
			$port = NULL;
			$socket = NULL;	
			
			//create new mysqli connection
			$this->connection = new mysqli($db->host , $db->user , $db->password , $db->database , $port , $socket);
			
			return TRUE;
		}
	
		/**
		 * Break connection to database
		 */
		public function disconnect() {
			//clean up connection!
			$this->connection->close();	
			
			return TRUE;
		}
		
		/**
		 * Prepare query to execute
		 * 
		 * @param $query
		 */
		public function prepare($query) {
			//store query in query variable
			$this->query = $query;
			return TRUE;
		}
		
		/**
		 * Sanitize data to be used in a query
		 * 
		 * @param $data
		 */
		public function escape($data) {
			return $this->connection->real_escape_string($data);
		}
		
		/**
		 * Execute a prepared query
		 */
		public function query() {
			if (isset($this->query)) {
				//execute prepared query and store in result variable
				$this->result = $this->connection->query($this->query);
			
				return TRUE;
			}
			
			return FALSE;		
		}
		
		/**
		 * Fetch a row from the query result
		 * 
		 * @param $type
		 */
		public function fetch($type = '') {
			
			$return = array();
			
			if (isset($this->result)) {
				
				switch ($type) {
					case 'array':
						//fetch a row as array
						while($row = $this->result->fetch_array(MYSQL_ASSOC)) {
							 $return[] = $row;	
						}
					break;
					
					case 'arrayNumeric':
						while($row = $this->result->fetch_array(MYSQL_NUM)) {
							 $return[] = $row;	
						}
					break;
					
					case 'object':
						//fetch a row as object
						while($row = $this->result->fetch_array(MYSQL_ASSOC)) {
							 $return[] = $row;	
						}	
					break;
					
					
					default:
						
					break;
				}
				
				return $return;
			}
			
			return FALSE;
		}
		
		/**
		 *	getLatestID
		 *	- returns the ID of the latest record insert
		 */
		public function getLatestID() {
			return mysqli_insert_id($this->connection);	
		}
		
		public function getResult() {
			return $this->result;	
		}
		
		public function getRows() {
			return $this->result->num_rows;	
		}
	}
?>