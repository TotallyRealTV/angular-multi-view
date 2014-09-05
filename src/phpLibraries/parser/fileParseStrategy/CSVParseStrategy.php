<?

	/**
	 *	CSVParseStrategy.php
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
	 *	- parses a CSV file
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('ParseStrategyInterface.php');
 		include_once('BaseParseStrategy.php');
  		
		class CSVParseStrategy extends BaseParseStrategy implements ParseStrategyInterface {
		
		/**
		 *	execute
		 *	- instances csvIterator and pushes each row to $data array
		 *	- returns result
		 */	 
			public function parseFile($fileName) {
				$parsedData = array();
				
				$contents = file_get_contents($fileName);
				$contents = iconv('ISO-8859-15', 'UTF-8', $contents);
				
				//echo $contents;
				
				$data = explode("\n", $contents);
				$header = explode("|", $data[0]);
				
				for ($i = 1; $i < count($data); $i++) {
					
					if (strlen($data[$i]) > 0) {
						$subData = explode("|", $data[$i]);	
						$newItem = new stdClass();
						
						for ($j = 0; $j < count($header); $j++) {
							$str = $subData[$j];
							
							$testStr = str_replace("\r", "", $str);
							
							if (strlen($testStr) > 0) {
								$str = urlencode($str);						
								$str = convertForFrench($str);
								$str = urldecode($str);
								$newItem->$header[$j] = $subData[$j];
							}
								
						}
						array_push($parsedData, $newItem);
					}
				}
				
				
				return $parsedData;
			}
		}



?>