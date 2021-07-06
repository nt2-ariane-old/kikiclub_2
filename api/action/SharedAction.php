<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/PostDAO.php");

	class SharedAction extends CommonAction {

		public $nbPages;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,'shared');
		}

		protected function executeAction() {
		}

	}