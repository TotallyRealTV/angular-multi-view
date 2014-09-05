<link href="styles.css" rel="stylesheet" type="text/css">

<?

	include_once("config.php");
	include_once("RecordVO.php");

	/**
	 *	PDO INSERT
	 *
	 *	SQL requests are made exclusively with objects. The data to insert is merely a property of our overall PDO object.
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
	$query->dbTable = "insert_tests";
	
	/**
	 *	add our query specifics. In the case of data, it must be a object of key->value pairings.
	 *	the language property will is stubbed in for potential future use with the DatabaseMessagingVO class
	 *	The below equates to SELECT id, title
	 */
	$query->type = "insert";
	$query->language = "en";	
	
	$query->data = new stdClass();
	$query->data->title = "insert test";
	$query->data->dateTime = date("Y-m-d H:i:s");

?>

<br />
<br />
<a href="index.php">BACK</a>
<br />

<h1>INSERT TEST SUCCESS:</h1>
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

<h1>INSERT TEST DATA FAIL:</h1>
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

<h1>INSERT TEST DB FAIL:</h1>
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