<?php
require_once("../action/DAO/RobotDAO.php");

class RobotAjaxAction
{
	public $results;
	public function __construct()
	{
		$this->results = [];
	}

	public function executeAction()
	{
		$this->results["robots"] = RobotDAO::getRobots();
		
	}
}
