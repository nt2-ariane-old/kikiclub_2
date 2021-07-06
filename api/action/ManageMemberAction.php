<?php
require_once("../action/CommonAction.php");

class ManageMemberAction extends CommonAction
{

	//utilities
	public $avatars;
	public $genders;

	//member info
	public $member;

	//error management
	public $error;
	public $errorMsg;



	public function __construct()
	{
		parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER, "manage-member");
	}

	protected function executeAction()
	{

		$this->genders = MemberDAO::getGenders($_SESSION["language"] == 'fr');

		if ($this->anim_mode && !empty($_SESSION["user_id"])) {
			$id = $_SESSION["user_id"];
		} else {
			$id = $_COOKIE["id"];
		}
		$id_member = null;
		if (!empty($_SESSION["member_id"])) {
			$id_member = $_SESSION["member_id"];
			$this->member = MemberDAO::selectMember($id_member);
		}
		if (!empty($_POST)) {
			if (
				!empty($_POST["firstname"]) &&
				!empty($_POST["lastname"])
			) {
				$birth = null;
				if (!empty($_POST['birth'])) {
					$birth = $_POST['birth'];
				}
				if (!empty($id_member)) {
					MemberDAO::updateMember($id_member, $_POST["firstname"], $_POST["lastname"], $birth, $_POST["gender"], $_POST["avatar"]);
				} else {
					MemberDAO::insertMember($_POST["firstname"], $_POST["lastname"], $birth, $_POST["gender"], $_POST["avatar"], $id);
					if ($this->anim_mode) {
						header('Location:assign-member.php');
					}
				}

				header('Location:' . $this->previous_page);
			} else {
				$this->error = true;
				$this->errorMsg = "You need to fill all Feeld...";
			}
		}
		if ($id_member >= 0) {
			if (isset($_POST["delete"])) {
				MemberDAO::deleteMember($id_member);
				unset($_SESSION["member_id"]);
				header('location:' . $this->previous_page . '.php');
			}
		}
	}
}
