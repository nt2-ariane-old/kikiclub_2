<?php
	require_once("../action/CommonAction.php");

	class IndexAction extends CommonAction {
		public $otherlogin;
		public $signup;
		public $error;
		public $errorMsg;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC, "index");
			$this->otherlogin = false;
			$this->error = false;
		}

		protected function executeAction() {
		
			if(isset($_GET["other"]))
			{
				$id_type = UsersDAO::getLoginTypeIdByName("Kikiclub");
				$this->otherlogin = true;

				if(isset($_POST["form"]))
				{
					if(!empty($_POST["email"]) &&
					!empty($_POST["psswd"]))
					{
						$infos = UsersDAO::loginUserWithEmail($_POST["email"],$_POST["psswd"],$id_type);
						if(is_string($infos))
						{
							$this->error = true;
							$this->errorMsg = $infos;
						}
						else
						{
							$_COOKIE["visibility"] = $infos["visibility"];
							$_COOKIE["id"] = $infos["id"];
						}
					} else {
						$this->error = true;
						$this->errorMsg =$this->trans->read("login", "errorFeeld");
					}
				}


			}
			else if(!empty($_GET["signup"]))
			{
				$this->signup = true;
				$id_type = UsersDAO::getLoginTypeIdByName("Kikiclub");

				if(isset($_POST["form"]))
				{
					if(!empty($_POST["email"]) &&
					!empty($_POST["psswd1"]) &&
					!empty($_POST["psswd2"])  &&
					!empty($_POST["firstname"])  &&
					!empty($_POST["lastname"]))
					{
						$token = $this->generateString(8);
						if(UsersDAO::RegisterUser($_POST["email"],$_POST["firstname"],$_POST["lastname"],$this->default_visibility,$token))
						{
							$infos = UsersDAO::loginUserWithEmail($_POST["email"],$_POST["psswd1"],$id_type);
							if(!is_string($infos))
							{
								$_COOKIE["id"] = $infos["id"];
								$_COOKIE["visibility"] =$infos["visibility"];
							}
							else
							{
								$this->error = true;
								$this->errorMsg = $infos;
							}

						}
						else
						{
							$this->error = true;
							$this->errorMsg = "Not working";
						}
					}
					else
					{
						$this->error = true;
						$this->errorMsg = $this->trans->read("login", "errorFeeld");
					}
				}


			}
			

		}
	}