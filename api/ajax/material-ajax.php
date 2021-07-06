<?php
	require_once("../action/Ajax/MaterialAjaxAction.php");

	$action = new MaterialAjaxAction();
	$action->execute();

	echo json_encode($action->results);