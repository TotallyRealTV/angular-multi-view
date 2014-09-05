<link href="styles.css" rel="stylesheet" type="text/css">

<?

	include_once("config.php");
	include_once("RecordVO.php");

	/**
	 *	PDO SELECT
	 *
	 *	SQL requests are made exclusively with objects. The data to select is merely a property of our overall PDO object.
	 */	

	/**
	 *	define our query object
	 */
	$query = new stdClass();
	
	/**
	 * 	add our database properties. These are all required.
	 */
	$query->host = DB_HOST;
	$query->user = DB_USER;
	$query->password = DB_PASS;
	$query->dbName = "pdo_tests";
	$query->dbTable = "select_tests";
	
	/**
	 *	add our query specifics. In the case of data, you can use array("*") to select all data from a table.
	 *	the language property is stubbed in for potential future use with the DatabaseMessagingVO class
	 *	The below equates to SELECT id, admin_name, display_name
	 */
	$query->type = "selectBetween";
	$query->language = "en";	
	$query->data = array("id", "admin_name", "display_name");
			
	/**
	 *	add our conditionRange sub object. This constitutes your WHERE clause. 
	 *	The below translates to WHERE active = 1, language = en
	 *	Optional.
	 */
	$query->conditionalRange = new stdClass();
	$query->conditionalRange->active = 1;
	$query->conditionalRange->language = "en";
	
	
	/**
	 *	add our betweenRange sub object. This constitutes your BETWEEB clause. 
	 *	This object becomes entry_date_time BETWEEN "2012-04-10" AND "2012-04-26"
	 *	Optional.
	 */
	$query->betweenRange = new stdClass();
	$query->betweenRange->betweenField = "entry_date_time";
	$query->betweenRange->startRange = "2012-04-10";
	$query->betweenRange->endRange = "2012-04-26";
	
	/**
	 *	add our selectOrder sub object. This constitutes your ORDER BY clause. 
	 *	The below translates to ORDER BY title ASC.
	 *	Optional.
	 */
	$query->selectOrder = new stdClass();
	$query->selectOrder->orderFields = "display_name";
	$query->selectOrder->orderType = "ASC";
	
	/**
	 *	add our limit sub object. <br />
	 *	This constitutes your LIMIT clause.
	 *	Optional.
	 */
	$query->limit = new stdClass();
	$query->limit = 10;

?>

<br />
<br />
<a href="index.php">BACK</a>
<br />

<h1>SELECT TEST SUCCESS:</h1>
<p>Expected result: data return</p>
<? 
	/**
	 *	instance our RecordVO class (our gateway)
	 */
	$record = new RecordVO();
	
	/**
	 *	execute the query
	 */
	$dataResult = new stdClass();
	$dataResult = $record->executeQuery($query);
	testOutput('obj', $dataResult); 
?>

<h1>SELECT TEST DATA FAIL:</h1>
<p>Expected result: error message</p>
<? 
	/**
	 *	instance our RecordVO class (our gateway)
	 */
	//$record = new RecordVO();
	
	/**
	 *	execute the query
	 */
	$query->dbTable = "crap-db-name"; 
	
	$dataResult = new stdClass();
	$dataResult = $record->executeQuery($query);
	testOutput('obj', $dataResult); 
	
?>

<h1>SELECT TEST DB FAIL:</h1>
<p>Expected result: fatal error</p>
<? 
	/**
	 *	instance our RecordVO class (our gateway)
	 */
	//$record = new RecordVO();
	
	/**
	 *	execute the query
	 */
	$query->dbName = "crap-db-name"; 
	
	$dataResult = new stdClass();
	$dataResult = $record->executeQuery($query);
	testOutput('obj', $dataResult); 
	
?>