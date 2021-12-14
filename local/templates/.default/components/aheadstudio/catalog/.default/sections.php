<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true); ?>
<?php global $USER; ?>
    <div class="page-inner page-inner--w1 page-inner--mobile_empty">
        <? $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "promo",
            array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "N",
                "CACHE_FILTER" => "Y",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "N",
                "DISPLAY_PICTURE" => "N",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("", ""),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "10",
                "IBLOCK_TYPE" => "content",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "500",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array("LINK", ""),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "N",
                "USER_REGISTERED" => ($USER->IsAuthorized() ? "Y" : "N")
            ),
            $component,
            array("HIDE_ICONS" => "Y")
        ); ?>
    </div>

    <div class="page-inner page-inner--w1">

        <? $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "catalog.banner",
            array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "N",
                "CACHE_FILTER" => "Y",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "N",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("", ""),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "15",
                "IBLOCK_TYPE" => "content",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "N",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "4",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array("LINK", ""),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "Y",
                "SHOW_404" => "N",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "N"
            )
        ); ?>


        <?php if (0): ?>
            <? $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "catalog",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                    "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
                    "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                    "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
                    "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
                    "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                    "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
                ),
                $component,
                array("HIDE_ICONS" => "Y")
            ); ?>
            <? $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "links",
                array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "DISPLAY_DATE" => "N",
                    "DISPLAY_NAME" => "N",
                    "DISPLAY_PICTURE" => "N",
                    "DISPLAY_PREVIEW_TEXT" => "N",
                    "DISPLAY_TOP_PAGER" => "N",
                    "FIELD_CODE" => array("", ""),
                    "FILTER_NAME" => "",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "IBLOCK_ID" => "11",
                    "IBLOCK_TYPE" => "content",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "MESSAGE_404" => "",
                    "NEWS_COUNT" => "500",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Новости",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "PROPERTY_CODE" => array("LINK", ""),
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SORT_BY1" => "SORT",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER1" => "ASC",
                    "SORT_ORDER2" => "ASC",
                    "STRICT_SECTION_CHECK" => "N"
                ),
                $component,
                array("HIDE_ICONS" => "Y")
            ); ?>

        <?php endif; ?>

    </div>
