<link href="styles.css" rel="stylesheet" type="text/css">

<?

	include_once("config.php");
	include_once("RecordVO.php");

	/**
	 *	PDO UPDATE
	 *
	 *	SQL requests are made exclusively with objects. The data to update is merely a property of our overall PDO object.
	 */	

	/**
	 *	define our query object
	 */
	$query = new stdClass();
	
	/**
	 * 	add our database properties. These are all required.
	 */
	$query->host = DB_HOST_ALT;
	$query->user = DB_USER_FULL;
	$query->password = DB_PASS_FULL;
	$query->dbName = "pdo_tests";
	$query->dbTable = "update_tests";
	
	/**
	 *	add our query specifics. In the case of data, it must be a object of key->value pairings.
	 *	the language property will is stubbed in for potential future use with the DatabaseMessagingVO class
	 *	The below equates to UPDATE update_tests SET title='update test'... WHERE id = 1;
	 */
	$query->type = "update";
	$query->language = "en";	
	
	$query->data = new stdClass();
	$query->data->title = "update test";
	$query->data->dateTime = date("Y-m-d H:i:s");
	
	//	these two lines identify the record ID we are to update
	$query->data->row = 1;
	$query->data->rowIDName = "id";

?>

<br />
<br />
<a href="index.php">BACK</a>
<br />

<h1>UPDATE TEST SUCCESS:</h1>
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

<h1>UPDATE TEST DATA FAIL:</h1>
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
	$query->data->row = 1;
	$query->data->rowIDName = "id";
	
	$dataResult = new stdClass();
	$dataResult = $record->executeQuery($query);
	testOutput('obj', $dataResult); 
	
?>

<h1>UPDATE TEST DB FAIL:</h1>
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
	$query->data->row = 1;
	$query->data->rowIDName = "id";
	
	$dataResult = new stdClass();
	$dataResult = $record->executeQuery($query);
	testOutput('obj', $dataResult); 
	
?>