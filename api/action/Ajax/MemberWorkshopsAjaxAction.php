<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/WorkshopDAO.php");
	require_once("../action/DAO/FilterDAO.php");
	require_once("../action/DAO/RobotDAO.php");
	require_once("../action/DAO/BadgeDAO.php");
	class MemberWorkshopsAjaxAction extends CommonAction {
		public $results;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ADMIN_USER,'member-workshops-ajax');
			$this->results = [];
		}
		private function calculateScore($id_member)
		{

			$workshops = MemberWorkshopDAO::selectMemberWorkshop($id_member);
			$score = 0;
			foreach ($workshops as $workshop) {
				if($workshop['id_statut'] == 3)
				{
					$filters = FilterDAO::getWorkshopFilters(intval($workshop["id_workshop"]));
					if(!empty($filters[FilterDAO::getFilterTypeIdByName("difficulty")]) &&
					!empty($filters[FilterDAO::getFilterTypeIdByName("robot")]))
					{
						$difficulties = $filters[FilterDAO::getFilterTypeIdByName("difficulty")];
						$robots = $filters[FilterDAO::getFilterTypeIdByName("robot")];


						if(!empty($robots) || !empty($difficulties))
						{
							foreach ($robots as $robot) {
								foreach ($difficulties as $diff) {
									$score += RobotDAO::getScoreOfRobotByDifficulty($robot["id_filter"],$diff["id_filter"]);
								}
							}
						}

					}
				}
			}
			MemberDAO::setScore($id_member,$score);
		}
		private function checkBadges($id_member)
		{
			$member = MemberDAO::selectMember($id_member);
			$member_badges = BadgeDAO::getMemberBadge($id_member);
			$badges = BadgeDAO::getBadges(1);

			foreach ($badges as $badge) {
				if($member["score"] >= $badge["value_needed"] )
				{
					if(!array_key_exists($badge["id"],$member_badges))
					{
						BadgeDAO::addBadgeToMember($badge["id"],$member["id"],$member["id_user"]);
					}
				}
			}
		}
		protected function assignNewWorkshop($id_member,$id_workshop,$statut)
		{
			$workshops = MemberWorkshopDAO::selectMemberWorkshop($id_member);
			$this->results['workshops'] = ($workshops);
			$this->results['id_workshop'] = $id_workshop;
			$this->results['statut'] = $statut;
			if(!empty($workshops[$id_workshop]))
			{
				MemberWorkshopDAO::updateMemberWorkshop($id_member,$id_workshop, $statut);
			}
			else
			{
				MemberWorkshopDAO::addMemberWorkshop($id_member,$id_workshop, $statut);
			}
			if(!MemberDAO::IsMemberToday($id_member))
			{
				MemberDAO::insertMemberPresence($id_member);
			}
		}
		protected function executeAction() {
			$id_member =$_SESSION["member_id"];
			if(!empty($_POST["id_workshop"]) &&
			!empty($_POST["category"]))
			{
				$id_workshop = intval($_POST['id_workshop']);
				$this->results['category1'] = $_POST['category'];
				$category = intval(substr($_POST['category'],4));
				$this->results['category2'] = $category;
				$this->assignNewWorkshop($id_member,$id_workshop,$category);
				
			}
			$this->calculateScore($id_member);
			$this->checkBadges($id_member);
		}
	}