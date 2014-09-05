<?

	/**
	 *	XLSParseStrategy.php
	 *
	 *	Created:
	 *	2012-03-06
	 *
	 *	Modified:
	 *	2012-03-06
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- parses an XLS file
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('ParseStrategyInterface.php');
 		include_once('BaseParseStrategy.php');
  		include_once('parseXLS/excelReader.php');
	
	
		class XLSParseStrategy extends BaseParseStrategy implements ParseStrategyInterface {
		
		/**
		 *	execute
		 *	- instances XLS reader
		 *	- returns array of records to calling class
		 */	 
			public function parseFile($fileName) {
				$reader = new Spreadsheet_Excel_Reader($fileName, false);
				$data = $reader->getData();
				
				$sheets = count($data);
				$rows = $reader->rowcount();
				$cols = $reader->colcount();
				
				for ($i = 0; $i < $sheets; $i++) {
					for ($j = 1; $j <= $rows; $j++) {
						
						for ($k = 1; $k < $cols; $k++) {
							$str = urlencode($data[$i]['cells'][$j][$k]);
							$str = replaceBadChars($str);
							$str = utf8_decode($str);
							
							$data[$i]['cells'][$j][$k] = $str;
						}
					}
				}
				
				return $data;
			}
		}



?>