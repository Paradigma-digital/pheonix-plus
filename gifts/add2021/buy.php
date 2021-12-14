<?php
	define("NO_KEEP_STATISTIC", true);
	define("NO_AGENT_CHECK", true);
	define('PUBLIC_AJAX_MODE', true);
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"]="N";
	$APPLICATION->ShowIncludeStat = false;
	CModule::IncludeModule("iblock");
	CModule::IncludeModule("catalog");
	CModule::IncludeModule("sale");


	$arParams = $_REQUEST;

	
	
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
			CSaleBasket::Delete($arBasketItem["ID"]);
		}
	}	
	
	// Удаление уже приобретенных подарков
	/*$dbGiftsParams = CSaleBasket::GetPropsList([
		"SORT" => "ASC",
	], [
		"CODE" => "LINKED_PRODUCT",
		"VALUE" => $arParams["base_product"],
	]);
	while($arGiftParam = $dbGiftsParams->Fetch()) {
		CSaleBasket::Delete($arGiftParam["BASKET_ID"]);
	}*/
	
	
	
	$arBasketProps = [
		[
			"NAME" => "Является подарком",
			"CODE" => "IS_GIFT",
			"VALUE" => "Y",
			"SORT" => 100,
		]
	];
	$arBasketParams = [
		"CUSTOM_PRICE" => "Y",
		"PRICE" => "0",
		"PRODUCT_PROVIDER_CLASS" => "CCatalogPhoenixGiftProvider", 
	];
	//deb($arParams); die;
	foreach($arParams["items"] as $arItem) {
		echo Add2BasketByProductID($arItem["id"], $arItem["quantity"], array_merge($arBasketParams, [
			"DISCOUNT_PRICE" => $arItem["price"],
		]), $arBasketProps);
	}
	

	
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>