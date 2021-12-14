<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	CGCUser::loginIfNotAuth($USER);
	$APPLICATION->SetTitle("Мои магазины");
?>

<?php
	$APPLICATION->IncludeComponent(
		"aheadstudio:user.shops.list",
		"",
		[
			"HL_ID" => "11",
			"SHOW_FIELDS" => [
				[
					"CODE" => "UF_NAIMENOVANIE",
					"TITLE" => "Название",
				], [
					"CODE" => "UF_ADRES",
					"TITLE" => "Адрес",
				], [
					"CODE" => "UF_INTERNETADRES",
					"TITLE" => "Веб-сайт",
				], [
					"CODE" => "UF_GOROD",
					"TITLE" => "Город",
				], [
					"CODE" => "UF_TELEFON",
					"TITLE" => "Телефон",
				],
			],
		]
	);
?>

<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>