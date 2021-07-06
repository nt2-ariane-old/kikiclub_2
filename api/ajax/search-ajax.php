<?php
	require_once("../action/Ajax/SearchAjaxAction.php");

	$action = new SearchAjaxAction();
	$action->execute();

	echo json_encode($action->results);