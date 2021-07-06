<?php
require_once("../action/CommonAction.php");
require_once("../action/DAO/WorkshopDAO.php");
require_once("../action/DAO/RobotDAO.php");
require_once("../action/DAO/FilterDAO.php");
class WorkshopsAjaxAction extends CommonAction
{
	public $results;
	public function __construct()
	{
		parent::__construct(CommonAction::$VISIBILITY_PUBLIC, "workshops-ajax");
	}

	protected function executeAction()
	{
		$this->results["states"] = FilterDAO::getWorkshopStatesFR();
		$this->results["robots"] = RobotDao::getRobots();
		$this->results["workshops"] = WorkshopDAO::getWorkshops();
		$this->results["filters"] = FilterDAO::getFilters();


		if (!empty($_POST["selected"])) {
			$selected = json_decode($_POST["selected"], true);
			foreach ($selected as $value) {
				if (!empty($_POST["deployed_multiple"])) {
					$deployed = WorkshopDAO::isDeployed($value);
					if ($deployed) {
						WorkshopDAO::setDeployed($value, "false");
						$this->results["undeployed"][] = $value;
					} else {
						WorkshopDAO::setDeployed($value, "true");
						$this->results["has_been_deployed"][] = $value;
					}
				} else if (!empty($_POST["delete_multiple"])) {
					WorkshopDAO::deleteWorkshop($value);
				}
				# code...
			}
		}
		if (!empty($_POST["sort"])) {
			$f = null;
			// if($this->admin_mode || empty($_SESSION["member_id"]))
			// {

			// }
			// else
			// {
			// 	$f = "MemberWorkshopDAO::getMemberWorkshopsSorted";
			// 	$id = $_SESSION["member_id"];
			// }
			$f = "";
			$id = null;
			switch ($_POST["sort"]) {
				case 'none':
					$this->results["workshops"] = $f($id, "none", false, !$this->admin_mode);
					break;
				case 'ascName':
					$this->results["workshops"] = $f($id, "name", true, !$this->admin_mode);
					break;
				case 'descName':
					$this->results["workshops"] = $f($id, "name", false, !$this->admin_mode);
					break;
				case 'recents':
					$this->results["workshops"] = $f($id, "id", true, !$this->admin_mode);
					break;
			}
		}
		if (!empty($_POST["search"])) {
			if (!empty($_SESSION["member_id"])) {
				$this->results["member_workshops"] = MemberWorkshopDAO::selectMemberWorkshop($_SESSION["member_id"]);
			}
			if (!empty($_POST["difficulties"])) {
				$difficulties = json_decode($_POST["difficulties"], true);
				$this->results["search"]["difficulties"] = $difficulties;
				if (sizeof($difficulties) > 0) {
					$temp = [];
					foreach ($this->results["workshops"] as $workshop) {
						$filters = FilterDAO::getWorkshopFilters($workshop["id"]);
						if (!empty($filters[FilterDAO::getFilterTypeIdByName('difficulty')])) {
							$workshop_difficulties = $filters[FilterDAO::getFilterTypeIdByName('difficulty')];
							if (!empty($workshop_difficulties)) {
								foreach ($difficulties as $difficulty_id) {
									foreach ($workshop_difficulties as $diff) {
										if ($difficulty_id === $diff["id_filter"]) {
											$temp[] = $workshop;
										}
									}
								}
							}
						}
					}
					$this->results["workshops"] = $temp;
				}
			}
			if (!empty($_POST["grades"])) {
				$grades = json_decode($_POST["grades"], true);
				$this->results["search"]["grades"] = $grades;
				if (sizeof($grades) > 0) {
					$temp = [];
					foreach ($this->results["workshops"] as $workshop) {
						$filters = FilterDAO::getWorkshopFilters($workshop["id"]);
						$workshop_grades = $filters[FilterDAO::getFilterTypeIdByName('grade')];
						if (!empty($workshop_grades)) {
							foreach ($grades as $grade_id) {
								foreach ($workshop_grades as $grade) {
									if ($grade_id === $grade["id_filter"]) {
										$temp[] = $workshop;
									}
								}
							}
						}
					}
					$this->results["workshops"] = $temp;
				}
			}
			if (!empty($_POST["states"])) {

				$states = json_decode($_POST["states"], true);
				$this->results["search"]["states"] = $states;
				if (!empty($_SESSION["member_id"])) {
					$has_new = false;
					if (sizeof($states) > 0) {
						$temp = [];
						$this->results["member_workshops"] = MemberWorkshopDAO::selectMemberWorkshop($_SESSION["member_id"]);
						$new_workshops = MemberWorkshopDAO::selectMemberNewWorkshop($_SESSION["member_id"]);
						foreach ($states as $state) {
							foreach ($this->results["workshops"] as $workshop) {
								foreach ($this->results["member_workshops"] as $m_workshop) {
									if (
										$m_workshop["id_workshop"] == $workshop["id"] &&
										$state == $m_workshop["id_statut"]
									) {
										$temp[] = $workshop;
									}
								}
								foreach ($new_workshops as $m_workshop) {

									if ($workshop["id"] == $m_workshop["id"]) {
										if ($state == 1 || $state == 2) {
											$temp[] = $workshop;
										}
									}
								}
							}
							$this->results["workshops"] = $temp;
						}
					}
				}
			}
			if (!empty($_POST["robots"])) {

				$robots = json_decode($_POST["robots"]);
				$this->results["search"]["robots"] = $robots;

				if (sizeof($robots) > 0) {
					$temp = [];
					foreach ($this->results["workshops"] as $workshop) {
						$filters = FilterDAO::getWorkshopFilters($workshop["id"]);
						if (!empty($filters[FilterDAO::getFilterTypeIdByName('robot')])) {
							$workshop_robots = $filters[FilterDAO::getFilterTypeIdByName('robot')];

							foreach ($robots as $robot_id) {
								foreach ($workshop_robots as $robot) {
									if ($robot_id === $robot["id_filter"]) {
										$temp[] = $workshop;
									}
								}
							}
						}
					}
					$this->results["workshops"] = $temp;
				}
			}
		}
		if (!empty($_POST["deployed"])) {
			WorkshopDAO::setDeployed($_POST["id"], $_POST["deployed"]);
			$this->results = [];
			$this->results["state"] = $_POST["deployed"];
			$this->results["type"] = "deployed";
			$this->results["workshop"] = WorkshopDAO::getWorkshop($_POST["id"]);
		}
		if ($this->admin_mode) {
			$this->results["direct_link"] = true;
		}
		if (!empty($_POST["id"])) {
			$this->results["workshop"] = WorkshopDAO::getWorkshop($_POST["id"]);
			$this->results["filters"] = FilterDAO::getWorkshopFilters($_POST["id"], true, true);
		}
		if (!empty($this->results["workshops"])) {
			$this->results["nbPages"] = ceil(sizeof($this->results["workshops"]) / 12);
		} else {
			$this->results["nbPages"] = 0;
		}
		if (isset($_POST["page"])) {
			$page = $_POST["page"];
			if ($page == -1) {
				$page = 0;
			} else if ($page >= $this->results["nbPages"]) {
				$page = $this->results["nbPages"] - 1;
			}
			$limit_min = $page * 12;
			$limit_max = 12;
			$this->results["workshops"] = array_slice($this->results["workshops"], $limit_min, $limit_max);
		}
		if (isset($_POST["assign-all"])) {
			$id = $_SESSION["workshop_id"];
			$filters = FilterDAO::getWorkshopFilters($id);
			$grades = $filters[FilterDAO::getFilterTypeIdByName('grade')];


			$ages = [];
			if (!empty($grades)) {
				foreach ($grades as $grade) {
					$id_grade = $grade["id_filter"];

					$ages[] = FilterDAO::getGradeById($id_grade)["age"];
				}
			}
			$members = MemberDAO::getAllMemberWithAges($ages);
			$this->results = [];

			$headers = "Reply-To: Kikiclub <do-not-reply@kikicode.club>\r\n";
			$headers .= "Return-Path: Kikiclub <do-not-reply@kikicode.club>\r\n";
			$headers .= "From: Kikiclub <do-not-reply@kikicode.club>\r\n";

			$headers .= "Organization: Code & Café\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "X-Priority: 3\r\n";
			$headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

			$subject = "";

			$htmlContent = "";

			$subject = "Nouvel Atelier!! :D ";
			$htmlContent = file_get_contents("./emails/template.php");


			$workshop = WorkshopDAO::getWorkshop($id);
			$htmlContent = str_replace("***WORKSHOP***", $workshop["name"], $htmlContent);
			$htmlContent = str_replace("***CONTENT***", $workshop["content"], $htmlContent);
			$htmlContent = str_replace("***PATH***", $workshop["media_path"], $htmlContent);
			foreach ($members as $member) {
				$id_member = $member["id"];
				$workshops = MemberWorkshopDAO::selectMemberWorkshop($id_member);

				$user = UsersDAO::getUserWithID($member["id_user"]);
				$to = $user["email"];
				$htmlContent = str_replace("***USER***", $user["firstname"], $htmlContent);
				$htmlContent = str_replace("***MEMBER***", $member["firstname"], $htmlContent);
				$this->results["member"][] = $member;
				if (!array_key_exists($id, $workshops)) {
					MemberWorkshopDAO::addMemberWorkshop($id_member, $id, 1);
					mail($to, $subject, $htmlContent, $headers);

					$this->results["append_member"][] = $member;
				}
			}
		}
	}
}
