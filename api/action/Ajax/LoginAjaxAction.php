<?php
	require_once("../action/CommonAction.php");
	class LoginAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC, "loginAjax", "Login");
			$this->results = false;

		}
		
		protected function executeAction() {

			if(isset($_POST["login"]))
			{
				$token = $this->generateString(8);
				$infos = UsersDAO::ConnectUser($_POST["email"],$_POST["firstname"],$_POST["lastname"],$this->default_visibility,$token);


				if(!empty($infos))
				{
					$token = openssl_random_pseudo_bytes(16);
					$token = bin2hex($token);
					UsersDAO::setTokenForUser($infos["id"],$token);
					$this->results = $token;
				}
				else
				{
					$this->results = "User don't exist...";
				}
			}
			else
			{
				$this->results = "You are not allowed to connect...";
			}

		}
	}