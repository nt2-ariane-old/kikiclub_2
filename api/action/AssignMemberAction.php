<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/WorkshopDAO.php");

	class AssignMemberAction extends CommonAction {
		public $workshopsDeployed;
		public $titles;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ANIMATOR,'assign-member');
			$this->titles[1] = 'Nouveau';
			$this->titles[2] = 'En Cours';
			$this->titles[3] = 'Terminé';
		}

		protected function executeAction() {
			if(empty($_SESSION["member_id"]))
			{
				header("Location:" . $this->previous_page .".php");
			}

			$id_member = $_SESSION["member_id"];
			$this->workshops_deployed = WorkshopDAO::getWorkshops(null,"none",false,true);
			$this->member_workshops = MemberWorkshopDAO::selectMemberWorkshop($id_member);



		}
	}