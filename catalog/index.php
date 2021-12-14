<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "канцтовары оптом, каталог, офисная продукция, подарочная упаковка, купить школьную продукцию, купить офисную продукцию, каталог канцелярских товаров, канцелярия, магазин феникс, товары феникс+, канц товары, тетрадь, дневник, пенал, папка, рюкзак, портфель, ранец, сумка, клач, альбом, ручка, визитница, датированный, недатированный, ежедневник, записная книжка, скетчпад, расписание, обложка документы");
$APPLICATION->SetPageProperty("description", "Официальный сайт и каталог канцтоваров компании Феникс+");
$APPLICATION->SetPageProperty("keywords", "сайт канцтоваров, канцтовары, канцтовары официальный сайт, магазин канцтоваров, канцтовары каталог, канцтовары оптом");
$APPLICATION->SetPageProperty("title", "Феникс+ - сайт канцтоваров оптом №1");
$APPLICATION->SetTitle("Каталог канцтоваров Феникс+.");

global $APPLICATION, $USER, $arrFilter;
$arUserSale = CGCUser::getSaleInfo($USER->GetID());

$page = $APPLICATION->GetCurPage(false);
$arUrl = explode("/", $page);
TrimArr($arUrl);

$rsSection = \Bitrix\Iblock\SectionTable::getList(array(
	'filter' => array(
		'CODE' => end($arUrl),
		'IBLOCK_ID' => 9,
	),
	'select' => array('ID'),
));

if($arSection=$rsSection->fetch())
{
	$nav = CIBlockSection::GetNavChain(false, $arSection["ID"]);
	while($arItem = $nav->Fetch()){
		$sectionItems[] = $arItem["ID"];
	}
}

$preorder = false;
if (in_array(1006, $sectionItems)) {
	$preorder = true; // если в разделе "предзаказы", то передаём флаг для отображения кнопок предзаказ
	if (Preorder::inPreorderGroup()) {		
		// если пользователь в группе "предзаказ" и в разделе "предзаказ", то отображаем товары с флагом предзаказ = "Да"
		// в этом же каталоге отображаем "основную коллекцию = "Да"
		$arrFilter = [
			["LOGIC" => "OR",
				["PROPERTY_PREDZAKAZ_VALUE" => "Да"],
				["PROPERTY_OSNOVNAYA_KOLLEKTSIYA_VALUE" => "Да"]
			]
		];
	} else {
		// если кто то без группы "Предзаказ" попал в раздел "Предзаказ", то ничего не выводим
		$arrFilter = ["ID" => 0];
	}
} else {
	if (Preorder::inPreorderGroup()) {
		// если пользователь в группе "Предзаказ" и не в разделе "Предзаказ", то в каталоге товаров скрываем товары с флагом "предзаказ" = "Да"
		// в этом же каталоге отображаем "основную коллекцию = "Да"
		$arrFilter = [
			["LOGIC" => "OR", 
			   ["PROPERTY_PREDZAKAZ" => false], 
			   ["PROPERTY_OSNOVNAYA_KOLLEKTSIYA_VALUE" => "Да"]
			]
		];
	}else{
		// если пользователь не состоит в группе "Предзаказ" скрываем все товары с флагом "предзаказ"
		// В каталоге разрешаем покупку товаров с "Основной коллекцией" = "Да"
		$arrFilter = [
			["LOGIC" => "OR",
				["PROPERTY_PREDZAKAZ" => false],
				["PROPERTY_PREDZAKAZ_VALUE" => "Нет"]	
			]
		];
	}
}

