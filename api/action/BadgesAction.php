<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/BadgeDAO.php");

	class BadgesAction extends CommonAction {
		public $badges;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ANIMATOR,'family-badges');
		}

		protected function executeAction() {
			//Get all badges
			$this->badges = BadgeDAO::getBadges();
		}
	}