<?

	/**
	 *	BrightCove
	 *
	 *	This class is the BrightCove-specific implementation of of a model class instantiated through VideoApiController.
	 *	It provides the properties and methods unique to the Bright Cove API
	 *
	 *	Initialization expects:
	 *	type (optional but recommended)
	 *	cacheType(optional but recommended)
	 *	cacheDuration (optional)
	 *
	 *	Date Created:	2012-08-02
	 *	Date Modified:	2012-08-02
	 *
	 *	Author:	Jonathan Blackburn for TELETOON Canada Inc.
	 */
	 
	 include_once(PHP_PATH . "site/brand/BrandVO.php");
	 include_once(PHP_PATH . "video/model/BaseVideoModel.php");
	 include_once(PHP_PATH . "video/model/brightCove/bc-mapi.php");
	 include_once(PHP_PATH . "video/vo/BrightCoveAdminMessagingVO.php");
	 
	 class BrightCove extends BaseVideoModel {
		 
		/**
		 *	constructor
		 */
		public function __construct($obj = NULL) {
			parent::setupProps($obj);
			$this->setupProps($obj);
			$this->generate();
			$this->generateMessaging();	
		}
		
		/**
		 *	setupProps
		 *	Instantiate classes required in this model
		 */
		protected function setupProps($obj = NULL) {
			$this->props->cacheType = isset($obj->cacheType) ? $obj->cacheType : "file";					//	The type of caching method to use, either 'file' or 'memcached'
			$this->props->cacheDuration = isset($obj->cacheDuration) ? $obj->cacheDuration : 600;			//	How many seconds until cache files are considered cold
			
			if ($this->props->cacheType == "file") {
				$this->props->cachePath = $this->brandParameters->brightCove->fileCachePath;
				$this->props->cacheExtension = ".cache";		
			} else {
				$this->props->cachePath = $this->brandParameters->brightCove->memCachePath;
				$this->props->cachePort = 11211;
			}
		}
		
		/**
		 *	instantiate our bc API instance, based on caching type
		 */
		protected function generate($obj = NULL) {
			
			$init = new stdClass();
			$init->readToken = $this->brandParameters->brightCove->readToken;
			$init->writeToken = $this->brandParameters->brightCove->writeToken;
			$init->cacheType = $this->props->cacheType;
			$init->cacheDuration = $this->props->cacheDuration;
			
			switch ($this->props->cacheType) {
				case "mem":
				
				break;
				
				default:
					$init->cachePath = $this->props->cachePath;
					$init->cacheExtension = $this->props->cacheExtension;
					$this->api = new BCMAPI($init);
				break;	
			}
		}
		
		/**
		 *	generateMessaging
		 *	- instances messaging VO unique to BrightCove API interaction
		 */
		protected function generateMessaging($obj = NULL) {
			$this->messaging = new BrightCoveAdminMessagingVO();
		}
		
		/**
		 *	update
		 *	- invoked from either updatePlaylist() or updateVideo()
		 *	- Updates a media asset. Only the meta data that has changed needs to be passed along. Be sure to include the asset ID, though.
		 *
		 *	Accepts:
		 *	- id: the id of the video / playlist to update
		 *	- description: the description of the video / playlist to update
		 *
		 */
		protected function update($obj = NULL) {
			// Create an array of the new meta data
			$metaData = array(
				'id' => $obj->id,
				'shortDescription' => $obj->description,
				'referenceId' => $obj->ref_id,
				'name' => $obj->name,
				'tags' => $obj->tags
			);
			
			// Update a video with the new meta data
			try {
				// Make our API call
				$this->api->update($obj->type, $metaData);
				return 0;
				
			} catch(Exception $error) {
				return 1;
			}
		}
		
		/**
		 *	delete
		 *	Deletes a media asset. Either an ID or Reference ID must be passed.
		 *
		 *	Accepts:
		 *	- id: asset id
		 *	- type: the type of asset to delete (optional)
		 *	- cascadeDeletion: TBD 
		 *
		 */
		protected function delete($obj = NULL) {
			$obj->type = isset($obj->type) ? $obj->type : 'video';	// video, playlist
			$obj->cascadeDeletion = isset($obj->cascadeDeletion) ? $obj->cascadeDeletion : TRUE;
			$this->api->delete($obj->type, $obj->id, NULL, $obj->cascadeDeletion);	
		}
		
		/**
		 *	public access methods
		 */
		 
		/**
		 *	findAllVideos
		 *
		 *	Accepts:
		 *	- an object containing a method string, as well as params object  (optionally) to invoke an implementation-specific API method 
		 *
		 *	Returns:
		 *	- results of the method to the caller
		 */
		public function findAllVideos($obj = NULL) {
			$params = array(
				'video_fields' => 'id,name'
			);
			
			// Set our search terms
			$terms = array(
				'all' => 'tag:' . $obj->brand
			);

			// Make our API call
			return $this->api->search('video', $terms, $params);	
		}
		
		
		
		
		
		/**
		 *	create video / image methods
		 */
		
		/**
		 *	createVideo
		 *	- This example details how to upload a video to a Brightcove account. This code is handling data that was passed from a form. 
		 *	Note that we re-name the uploaded movie to its original name rather than the random string generated when it's placed in the "tmp" directory; 
		 *	this is because the tmp_name does not include the file extension. The video name is a required field.
		 *
		 *	Accepts:
		 *	- display_name
		 *	- video_description
		 *	- file_location
		 *	
		 */
		public function createVideo($obj = NULL) {
			$metaData = array(
				'name' => $obj->display_name,
				'shortDescription' => $obj->video_description,
				'referenceId' => $obj->video_refid,
				'tags' => $obj->video_tags
			);
			
			$options = array(
				'create_multiple_renditions' => TRUE	
			);
			
			// Upload the video and save the video ID
			return $this->api->createMedia('video', $obj->file_location, $metaData, $options);
		}
		
		/**
		 *	createImage
		 *	- This example details how to upload a image to a Brightcove account. This code is handling data that was passed from a form. 
		 *	Note that we re-name the uploaded image to its original name rather than the random string generated when it's placed in the "tmp" directory; 
		 *	this is because the tmp_name does not include the file extension.
		 *
		 *	Accepts:
		 *	- id: the id of a video that was created
		 *	- imageName: name of the image to upload
		 *	- $_FILES['videoImage']
		 *	
		 */
		public function createImage($obj = NULL) {
			// Create an array of meta data from our form fields
			$metaData = array(
				'type' => 'VIDEO_STILL',
				'displayName' => $obj->imageName
			);
			
			// Move the file out of 'tmp', or rename
			rename($_FILES['videoImage']['tmp_name'], $this->brandParameters->brightCove->tmpUploadDirectory . $_FILES['videoImage']['name']);
			$file = $this->brandParameters->brightCove->tmpUploadDirectory . $_FILES['videoImage']['name'];
			
			// Upload the image, assign to a video, and save the image asset ID
			$id = $this->api->createImage('video', $file, $metaData, $obj->id);
			
			return $id;	
		}
		
		/**
		 *	createPlaylist
		 *	- This example shows how to create a playlist in a Brightcove account. The code is handling data that was passed from a form. 
		 *	The name, video IDs, and playlist type are all required fields.
		 *
		 *	Accepts:
		 *	- videoIds (comma-separated string)
		 *	- name
		 *	- description
		 */
		public function createPlaylist($obj = NULL) {
			
			// Create an array of meta data from our form fields
			$metaData = array(
				'name' => $obj->display_name,
				'shortDescription' => $obj->playlist_description,
				'referenceId' => $obj->playlist_refid,
				'playlistType' => 'explicit',
				'tags' => explode(",", $obj->playlist_tags)
			);
			
			// Create the playlist and save the playlist ID
			return $this->api->createPlaylist('video', $metaData);
			
		}
		
		/**
		 *	update / delete / manage playlists / videos
		 */
		
		/**
		 *	updatePlaylist
		 *	- wrapped method to update a playlist (see update for documentation)
		 */
		public function updatePlaylist($obj = NULL) {
			$obj->description = $obj->playlist_description;
			$obj->tags = explode(",", $obj->playlist_tags);
			$obj->name = $obj->display_name;
			$obj->id = $obj->playlist_id;
			$obj->type = 'playlist';
			$obj->ref_id = $obj->playlist_refid;
			unset($obj->playlist_description);
			return $this->update($obj);	
		}
		
		/**
		 *	addToPlaylist
		 *	- adds video(s) to a playlist
		 *
		 *	Accepts:
		 *	- id: id of playlist to affect
		 *	- videoIds: array of ids to add
		 *
		 *	Returns:
		 *	- updated array of video ids in playlist
		 *
		 */
		public function addToPlaylist($obj = NULL) {
			$result = new stdClass();
			
			try {
				$result = $this->api->addToPlaylist($obj->id, $obj->videoIds);
				$result->errorCode = 5;
			} catch (Exception $error) {
				$result->errorCode = 6;	
			}
			
			return $result;
		}
		
		/**
		 *	removeFromPlaylist
		 *	- removes video(s) to a playlist
		 *
		 *	Accepts:
		 *	- id: id of playlist to affect
		 *	- idsToAdd: array of ids to add
		 *
		 *	Returns:
		 *	- updated array of video ids in playlist
		 *
		 */
		public function removeFromPlaylist($obj = NULL) {
			$result = new stdClass();
			
			try {
				$result = $this->api->removeFromPlaylist($obj->id, $obj->idsToRemove);	
				$result->errorCode = 7;
			} catch (Exception $error) {
				$result->errorCode = 8;	
			}
			
			return $result;
		}
		
		/**
		 *	updateVideo
		 *	- wrapper method to update a video (see update() for documentation)
		 */
		public function updateVideo($obj = NULL) {
			$obj->description = $obj->video_description;
			$obj->id = $obj->video_id;
			$obj->name = $obj->video_name;
			$obj->tags = $obj->video_tags;
			$obj->type = 'video';
			$obj->ref_id = $obj->video_refid;
			unset($obj->video_description);
			unset($obj->video_id);
			unset($obj->video_name);
			unset($obj->video_tags);
			unset($obj->video_refid);
			return $this->update($obj);	
		}
		
		/**
		 *	deletePlaylist
		 *	- wrapper method to delete a playlist (see delete() for documentation)
		 */
		public function deletePlaylist($obj = NULL) {
			return $this->delete($obj);	
		}
		
		/**
		 *	deleteVideo
		 *	- wrapper method to delete a video (see delete() for documentation)
		 */
		public function deleteVideo($obj = NULL) {
			return $this->delete($obj);	
		}
		
		/**
		 *	getStatus
		 */
		public function getStatus($obj = NULL) {
			return $this->api->getStatus($obj->type, $obj->id);	
		}
		
		/**
		 *	getPlaylistByReferenceId
		 *	- returns data of a playlist by incoming playlist_ref_id
		 *	token=9GZYO4HIboQ05kDpRZ46oxND16zqfm8bwZ0XhdrNyog.&reference_id=retro-gi-joe-playlist-all-en&video_fields=referenceId%2CthumbnailURL%2Cname%2CvideoStillURL&fields=videos
		 */
		public function getPlaylistByReferenceId($obj = NULL) {
			
			$params = array(
				'reference_id' => $obj->playlist_ref_id,
				'video_fields' => 'referenceId,thumbnailURL,name,videoStillURL',
				'fields' => 'videos'
			);
			
			// Make our API call
			return $this->api->find('playlistbyreferenceid', $params);	
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
		 *	- creates and returns an array of key=value, key=value pairings containing expected tag values
		 */
		public function createStandardTags($obj = NULL) {
			$tags = array();
			
			foreach ($obj as $key=>$value) {
				array_push($tags, strtolower($key) . "=" . strtolower($value));	
			}
			
			return $tags;
		}
		
		/**
		 *	createOptionalTags
		 *	- creates and returns an array of key=value, key=value pairings containing user-input tag values
		 */
		public function createOptionalTags($tagString = '', $obj = NULL) {
			$tags = $tagString != "" ? explode(",", $tagString) : array();
			$obj = $obj == NULL ? new stdClass() : $obj;
			
			if (is_array($tags) && count($tags) > 0) {
				for ($i = 0; $i < count($tags); $i++) {
					$tmp = explode("=", $tags[$i]);
					if (!empty($tmp[0]) && !empty($tmp[1])) {
						$obj->$tmp[0] = $tmp[1];	
					}
				}
			}
			return $obj;
		}
		
		/**
		 *	sanitizeData
		 *	- urldecodes all strings in a supplied object so that data inserted into the BC system is clean
		 */
		public function sanitizeData($obj = NULL) {
			$clean = new stdClass();
			
			foreach ($obj as $key=>$value) {
				if (is_string($value)) $clean->$key = stripslashes(urldecode($value));
				else $clean->$key = $value;	
			}
			
			return $clean;	
		}
	}

?>