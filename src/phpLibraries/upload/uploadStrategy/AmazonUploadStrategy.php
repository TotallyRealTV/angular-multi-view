<?

	/**
	 *	AmazonUploadStrategy.php
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
	 *	- uploads a file to an amazon bucket
	 */


	/*
		-------------------------------
		include supporting files
		-------------------------------
	*/

		include_once('UploadStrategyInterface.php');
 		include_once('BaseUploadStrategy.php');
		include_once('S3.php');
  		
		class AmazonUploadStrategy extends BaseUploadStrategy implements UploadStrategyInterface {
		
			private $awsAccessKey = "AKIAJQ4NHBQSKWRM4EGA";
			private $awsSecretKey = "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";
			
			
			/**
			 *	uploadFile
			 *	- instances AWS upload
			 *	- returns error code (0 = success, 1 = error)
			 */	 
			public function uploadFile($obj) {
				
				$errorCode = 0;
				
				$s3 = new S3($this->awsAccessKey, $this->awsSecretKey);
				
				if (!in_array($obj->bucketName, $s3->listBuckets())) {
					$errorCode = 2;		
				} else {
					if ($s3->putObjectFile($obj->tmpFileName, $obj->bucketName, $obj->targetDirectory . $obj->fileName, S3::ACL_PUBLIC_READ)) $errorCode = 0;
					else $errorCode = 1;
				}
				
				return $errorCode;
			}
			
			public function uploadObject($obj) {
				$errorCode = 0;
				$s3 = new S3($this->awsAccessKey, $this->awsSecretKey);	
				if ($s3->putObjectFile($obj->tmpFileName, $obj->bucketName, $obj->targetDirectory . $obj->fileName, S3::ACL_PUBLIC_READ)) $errorCode = 0;
				else $errorCode = 1;
				
				return $errorCode;	
			}
			
			public function generateFile($obj) {
				$s3 = new S3($this->awsAccessKey, $this->awsSecretKey);
				
				if (!in_array($obj->bucketName, $s3->listBuckets())) {
					$errorCode = 2;		
				} else {
					if ($s3->putObject($obj->tmpFileName, $obj->bucketName, $obj->targetDirectory . $obj->fileName, S3::ACL_PUBLIC_READ)) $errorCode = 0;
					else $errorCode = 1;
				}
				
				return $errorCode;	
			}
			
			public function generateDirectory($obj) {
				$s3 = new S3($this->awsAccessKey, $this->awsSecretKey);
				
				if (!in_array($obj->bucketName, $s3->listBuckets())) {
					$errorCode = 2;		
				} else {
					if ($s3->putObject($obj->tmpFileName, $obj->bucketName, $obj->targetDirectory, S3::ACL_PUBLIC_READ)) $errorCode = 0;
					else $errorCode = 1;
				}
				
				return $errorCode;	
			}
		
			/**
			 *	deleteFile
			 *	- deletes fileName from AWS bucket
			 */
			public function deleteFile($obj) {
				
				$errorCode = 0;
				
				$s3 = new S3($this->awsAccessKey, $this->awsSecretKey);
				
				if ($s3->deleteObject($obj->bucketName, $obj->targetDirectory . $obj->fileName) == true) $errorCode = 0;
				else $errorCode = 4;
				
				return $errorCode;	
			}
			
			/**
			 *	getFileName
			 *	- returns a fully-qualified file name from an amazon bucket
			 */
			public function getFileName($obj) {
				$fileName = "http://" . $obj->bucketName . ".s3.amazonaws.com/" . $obj->targetDirectory . $obj->fileName;
				return $fileName;			
			}
			
			/**
			 *	getBucket
			 *	returns an array of bucket contents or false
			 */
			public function getDirectoryContents($obj) {
				$s3 = new S3($this->awsAccessKey, $this->awsSecretKey);
				return $s3->getBucket($obj->bucketName, null, null, null, "|", false);
			}
			
			/**
			 *	getObject
			 */
			public function getDirectoryInfo($obj) {
				$s3 = new S3($this->awsAccessKey, $this->awsSecretKey);
				return $s3->getObjectInfo($obj->bucketName, $obj->targetDirectory . $obj->tmpFileName);	
			}
			
			public function getFileInfo($obj) {
				$s3 = new S3($this->awsAccessKey, $this->awsSecretKey);
				return $s3->getObjectInfo($obj->bucketName, $obj->targetDirectory . $obj->fileName);		
			}
			
			public function getObject($obj) {
				$s3 = new S3($this->awsAccessKey, $this->awsSecretKey);
				return $s3->getObject($obj->bucketName, $obj->targetDirectory . $obj->fileName);		
			}
			
			public function setACP($obj) {
				$s3 = new S3($this->awsAccessKey, $this->awsSecretKey);
				return $s3->setAccessControlPolicy($obj->bucketName, $obj->targetDirectory . $obj->fileName, $obj->acp);		
			}
			
			public function getACP($obj) {
				$s3 = new S3($this->awsAccessKey, $this->awsSecretKey);
				return $s3->getAccessControlPolicy($obj->bucketName, $obj->targetDirectory . $obj->fileName);		
			}
			
			
		}

?>