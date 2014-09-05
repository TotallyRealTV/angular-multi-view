<?
	/**
	 * 	VideoApiController
	 *
	 *	This class serves as the gateway to a Video Streaming API
	 *	
	 *	Currently implemented APIs:
	 *	- Brightcove
	 *
	 */
	
	include_once(PHP_PATH . "video/model/brightCove/BrightCove.php");
	
	
	class VideoApiController {
		
		protected $props;						//	an object to hold our critical properties required to instance / interface with an API
		protected $api;							//	holds our video api instance
		
		public function __construct($obj)  { 
			$this->generateVideoApi($obj);
		}
		
		/**
		 *	generateVideoApi
		 *	- invokes the required archive strategy based on $this->type
		 */
		protected function generateVideoApi($obj = NULL) {
			$className = ucfirst($obj->type);
			$this->api = new $className($obj);
		}
		 
		/**
		 *	getMessage
		 *	- access method to return custom messaging from API implementation
		 */
		public function getMessage() {
			return $this->api->getMessage();	
		}
		
		/**
		 *	addtMessage
		 *	- adds a message to MessageVO return value
		 */
		public function addMessage($num) {
			return $this->api->addMessage($num);	
		}
		
		/**
		 *	findAllVideos
		 *
		 *	Returns:
		 *	either the results of the invoked method, or an error message
		 */
		public function findAllVideos($obj = NULL) {
			return $this->api->findAllVideos($obj);
		}
		
		/**
		 *	createVideo
		 *	- invokes createVideo method in chosen Video API instance
		 *	- returns result
		 */
		public function createVideo($obj = NULL) {
			return $this->api->createVideo($obj);	
		}
		
		/**
		 *	updateVideo
		 *	- invokes updateVideo method in API instance
		 *	- returns result
		 */
		public function updateVideo($obj = NULL) {
			$result = new stdClass();
			$result->errorCode = $this->api->updateVideo($obj);
			$this->addMessage($result->errorCode);
			$result->message = $this->getMessage();
			return $result;
		}
		
		/**
		 *	getPlaylistByReferenceId
		 */
		public function getPlaylistByReferenceId($obj = NULL) {
			return $this->api->getPlaylistByReferenceId($obj);	
		}
		
		
		
		/**
		 *	createPlaylist
		 *	- invokes createPlaylist method in API instance
		 *	- returns result
		 */
		public function createPlaylist($obj = NULL) {
			return $this->api->createPlaylist($obj);
		}
		
		/**
		 *	addToPlaylist
		 *	- invokes addToPlaylist method in API instance
		 *	- returns result
		 */
		public function addToPlaylist($obj = NULL) {
			return $this->api->addToPlaylist($obj);	
		}
		
		/**
		 *	removeFromPlaylist
		 *	- invokes removeFromPlaylist method in API instance
		 *	- returns result
		 */
		public function removeFromPlaylist($obj = NULL) {
			return $this->api->removeFromPlaylist($obj);	
		}
		
		/**
		 *	updatePlaylist
		 *	- invokes updatePlaylist method in API instance
		 *	- returns result
		 */
		public function updatePlaylist($obj = NULL) {
			$result = new stdClass();
			$result->errorCode = $this->api->updatePlaylist($obj);
			$this->addMessage($result->errorCode);
			$result->message = $this->getMessage();
			return $result;	
		}
		
		/**
		 *	getStatus
		 *	- retrieves status of video in BC system as it is processed
		 */
		public function getStatus($obj = NULL) {
			return $this->api->getStatus($obj);	
		}
		
		/**
		 *	getErrorMessage
		 *	- retrieves error message set in API wrapper
		 */
		public function getErrorMessage($obj = NULL) {
			return $this->api->getErrorMessage();	
		}
		
		/**
		 *	createStandardTags
		 */
		public function createStandardTags($obj = NULL) {
			return $this->api->createStandardTags($obj);	
		}
		
		/**
		 *	createOptionalTags
		 */
		public function createOptionalTags($tagString = '', $obj = NULL) {
			return $this->api->createOptionalTags($tagString, $obj);
		}
		
		/**
		 *	sanitizeData
		 *	- url_decodes all strings in a supplied object
		 */
		public function sanitizeData($obj = NULL) {
			return $this->api->sanitizeData($obj);	
		}
	}
	

?>