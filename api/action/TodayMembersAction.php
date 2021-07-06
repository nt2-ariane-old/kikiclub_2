<?php
	require_once("../action/CommonAction.php");

	class TodayMembersAction extends CommonAction {

		public $today_members;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ANIMATOR,'today-members');
		}

		protected function executeAction() {

			if(!empty($_POST['member_id']))
			{
				MemberDAO::insertMemberPresence($_POST['member_id']);
			}
			$this->today_members = MemberDAO::selectTodayMembers();
		}

	}