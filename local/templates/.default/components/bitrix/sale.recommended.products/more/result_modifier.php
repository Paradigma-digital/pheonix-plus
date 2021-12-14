<?
foreach ($arResult["ITEMS"] as &$arItem) {
    if (CSite::InGroup([preorder_id_group])) {
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
