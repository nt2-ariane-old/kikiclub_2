<?php
	require_once("../action/CommonAction.php");

	class MemberAjaxAction extends CommonAction {
		public $results;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,"member-ajax");
		}

		protected function executeAction() {
			if(!empty($_COOKIE["id"]))
				$this->results["family"] = MemberDAO::selectFamily($_COOKIE["id"]);
				$this->results["avatars"] = MemberDAO::loadAvatar();
				if(!empty($this->results["family"]))
				{
					foreach ($this->results["family"] as $key => $value) {
						$this->results["family"][$key]["workshops"] = MemberWorkshopDAO::selectMemberWorkshop($this->results["family"][$key]["id"]);
						$this->results["family"][$key]["alert"] = MemberWorkshopDAO::selectMemberNewWorkshop($this->results["family"][$key]["id"]);
					}
				}

		}
	}