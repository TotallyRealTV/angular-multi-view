<link href="styles.css" rel="stylesheet" type="text/css">

<h1>Php PDO Tests</h1>
<p>The files contained within this folder show you how to use TELETOON's PDO (php data object) library. PDO should be used for all database queries, regardless of module.</p>
<h2>Why PDO?</h2>
<p>1.	Standardized, uniform database access across all of our development. This layer of abstraction will especially be a benefit if we ever decide to switch database types.<br>
  2. Prepared Statements: an added level of protection against injection attacks.<br>
  3. Procedural = bad. Okay, sometimes it's needs-must (a lack of time or shelf life can excuse procedural code), but database transactions are a core portion of our development. Centralizing how we access our databases and tables is critical.
</p>
<p>&nbsp;</p>

<h2>Logic Flow</h2>
<p><a href="pdo_logic_flow.pdf" target="_blank">view the logic flow PDF</a></p>
<p>&nbsp;</p>

<h2>Configuration:</h2>
<p>1. Ensure that the phpLibraries/ repository has been checked out and installed in your XAMP htdocs/ directory.</p>
<p>2. Unzip the sql.zip file and install the pdo_tests database.</p>
<p>3. Analyze the code of each example below and then run each test.</p>
<p>&nbsp;</p>

<h2>Query Types:</h2>

<a href="insert.php">INSERT</a>
<br />
<a href="update.php">UPDATE</a>
<br />
<a href="select.php">SELECT</a>
<br />
<a href="selectLike.php">SELECT LIKE</a>
<br />
<a href="selectCount.php">SELECT COUNT</a>
<br />
<a href="selectIn.php">SELECT IN</a>
<br />
<a href="selectBetween.php">SELECT BETWEEN</a>
<br />
<!--a href="create.php">CREATE</a>
<br />
<a href="showCreate.php">SHOW CREATE</a>
<br />
<a href="showTables.php">SHOW TABLES</a>
<br /-->