$APPLICATION->IncludeComponent(
    "aheadstudio:catalog",
    ".default",
    array(
		"PREORDER" => $preorder ? "Y":"N",
        "ACTION_VARIABLE" => "action",
        "ADD_ELEMENT_CHAIN" => "Y",
        "ADD_PROPERTIES_TO_BASKET" => "N",
        "ADD_SECTIONS_CHAIN" => "Y",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "BASKET_URL" => "/cart/",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "86400",
        "CACHE_TYPE" => "A",
        "COMPATIBLE_MODE" => "Y",
        "CONVERT_CURRENCY" => "N",
        "DETAIL_BACKGROUND_IMAGE" => "-",
        "DETAIL_BROWSER_TITLE" => "-",
        "DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
        "DETAIL_META_DESCRIPTION" => "-",
        "DETAIL_META_KEYWORDS" => "-",
        "DETAIL_PROPERTY_CODE" => array(
            0 => "VOZRAST",
            1 => "KOLICHESTVO_STRANITS",
            2 => "OSOBENNOSTI",
            3 => "TIP_PRODUKTSII",
            4 => "RAZMER",
            5 => "KOLICHESTVO_LISTOV",
            6 => "VID_SKREPLENIYA",
            7 => "PLOTNOST_BUMAGI",
            8 => "PECHAT_BLOKA",
            9 => "ZAKLADKA",
            10 => "OTDELKA_OBLOZHKI",
            11 => "TSVET_OBLOZHKI",
            12 => "SPRAVOCHNYY_MATERIAL",
            13 => "MATERIAL_OBLOZHKI",
            14 => "VID_OBLOZHKI",
            15 => "TORGOVAYA_MARKA",
            16 => "TSVET_BUMAGI",
            17 => "",
        ),
        "DETAIL_SET_CANONICAL_URL" => "N",
        "DETAIL_SET_VIEWED_IN_COMPONENT" => "Y",
        "DETAIL_STRICT_SECTION_CHECK" => "N",
        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "ELEMENT_SORT_FIELD" => "sort",
        "ELEMENT_SORT_FIELD2" => "id",
        "ELEMENT_SORT_ORDER" => "asc",
        "ELEMENT_SORT_ORDER2" => "desc",
        "FILE_404" => "",
        "FILTER_FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "FILTER_NAME" => "arrFilter",
        "FILTER_PRICE_CODE" => $arUserSale["GROUP"]["PRICE"]["CODE"],
        "FILTER_PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
        "GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
        "GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "4",
        "GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
        "GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
        "GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
        "GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "4",
        "GIFTS_MESS_BTN_BUY" => "Выбрать",
        "GIFTS_SECTION_LIST_BLOCK_TITLE" => "Подарки к товарам этого раздела",
        "GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE" => "N",
        "GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT" => "4",
        "GIFTS_SECTION_LIST_TEXT_LABEL_GIFT" => "Подарок",
        "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
        "GIFTS_SHOW_IMAGE" => "Y",
        "GIFTS_SHOW_NAME" => "Y",
        "GIFTS_SHOW_OLD_PRICE" => "Y",
        "HIDE_NOT_AVAILABLE" => "Y",
        "HIDE_NOT_AVAILABLE_OFFERS" => "Y",
        "IBLOCK_ID" => "9",
        "IBLOCK_TYPE" => "1c_catalog",
        "INCLUDE_SUBSECTIONS" => "Y",
        "LINE_ELEMENT_COUNT" => "3",
        "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
        "LINK_IBLOCK_ID" => "",
        "LINK_IBLOCK_TYPE" => "",
        "LINK_PROPERTY_SID" => "",
        "LIST_BROWSER_TITLE" => "-",
        "LIST_META_DESCRIPTION" => "-",
        "LIST_META_KEYWORDS" => "-",
        "LIST_PROPERTY_CODE" => array(
            0 => "CML2_ARTICLE",
            1 => "",
        ),
        "MESSAGE_404" => "",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Товары",
        "PAGE_ELEMENT_COUNT" => "9",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRICE_CODE" => $arUserSale["GROUP"]["PRICE"]["CODE"],
        "PRICE_VAT_INCLUDE" => "Y",
        "PRICE_VAT_SHOW_VALUE" => "N",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_PROPERTIES" => array(
        ),
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "SECTION_BACKGROUND_IMAGE" => "-",
        "SECTION_COUNT_ELEMENTS" => "Y",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "SECTION_TOP_DEPTH" => "1",
        "SEF_FOLDER" => "/catalog/",
        "SEF_MODE" => "Y",
        "SET_LAST_MODIFIED" => "N",
        "SET_STATUS_404" => "Y",
        "SET_TITLE" => "Y",
        "SHOW_404" => "Y",
        "SHOW_DEACTIVATED" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "SHOW_TOP_ELEMENTS" => "Y",
        "TOP_ELEMENT_COUNT" => "40",
        "TOP_ELEMENT_SORT_FIELD" => "RAND",
        "TOP_ELEMENT_SORT_FIELD2" => "id",
        "TOP_ELEMENT_SORT_ORDER" => "asc",
        "TOP_ELEMENT_SORT_ORDER2" => "desc",
        "TOP_LINE_ELEMENT_COUNT" => "3",
        "TOP_PROPERTY_CODE" => array(
            0 => "CML2_ARTICLE",
            1 => "",
        ),
        "USER_CONSENT" => "N",
        "USER_CONSENT_ID" => "0",
        "USER_CONSENT_IS_CHECKED" => "Y",
        "USER_CONSENT_IS_LOADED" => "N",
        "USE_ALSO_BUY" => "N",
        "USE_COMPARE" => "N",
        "USE_ELEMENT_COUNTER" => "Y",
        "USE_FILTER" => "Y",
        "USE_GIFTS_DETAIL" => "N",
        "USE_GIFTS_MAIN_PR_SECTION_LIST" => "N",
        "USE_GIFTS_SECTION" => "N",
        "USE_MAIN_ELEMENT_SECTION" => "N",
        "USE_PRICE_COUNT" => "N",
        "USE_PRODUCT_QUANTITY" => "N",
        "USE_REVIEW" => "N",
        "USE_STORE" => "N",
        "COMPONENT_TEMPLATE" => ".default",
        "SEF_URL_TEMPLATES" => array(
            "popular" => "/catalog/popular/",
            "new" => "/catalog/new/",
            "actions" => "/catalog/actions/",
            "sections" => "",
            "section" => "#SECTION_CODE_PATH#/",
            "element" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
            "compare" => "compare.php?action=#ACTION_CODE#",
            "smart_filter" => "#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
        ),
        "VARIABLE_ALIASES" => array(
            "compare" => array(
                "ACTION_CODE" => "action",
            ),
        ),
        "USER_TYPE" => CGCUser::getUserType([
            "ID" => $USER->GetID()
        ]),
    ),
    false
);?>

<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");