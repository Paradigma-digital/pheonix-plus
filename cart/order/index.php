<?
if ($_REQUEST["ORDER_ID"] || 1) {
    $start = microtime(true);
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");

global $USER;
if (CGCCatalog::checkCart($USER->GetID())["ERRORS"] > 0) {
    LocalRedirect("/cart/?CHECK=Y");
}
$arSaleInfo = CGCUser::getSaleInfo($USER->GetID());
$userType = CGCUser::getUserType([
    "ID" => $USER->GetID()
]);

$arUserProfiles = CGCUser::getProfiles($USER->GetID());

$APPLICATION->IncludeComponent(
    "bitrix:sale.order.ajax",
    $userType == "SIMPLE" ? "retail" : "default",
    array(
        "ACTION_VARIABLE" => "soa-action",
        "ADDITIONAL_PICT_PROP_3" => "-",
        "ADDITIONAL_PICT_PROP_4" => "-",
        "ADDITIONAL_PICT_PROP_5" => "-",
        "ADDITIONAL_PICT_PROP_8" => "-",
        "ALLOW_APPEND_ORDER" => "Y",
        "ALLOW_AUTO_REGISTER" => "N",
        "ALLOW_NEW_PROFILE" => "N",
        "ALLOW_USER_PROFILES" => "Y",
        "BASKET_IMAGES_SCALING" => "adaptive",
        "BASKET_POSITION" => "before",
        "COMPATIBLE_MODE" => "Y",
        "DELIVERIES_PER_PAGE" => "9",
        "DELIVERY_FADE_EXTRA_SERVICES" => "N",
        "DELIVERY_NO_AJAX" => "Y",
        "DELIVERY_NO_SESSION" => "Y",
        "DELIVERY_TO_PAYSYSTEM" => "d2p",
        "DISABLE_BASKET_REDIRECT" => "N",
        "ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
        "PATH_TO_AUTH" => "/auth/",
        "PATH_TO_BASKET" => "/cart/",
        "PATH_TO_PAYMENT" => "/cart/order/payment.php",
        "PATH_TO_PERSONAL" => "/catalog/",
        "PAY_FROM_ACCOUNT" => "N",
        "PAY_SYSTEMS_PER_PAGE" => "9",
        "PICKUPS_PER_PAGE" => "5",
        "PICKUP_MAP_TYPE" => "yandex",
        "PRODUCT_COLUMNS_HIDDEN" => array(),
        "PRODUCT_COLUMNS_VISIBLE" => array("PREVIEW_PICTURE", "PROPS"),
        "SEND_NEW_USER_NOTIFY" => "Y",
        "SERVICES_IMAGES_SCALING" => "adaptive",
        "SET_TITLE" => "Y",
        "SHOW_BASKET_HEADERS" => "N",
        "SHOW_COUPONS_BASKET" => "N",
        "SHOW_COUPONS_DELIVERY" => "N",
        "SHOW_COUPONS_PAY_SYSTEM" => "N",
        "SHOW_DELIVERY_INFO_NAME" => "Y",
        "SHOW_DELIVERY_LIST_NAMES" => "Y",
        "SHOW_DELIVERY_PARENT_NAMES" => "Y",
        "SHOW_MAP_IN_PROPS" => "Y",
        "SHOW_NEAREST_PICKUP" => "N",
        "SHOW_NOT_CALCULATED_DELIVERIES" => "L",
        "SHOW_ORDER_BUTTON" => "final_step",
        "SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
        "SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
        "SHOW_PICKUP_MAP" => "Y",
        "SHOW_STORES_IMAGES" => "Y",
        "SHOW_TOTAL_ORDER_BUTTON" => "N",
        "SHOW_VAT_PRICE" => "N",
        "SKIP_USELESS_BLOCK" => "Y",
        "SPOT_LOCATION_BY_GEOIP" => "Y",
        "TEMPLATE_LOCATION" => "popup",
        "TEMPLATE_THEME" => "site",
        "USER_CONSENT" => "N",
        "USER_CONSENT_ID" => "0",
        "USER_CONSENT_IS_CHECKED" => "Y",
        "USER_CONSENT_IS_LOADED" => "N",
        "USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
        "USE_CUSTOM_ERROR_MESSAGES" => "N",
        "USE_CUSTOM_MAIN_MESSAGES" => "N",
        "USE_ENHANCED_ECOMMERCE" => "N",
        "USE_PRELOAD" => "Y",
        "USE_PREPAYMENT" => "N",
        "USE_YM_GOALS" => "N",
        "NDS_INFO" => $arSaleInfo["NDS"],
        "USER_PROFILES" => $arUserProfiles,
        "MESS_BUYER_BLOCK_NAME" => "Контакты покупателя",
    )
);
?>

<?
if ($_REQUEST["ORDER_ID"]) {
    $log = file_get_contents("log.txt");
    $arLog = explode("\n", $log);
    $arLogTmp = [];
    foreach ($arLog as $arLogItem) {
        $arLogItemTmp = explode(":", $arLogItem);
        $arLogTmp[$arLogItemTmp[0]] = $arLogItemTmp[1];
    }
    if (!$arLogTmp[$_REQUEST["ORDER_ID"]]) {
        $log .= "\n" . $_REQUEST["ORDER_ID"] . ":" . round(microtime(true) - $start, 4);
        file_put_contents("log.txt", $log);
    }
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
