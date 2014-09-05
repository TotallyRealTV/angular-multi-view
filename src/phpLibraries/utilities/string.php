<?

	
	/**
		-----------------------------------------------------
		
		string.php
		
		NOTES:
		common legacy string methods
	
		----------------------------------------------------
	*/
	
	 /**
	  * Checks to see of a string contains a particular substring
	  * @param $substring the substring to match
	  * @param $string the string to search 
	  * @return true if $substring is found in $string, false otherwise
	  */
		function contains($substring, $string) {
			$pos = strpos($string, $substring);
		 
			if($pos === false) {
				// string needle NOT found in haystack
				return false;
			}
			
			// string needle found in haystack
			return true;
					 
		}
		
		function replaceBadChars($checkMe) {
			
			// define method arrs
			$badChars = Array(	"%E2%80%9C",
								"%E2%80%9D",
								"%E2%80%A6",
								"%E2%80%93",
								"%E2%80%99",
								"%C3%80",
								"%96", //dash
								"%97", //dash
								"%93", //double quote open
								"%94", //double quote close
								"%92", //apostrophe
								"%85", //emdash (?)
								"%91", //apostrophe 2
								"%0D%0A", //return and linefeed (replace with period)
								"%5C%22", //slashed double quote
								"%5C%27", //slashed single quote
								"%99", 	//
								"%80",
								"%E2", // Œ
								"%9C",
								"%AE",
								"%C3%A9",
								"%C0", //Capital A-grave
								"%E0", //Lowercase a-grave
								"%C1", //Capital A-acute
								"%E1", //Lowercase a-acute
								"%C2", //LCapital A-circumflex
								"%E2", //LLowercase a-circumflex
								"%C4",//LCapital A-umlaut
								"%E4",//LLowercase a-umlaut
								"%C6", //LCapital AE Ligature
								"%E6", //LLowercase AE Ligature
								"%C7", //LCapital C-cedilla
								"%E7",//LLowercase c-cedilla
								"%C8",//LCapital E-grave
								"%E8",//LLowercase e-grave
								"%C9",//LCapital E-acute
								"%E9",//LLowercase e-acute
								"%CA;",//LCapital E-circumflex
								"%EA",//LLowercase e-circumflex
								"%CB",//LCapital E-umlaut
								"%EB",//LLowercase e-umlaut
								"%CC", //Capital I-grave
								"%EC", //Lowercase i-grave
								"%CD", //Capital I-acute
								"%ED", //Lowercase i-acute
								"%CE",//LCapital I-circumflex
								"%EE",//L&#238;	&#xEE;	Lowercase i-circumflex
								"%CF",//LCapital I-umlaut
								"%EF",//LLowercase i-umlaut
								"%D2",//LCapital O-grave
								"%F2",//LLowercase o-grave
								"%D3",//LCapital O-acute
								"%F3",//LLowercase o-acute
								"%D4",//LCapital O-circumflex
								"%F4",//LLowercase o-circumflex
								//"&OElig;",//LCapital OE ligature
								//"&oelig;",//LLowercase oe ligature
								"%D9",//LCapital U-grave
								"%F9",//Llowercase u-grave
								"%DA", //Capital U-acute
								"%FA",//lowercase u-acute
								"%DB",//LCapital U-circumflex
								"%FB",//Llowercase u-circumflex
								"%DC",//LCapital U-umlaut
								"%FC",//Llowercase u-umlaut,
								"%3F", //single apostrophe,
								"%C4%99"
								);
								
							
			$goodChars = Array(	"%22",
								"%22",
								"...",
								"%2D",
								"%27",
								"&Agrave;",
								"%2D",
								"%2D",
								"%22",
								"%22",
								"%27",
								"%2D",
								"%27",
								"%0D",
								"%22",
								"%27",
								"%22", // ISO, no good
								"%2D",
								"",
								"&oelig;",
								"&reg;",
								"&eacute;",
								"&Agrave;", //Capital A-grave
								"&agrave;",
								"&Aacute;", //Capital A-acute
								"&aacute;",
								"&Acirc;", //LCapital A-circumflex
								"&acirc;",
								"&Auml;",//LCapital A-umlaut
								"&auml;",//LLowercase a-umlaut
								"&AElig;", //LCapital AE Ligature
								"&aelig;",
								"&Ccedil;", //LCapital C-cedilla
								"&ccedil;",
								"&Egrave;",//LCapital E-grave
								"&egrave;",
								"&Eacute;",//LCapital E-acute
								"&eacute;",
								"&Ecirc;",//LCapital E-circumflex
								"&ecirc;",
								"&Euml;",//LCapital E-umlaut
								"&euml;",
								"&Igrave;",//LCapital I-grave
								"&igrave;",
								"&Iacute;",//LCapital I-acute
								"&iacute;",
								"&Icirc;",//LCapital I-circumflex
								"&icirc;",
								"&Iuml;",//LCapital I-umlaut
								"&iuml;",
								"&Ograve;",//LCapital O-grave
								"&ograve;",
								"&Oacute;",//LCapital O-acute
								"&oacute;",
								"&Ocirc;",//LCapital O-circumflex
								"&ocirc;",//LLowercase o-circumflex
								//"&OElig;",
								//"&Oelig;",//LLowercase oe ligature
								"&Ugrave;",//LCapital U-grave
								"&ugrave;",
								"&Uacute;", //Capital U-acute
								"&uacute;",
								"&Ucirc;",//LCapital U-circumflex
								"&ucirc;",
								"&Uuml;",//LCapital U-umlaut
								"&uuml;",
								"'",
								"&ecedil;"
								);
								
							
			$checkMe = str_replace($badChars, $goodChars, $checkMe);
			$checkMe = urldecode($checkMe);
			
			return $checkMe;
		}
		
		
		
		/**
		 *	frenchCharsToLowerCase
		 *	Replaces URL - encoded extended Capitalized french characters and replace with lowercase equivalents.
		 *	returns replaced string to caller
		 */
		function frenchCharsToLowerCase($checkMe) {
		
			$checkMe=urlencode($checkMe);
		
			$badChars = Array(	"%C0", //Capital A-grave
                        "%E0", //Lowercase a-grave
                        "%C1", //Capital A-acute
                        "%E1", //Lowercase a-acute
                        "%C2", //LCapital A-circumflex
                        "%E2", //LLowercase a-circumflex
                        "%C4",//LCapital A-umlaut
                        "%E4",//LLowercase a-umlaut
                        "%C6", //LCapital AE Ligature
                        "%E6", //LLowercase AE Ligature
                        "%C7", //LCapital C-cedilla
                        "%E7",//LLowercase c-cedilla
                        "%C8",//LCapital E-grave
                        "%E8",//LLowercase e-grave
                        "%C9",//LCapital E-acute
                        "%E9",//LLowercase e-acute
                        "%CA;",//LCapital E-circumflex
                        "%EA",//LLowercase e-circumflex
                        "%CB",//LCapital E-umlaut
                        "%EB",//LLowercase e-umlaut
                        "%CC", //Capital I-grave
                        "%EC", //Lowercase i-grave
                        "%CD", //Capital I-acute
                        "%ED", //Lowercase i-acute
                        "%CE",//LCapital I-circumflex
                        "%EE",//L&#238;	&#xEE;	Lowercase i-circumflex
                        "%CF",//LCapital I-umlaut
                        "%EF",//LLowercase i-umlaut
                        "%D2",//LCapital O-grave
                        "%F2",//LLowercase o-grave
                        "%D3",//LCapital O-acute
                        "%F3",//LLowercase o-acute
                        "%D4",//LCapital O-circumflex
                        "%F4",//LLowercase o-circumflex
                        //"&OElig;",//LCapital OE ligature
                        //"&oelig;",//LLowercase oe ligature
                        "%D9",//LCapital U-grave
                        "%F9",//Llowercase u-grave
                        "%DA", //Capital U-acute
                        "%FA",//lowercase u-acute
                        "%DB",//LCapital U-circumflex
                        "%FB",//Llowercase u-circumflex
                        "%DC",//LCapital U-umlaut
                        "%FC",//Llowercase u-umlaut
						"%C4%99"
						);
					
	$goodChars = Array(	"&Agrave;", //Capital A-grave
                        "&agrave;",
                        "&Aacute;", //Capital A-acute
                        "&aacute;",
                        "&Acirc;", //LCapital A-circumflex
                        "&acirc;",
                        "&Auml;",//LCapital A-umlaut
                        "&auml;",//LLowercase a-umlaut
                        "&AElig;", //LCapital AE Ligature
                        "&aelig;",
                        "&Ccedil;", //LCapital C-cedilla
                        "&ccedil;",
                        "&Egrave;",//LCapital E-grave
                        "&egrave;",
                        "&Eacute;",//LCapital E-acute
                        "&eacute;",
                        "&Ecirc;",//LCapital E-circumflex
                        "&ecirc;",
                        "&Euml;",//LCapital E-umlaut
                        "&euml;",
                        "&Igrave;",//LCapital I-grave
                        "&igrave;",
                        "&Iacute;",//LCapital I-acute
                        "&iacute;",
                        "&Icirc;",//LCapital I-circumflex
                        "&icirc;",
                        "&Iuml;",//LCapital I-umlaut
                        "&iuml;",
                        "&Ograve;",//LCapital O-grave
                        "&ograve;",
                        "&Oacute;",//LCapital O-acute
                        "&oacute;",
                        "&Ocirc;",//LCapital O-circumflex
                        "&ocirc;",//LLowercase o-circumflex
                        //"&OElig;",
                        //"&Oelig;",//LLowercase oe ligature
                        "&Ugrave;",//LCapital U-grave
                        "&ugrave;",
                        "&Uacute;", //Capital U-acute
                        "&uacute;",
                        "&Ucirc;",//LCapital U-circumflex
                        "&ucirc;",
                        "&Uuml;",//LCapital U-umlaut
                        "&uuml;",
						"&ecedil;"
						);
                        
/*
"&Agrave;", //Capital A-grave
                        "&agrave;", //Lowercase a-grave
                        "&Acirc;", //LCapital A-circumflex
                        "&acirc;", //LLowercase a-circumflex
                        "&AElig;", //LCapital AE Ligature
                        "&aelig;", //LLowercase AE Ligature
                        "&Ccedil;", //LCapital C-cedilla
                        "&ccedil;",//LLowercase c-cedilla
                        "&Egrave;",//LCapital E-grave
                        "&egrave;",//LLowercase e-grave
                        "&Eacute;",//LCapital E-acute
                        "&eacute;",//LLowercase e-acute
                        "&Ecirc;",//LCapital E-circumflex
                        "&ecirc;",//LLowercase e-circumflex
                        "&Euml;",//LCapital E-umlaut
                        "&euml;",//LLowercase e-umlaut
                        "&Icirc;",//LCapital I-circumflex
                        "&icirc;",//L&#238;	&#xEE;	Lowercase i-circumflex
                        "&Iuml;",//LCapital I-umlaut
                        "&iuml;",//LLowercase i-umlaut
                        "&Ocirc;",//LCapital O-circumflex
                        "&ocirc;",//LLowercase o-circumflex
                        "&OElig;",//LCapital OE ligature
                        "&oelig;",//LLowercase oe ligature
                        "&Ugrave;",//LCapital U-grave
                        "&ugrave;",//LLowercase u-grave
                        "&Ucirc;",//LCapital U-circumflex
                        "&ucirc;",//LLowercase U-circumflex
                        
			Display	Friendly Code	Numerical Code	Hex Code	Description
			À 	&Agrave;	&#192;	&#xC0;	Capital A-grave
			à 	&agrave;	&#224;	&#xE0;	Lowercase a-grave
			Â 	&Acirc;	&#194;	&#xC2;	Capital A-circumflex
			â 	&acirc;	&#226;	&#xE2;	Lowercase a-circumflex
			Æ	&AElig;	&#198;	&#xC6;	Capital AE Ligature
			æ	&aelig;	&#230;	&#xE6;	Lowercase AE Ligature
			Ç	&Ccedil;	&#199;	&#xC7;	Capital C-cedilla
			ç	&ccedil;	&#231;	&#xE7;	Lowercase c-cedilla
			È 	&Egrave;	&#200;	&#xC8;	Capital E-grave
			è	&egrave;	&#232;	&#xE8;	Lowercase e-grave
			É 	&Eacute;	&#201;	&#xC9;	Capital E-acute
			é	&eacute;	&#233;	&#xE9;	Lowercase e-acute
			Ê 	&Ecirc;	&#202;	&#xCA;	Capital E-circumflex
			ê 	&ecirc;	&#234;	&#xEA;	Lowercase e-circumflex
			Ë 	&Euml;	&#203;	&#xCB;	Capital E-umlaut
			ë 	&euml;	&#235;	&#xEB;	Lowercase e-umlaut
			Î 	&Icirc;	&#206;	&#xCE;	Capital I-circumflex
			î 	&icirc;	&#238;	&#xEE;	Lowercase i-circumflex
			Ï 	&Iuml;	&#207;	&#xCF;	Capital I-umlaut
			ï 	&iuml;	&#239;	&#xEF;	Lowercase i-umlaut
			Ô	&Ocirc;	&#212;	&#xD4;	Capital O-circumflex
			ô	&ocirc;	&#244;	&#xF4;	Lowercase o-circumflex
			Œ	&OElig;	&#140;	&#x152;	Capital OE ligature
			œ	&oelig;	&#156;	&#x153;	Lowercase oe ligature
			Ù	&Ugrave;	&#217;	&#xD9;	Capital U-grave
			ù	&ugrave;	&#249;	&#xF9;	Lowercase u-grave
			Û	&Ucirc;	&#219;	&#xDB;	Capital U-circumflex
			û	&ucirc;	&#251;	&#xFB;	Lowercase U-circumflex
			Ü	&Uuml;	&#220;	&#xDC;	Capital U-umlaut
			ü	&uuml;	&#252;	&#xFC;	Lowercase U-umlaut
			«	&laquo;	&#171;	&#xAB;	Left angle quotes
			»	&raquo;	&#187;	&#xBB;	Right angle quotes
			€	&euro;	&#128;	&#x80;	Euro
			?	 	&#8355;	&#x20A3;	Franc
			*/
			$checkMe = str_replace($badChars, $goodChars, $checkMe);
			
			return urldecode($checkMe);
		
		}
		
		
		function trimStringEnd($str, $trim) {
			return rtrim($str, $trim);	
		}
		
		function trimStringBeginning($str, $trim) {
			return ltrim($str, $trim);	
		}
		
		function getLastCharacter($str) {
			return $str[strlen($str)-1];	
		}

		function convertForFrench($str) {
			$str = urlencode($str);
			$str = replaceBadChars($str);
			return $str;	
		}
		
		function stripAccents($str) {
			return strtr($str, utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
		}
		
		function specialCharsToUpper($str) {
			$specialChars = array(
				array("&AGRAVE;", "&Agrave;"),
				array("&AACUTE", "&Aacute"),
				array("&ACIRC;", "&Acirc;"),
				array("&AMUL;",  "&Auml;",),
				array("&AELIG;", "&AElig;"),
				array("&CCEDIL;", "&Ccedil;"),
				array("&EGRAVE;", "&Egrave;"),
				array("&EACUTE;",  "&Eacute;"),
				array("&ECIRC;", "&Ecirc;"),
				array("&EUML;", "&Euml;"),
				array("&IGRAVE;", "&Igrave;"),
				array("&IACUTE;", "&Iacute;"),
				array("&ICIRC;", "&Icirc;"),
				array("&IUML;",  "&Iuml;"),
				array("&OGRAVE;",  "&Ograve;"),
				array("&OACUTE;", "&Oacute;"),
				array("&OCIRC;", "&Ocirc;"),
				array("&UGRAVE;", "&Ugrave;"),
				array("&UACUTE;", "&Uacute;"),
				array("&UCIRC;", "&Ucirc;"),
				array("&UUML;", "&Uuml;"),
				array("&ECEDIL;", "&Ecedil;")
			);
		
			$str = strtoupper($str);
			
			for ($i = 0; $i < count($specialChars); $i++) {
				$str = str_replace($specialChars[$i][0], $specialChars[$i][1], $str);
			}
			
			return $str;	
		}

?>