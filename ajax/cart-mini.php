<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.line",
	".default",
	Array(
		"HIDE_ON_BASKET_PAGES" => "Y",
		"PATH_TO_BASKET" => SITE_DIR."cart/",
		"PATH_TO_ORDER" => SITE_DIR."cart/order/",
		"POSITION_FIXED" => "N",
		"SHOW_AUTHOR" => "N",
		"SHOW_EMPTY_VALUES" => "Y",
		"SHOW_NUM_PRODUCTS" => "Y",
		"SHOW_PERSONAL_LINK" => "N",
		"SHOW_PRODUCTS" => "N",
		"SHOW_TOTAL_PRICE" => "Y"
	)
);