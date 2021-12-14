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
$this->setFrameMode(true);
perPageClass::getValue();
?>
<?
$arSearchElements = $APPLICATION->IncludeComponent(
    "bitrix:search.page",
    ".default",
    array(
        "USE_SUGGEST" => 'N',
        "RESTART" => 'Y',
        "NO_WORD_LOGIC" => 'N',
        "USE_LANGUAGE_GUESS" => $arParams["USE_LANGUAGE_GUESS"],
        "CHECK_DATES" => $arParams["CHECK_DATES"],
        "arrFILTER" => array("iblock_" . $arParams["IBLOCK_TYPE"]),
        "arrFILTER_iblock_" . $arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"]),
        "USE_TITLE_RANK" => "Y",
        "DEFAULT_SORT" => "rank",
        "SHOW_WHERE" => "N",
        "arrWHERE" => array(),
        "SHOW_WHEN" => "N",
        "PAGE_RESULT_COUNT" => "2000",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "N",
    ),
    $arResult["THEME_COMPONENT"],
    array('HIDE_ICONS' => 'Y')
);

$arElements = [];
$query = htmlspecialchars($_GET["q"]);

if ($query) {
    global $searchFilter;
    foreach ($arParams["PRICE_CODE"] as $id => $name) {

        $searchFilter['!CATALOG_PRICE_' . $id] = false;
    }

    $filterPreOrder = [];
    /*
    if (CSite::InGroup([preorder_id_group])) {
//        $pre = "PROPERTY_PREDZAKAZ";
    }else{
        $pre = [
            "LOGIC" => "AND",
            [
                "PROPERTY_PREDZAKAZ" => false,
            ],
            [
                "PROPERTY_PREDZAKAZ" => "Нет",
            ]
        ];
    }
*/
    $filter = [
        "LOGIC" => "OR",
        [
            "NAME" => "%" . $query . "%",
        ],
        [
            "ID" => ($arSearchElements ? $arSearchElements : false),
        ],
        [
            "LOGIC" => "AND",
            [
                "PROPERTY_CML2_ARTICLE" => $query,
            ]
        ],
        [
            "LOGIC" => "AND",
            [
                "PROPERTY_CML2_BAR_CODE" => $query,
            ]
        ]
    ];
    
    $dbElements = CIBlockElement::GetList(
        false,
        [
            "GLOBAL_ACTIVE" => "Y",
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            $filter,
        ],
        false,
        false,
        ["ID", "NAME", "PROPERTY_CML2_ARTICLE", "PROPERTY_CML2_BAR_CODE", "PROPERTY_PREDZAKAZ"]
    );
    while ($arElement = $dbElements->Fetch()) {
        if (!CSite::InGroup([preorder_id_group]) && $arElement["PROPERTY_PREDZAKAZ_VALUE"]  == "Да") {
            continue;
        }
        $arElements[] = $arElement["ID"];
    }
}

