<?php
	define("NO_KEEP_STATISTIC", true);
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

	CModule::IncludeModule("iblock");
	CModule::IncludeModule("catalog");
	CModule::IncludeModule("sale");

	global $USER;
	$arUserSale = CGCUser::getSaleInfo($USER->GetID());

	$arBasketParams = [];
	if($arUserSale["NDS"]["TYPE"] == "OVER") {
		$arBasketParams["PRODUCT_PROVIDER_CLASS"] = "CCatalogPhoenixProductProvider";
		$arBasketParams["CUSTOM_PRICE"] = "Y";
	}
	
	$quantity = (int)($_REQUEST["quantity"]);
    $barcode = (int)($_REQUEST["barcode"]);
    
    $arResult = [];
    
    // Минимальная проверка
    if(!$quantity || !$barcode) {
	    $arResult["message"] = "Пожалуйста, введите артикул или шк товара";
	    $arResult["result"] = -1;
	    echo json_encode($arResult);
	    die();
    }
    
    // Ищем товар по его ШК
    $arProduct = CGCHelper::getIBlockElements([
	    "FILTER" => [
		    [
			    "LOGIC" => "OR",
			    ["PROPERTY_CML2_BAR_CODE" => $barcode],
			    ["PROPERTY_CML2_ARTICLE" => $barcode]
		    ],
		    "ACTIVE" => "Y",
		    "GLOBAL_ACTIVE" => "Y",
	    ],
	    "NAV" => [
		    "nTopCount" => "1"
	    ],
	    "SELECT" => [
		    "ID", "NAME", "DETAIL_PAGE_URL", "CATALOG_QUANTITY", "IBLOCK_ID",
	    ]
    ]);
    if(!$arProduct) {
	    $arResult["message"] = "Товар с шк/арт. <b>".$barcode."</b> не найден";
	    $arResult["result"] = -1;
	    echo json_encode($arResult);
	    die();
    }
    
    $arProduct = $arProduct[0];
    
    

    // Минимальное количество
	$dbProductProp = CIBlockElement::GetProperty(
		$arProduct["IBLOCK_ID"],
		$arProduct["ID"],
		[
			"SORT" => "ASC",
		],
		[
			"CODE" => "CML2_TRAITS",
		]
    );
    while($arProductProp = $dbProductProp->Fetch()) {
	    if($arProductProp["DESCRIPTION"] == "КратностьОтгрузки") {
		    $quantity = $arProductProp["VALUE"];
		   	break;
	    }
    }
    
    
    
    // Массив информации о товаре
    $arResult["product"] = [
	    "id" => $arProduct["ID"],
	    "name" => $arProduct["NAME"],
	    "url" => $arProduct["DETAIL_PAGE_URL"],
    ];
	
	
	// Проверяем наличие
	if($arProduct["CATALOG_QUANTITY"] <= 0) {
		$arResult["result"] = -1;
		$arResult["message"] = "Товар ".$arResult["product"]["name"]." отсутствует";
		echo json_encode($arResult);
		die();
	}
	
    
    // Пробуем добавить товар в корзину
    $arResult["result"] = Add2BasketByProductID($arProduct["ID"], $quantity, $arBasketParams, array());
    if($arResult["result"]) {
	    $arResult["message"] = "Товар <a class='link link--black' target='_blank' href='".$arResult["product"]["url"]."'>".$arResult["product"]["name"]."</a> успешно добавлен в корзину";
    } else {
	    $arResult["result"] = -1;
		$arResult["message"] = "Ошибка добавления товара ".$arResult["product"]["name"]." в корзину";
    }
    
    echo json_encode($arResult);
    die();
?>

