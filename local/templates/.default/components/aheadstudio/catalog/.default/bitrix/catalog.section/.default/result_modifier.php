<?
foreach ($arResult["ITEMS"] as &$arItem) {
    $arItem["SHOW_MAIN_COLLECTION"] = "N";
    $arItem["SHOW_PRE_ORDER"] = "N";
	
    if (Preorder::inPreorderGroup()) {
        $props = [
            "PROPERTIES" => [
                "PRE_ORDER" => $arItem['PROPERTIES']["PREDZAKAZ"],
                "MAIN_COLLECTION" => $arParams["PREORDER"] == "Y" ? $arItem['PROPERTIES']["OSNOVNAYA_KOLLEKTSIYA"] : ""
            ],
            "PRICES" => $arItem["PRICES"]
        ];

        $arItem = array_merge($arItem, Preorder::updateCatalog($props));
    }
    CGCCatalog::getProductDiscount($arItem);
}