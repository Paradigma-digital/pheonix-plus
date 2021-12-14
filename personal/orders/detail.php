<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

CGCUser::loginIfNotAuth($USER);

$APPLICATION->SetTitle("Карточка заказа");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.detail",
	"order",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ALLOW_INNER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CUSTOM_SELECT_PROPS" => array(""),
		"DISALLOW_CANCEL" => "N",
		"ID" => $_REQUEST["ORDER_ID"],
		"ONLY_INNER_FULL" => "N",
		"PATH_TO_CANCEL" => "/personal/orders/cancel/#ID#/",
		"PATH_TO_COPY" => "",
		"PATH_TO_LIST" => "/personal/orders/",
		"PATH_TO_PAYMENT" => "/personal/orders/payment.php",
		"PICTURE_HEIGHT" => "110",
		"PICTURE_RESAMPLE_TYPE" => "1",
		"PICTURE_WIDTH" => "110",
		"PROP_1" => array(""),
		"REFRESH_PRICES" => "N",
		"RESTRICT_CHANGE_PAYSYSTEM" => array("0"),
		"SET_TITLE" => "Y",
		"USER_TYPE" => CGCUser::getUserType([
			"ID" => $USER->GetID()
		])
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>