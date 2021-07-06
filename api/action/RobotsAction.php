<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/RobotDAO.php");

	class RobotsAction extends CommonAction {

		public $robots;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'robots');
		}

		protected function executeAction() {
			$this->robots = RobotDAO::getRobots();
		}
	}