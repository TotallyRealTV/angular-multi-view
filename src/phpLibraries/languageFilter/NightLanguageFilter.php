<?

	/**
	 *	LanguageFilter.php
	 *
	 *	Created:
	 *	2012-02-07
	 *
	 *	Modified:
	 *	2012-02-07
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- this instances LanguageFilter, which provides the common methods and properties used in language filtering for both teletoon & night.
	 *	- all data (such as filter arrays), and implementation-specific methods, will be found in extensions to this class. Current extensions include:
	 *		- TeletoonLanguageFilter
	 *		- 
	 *
	 *	Accepts:
	 *	
	 */

	


	class NightLanguageFilter extends LanguageFilter  {
		
		// constructor
		public function __construct($obj) {
			$this->setupProps($obj);
			
			parent::generate($obj);
		}
	
		// setup methods
		protected function setupProps($obj) {
			
			$this->brand = "night";
			
			$this->badWords = array('PÉNIS', 
									'PENIS', 
									'SUCE', 
									'CACA', 
									'PIPI', 
									'SEINS', 
									'MERDE', 
									'PUTAIN', 
									'CHIER', 
									'ZOB', 
									'CONNARD', 
									'CONNASSE',
									'SALOPE', 
									'SALAUD', 
									'CHIOTTE', 
									'ESGOURDE', 
									'ROUBIGNOLLE', 
									'COUILLE', 
									'PUTASSE', 
									'PUTASSIERE', 
									'BORDEL', 
									'JACQUETER',
									'JAFFER', 
									'BAISER', 
									'NIQUER', 
									'ENCULER', 
									'ENCULÉ', 
									'ENCULE', 
									'ENFOIRÉ', 
									'ENFOIRE', 
									'FOUTRE', 
									'TABARNAC', 
									'CRISSE',
									'CALISSE', 
									'ESTIE', 
									'CIBOIRE', 
									'ST-VIERGE', 
									'SACRAMENT', 
									'SACREMENT', 
									'ENFOIRER', 
									'EMMERDER', 
									//'ARSE', 
									'ASSHOLE', 
									'BLOWJOB', 
									'BONER', 
									'BROWNEYE', 
									'BULLSHIT', 
									'CLIT', 
									'CUNNILINGUS',
									//'DILDO', 
									//'DUMBASS', 
									'FAGGOT', 
									'GONADS', 
									'PUSSY', 
									'PHUQER', 
									//'SHIT', 
									'SLUT', 
									'TABAR', 
									'TABARNAK',
									'TWAT', 
									'VAGINA', 
									//'VIBRATOR', 
									'WANKER', 
									//'FART', 
									'FOOK', 
									'FUKE', 
									//'FUKIN', 
									'FRICKIN', 
									'F.UCK', 
									//'SH!T', 
									//'SH\*T',
									'F\*UK', 
									'F!CK', 
									'RAPE', 
									'RAPING', 
									'WTF', 
									'HOTMAIL',
									'GMAIL', 
									'YAHOO\.COM', 
									'YAHOO\.CA', 
									'MSN',
									'://', 
									'admin', 
									'anal', 
									//'anus', 
									'aryan', 
									//'ass', 
									//'a55', 
									'bang', 
									'bastard', 
									'bimbo', 
									'bitch', 
									'blow', 
									'bondage',
									'boobs', 
									'butt', 
									'carpet', 
									'chink', 
									'cock',
									'coon', 
									'cum', 
									'cunt',
									'darky',
									'darkie',
									'darkies', 
									'dick', 
									'ejacu', 
									//'erot', 
									'fag', 
									//'fct', 
									//'fetish', 
									//'fore',
									'fuck', 
									//'fudge', 
									'fuk', 
									'f_ck', 
									'gook', 
									//'gang', 
									//'hardcore', 
									//'hentai', 
									//'hoochie', 
									'holocaust', 
									'homo', 
									'hooker',
									'horny', 
									//'http', 
									'intercourse', 
									'jerk', 
									'jew', 
									//'lesbo', 
									'jigaboo', 
									'jizz', 
									'kike', 
									'kkk', 
									'klu', 
									'klux',
									'klan', 
									//'knob', 
									'kyke', 
									'lesbian', 
									'masoch', 
									//'masturbat', 
									//'muff', 
									'naked', 
									'nazi', 
									//'nigg',
									'ngger',
									'nggr',
									'nigga',
									'niggaz',
									'nigger', 
									'niggers',
									'niggered',
									'nude', 
									'nympho',
									//'oral', 
									'orgasm', 
									'orgy', 
									'paki', 
									//'panties', 
									'pedophile', 
									'penetrate', 
									'penis', 
									//'piss', 
									'porchmonkey', 
									'porn', 
									'puss', 
									//'s and m',
									//'s&m', 
									//'s & m', 
									//'sandm', 
									//'sadism', 
									//'sex', 
									'shit', 
									/*'sht', 
									'sh1t', 
									'sh_t',*/ 
									'sixtynine', 
									'sixty', 
									//'slut', 
									'spearchucker', 
									//'sperm', 
									'spic', 
									'spook',
									'spunk', 
									'strip', 
									'suck', 
									//'three some', 
									//'threesome', 
									'tits', 
									'turd', 
									'twat', 
									'upskirt', 
									//'vagina', 
									//'virgin', 
									//'voyeur', 
									'white',
									'supremacy', 
									'tabar', 
									'whore', 
									'wop');
			
			parent::setupProps($obj);
		}
		
	}
	
?>