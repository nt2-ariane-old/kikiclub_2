<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/WorkshopDAO.php");
	require_once("../action/DAO/RobotDAO.php");
	require_once("../action/DAO/FilterDAO.php");

	class WorkshopsAction extends CommonAction {
		public $workshops_list;

		public $completed;
		public $new;
		public $Inprogress;
		public $notStarted;
		public $recommandations;
		public $workshop;
		public $show_workshop;
		public $questions;

		public $workshopStates;
		public $grades;

		public $stateSearch;
		public $robots;
		public $difficulty;
		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC,"workshops");
			$this->show_workshop = false;
			$this->completed = [];
			$this->new = [];
			$this->inProgress = [];
			$this->notStarted = [];
			$this->recommandations = [];
		}

		protected function executeAction() {

			if($_SESSION["language"] == "en")
			{
				$this->difficulty = FilterDAO::getDifficultiesEN();
				$this->workshopStates = FilterDAO::getWorkshopStatesEN();
				$this->grades = FilterDAO::getGradesEN();
			}
			else
			{
				$this->difficulty = FilterDAO::getDifficultiesFR();
				$this->workshopStates = FilterDAO::getWorkshopStatesFR();
				$this->grades = FilterDAO::getGradesFR();
			}

			$this->workshops_list = WorkshopDAO::getWorkshops(null,"none",false,true);

			$this->robots = RobotDAO::GetRobots();



		}
	}