<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;

if($arParams["NDS_INFO"]["BASKET_COL_VAT_VALUE"]["DISPLAY"] == "Y") {
	foreach ($arResult["GRID"]["ROWS"] as $k => &$arItem) {
		//deb($arItem, false);
		//$arProductPrice = CPrice::GetByID($arItem["PRODUCT_PRICE_ID"]);
		
		if($arParams["NDS_INFO"]["TYPE"] == "OVER") {
			$arItem["NDS"] = round($arItem["SUM_VALUE"] * $arItem["VAT_RATE"], 2);
			$arItem["NDS_FORMATED"] = CurrencyFormat($arItem["NDS"], "RUB");
			$arItem["SUM_FULL_PRICE_FORMATED"] = CurrencyFormat(round($arItem["NDS"] + $arItem["SUM_VALUE"], 2), "RUB");
		} else {
			$arItem["NDS_FORMATED"] = CurrencyFormat(round($arItem["VAT_VALUE"] * $arItem["QUANTITY"], 2), "RUB");
		}
		
		//$arItem["PRICE_FORMATED"] = CurrencyFormat($arProductPrice["PRICE"], "RUB");
		//$arItem["SUM"] = CurrencyFormat(($arProductPrice["PRICE"] * $arItem["QUANTITY"]), "RUB");

	}
}
unset($arItem);
//deb($arResult, false);






// Подарки
/*
$arResultGridRows = [];
$arResult["GIFTS"] = [];
$arItemIDsQuantity = [];
foreach($arResult["GRID"]["ROWS"] as $arItem) {
	$arResultGridRowItem = $arItem;
	
	$arResultGridRowItem["GIFTS"] = [];	
	if($arResultGridRowItem["PROPS_ALL"]["LINKED_PRODUCT"]) {
		if(!$arResult["GIFTS"][$arResultGridRowItem["PROPS_ALL"]["LINKED_PRODUCT"]["VALUE"]]) {
			$arResult["GIFTS"][$arResultGridRowItem["PROPS_ALL"]["LINKED_PRODUCT"]["VALUE"]] = [];
		}
		$arResult["GIFTS"][$arResultGridRowItem["PROPS_ALL"]["LINKED_PRODUCT"]["VALUE"]][] = $arResultGridRowItem;
	} else {
		$addGifts = CIBlockElement::GetProperty(9, $arResultGridRowItem["PRODUCT_ID"], ["SORT" => "ASC"], ["CODE" => "PREDLAGAT_PODAROK"])->Fetch();
		if($addGifts && $addGifts["VALUE"]) {
			$arResultGridRowItem["ADD_GIFTS"] = "Y";
		}
		$arItemIDsQuantity[$arItem["ID"]] = $arItem["QUANTITY"];
		$arResultGridRows[] = $arResultGridRowItem;
	}
}
$restartFlag = false;
foreach($arResult["GIFTS"] as $linkedBasketID => $arGiftItems) {
	$count = 0;
	foreach($arGiftItems as $arGiftItem) {
		$count += $arGiftItem["QUANTITY"];
	}
	unset($arGiftItem);
	if(!in_array($linkedBasketID, array_keys($arItemIDsQuantity)) || ($arItemIDsQuantity[$linkedBasketID] && $arItemIDsQuantity[$linkedBasketID] != $count)) {
		foreach($arGiftItems as $arGiftItem) {
			CSaleBasket::Delete($arGiftItem["ID"]);
		}
		$restartFlag = true;
	}
}
if($restartFlag) {
	LocalRedirect("/cart/");
	die;
}
$arResult["GRID"]["ROWS"] = $arResultGridRows;
*/


