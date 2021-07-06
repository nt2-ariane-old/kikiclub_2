<?php
	require_once("../action/Ajax/MediaAjaxAction.php");

	$action = new MediaAjaxAction();
	$action->execute();

	echo json_encode($action->results);