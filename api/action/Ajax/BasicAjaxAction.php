<?php
	require_once("../action/CommonAction.php");

	class BasicAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'basic-ajax');
		}

		protected function executeAction() {

			if(isset($_POST["set_value"]))
			{
				unset($_POST["set_value"]);

				foreach ($_POST as $key => $value) {
					$_SESSION[$key] = $value;
				}
			}

		}
	}