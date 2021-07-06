<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/FilterDAO.php");
	require_once("../action/DAO/WorkshopDAO.php");
	require_once("../action/DAO/BadgeDAO.php");

	class MemberHomeAction extends CommonAction {
		public $member;
		public $won_badges;
		public $all_badges;
		public $workshops_categories;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_CUSTOMER_USER,'member-home');
		}

		protected function executeAction() {

			if(empty($_SESSION["member_id"]))
			{
				header('location:users.php');
			}

			$id = $_SESSION["member_id"];
			$this->member = MemberDAO::selectMember($id);

			$m_workshops = MemberWorkshopDAO::selectMemberWorkshop($id);
			$workshops = WorkshopDAO::getWorkshops();

			foreach ($workshops as $workshop) {
				if(!array_key_exists($workshop["id"],$m_workshops))
				{
					$id_w = $workshop["id"];
					$filters = FilterDAO::getWorkshopFilters($id_w);
					$grades = $filters[FilterDAO::getFilterTypeIdByName('grade')];

					$ages = [];
					if(!empty($grades))
					{
						foreach ($grades as $grade) {
							$id_grade = $grade["id_filter"];

							$ages[] = FilterDAO::getGradeById($id_grade)["age"];
						}

					}

					if($this->member["age"] >= 17)
					{
						if(in_array(17,$ages))
						{
							MemberWorkshopDAO::addMemberWorkshop($id,$id_w, 1);
						}
					}
					if(in_array($this->member["age"],$ages))
					{
						MemberWorkshopDAO::addMemberWorkshop($id,$id_w, 1);
					}
				}
			}

			$this->workshops_categories = MemberWorkshopDAO::selectMemberWorkshopByCategories($id);
			$this->member["alert"] = sizeof(MemberWorkshopDAO::selectMemberNewWorkshop($id));

			$this->won_badges = BadgeDAO::getMemberBadge($id);
			$this->all_badges = BadgeDAO::getBadges();
		}
	}