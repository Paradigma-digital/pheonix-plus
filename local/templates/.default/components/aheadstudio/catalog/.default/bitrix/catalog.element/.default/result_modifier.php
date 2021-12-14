<?
CGCCatalog::getProductDiscount($arResult);
$arResult["SHOW_MAIN_COLLECTION"] = "N";
$arResult["SHOW_PRE_ORDER"] = "N";

if (Preorder::inPreorderGroup()) {
    $props = [
        "PROPERTIES" => [
            "PRE_ORDER" => $arResult['PROPERTIES']["PREDZAKAZ"],
            "MAIN_COLLECTION" => $arResult['PROPERTIES']["OSNOVNAYA_KOLLEKTSIYA"]
        ],
        "PRICES" => $arResult["PRICES"]
    ];

    $arResult = array_merge($arResult, Preorder::updateCatalog($props));
}

if ($arResult['PROPERTIES']["FILES"]["VALUE"]) {
    foreach ($arResult['PROPERTIES']["FILES"]["DESCRIPTION"] as $i => $fileDescription) {
        if (strstr($fileDescription, "panorama")) {
            $arResult["3D"] = CFile::GetPath($arResult['PROPERTIES']["FILES"]["VALUE"][$i]);
        }
    }
}

$arResult["YOUTUBE_VIDEO"] = [];
foreach ($arResult['PROPERTIES']['CML2_TRAITS']["VALUE"] as $traitIndex => $traitValue) {
    if ($arResult['PROPERTIES']['CML2_TRAITS']["DESCRIPTION"][$traitIndex] == "YouTubeID") {
        $arResult["YOUTUBE_VIDEO"][] = $traitValue;
    }
}