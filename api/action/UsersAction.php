<?php
	require_once("../action/CommonAction.php");

	class UsersAction extends CommonAction {


		public $users;
		public $admin_members;
		public $members;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,'users');
		}

		protected function executeAction() {


			unset($_SESSION["member_id"]);
			if(isset($_POST["list"]))
			{

				if(!empty($_POST["users_list"]))
				{
					$searchUsers =json_decode($_POST["users_list"],true);
					foreach ($searchUsers as $user) {
						$id = $user["value"];
						$this->users[] = UsersDAO::getUserWithID($id);
					}

				}
				if(!empty($_POST["members_list"]))
				{

					$searchMembers =json_decode($_POST["members_list"],true);
					foreach ($searchMembers as $member) {
						$id = $member["value"];
						$this->admin_members[] = MemberDAO::selectMember($id);
					}

				}
				if(!empty($_POST["users_and_member_list"]))
				{
					$results =json_decode($_POST["users_and_member_list"],true);
					foreach ($results as $result) {
						$id = $result["value"];

						if($result["type"] == "member")
						{
							$this->admin_members[] = MemberDAO::selectMember($id);
						}
						if($result["type"] == "user")
						{
							$this->users[] = UsersDAO::getUserWithID($id);

						}
					}


				}

			}
			else if(isset($_POST["deployed"]))
			{
				if(!empty($_POST["workshops_list"]))
				{
					$this->deployWorkshops();
				}
			}

		}
	}