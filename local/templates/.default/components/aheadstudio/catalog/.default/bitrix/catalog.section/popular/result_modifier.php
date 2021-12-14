<?
foreach ($arResult["ITEMS"] as &$arItem) {
    if (Preorder::inPreorderGroup()) {
        $props = [
            "PROPERTIES" => [
                "PRE_ORDER" => $arItem['PROPERTIES']["PREDZAKAZ"],
                "MAIN_COLLECTION" => $arItem['PROPERTIES']["OSNOVNAYA_KOLLEKTSIYA"]
            ],
            "PRICES" => $arItem["PRICES"]
        ];

        $arItem = array_merge($arItem, Preorder::updateCatalog($props));
    }
    CGCCatalog::getProductDiscount($arItem);
}