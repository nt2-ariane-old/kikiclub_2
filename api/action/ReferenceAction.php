<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/BadgeDAO.php");

	class ReferenceAction extends CommonAction {
		public $first;
        public $user_token;
        public $error;
        public $success;
        public $msg;
		public function __construct() {
            parent::__construct(CommonAction::$VISIBILITY_PUBLIC,'reference');
            $this->first = false;
		}

		protected function executeAction() {
            if($_COOKIE["visibility"] == CommonAction::$VISIBILITY_PUBLIC)
            {
                header('Location:http://kikicode.ca/login-kikiclub-do-not-delete');
            }
            $connexion = UsersConnexionDAO::getUserConnexion($_COOKIE["id"]);
            if(sizeof($connexion) <= 1)
            {
                $this->first = true;
            }
            $user = UsersDAO::getUserWithID($_COOKIE["id"]);
            if(!empty($user))
            {
                $this->user_token = $user["token"];
            }
            $code = null;
            if(!empty($_POST["code"]) )
            {
                $code = $_POST["code"];
            }
            if(!empty($_SESSION["referral"]))
            {
                $code = $_SESSION["referral"];
                $_SESSION["referral"] = null;
            }
            if(!empty($code))
            {
                if($this->first)
                {
                    $user = UsersConnexionDAO::testRegisterToken(strtoupper($code));
                    if(!empty($user))
                    {
                        if($user["id"] != $_COOKIE["id"])
                        {
                            if(UsersConnexionDAO::addReferance($user["id"],$_COOKIE["id"]))
                            {
                                $badges = BadgeDAO::getBadges(1);

                                $members = MemberDAO::getUserFamily($user["id"]);
                                addScoresToMembers($members,$badges);

                                $members = MemberDAO::getUserFamily($_COOKIE["id"]);
                                addScoresToMembers($members,$badges);

                                $this->success = true;
                                $this->msg = "Le code à bien été appliqué.";
                            }
                            else
                            {
                                $this->error = true;
                                $this->msg = "Vous avez déjà utilisez ce code...";
                            }
                        }
                        else
                        {
                            $this->error = true;
                            $this->msg = "Vous ne pouvez pas entrez votre propre code de référence.";
                        }
                    }
                    else
                    {
                        $this->error = true;
                        $this->msg = "Le code n'Est pas valide...";
                    }
                }
                else
                {
                    $this->error = true;
                    $this->msg = "Désolé, vous n'êtes pas un nouveau membre...";
                }
            }

		}
        protected function testBadges($member,$member_badges,$badges)
        {
            foreach ($badges as $badge) {

                if($member["score"] >= $badge["value_needed"] )
                {
                    if(!array_key_exists($badge["id"],$member_badges))
                    {
                        $this->results[] = $member["firstname"] . " just won the " . $badge["name"] . " badge";
                        BadgeDAO::addBadgeToMember($badge["id"],$member["id"],$member["id_user"]);
                    }
                    else
                    {
                        $this->results[] = $member["firstname"] . " already have the " . $badge["name"] . " badge";
                    }
                }
                else
                {
                    $this->results[] = $member["firstname"] . " need to have " . $badge["value_needed"] . " to have the badge. He only have " . $member["score"] . " pts";

                }
            }
        }
        protected function addScoresToMembers($members,$badges)
        {
            foreach ($members["family"] as $member) {
                MemberDAO::addScore($member["id"],1);
                $member = MemberDAO::selectMember($member['id']);
                $member_badges = BadgeDAO::getMemberBadge($member['id']);
                $this->testBadges($member,$member_badges,$badges);

            }
        }
    }
