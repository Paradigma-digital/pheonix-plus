<?php

$arResult['CNT'] = 0;
$customTotal = 0;
if (!empty($arResult['CATEGORIES']['READY']))
{
	foreach ($arResult['CATEGORIES']['READY'] as $good)
	{
		//deb($good, false);
		/*if($arParams["NDS_INFO"]["BASKET_COL_SUMMARY_VALUE"]["DISPLAY"] == "Y") {
			$arProductPrice = CPrice::GetByID($good["PRODUCT_PRICE_ID"]);
			$customTotal += $arProductPrice["PRICE"] * $good["QUANTITY"];
		}*/
		
		$customTotal += $good["SUM_VALUE"];
		$arResult['CNT'] += $good['QUANTITY'];
	}
}
if($customTotal) {
	$arResult['TOTAL_PRICE'] = CurrencyFormat($customTotal, "RUB");
}
//deb($arResult);