<?
$arInfoParams = [
    "Штрихкод единицы товара" => "BARCODE",
    "ВидыУпаковок" => "IN_PACK",
    "КратностьОтгрузки" => "MULTIPLE",
];

foreach ($arResult["ITEMS"] as &$arItem) {
    $arItem["SHOW_MAIN_COLLECTION"] = "N";
    $arItem["SHOW_PRE_ORDER"] = "N";
    CGCCatalog::getProductDiscount($arItem);

    $arItem["PRODUCT_INFO"] = [
        "IN_PACK" => false,
        "BARCODE" => false,
        "MULTIPLE" => false,
    ];

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

    foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
        if ($arInfoParams[$arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval]]) {
            $arItem["PRODUCT_INFO"][$arInfoParams[$arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval]]] = $val;
        }
    }
}