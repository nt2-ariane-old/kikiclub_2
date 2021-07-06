<?php
	require_once("../action/Ajax/SendEmailAjaxAction.php");

	$action = new SendEmailAjaxAction();
	$action->execute();

	echo json_encode($action->results);