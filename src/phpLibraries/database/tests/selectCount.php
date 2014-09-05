<link href="styles.css" rel="stylesheet" type="text/css">

<?

	include_once("config.php");
	include_once("RecordVO.php");

	/**
	 *	PDO SELECT COUNT
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
	 *	the language property will is stubbed in for potential future use with the DatabaseMessagingVO class
	 *	The below equates to SELECT id, title
	 */
	$query->type = "selectCount";
	$query->language = "en";	
	$query->data = array("id");
	$query->dataType = "customKey";		// you can set this to whatever you want
			
	/**
	 *	add our conditionRange sub object. This constitutes your WHERE clause. 
	 *	The below translates to WHERE active = 1, language = en
	 *	Optional.
	 */
	$query->conditionalRange = new stdClass();
	$query->conditionalRange->active = 1;
	$query->conditionalRange->language = "en";
	
	/**
	 *	less than range
	 *	This constitutes your <= clause.
	 *	Optional.
	 */
	$query->lessThanEqualRange = new stdClass();
	$query->lessThanEqualRange->entry_date_time = "2012-04-26";
	
	/**
	 *	less than range
	 *	This constitutes your <= clause.
	 *	Optional.
	 */		
	$query->greaterThanEqualRange = new stdClass();
	$query->greaterThanEqualRange->entry_date_time = "2012-04-01";

?>

<br />
<br />
<a href="index.php">BACK</a>
<br />

<h1>SELECT COUNT TEST SUCCESS:</h1>
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

<h1>SELECT COUNT TEST DATA FAIL:</h1>
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

<h1>SELECT COUNT TEST DB FAIL:</h1>
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