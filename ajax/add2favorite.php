<?php
	define("NO_KEEP_STATISTIC", true);
	define("NO_AGENT_CHECK", true);
	define('PUBLIC_AJAX_MODE', true);
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

	global $USER;
	$userType = CGCUser::getUserType([
		"ID" => $USER->GetID()
	]);

	СGCBookmark::addProduct($userType, $_REQUEST["id"]);
?>