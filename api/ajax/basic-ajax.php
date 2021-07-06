<?php
	require_once("../action/Ajax/BasicAjaxAction.php");

	$action = new BasicAjaxAction();
	$action->execute();

	echo json_encode($action->results);