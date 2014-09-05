<?
	error_reporting(E_ALL ^ E_NOTICE);
	include $_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/debug/output.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/phpLibraries/utilities/string.php";
	require_once 'excelReader.php';
	
	
	
	$reader = new Spreadsheet_Excel_Reader("example.xls", false);
	$data = $reader->getData();
	
	$sheets = count($data);
	$rows = $data[0]['numRows'];
	$cols = $data[0]['numCols'];
	
	for ($i = 0; $i < $sheets; $i++) {
		for ($j = 0; $j <= $rows; $j++) {
			for ($k = 1; $k < $cols; $k++) {
				$str = urlencode($data[$i]['cells'][$j][$k]);
				//echo "data: " . $str . "<BR>";	
				$str = replaceBadChars($str);
				$str = utf8_decode($str);
				
				$data[$i]['cells'][$j][$k] = $str;
			}
			
			
		}
	}
	
?>