<?php

	/**
	 *	SendmailStrategyInterface.php
	 *
	 *	Created:
	 *	2014-03-23
	 *
	 *	Modified:
	 *	2014-03-23
	 *
	 *	Created by:
	 *	Jonathan Blackburn for Teletoon Canada Inc.
	 *
	 *	Purpose:
	 *	- the Interface to which all Sendmail strategies must conform
	*/

	/*
		-------------------------------
		interface declaration
		-------------------------------
	*/

		interface SendmailStrategyInterface {
		  
		  	// interface methods
			public function sendmail($obj);
		}


?>