<?php
	require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
	CModule::IncludeModule("iblock");
	
	$ar6To10 = CGCHelper::getIBlockElements([
		"FILTER" => [
			"IBLOCK_ID" => "26",
			"SECTION_ID" => "963",
		],
		"SELECT" => [
			"ID", "PREVIEW_PICTURE", "NAME", "PROPERTY_AGE",
		]
	]);
	
	$ar11To15 = CGCHelper::getIBlockElements([
		"FILTER" => [
			"IBLOCK_ID" => "26",
			"SECTION_ID" => "964",
		],
		"SELECT" => [
			"ID", "PREVIEW_PICTURE", "NAME", "PROPERTY_AGE",
		]
	]);
	deb($ar11To15);
?>
