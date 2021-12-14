<?php
	define("NO_KEEP_STATISTIC", true);
	define("NO_AGENT_CHECK", true);
	define('PUBLIC_AJAX_MODE', true);
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"]="N";
	$APPLICATION->ShowIncludeStat = false;
?>

<? $APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"header-menu",
	Array(
		"ADD_SECTIONS_CHAIN" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COUNT_ELEMENTS" => "N",
		"IBLOCK_ID" => "9",
		"IBLOCK_TYPE" => "1c_catalog",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => array(0=>"",),
		"SECTION_ID" => "",
		"SECTION_URL" => "/catalog/#SECTION_CODE_PATH#/",
		"SECTION_USER_FIELDS" => array(),
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => "5",
		"VIEW_MODE" => "LINE"
	)
); ?>