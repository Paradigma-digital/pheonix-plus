<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "школьный каталог феникс, каталог феникс, офисный каталог феникс, каталог офисной продукции, школьный каталог 2018");
$APPLICATION->SetPageProperty("keywords", "скачать, каталог офисной продукции, школьный каталог");
$APPLICATION->SetPageProperty("description", "Вы можете скачать актуальные каталоги с нашей продукцией для вашего удобства");
$APPLICATION->SetPageProperty("title", "Феникс+ Российский производитель канцелярии, товаров для школы и офиса");
$APPLICATION->SetTitle("Видео-галерея");
?>
<div class="page-inner page-inner--w1">
<?php
	$APPLICATION->IncludeComponent(
		"aheadstudio:video.list",
		"",
		[
			"CHANNEL_ID" => "UCTKRu44LHmJfqU78Y9ytuwQ",
			"API_KEY" => "AIzaSyAaVFKYh2f9obOrmP3zg_FOjz1mfnHBOzE",
		],
	);
?>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>