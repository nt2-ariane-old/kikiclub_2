<?php
	require_once("../action/Ajax/WorkshopsAjaxAction.php");

	$action = new WorkshopsAjaxAction();
	$action->execute();

	echo json_encode($action->results);