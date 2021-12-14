<?php
	//deb($arResult);
	$dbOrderProps = CSaleOrderPropsValue::GetOrderProps($arResult["ID"]);
	$arResult["PROPS"] = [];
	while($arOrderProp = $dbOrderProps->Fetch()) {
		//deb($arOrderProp, false);
		if($arOrderProp["CODE"] == "COMPANY_ID") {
			$arResult["PROPS"]["COMPANY"] = CGCHelper::getHlElements(2, [
				"UF_XML_ID" => $arOrderProp["VALUE"]
			])[0];
		} else if(($arOrderProp["CODE"] == "1C_ACCOUNT") || $arOrderProp["CODE"] == "1C_DATE" || $arOrderProp["CODE"] == "NDS_TYPE" || $arOrderProp["CODE"] == "CANCELLED" || $arOrderProp["CODE"] == "DELIVERY_LINK") {
			$arResult["PROPS"][$arOrderProp["CODE"]] = $arOrderProp["VALUE"];
		} else {
			continue;
		}
		
		
	}
	//deb($arResult["COMPANY"]);
	
	foreach($arResult["BASKET"] as &$arBasketItem) {
		$arProduct = CCatalogProduct::GetByID($arBasketItem["PRODUCT_ID"]);
		$arBasketItem["AVAILABLE_COUNT"] = ($arProduct ? $arProduct["QUANTITY"] : "");
	}
	
	
	//deb($arResult);
	//echo $arResult["PROPS"]["NDS_TYPE"];
	$arResult["NDS_INFO"] = CGCUser::getSaleInfo(false, $arResult["PROPS"]["NDS_TYPE"]);
	
	//deb($arResult["NDS_INFO"]);
	
	if($arResult["NDS_INFO"]["BASKET_COL_VAT_VALUE"]["DISPLAY"] == "Y") {
		foreach ($arResult["BASKET"] as $k => &$arItem) {
			//deb($arItem, false);
			//$arProductPrice = CPrice::GetByID($arItem["PRODUCT_PRICE_ID"]);
			$arItem["SUM_VALUE"] = $arItem["QUANTITY"] * $arItem["PRICE"];
			if($arResult["NDS_INFO"]["TYPE"] == "OVER") {
				$arItem["NDS"] = round($arItem["SUM_VALUE"] * $arItem["VAT_RATE"], 2);
				$arItem["NDS_FORMATED"] = CurrencyFormat($arItem["NDS"], "RUB");
				$arItem["SUM_FULL_PRICE_FORMATED"] = CurrencyFormat(round($arItem["NDS"] + $arItem["SUM_VALUE"], 2), "RUB");
			} else {
				
				$arItem["NDS_FORMATED"] = CurrencyFormat(($arItem["SUM_VALUE"] / (1 + $arItem["VAT_RATE"]) * $arItem["VAT_RATE"]), "RUB");
				
			}
			
			//$arItem["PRICE_FORMATED"] = CurrencyFormat($arProductPrice["PRICE"], "RUB");
			//$arItem["SUM"] = CurrencyFormat(($arProductPrice["PRICE"] * $arItem["QUANTITY"]), "RUB");
	
		}
	}
	
	
	
	if($arResult["STATUS_ID"] == "F" || $arResult["STATUS_ID"] == "FP") {
		$arResult["UPD"] = GCDocs::getUPD([
			"ORDER_ID" => $arResult["ID"],
		]);

		//deb($arResult["UPD"]);
	}

	//deb($arResult["UPD"], false);
	
?>