<?
if ($arParams["SHOW_TOP_ELEMENTS"] !== "N") {
    if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] === 'Y') {
        $basketAction = isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '';
    } else {
        $basketAction = isset($arParams['TOP_ADD_TO_BASKET_ACTION']) ? $arParams['TOP_ADD_TO_BASKET_ACTION'] : '';
    }

    global $onlyHitFltr;
    global $onlyNewFltr;
    global $onlyActionsFltr;

    $onlyHitFltr['PROPERTY_STATUS_TOVARA'] = CGCHelper::getPropertyIDByCode("STATUS_TOVARA", "Хит");
    // $onlyHitFltr[">CATALOG_QUANTITY"] = 0;

    $onlyActionsFltr['PROPERTY_STATUS_TOVARA'] = CGCHelper::getPropertyIDByCode("STATUS_TOVARA", "Скидка");
    // $onlyActionsFltr[">CATALOG_QUANTITY"] = 0;

    $onlyNewFltr['PROPERTY_STATUS_TOVARA'] = CGCHelper::getPropertyIDByCode("STATUS_TOVARA", "Новинка");

    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "common",
        array(
            "SHOW_ALL_WO_SECTION" => 'Y',
            "USE_FILTER" => 'Y',
            "FILTER_NAME" => 'onlyNewFltr',
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_SORT_FIELD" => $arParams["TOP_ELEMENT_SORT_FIELD"],
            "ELEMENT_SORT_ORDER" => $arParams["TOP_ELEMENT_SORT_ORDER"],
            "ELEMENT_SORT_FIELD2" => $arParams["TOP_ELEMENT_SORT_FIELD2"],
            "ELEMENT_SORT_ORDER2" => $arParams["TOP_ELEMENT_SORT_ORDER2"],
            "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
            "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
            "BASKET_URL" => $arParams["BASKET_URL"],
            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
            "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
            "ELEMENT_COUNT" => "40",
            "LINE_ELEMENT_COUNT" => $arParams["TOP_LINE_ELEMENT_COUNT"],
            "PROPERTY_CODE" => $arParams["TOP_PROPERTY_CODE"],
            "PROPERTY_CODE_MOBILE" => $arParams["TOP_PROPERTY_CODE_MOBILE"],
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
            "PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
            "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
            "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
            "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
            "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
            "OFFERS_FIELD_CODE" => $arParams["TOP_OFFERS_FIELD_CODE"],
            "OFFERS_PROPERTY_CODE" => $arParams["TOP_OFFERS_PROPERTY_CODE"],
            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
            "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
            "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
            "OFFERS_LIMIT" => $arParams["TOP_OFFERS_LIMIT"],
            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
            'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
            'VIEW_MODE' => (isset($arParams['TOP_VIEW_MODE']) ? $arParams['TOP_VIEW_MODE'] : ''),
            'ROTATE_TIMER' => (isset($arParams['TOP_ROTATE_TIMER']) ? $arParams['TOP_ROTATE_TIMER'] : ''),
            'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),

            'LABEL_PROP' => $arParams['LABEL_PROP'],
            'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
            'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
            'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
            'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
            'PRODUCT_BLOCKS_ORDER' => $arParams['TOP_PRODUCT_BLOCKS_ORDER'],
            'PRODUCT_ROW_VARIANTS' => $arParams['TOP_PRODUCT_ROW_VARIANTS'],
            'ENLARGE_PRODUCT' => $arParams['TOP_ENLARGE_PRODUCT'],
            'ENLARGE_PROP' => isset($arParams['TOP_ENLARGE_PROP']) ? $arParams['TOP_ENLARGE_PROP'] : '',
            'SHOW_SLIDER' => $arParams['TOP_SHOW_SLIDER'],
            'SLIDER_INTERVAL' => isset($arParams['TOP_SLIDER_INTERVAL']) ? $arParams['TOP_SLIDER_INTERVAL'] : '',
            'SLIDER_PROGRESS' => isset($arParams['TOP_SLIDER_PROGRESS']) ? $arParams['TOP_SLIDER_PROGRESS'] : '',

            'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
            'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
            'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
            'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
            'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
            'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
            'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
            'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
            'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'],
            'ADD_TO_BASKET_ACTION' => $basketAction,
            'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
            'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],

            'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
            "DISPLAY_ALL_LINK" => "Y",

            "TEMPLATE" => [
                "IS_SLIDER" => "Y",
                "TITLE" => "Новинки",
                "ALL_LINK" => "/catalog/new/",
            ],
            "DISPLAY_BOTTOM_PAGER" => "N",
        ),
        $component
    );

    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "common",
        array(
            "SHOW_ALL_WO_SECTION" => 'Y',
            "USE_FILTER" => 'Y',
            "FILTER_NAME" => 'onlyHitFltr',
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_SORT_FIELD" => $arParams["TOP_ELEMENT_SORT_FIELD"],
            "ELEMENT_SORT_ORDER" => $arParams["TOP_ELEMENT_SORT_ORDER"],
            "ELEMENT_SORT_FIELD2" => $arParams["TOP_ELEMENT_SORT_FIELD2"],
            "ELEMENT_SORT_ORDER2" => $arParams["TOP_ELEMENT_SORT_ORDER2"],
            "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
            "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
            "BASKET_URL" => $arParams["BASKET_URL"],
            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
            "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
            "ELEMENT_COUNT" => $arParams["TOP_ELEMENT_COUNT"],
            "LINE_ELEMENT_COUNT" => $arParams["TOP_LINE_ELEMENT_COUNT"],
            "PROPERTY_CODE" => $arParams["TOP_PROPERTY_CODE"],
            "PROPERTY_CODE_MOBILE" => $arParams["TOP_PROPERTY_CODE_MOBILE"],
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
            "PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
            "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
            "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
            "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
            "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
            "OFFERS_FIELD_CODE" => $arParams["TOP_OFFERS_FIELD_CODE"],
            "OFFERS_PROPERTY_CODE" => $arParams["TOP_OFFERS_PROPERTY_CODE"],
            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
            "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
            "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
            "OFFERS_LIMIT" => $arParams["TOP_OFFERS_LIMIT"],
            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
            'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
            'VIEW_MODE' => (isset($arParams['TOP_VIEW_MODE']) ? $arParams['TOP_VIEW_MODE'] : ''),
            'ROTATE_TIMER' => (isset($arParams['TOP_ROTATE_TIMER']) ? $arParams['TOP_ROTATE_TIMER'] : ''),
            'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),

            'LABEL_PROP' => $arParams['LABEL_PROP'],
            'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
            'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
            'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
            'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
            'PRODUCT_BLOCKS_ORDER' => $arParams['TOP_PRODUCT_BLOCKS_ORDER'],
            'PRODUCT_ROW_VARIANTS' => $arParams['TOP_PRODUCT_ROW_VARIANTS'],
            'ENLARGE_PRODUCT' => $arParams['TOP_ENLARGE_PRODUCT'],
            'ENLARGE_PROP' => isset($arParams['TOP_ENLARGE_PROP']) ? $arParams['TOP_ENLARGE_PROP'] : '',
            'SHOW_SLIDER' => $arParams['TOP_SHOW_SLIDER'],
            'SLIDER_INTERVAL' => isset($arParams['TOP_SLIDER_INTERVAL']) ? $arParams['TOP_SLIDER_INTERVAL'] : '',
            'SLIDER_PROGRESS' => isset($arParams['TOP_SLIDER_PROGRESS']) ? $arParams['TOP_SLIDER_PROGRESS'] : '',

            'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
            'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
            'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
            'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
            'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
            'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
            'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
            'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
            'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'],
            'ADD_TO_BASKET_ACTION' => $basketAction,
            'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
            'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],

            'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
            "DISPLAY_ALL_LINK" => "Y",

            "TEMPLATE" => [
                "IS_SLIDER" => "Y",
                "TITLE" => "Популярные товары",
                "ALL_LINK" => "/catalog/popular/",
            ],

            "DISPLAY_BOTTOM_PAGER" => "N",
        ),
        $component
    );


    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "common",
        array(
            "SHOW_ALL_WO_SECTION" => 'Y',
            "USE_FILTER" => 'Y',
            "FILTER_NAME" => 'onlyActionsFltr',
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_SORT_FIELD" => $arParams["TOP_ELEMENT_SORT_FIELD"],
            "ELEMENT_SORT_ORDER" => $arParams["TOP_ELEMENT_SORT_ORDER"],
            "ELEMENT_SORT_FIELD2" => $arParams["TOP_ELEMENT_SORT_FIELD2"],
            "ELEMENT_SORT_ORDER2" => $arParams["TOP_ELEMENT_SORT_ORDER2"],
            "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
            "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
            "BASKET_URL" => $arParams["BASKET_URL"],
            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
            "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
            "ELEMENT_COUNT" => $arParams["TOP_ELEMENT_COUNT"],
            "LINE_ELEMENT_COUNT" => $arParams["TOP_LINE_ELEMENT_COUNT"],
            "PROPERTY_CODE" => $arParams["TOP_PROPERTY_CODE"],
            "PROPERTY_CODE_MOBILE" => $arParams["TOP_PROPERTY_CODE_MOBILE"],
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
            "PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
            "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
            "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
            "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
            "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
            "OFFERS_FIELD_CODE" => $arParams["TOP_OFFERS_FIELD_CODE"],
            "OFFERS_PROPERTY_CODE" => $arParams["TOP_OFFERS_PROPERTY_CODE"],
            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
            "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
            "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
            "OFFERS_LIMIT" => $arParams["TOP_OFFERS_LIMIT"],
            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
            'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
            'VIEW_MODE' => (isset($arParams['TOP_VIEW_MODE']) ? $arParams['TOP_VIEW_MODE'] : ''),
            'ROTATE_TIMER' => (isset($arParams['TOP_ROTATE_TIMER']) ? $arParams['TOP_ROTATE_TIMER'] : ''),
            'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),

            'LABEL_PROP' => $arParams['LABEL_PROP'],
            'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
            'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
            'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
            'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
            'PRODUCT_BLOCKS_ORDER' => $arParams['TOP_PRODUCT_BLOCKS_ORDER'],
            'PRODUCT_ROW_VARIANTS' => $arParams['TOP_PRODUCT_ROW_VARIANTS'],
            'ENLARGE_PRODUCT' => $arParams['TOP_ENLARGE_PRODUCT'],
            'ENLARGE_PROP' => isset($arParams['TOP_ENLARGE_PROP']) ? $arParams['TOP_ENLARGE_PROP'] : '',
            'SHOW_SLIDER' => $arParams['TOP_SHOW_SLIDER'],
            'SLIDER_INTERVAL' => isset($arParams['TOP_SLIDER_INTERVAL']) ? $arParams['TOP_SLIDER_INTERVAL'] : '',
            'SLIDER_PROGRESS' => isset($arParams['TOP_SLIDER_PROGRESS']) ? $arParams['TOP_SLIDER_PROGRESS'] : '',

            'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
            'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
            'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
            'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
            'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
            'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
            'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
            'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
            'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'],
            'ADD_TO_BASKET_ACTION' => $basketAction,
            'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
            'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],

            'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
            "DISPLAY_ALL_LINK" => "Y",


            "TEMPLATE" => [
                "IS_SLIDER" => "Y",
                "TITLE" => "Акции",
                "ALL_LINK" => "/catalog/actions/",
            ],

            "DISPLAY_BOTTOM_PAGER" => "N",
        ),
        $component
    );

    unset($basketAction);
}
/*

$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
	),
	$component,
	array("HIDE_ICONS" => "Y")
);

if ($arParams["USE_COMPARE"] === "Y")
{
	$APPLICATION->IncludeComponent(
		"bitrix:catalog.compare.list",
		"",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"NAME" => $arParams["COMPARE_NAME"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
			"COMPARE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
			"ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action")."_ccl",
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			'POSITION_FIXED' => isset($arParams['COMPARE_POSITION_FIXED']) ? $arParams['COMPARE_POSITION_FIXED'] : '',
			'POSITION' => isset($arParams['COMPARE_POSITION']) ? $arParams['COMPARE_POSITION'] : ''
		),
		$component,
		array("HIDE_ICONS" => "Y")
	);
}