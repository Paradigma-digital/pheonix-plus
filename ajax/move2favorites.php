<?php
	define("NO_KEEP_STATISTIC", true);
	define("NO_AGENT_CHECK", true);
	define('PUBLIC_AJAX_MODE', true);
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

	global $USER;
	$userType = CGCUser::getUserType([
		"ID" => $USER->GetID()
	]);
	
	$_REQUEST = json_decode(file_get_contents('php://input'), true);
	СGCBookmark::addProducts($userType, $_REQUEST["ids"]);
?>