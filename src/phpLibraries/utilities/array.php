<?php

	
	/**
		-----------------------------------------------------
		
		array.php
		
		NOTES:
		common array methods
	
		----------------------------------------------------
	*/
	
		
	
	 /**
	  * removes an element from an array
	  * @param $substring the substring to match
	  * @param $string the string to search 
	  * @return true if $substring is found in $string, false otherwise
	  */
		function removeElementWithValue($array, $key, $value){
			$count = count($array);
			for ($i = 0; $i < $count; $i++) {
		 		if ($array[$i][0] == $key && $array[$i][1] == $value) {
					unset($array[$i]);	
				}
			}
			
			$array = array_values($array);
			
			return $array;
		}
		
	
	/**
	 *	flattens a multi-dimensional array to single-dimension
	 */	
		function array_flat($array) { 

			foreach($array as $a) { 
				if(is_array($a)) { 
			  		$tmp = array_merge($tmp, array_flat($a)); 
				} else { 
			  		$tmp[] = $a; 
				} 
		  	}
			 
			return $tmp; 
		}
		
		function trimArray($sourceArray, $targetArray) {
			for ($i = count($sourceArray) - 1; $i >= 0; $i--) {
				array_splice($targetArray, $sourceArray[$i], 1);	
			}
			array_unique($targetArray);
			return $targetArray;
		}

?>