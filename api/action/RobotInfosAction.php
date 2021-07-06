<?php
	require_once("../action/CommonAction.php");
	require_once("../action/DAO/RobotDAO.php");
	require_once("../action/DAO/FilterDAO.php");
	require_once("../action/DAO/WorkshopDAO.php");

	class RobotInfosAction extends CommonAction {

		public $exist;
		public $added;
		public $robot;

		public $add;
		public $update;

		public $grades;

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_ANIMATOR,'robot-infos');
			$this->exist = false;
			$this->added = false;
			$this->add = false;
			$this->update = false;
		}

		protected function executeAction() {

			if(!empty($_GET["robot_id"]))
			{
				$_SESSION["robot_id"] = $_GET["robot_id"];
			}
			if(!empty($_SESSION["robot_id"]))
			{
				if(!empty(RobotDAO::getRobotByID($_SESSION["robot_id"])))
				{
					$this->exist = true;
					if($this->admin_mode)
					{
						$this->update = true;
					}


				}
				else
				{
					if($this->admin_mode)
					{
						$this->add = true;
					}
				}
			}
			else
			{
				if($this->admin_mode)
				{
					$this->add = true;
				}
			}

			$this->difficulties = FilterDAO::getDifficultiesEN();

			if($this->exist) $id = $_SESSION["robot_id"];

			if($_SESSION["language"] == 'en')
			{
				$this->grades = FilterDAO::getGradesEN(true);
			}
			else
			{
				$this->grades = FilterDAO::getGradesFR(true);
			}
			if($this->admin_mode)
			{
				if(isset($_POST['push']))
				{
					if($this->exist)
					{
						if(isset($_POST['push']))
						{
							if( !empty($_POST["name"]) &&
							!empty($_POST["grade_recommanded"]))
							{
								RobotDAO::updateRobot($id,$_POST["name"],$_POST["grade_recommanded"],$_POST["media_path"],$_POST["media_type"],$_POST["description"]);
								foreach ($this->difficulties as $difficulty) {
									RobotDAO::updateRobotScoreByDifficulty($id,$difficulty["id"],intval($_POST["score_" . $difficulty["id"]]));
								}
							}
							header('location:robots.php');
						}
						if(isset($_POST["delete"]))
						{
							RobotDAO::deleteRobot($id);;
						}
					}
					else
					{
						if(isset($_POST['push']))
						{
							RobotDAO::insertRobot($_POST["name"],$_POST["grade_recommanded"],$_POST["media_path"],$_POST["media_type"],$_POST["description"]);
							$newRobot = RobotDAO::getRobotByName($_POST["name"]);
							foreach ($this->difficulties as $difficulty) {
								RobotDAO::insertRobotScoreByDifficulty($newRobot["id"],$difficulty["id"],intval($_POST["score_" . $difficulty["id"]]));
							}
							header('location:robots.php');
						}

					}

				}
				if(isset($_POST['delete']))
				{
					if($this->exist)
					{
						RobotDAO::deleteRobot($id);
						header('location:robots.php');
					}
				}
			}

			if($this->exist)
			{
				if($this->admin_mode)
				{
					$this->robot = RobotDAO::getRobotsAndDifficultiesByID($id);
				}
				else
				{
					$this->robot = RobotDAO::getRobotByID($id);
				}
			}

		}
	}