<?
       

	/**
	 *	testFileParser.php
	 *	- sample implementation of FileParser.php
	 *	- fgetcsv is not binary-safe(!). Set delimiter in the file as a pipe (|), then explode string on "|" and write custom parser for each line. Fuck you php.
	 */

	
	include $_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/global/global.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/debug/output.php";
	
	
	require_once("FileParser.php");
	
	$init = (object) NULL;
	$init = retrieveObVars($init);

	$fileParser = new FileParser($init);

	$data = $fileParser->parseFile();
	testOutput('obj', $data);
	

?>