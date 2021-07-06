<?php
	require_once("../action/Ajax/MemberAjaxAction.php");

	$action = new MemberAjaxAction();
	$action->execute();

	echo(json_encode($action->results));