if (!empty($arElements) && is_array($arElements)) {
    ?>
    <div class="catalog-info">
        <div class="catalog-search">
            <div class="catalog-search-title"><span>Вы искали: </span><?= htmlspecialchars($_GET['q']) ?></div>
            <div class="catalog-search-count"><?php echo count($arElements);
                echo " " . getNumEnding(count($arElements), array("совпадение", "совпадения", "совпадений")); ?></div>
        </div>
        <div class="catalog-sort">
            <div class="catalog-sort-item catalog-sort-item--large"><span
                        class="catalog-sort-item-title">Сортировать по</span>
                <select name='sort' class="form-item--select"
                        onchange="document.location = '<?= $APPLICATION->GetCurPage() ?>?q=<?= $_GET['q'] ?>&sort='+$(this).val();">
                    <? foreach (sortClass::$points as $kpoint => $point) { ?>
                        <option<? if ($kpoint == sortClass::getValue()) { ?> selected=""<? } ?>
                                value="<?= $kpoint ?>"><?= $point['TEXT'] ?></option>
                    <? } ?>
                </select>
            </div>

            <div class="catalog-sort-item catalog-sort-item--small"><span
                        class="catalog-sort-item-title">показывать по</span>
                <select class="form-item--select"
                        onchange="document.location = '<?= $APPLICATION->GetCurPage() ?>?q=<?= $_GET['q'] ?>&perpage='+$(this).val();">
                    <? foreach (perSearchPageClass::$points as $kpoint => $point) { ?>
                        <option<? if ($kpoint == perSearchPageClass::getValue()) { ?> selected=""<? } ?>
                                value="<?= $kpoint ?>"><?= $point ?></option>
                    <? } ?>
                </select>
            </div>
        </div>
    </div>
    <?

    $searchFilter = array(
        "=ID" => $arElements,
    );

    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "common",
        array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            //"ELEMENT_SORT_FIELD" => sortClass::getValueField(),
            //"ELEMENT_SORT_ORDER" => sortClass::getValueOrder(),
            //"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
            //"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],

            "ELEMENT_SORT_FIELD" => sortClass::getValueField(),
            "ELEMENT_SORT_ORDER" => sortClass::getValueOrder(),
            "ELEMENT_SORT_FIELD2" => sortClass::getValueField2(),
            "ELEMENT_SORT_ORDER2" => sortClass::getValueOrder2(),
            "HIDE_NOT_AVAILABLE" => "Y",

            "PAGE_ELEMENT_COUNT" => perSearchPageClass::getValueEx(),
            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
            "PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
            "PROPERTY_CODE_MOBILE" => $arParams["PROPERTY_CODE_MOBILE"],
            "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
            "OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
            "OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
            "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
            "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
            "OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
            "SECTION_URL" => $arParams["SECTION_URL"],
            "DETAIL_URL" => $arParams["DETAIL_URL"],
            "BASKET_URL" => $arParams["BASKET_URL"],
            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
            "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
            "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
            "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
            "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
            "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
            "CURRENCY_ID" => $arParams["CURRENCY_ID"],

            'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
            "PAGER_TITLE" => $arParams["PAGER_TITLE"],
            "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
            "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
            "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
            "LAZY_LOAD" => $arParams["LAZY_LOAD"],
            "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
            "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],
            "FILTER_NAME" => "searchFilter",
            "SECTION_ID" => "",
            "SECTION_CODE" => "",
            "SECTION_USER_FIELDS" => array(),
            "INCLUDE_SUBSECTIONS" => "Y",
            "SHOW_ALL_WO_SECTION" => "Y",
            "META_KEYWORDS" => "",
            "META_DESCRIPTION" => "",
            "BROWSER_TITLE" => "",
            "ADD_SECTIONS_CHAIN" => "N",
            "SET_TITLE" => "N",
            "SET_STATUS_404" => "N",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "N",
            'LABEL_PROP' => $arParams['LABEL_PROP'],
            'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
            'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
            'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
            'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
            'PRODUCT_BLOCKS_ORDER' => $arParams['PRODUCT_BLOCKS_ORDER'],
            'PRODUCT_ROW_VARIANTS' => $arParams['PRODUCT_ROW_VARIANTS'],
            'ENLARGE_PRODUCT' => $arParams['ENLARGE_PRODUCT'],
            'ENLARGE_PROP' => $arParams['ENLARGE_PROP'],
            'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'SLIDER_PROGRESS' => $arParams['SLIDER_PROGRESS'],
            'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
            'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
            'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
            'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],
            'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
            'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
            'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
            'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
            'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'],
            'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
            'SHOW_CLOSE_POPUP' => (isset($arParams['SHOW_CLOSE_POPUP']) ? $arParams['SHOW_CLOSE_POPUP'] : ''),
            'COMPARE_PATH' => $arParams['COMPARE_PATH'],
            'COMPARE_NAME' => $arParams['COMPARE_NAME'],
            "USER_TYPE" => $arParams["USER_TYPE"],
        ),
        $arResult["THEME_COMPONENT"],
        array('HIDE_ICONS' => 'Y')
    );
} elseif (is_array($arElements)) {
    ?>
    <div class="catalog-info">
        <div class="catalog-search">
            <div class="catalog-search-title"><span>Вы искали </span><?= htmlspecialchars($_GET['q']) ?></div>
        </div>
    </div>
    <div class="search-empty">По вашему запросу ничего не найдено.</div>
    <?
}
?>