<?php
	$arPageParams = [
		"HIDE_LEFT_MENU" => "Y",
	];
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
	$APPLICATION->SetTitle("Избранное");
?>

<div class="page-inner page-inner--w1">
	<?php
		global $USER;
		$arUserSale = CGCUser::getSaleInfo($USER->GetID());
		
		$arProductsFilter = [
			"ID" => СGCBookmark::getFavorites()
		];
		
		if($arProductsFilter["ID"]):
	$APPLICATION->IncludeComponent(
		"aheadstudio:catalog.section",
		"common",
		Array(		
								"SHOW_ALL_WO_SECTION" => 'Y',
								"IBLOCK_ID" => "9",
								"IBLOCK_TYPE" => "1c_catalog",
								"ELEMENT_SORT_FIELD" => "PROPERTY_CML2_ARTICLE",
								"ELEMENT_SORT_ORDER" => "ASC",
								"FILTER_NAME" => "arProductsFilter",
								"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
								"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
								"BASKET_URL" => $arParams["BASKET_URL"],
								"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
								"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
								"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
								"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
								"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
								"ELEMENT_COUNT" => ($arParams["DISPLAY_AS_SLIDER"] ? 24 : 200),
								"LINE_ELEMENT_COUNT" => $arParams["TOP_LINE_ELEMENT_COUNT"],
								"PROPERTY_CODE" => ["CML2_ARTICLE"],
								"PROPERTY_CODE_MOBILE" => $arParams["TOP_PROPERTY_CODE_MOBILE"],
								"PRICE_CODE" => array(
									0 => $arUserSale["GROUP"]["PRICE"]["CODE"],
								),
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
								'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
						
								'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
		
		    "PAGE_ELEMENT_COUNT" => "12",
		    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
		    
		    "DISPLAY_BOTTOM_PAGER" => "Y",
		    "DISPLAY_TOP_PAGER" => "N",
		    
		    "TEMPLATE" => [
			    "DISPLAY_REMOVE_FROM_FAVORITES" => "Y",
		    ]
		)
	); ?>
	<?php //if($USER->isAuthorized()): ?>
		<div class="page-text">
			<div class="right">
				<span class="btn btn--red move2basket", data-ids='<?php echo json_encode($arProductsFilter["ID"]); ?>'>Добавить все товары в корзину</span>
			</div>
		</div>
	<?php //endif; ?>

<?php else: ?>
	<div class="basket-empty">
		<div class="basket-empty-title">Список пуст.</div>
		<a href="/catalog/" class="link link--larrow"><span class="link-icon"></span> <span class="link-text">Перейти к каталогу</span></a>
	</div>
<?php endif; ?>
	

	
</div>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>