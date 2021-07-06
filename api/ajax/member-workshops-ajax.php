<?php
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);
require_once("../action/Ajax/MemberWorkshopsAjaxAction.php");


$action = new MemberWorkshopsAjaxAction();
$action->execute();

echo (json_encode($action->results));
