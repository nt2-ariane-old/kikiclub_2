<?php
	require_once("../action/CommonAction.php");

	class EmailAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'template');
		}

		protected function executeAction() {

		}
	}