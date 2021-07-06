<?php

require_once("../action/CommonAction.php");

class ManageUserAction extends CommonAction
{
	//user info
	public $id_user;
	public $user;
	public function __construct()
	{
		parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER, 'manage-user');
	}



	protected function executeAction()
	{

		if (!empty($_SESSION["user_id"])) {
			$this->id_user = $_SESSION["user_id"];
			$this->user =  MemberDAO::getUserFamily($this->id_user);
		}
		if (isset($_POST['push'])) {
			if ($this->id_user != null) {

				UsersDAO::updateUser($this->id_user, $_POST['email'], $_POST['firstname'], $_POST['lastname'], intval($_POST['admin']));
				header('location:users.php');
			} else {
				$token = $this->generateString(8);
				UsersDAO::registerUser($_POST['email'], $_POST['firstname'], $_POST['lastname'], intval($_POST['admin']), $token);
				$this->user = UsersDAO::getUserWithEmail($_POST['email']);
				$this->id_user = $this->user['id'];
				$_SESSION["user_id"] = $this->id_user;
				$this->user = MemberDAO::getUserFamily($this->id_user);
			}
		}
		if (isset($_POST['delete'])) {
			UsersDAO::deleteUser($this->id_user);
			header('location:users.php');
		}
	}
}
