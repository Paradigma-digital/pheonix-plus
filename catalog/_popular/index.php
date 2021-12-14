<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "канцтовары оптом, каталог, офисная продукция, подарочная упаковка, купить школьную продукцию, купить офисную продукцию, каталог канцелярских товаров, канцелярия, магазин феникс, товары феникс+, канц товары, тетрадь, дневник, пенал, папка, рюкзак, портфель, ранец, сумка, клач, альбом, ручка, визитница, датированный, недатированный, ежедневник, записная книжка, скетчпад, расписание, обложка документы");
$APPLICATION->SetPageProperty("description", "Канцтовары оптом. Каталог компании Феникс +. Российский производитель канцелярии, товаров для школы и офиса");
$APPLICATION->SetPageProperty("keywords", "офисная продукция, развивающая продукция, школьников, студентов, офисная продукция, хобби, творчество, развивающая продукция, тематическая, подарочная упаковка, высокое качество, программы лояльности, широкий ассортимент, гарантия качества, канцтовары, канцелярия");
$APPLICATION->SetPageProperty("title", "Каталог канцтоваров Феникс+. Школьный и офисный каталог и канцтовары.");
$APPLICATION->SetTitle("Канцтовары Феникс+, оптовая продажа и каталог канцтоваров");
?>
<div class="page-inner page-inner--w1">
	
	
	    <div class="catalog-info">
	<?$APPLICATION->ShowViewContent('section_title');?>
	
	<div class="catalog-sort">
	    <div class="catalog-sort-item catalog-sort-item--large"><span class="catalog-sort-item-title">Сортировать по</span>
		<select name='sort' class="form-item--select" onchange="document.location = '<?=$APPLICATION->GetCurPage()?>?sort='+$(this).val();">
		    <? foreach (sortClass::$points as $kpoint => $point) { ?>
			<option<? if ($kpoint == sortClass::getValue()) { ?> selected=""<? } ?> value="<?=$kpoint?>"><?=$point['TEXT']?></option>
		    <? } ?>
		</select>
	    </div>
	    
	    <div class="catalog-sort-item catalog-sort-item--small"><span class="catalog-sort-item-title">показывать по</span>
		<select class="form-item--select" onchange="document.location = '<?=$APPLICATION->GetCurPage()?>?perpage='+$(this).val();">
		    <? foreach (perPageClass::$points as $kpoint => $point) { ?>
			<option<? if ($kpoint == perPageClass::getValue()) { ?> selected=""<? } ?> value="<?=$kpoint?>"><?=$point?></option>
		    <? } ?>
		</select>
	    </div><a href="#filter" data-type="inline" class="catalog-filter-mobile popup"><span class="catalog-filter-mobile-title">Фильтр</span><span class="catalog-filter-mobile-icon"><span class="catalog-filter-mobile-icon-item catalog-filter-mobile-icon-item--1"></span><span class="catalog-filter-mobile-icon-item catalog-filter-mobile-icon-item--2"></span><span class="catalog-filter-mobile-icon-item catalog-filter-mobile-icon-item--3"></span></span></a>
	</div>
    </div>
	
	
	
<?
	$arPopularFilter = Array(
		"!PROPERTY_KHIT" => false
	);
	$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	".default",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "N",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => "",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arPopularFilter",
		"HIDE_NOT_AVAILABLE" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
		"IBLOCK_ID" => "9",
		"IBLOCK_TYPE" => "1c_catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => array(),
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_LIMIT" => "5",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "18",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array("BASE"),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array("",""),
		"PROPERTY_CODE_MOBILE" => array(),
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array("",""),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N"
	)
);?>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>