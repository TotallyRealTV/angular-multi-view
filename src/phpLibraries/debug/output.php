<?php

	
	/*
		----------------------------------------------------
		
		global php helpers
		DATE: September 28, 2008
		
		helpers.php
		
		NOTES:
		output	
		----------------------------------------------------
	*/
	
	
	
		
		
	/*
		-------------------------------------
		testOutput($type, $output)
		
		EXPECTS: a type (str) of either 'str' or 'arr' || 'obj'
		returns: nothing
		
		NOTES:
		- either echoes a string or prints an array to screen
		-------------------------------------
	*/
	
		function testOutput($type, $ob) {
			if ($type == 'str') {
				 echo 'STRING OUTPUT: '.$ob;	// comment out when employing sessions
			} else if($type == 'arr') {
				printa($ob, 1);
			} else if ($type == 'obj') {
				echo "OBJ: {<BR>";
				printObj($ob, 1);
				echo "}";	
				
			} 
		}
		
		function printInfo($class = "", $method = "", $line = "") {
			echo "<br>" . $class . "<br>" . $method . "<br>" . " at line: " . $line;	
		}
	
	/*
		printObj
		Recursive outputs objects & props
	*/
		function printObj($obj, $index) {
			$indent = "";
			for ($i = 0; $i < $index; $i++) {
				$indent .= "&nbsp&nbsp;&nbsp;&nbsp;";
			}
			
			foreach ($obj as $key=>$value) {
				if (is_object($value)) {
					echo "<BR>".$indent . "OBJ: [" .$key . "] {<BR>";
					printObj($value, $index+=1);
					echo $indent . "}<BR>";	
				} else if (is_array($value)) {
					echo $indent . $key . "[arr]:<BR>";
					printa($value, $index+=1);
				} else {
					echo $indent . $key . ' = ' . $value. '<BR>'; // comment out when employing sessions	
				}
			}	
		}
		
	/*
		----------------------------------------------------
		Function printa
		
		Used to display detailed information about an array
		
		----------------------------------------------------
	*/	
	
		
		function printa($obj, $index) {
			
			$indent = "";
			for ($i = 0; $i < $index; $i++) {
				$indent .= "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			
			global $__level_deep;
		  
			if (!isset($__level_deep)) $__level_deep = array();
		
				if (is_object($obj))
					print $indent. '[obj]<br>\n';
				elseif (is_array($obj)) {
			
					foreach(array_keys($obj) as $keys) {
						array_push($__level_deep, "[".$keys."]");
						printa($obj[$keys], $index);
						array_pop($__level_deep);
					}
				}
				
			else print $indent . implode(" ",$__level_deep)." = $obj<br>\n";
		}
		
		/**
		 *	methodName()
		 *	outputs method name
		 */
		function methodName($function, $file, $line) { 
			echo $function ." in ". $file ." at ". $line ."\n"; 
		}
		
		
	
