<?php
	$arPageParams = Array(
		"ADD_PAGE_TEXT_HOLDER" => "N"
	);
	//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	$APPLICATION->SetTitle("Феникс+. Подарки");
	
	
	//$basketID = $_REQUEST["BASKET_ID"];
	//if(!$basketID) {
	//	die;
		//LocalRedirect("/cart/");
	//}
	//$productID = $_REQUEST["PRODUCT_ID"];
	
	//$arBasketItem = CSaleBasket::GetByID($basketID);
	//deb($arBasketItem);
	
	
	// Получение уже приобретенных подарков
	/*$arGiftsIDs = [];
	$dbGiftsParams = CSaleBasket::GetPropsList([
		"SORT" => "ASC",
	], [
		"CODE" => "IS_GIFT",
		"VALUE" => $arBasketItem["ID"],
	]);
	while($arGiftParam = $dbGiftsParams->Fetch()) {
		$arGiftsIDs[] = $arGiftParam["BASKET_ID"];
	}
	
	
	
	$arGifts = [];
	$dbGifts = CSaleBasket::GetList(false, [
		"ID" => $arGiftsIDs
	], false, false, [
		"ID", "PRODUCT_ID", "QUANTITY"
	]);
	while($arGift = $dbGifts->Fetch()) {
		$arGifts[$arGift["PRODUCT_ID"]] = $arGift;
	}
	
	$arProducts = CGCHelper::getIBlockElements([
		"FILTER" => [
			"ID" => $productID
		],
		"NAV" => [
			"nTopCount" => "1"
		],
		"SELECT" => [
			"ID", "NAME", "PROPERTY_PREDLAGAT_PODAROK"
		]
	]);
	if($arProducts && $arProducts[0]) {
		$arProduct = $arProducts[0];
	} else {
		die;
	}
	*/
	//deb($arGifts); die;
	
	
	$giftsCount = $_REQUEST["count"];
	
	$arSelectedGifts = [];
	$dbBasketItems = CSaleBasket::GetList(false, [
		"FUSER_ID" => CSaleBasket::GetBasketUserID(),
		"LID" => SITE_ID,
		"ORDER_ID" => "NULL"
	], false, false, [
		"ID", "PRODUCT_ID", "QUANTITY"
	]);
	while($arBasketItem = $dbBasketItems->Fetch()) {
		$dbBasketItemProp = CSaleBasket::GetPropsList([
			"SORT" => "ASC",
		], [
			"CODE" => "IS_GIFT",
			"BASKET_ID" => $arBasketItem["ID"],
		]);
		$arBasketItemProp = $dbBasketItemProp->Fetch();
		if($arBasketItemProp) {
			$arSelectedGifts[$arBasketItem["PRODUCT_ID"]] = $arBasketItem;
		}
	}
	//deb($arSelectedGifts);
?>
<div class="page-popup">
	<div class="page-popup-content">
		
<div class="gifts-holder">
	<div class="page-inner page-inner--w1">
		<div class="page-heading">
			<h1 class="h1">Выберите подарки</h1>
			<div class="page-description">
				<div class="page-inner page-inner--w2">
					<div class="page-text">
						Вы можете выбрать <b><?php echo $giftsCount; ?></b> подарков.
						<br />
						После выбора подарков нажмите &laquo;Добавить&raquo; внизу страницы для возврата в корзину.
					</div>
				</div>
			</div>
		</div>
		
		<?php
			global $USER;
			$arUserSale = CGCUser::getSaleInfo($USER->GetID());
			$isGiftsFilter = [
				"!PROPERTY_PODAROK" => false,
				">CATALOG_QUANTITY" => 0,
			];
		
			$APPLICATION->IncludeComponent(
				"aheadstudio:catalog.section",
				"gifts",
				Array(		
					"SHOW_ALL_WO_SECTION" => 'Y',
					"IBLOCK_ID" => "9",
					"IBLOCK_TYPE" => "1c_catalog",
					"ELEMENT_SORT_FIELD" => "PROPERTY_CML2_ARTICLE",
					"ELEMENT_SORT_ORDER" => "ASC",
					"FILTER_NAME" => "isGiftsFilter",
					"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
					"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
					"BASKET_URL" => $arParams["BASKET_URL"],
					"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
					"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
					"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
					"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
					"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
					"ELEMENT_COUNT" => $arParams["DISPLAY_AS_SLIDER"] ? 24 : 200,
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
					"DISPLAY_ALL_LINK" => "Y",
				
				
				    "PAGE_ELEMENT_COUNT" => "30",
				    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
				    
				    "DISPLAY_BOTTOM_PAGER" => "N",
				    "DISPLAY_TOP_PAGER" => "N",
				    "HEADING" => [
					    "TITLE" => $arItem["NAME"],
					    "URL" => $arItem["DETAIL_PAGE_URL"],
				    ],
				    "GIFTS_IN_BASKET" => $arSelectedGifts,
				)
			);
		?>
	</div>
	
	<div class="gifts-bar", data-info='{"max": "<?php echo $giftsCount; ?>"}'>
		<div class="page-inner page-inner--w1">
			<div class="gifts-bar-inner">
				<div class="gifts-bar-counter">
					<div class="gifts-bar-counter-title">Выбрано подарков:</div>
					<div class="gifts-bar-counter-nums">
						<span class="gifts-bar-counter-num-current">0</span>
						<span class="gifts-bar-counter-num-sep">/</span>
						<span class="gifts-bar-counter-num-all"><?php echo $giftsCount; ?></span>
					</div>
				</div>
				<div class="gifts-bar-controls">
					<div class="btn btn--blue gifts-add disabled btn--large"><span>Добавить</span></div>
				</div>
			</div>
		</div>
	</div>
</div>
		
	</div>
</div>

<?php
	//require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>