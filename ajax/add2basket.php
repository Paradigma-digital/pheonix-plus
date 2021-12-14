<?
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define('PUBLIC_AJAX_MODE', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"] = "N";
$APPLICATION->ShowIncludeStat = false;

CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");

global $USER;
$arUserSale = CGCUser::getSaleInfo($USER->GetID());

//print_r($arUserSale); die;

$arBasketParams = [];
if ($arUserSale["NDS"]["TYPE"] == "OVER") {
    $arBasketParams["PRODUCT_PROVIDER_CLASS"] = "CCatalogPhoenixProductProvider";
    $arBasketParams["CUSTOM_PRICE"] = "Y";
}

$product = CIBlockElement::GetList(
    array(),
    array('IBLOCK_ID' => iblock_id_catalog, 'ID' => $id),
    false,
    false,
    array('ID', 'NAME', 'CODE', 'IBLOCK_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_SIZE', 'CATALOG_QUANTITY', 'DETAIL_PAGE_URL', "PROPERTY_FIXED_PRICE")
);

$product = $product->GetNext();
if ($product["PROPERTY_FIXED_PRICE_VALUE"]) {
    $arBasketParams["PRODUCT_PROVIDER_CLASS"] = "CCatalogPhoenixProductActionProvider";
    $arBasketParams["CUSTOM_PRICE"] = "Y";
}

//deb(123);

$id = (int)($_REQUEST['id']);
$quantity = (int)($_REQUEST['quantity']);
$pack = (int)($_REQUEST['pack']);

if ($id > 0 && $quantity > 0) {
    $bsk = array();
    $dbBasketItems = CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL"
        ),
        false,
        false,
        array()
    );
    while ($point = $dbBasketItems->Fetch()) {
        $bsk[$point['PRODUCT_ID']] = $point;
    }
    $lastquantity = 0;
    if (!empty($bsk[$id])) {
        $lastquantity = $bsk[$id]['QUANTITY'];
        CSaleBasket::Delete($bsk[$id]['ID']);
    }

    global $USER;

    $q = $quantity + $lastquantity;

    if ($q > $product["CATALOG_QUANTITY"]) {
        $q = $product["CATALOG_QUANTITY"];
        if ($pack) {
            $q = ($q - ($q % $pack));
        }
    }

    Preorder::updateUserBasket("UF_USER_CART", $id, $quantity);

    Add2BasketByProductID($id, $q,
        $arBasketParams, array()
//                array(
//                        array("NAME" => "Артикул", "CODE" => "ARTICLE", "VALUE" => $product['PROPERTY_ARTICLE_VALUE']),
//                        array("NAME" => "Товар", "CODE" => "PRODUCT", "VALUE" => $product['ID']),
//                        array("NAME" => "Название товара", "CODE" => "NAME", "VALUE" => $product['NAME']),
//                        array("NAME" => "Ссылка на товар", "CODE" => "LINK", "VALUE" => $product['DETAIL_PAGE_URL']),
//                        array("NAME" => "Количество товара", "CODE" => "QUANTITY", "VALUE" => ($offer['CATALOG_QUANTITY']-$offer['CATALOG_QUANTITY_RESERVED'])),
//                        array("NAME" => "Размер", "CODE" => "SIZE", "VALUE" => $offer['PROPERTY_SIZE_VALUE'])
//                )
    );
}


echo '<div data-quantity="' . $q . '">';

$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket.line",
    ".default",
    array(
        "HIDE_ON_BASKET_PAGES" => "N",
        "PATH_TO_BASKET" => SITE_DIR . "cart/",
        "PATH_TO_ORDER" => SITE_DIR . "cart/order/",
        "POSITION_FIXED" => "N",
        "SHOW_AUTHOR" => "N",
        "SHOW_EMPTY_VALUES" => "Y",
        "SHOW_NUM_PRODUCTS" => "Y",
        "SHOW_PERSONAL_LINK" => "N",
        "SHOW_PRODUCTS" => "Y",
        "SHOW_TOTAL_PRICE" => "Y"
    )
);

$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket.line",
    "popup_ajax",
    array(
        "HIDE_ON_BASKET_PAGES" => "N",
        "PATH_TO_BASKET" => SITE_DIR . "cart/",
        "PATH_TO_ORDER" => SITE_DIR . "cart/order/",
        "POSITION_FIXED" => "N",
        "SHOW_AUTHOR" => "N",
        "SHOW_EMPTY_VALUES" => "Y",
        "SHOW_NUM_PRODUCTS" => "Y",
        "SHOW_PERSONAL_LINK" => "N",
        "SHOW_PRODUCTS" => "Y",
        "SHOW_TOTAL_PRICE" => "Y"
    )
);

echo '</div>';

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");