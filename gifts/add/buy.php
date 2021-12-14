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
	
	
	// Удаление уже приобретенных подарков
	$dbGiftsParams = CSaleBasket::GetPropsList([
		"SORT" => "ASC",
	], [
		"CODE" => "LINKED_PRODUCT",
		"VALUE" => $arParams["base_product"],
	]);
	while($arGiftParam = $dbGiftsParams->Fetch()) {
		CSaleBasket::Delete($arGiftParam["BASKET_ID"]);
	}
	
	
	
	$arBasketProps = [
		[
			"NAME" => "Связанный товар",
			"CODE" => "LINKED_PRODUCT",
			"VALUE" => $arParams["base_product"],
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