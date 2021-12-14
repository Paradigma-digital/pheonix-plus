<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?php
	$APPLICATION->IncludeComponent(
		"aheadstudio:user.shop.add",
		"",
		[
			"HL_ID" => "11",
			"SHOW_FIELDS" => [
				[
					"CODE" => "UF_NAIMENOVANIE",
					"TITLE" => "Название",
					"REQUIRED" => true,
				], [
					"CODE" => "UF_ADRES",
					"TITLE" => "Адрес",
					"REQUIRED" => true,
				], [
					"CODE" => "UF_GOROD",
					"TITLE" => "Город",
					"REQUIRED" => true,
				], [
					"CODE" => "UF_INTERNETADRES",
					"TITLE" => "Веб-сайт",
				], [
					"CODE" => "UF_TELEFON",
					"TITLE" => "Телефон",
				],
			],
		]
	);
?>
<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>