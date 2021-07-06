<?php
	require_once("../action/CommonAction.php");

	class ErrorAction extends CommonAction {
		public $err400 = false;
		public $err401 = false;
		public $err402 = false;
		public $err403 = false;
		public $err404 = false;
		public $err500 = false;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'error');
		}

		protected function executeAction() {
			if(isset($_GET["400"]))
			{
				$this->err400 = true;
			}
			if(isset($_GET["401"]))
			{
				$this->err401 = true;
			}
			if(isset($_GET["402"]))
			{
				$this->err402 = true;
			}
			if(isset($_GET["403"]))
			{
				$this->err403 = true;
			}
			if(isset($_GET["404"]))
			{
				$this->err404 = true;
			}
			if(isset($_GET["500"]))
			{
				$this->err500 = true;
			}
		}
	}