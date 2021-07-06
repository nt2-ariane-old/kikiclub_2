<?php
header("Access-Control-Allow-Origin: *");
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);
require_once("../action/Ajax/RobotAjaxAction.php");

$action = new RobotAjaxAction();
$action->executeAction();

echo json_encode($action->results);
