<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
?>
<div class="promo-blocks">
	<?php foreach($arResult["ITEMS"] as $arItem): ?>
		<div class="promo-block-item">
			<?php if($arItem["DISPLAY_PROPERTIES"]["IS_MAIN"]): ?>
				<div class="promo-block-item-banner promo-block-item-banner--large">
					<img src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"]; ?>" />
				</div>
			<?php else: ?>
				<?php if($arItem["PREVIEW_PICTURE"]): ?>
					<div class="promo-block-item-banner promo-block-item-banner--small">
						<img src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"]; ?>" />
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<div class="promo-block-item-content">
				<?php if($arItem["DISPLAY_PROPERTIES"]["IS_MAIN"]): ?>
					<div class="promo-block-item-content-text">
						<div class="page-inner page-inner--w2">
							<div class="page-text">
								<?php //echo $arItem["PREVIEW_TEXT"]; ?>
							</div>
						</div>
						
						<div class="">	
							<div class="gifts-teaser">
								<div class="gifts-teaser-inner">
									<div class="gifts-teaser-left wow wow--btt">
										<div class="gifts-teaser-title">Феникс+ объявляет<br />Новогоднюю акцию <br /><span>&laquo;Волшебное настроение&raquo;</span></div>
									</div>
									<div class="gifts-teaser-right wow wow--btt">
										<div class="gifts-teaser-dates">с 01 по 31 декабря 2019 года</div>
										<div class="gifts-teaser-text">Закажите товары, участвующие в Акции и получите в подарок Новогодние украшения и приятные товары-комплименты!</div>
									</div>
								</div>
							</div>
							
							<div class="gifts-features">
								<div class="gifts-features-items">
									<div class="gifts-feature-item wow wow--btt">
										<div class="gifts-feature-item-icon">
											<img src="/upload/gifts/icons/1.svg" />
										</div>
										<div class="gifts-feature-item-title">1 товар = <b>1 подарок</b><br />в заказе</div>
									</div>
									<div class="gifts-feature-item wow wow--btt">
										<div class="gifts-feature-item-icon">
											<img src="/upload/gifts/icons/2.svg" />
										</div>
										<div class="gifts-feature-item-title">Подарок <b>на выбор</b><br />из списка</div>
									</div>
									<div class="gifts-feature-item wow wow--btt">
										<div class="gifts-feature-item-icon">
											<img src="/upload/gifts/icons/3.svg" />
										</div>
										<div class="gifts-feature-item-title">Клиентская скидка<br />на товары по акции<br /><b>сохраняется</b></div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				<?php else: ?>
					<div class=" wow wow--opacity">
					<?php
						global $USER;
						$arUserSale = CGCUser::getSaleInfo($USER->GetID());
						
						$GLOBALS["blockProductsFilter"] = [
							"PROPERTY_PREDLAGAT_PODAROK" => $arItem["DISPLAY_PROPERTIES"]["BLOCK_ID"]["VALUE"],
							">CATALOG_QUANTITY" => 0,
						];
						$APPLICATION->IncludeComponent(
							"aheadstudio:catalog.section",
							"promo",
							Array(		
								"SHOW_ALL_WO_SECTION" => 'Y',
								"IBLOCK_ID" => "9",
								"IBLOCK_TYPE" => "1c_catalog",
								"ELEMENT_SORT_FIELD" => "PROPERTY_CML2_ARTICLE",
								"ELEMENT_SORT_ORDER" => "ASC",
								"FILTER_NAME" => "blockProductsFilter",
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
								"DISPLAY_ALL_LINK" => "Y",
							
							
							    "PAGE_ELEMENT_COUNT" => "12",
							    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
							    
							    "DISPLAY_BOTTOM_PAGER" => "N",
							    "DISPLAY_TOP_PAGER" => "N",
							    "HEADING" => [
								    "TITLE" => "Товары, участвующие в акции",
								    "URL" => $arItem["DETAIL_PAGE_URL"],
							    ],
							    "DISPLAY_AS_SLIDER" => $arParams["DISPLAY_AS_SLIDER"],
							)
						);
						
						
						$GLOBALS["blockGiftsFilter"] = [
							"PROPERTY_PODAROK" => $arItem["DISPLAY_PROPERTIES"]["BLOCK_ID"]["VALUE"],
							">CATALOG_QUANTITY" => 0,
						];
						$APPLICATION->IncludeComponent(
							"aheadstudio:catalog.section",
							"promo",
							Array(		
								"SHOW_ALL_WO_SECTION" => 'Y',
								"IBLOCK_ID" => "9",
								"IBLOCK_TYPE" => "1c_catalog",
								"ELEMENT_SORT_FIELD" => "PROPERTY_CML2_ARTICLE",
								"ELEMENT_SORT_ORDER" => "ASC",
								"FILTER_NAME" => "blockGiftsFilter",
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
								"DISPLAY_ALL_LINK" => "Y",
							
							
							    "PAGE_ELEMENT_COUNT" => "30",
							    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
							    
							    "DISPLAY_BOTTOM_PAGER" => "N",
							    "DISPLAY_TOP_PAGER" => "N",
							    "HEADING" => [
								    "TITLE" => "Подарки"
							    ],
							    "DISPLAY_AS_SLIDER" => "Y",
							    "HIDE_CONTROLS" => "Y",
							)
						);
					?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>