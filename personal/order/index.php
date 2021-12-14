<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

global $USER;

CGCUser::loginIfNotAuth($USER);

$APPLICATION->SetTitle("Карточка заказа");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order",
	"",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"CUSTOM_SELECT_PROPS" => array(""),
		"DETAIL_HIDE_USER_INFO" => array("0"),
		"HISTORIC_STATUSES" => array("F"),
		"NAV_TEMPLATE" => "",
		"ORDERS_PER_PAGE" => "20",
		"ORDER_DEFAULT_SORT" => "STATUS",
		"PATH_TO_BASKET" => "/cart/",
		"PATH_TO_CATALOG" => "/catalog/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PROP_1" => array(),
		"REFRESH_PRICES" => "N",
		"RESTRICT_CHANGE_PAYSYSTEM" => array("0"),
		"SAVE_IN_SESSION" => "N",
		"SEF_FOLDER" => "/personal/order/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => Array("list"=>"","detail"=>"#ID#/",),
		"SET_TITLE" => "Y",
		"STATUS_COLOR_F" => "gray",
		"STATUS_COLOR_N" => "green",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
		"USER_TYPE" => CGCUser::getUserType([
			"ID" => $USER->GetID()
		])
	)
);?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>