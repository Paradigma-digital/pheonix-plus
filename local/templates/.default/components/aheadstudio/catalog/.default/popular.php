<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
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

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;


$this->setFrameMode(true);
$arParams["HIDE_NOT_AVAILABLE"] = 'Y';
?>
<div class="page-inner page-inner--w1">
    <div class="catalog-info">
        <? $APPLICATION->ShowViewContent('section_title'); ?>
        <div class="catalog-sort">
            <div class="catalog-sort-item catalog-sort-item--large"><span
                        class="catalog-sort-item-title">Сортировать по</span>
                <select name='sort' class="form-item--select"
                        onchange="document.location = '<?= $APPLICATION->GetCurPage() ?>?sort='+$(this).val();">
                    <? foreach (sortClass::$points as $kpoint => $point) { ?>
                        <option<? if ($kpoint == sortClass::getValue()) { ?> selected=""<? } ?>
                                value="<?= $kpoint ?>"><?= $point['TEXT'] ?></option>
                    <? } ?>
                </select>
            </div>

            <div class="catalog-sort-item catalog-sort-item--small"><span
                        class="catalog-sort-item-title">показывать по</span>
                <select class="form-item--select"
                        onchange="document.location = '<?= $APPLICATION->GetCurPage() ?>?perpage='+$(this).val();">
                    <? foreach (perSearchPageClass::$points as $kpoint => $point) { ?>
                        <option<? if ($kpoint == perSearchPageClass::getValue()) { ?> selected=""<? } ?>
                                value="<?= $kpoint ?>"><?= $point ?></option>
                    <? } ?>
                </select>
            </div>
            <a href="#filter" data-type="inline" class="catalog-filter-mobile popup"><span
                        class="catalog-filter-mobile-title">Фильтр</span><span class="catalog-filter-mobile-icon"><span
                            class="catalog-filter-mobile-icon-item catalog-filter-mobile-icon-item--1"></span><span
                            class="catalog-filter-mobile-icon-item catalog-filter-mobile-icon-item--2"></span><span
                            class="catalog-filter-mobile-icon-item catalog-filter-mobile-icon-item--3"></span></span></a>
        </div>
    </div>
    <div class="catalog-holder catalog-holder--full">
        <?
        $GLOBALS[$arParams["FILTER_NAME"]]['>CATALOG_QUANTITY'] = 0;
        //$GLOBALS[$arParams["FILTER_NAME"]]["!PROPERTY_KHIT"] = false;
        $GLOBALS[$arParams["FILTER_NAME"]]["PROPERTY_STATUS_TOVARA"] = CGCHelper::getPropertyIDByCode("STATUS_TOVARA", "Хит");
        ?>

        <?
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.section",
            "common",
            array(
                "SHOW_ALL_WO_SECTION" => 'Y',
                "USE_FILTER" => 'Y',
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "ELEMENT_SORT_FIELD" => sortClass::getValueField(),
                "ELEMENT_SORT_ORDER" => sortClass::getValueOrder(),
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
                "ELEMENT_COUNT" => perSearchPageClass::getValueEx(),
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
                "PAGE_ELEMENT_COUNT" => perSearchPageClass::getValueEx(),
                "TEMPLATE" => [
                    "TITLE" => "Популярные товары",
                    "DISPLAY_BREADCRUMBS" => "Y",
                ],
            ),
            $component
        );
        ?>

    </div>
</div>