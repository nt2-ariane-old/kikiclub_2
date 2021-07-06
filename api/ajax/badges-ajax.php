<?php
	require_once("../action/Ajax/BadgesAjaxAction.php");

	$action = new BadgesAjaxAction();
	$action->execute();

	echo json_encode($action->results);