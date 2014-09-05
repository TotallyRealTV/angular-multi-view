<?php

	/**
	 *	ContactController
	 *
	 *	Submits contact emails to db
	 *
	 *	Sample Usage:
	 *		http://localhost/api/?section=contact&formAction=sendmail&pname=Jonathan%20Blackburn&pemail=test@test.com&pmessage=this%20is%20a%20test
	 */
	
	include_once(ROOT_PATH . "config/contact/config.php");
	include_once("model/contact/ContactModel.php");

	
	class ContactController extends BaseController {
		
		/**
		 *	constructor
		 *	- invokes setupProps on the parent of this class
		 *	- generates the model associated with this controller
		 */
		public function __construct($obj)  {  
			$obj = $this->setupProps($obj);
			$this->generate($obj);
			$this->execute();
		}
		
		/**
		 *	generateModel
		 *	- instances the model for this controller, setting errorCode for use in performAction
		 */
		protected function generate($obj = NULL) {
			$this->model = new ContactModel($obj);
		}
		
		/**
		 *	this method invokes the business logic to send an email:
		 *		- sends a text email to jb
		 */
		protected function execute($obj = NULL) {
			
			$data = new stdClass();
			$data->errorCode = $this->model->get("errorCode");
			$data = $this->model->execute();
			echo json_encode($data);
		}
	}

?>