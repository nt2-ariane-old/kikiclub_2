<?php
	require_once("../action/CommonAction.php");

	class MediaAjaxAction extends CommonAction {

		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC, 'media-ajax');
		}

		protected function executeAction() {
			$this->post_upload();
		}
		public function post_upload(){

			$dir = $_POST["dir"];
			$max_size = 1024 * 1024 * 10;

			$head = "http://";
			if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
			{
				$head = "https://";
			}
			$uploaddir = "./" . $dir . "/";
			$webdir = $head . $_SERVER['HTTP_HOST'] . "/" . $dir . "/";

			$uploadfile = $uploaddir . basename($_FILES['file']['name']);
			$webfile = $webdir . basename($_FILES['file']['name']);

			$accepeted_type = ['mp4','mov','avi','flv','wmv','jpeg','bmp','tiff','png','jpeg','jpg','gif','mp3'];
			$type = pathinfo($webfile, PATHINFO_EXTENSION);
			if(in_array($type,$accepeted_type))
			{
				if($_FILES["file"]["size"] <= $max_size)
				{
					if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
						$this->results["path"] =  $webfile;
						$this->results["type"] =  pathinfo($webfile, PATHINFO_EXTENSION);
					} else {
						$this->results =  "Possible file upload attack!";
					}
				}
				else
				{
					$this->results =  "Max size exceeded";
				}
			}
			else
			{
				$this->results =  "Type " .pathinfo($webfile, PATHINFO_EXTENSION) . " not accepted";
			}





		}
	}