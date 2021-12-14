<?
$restrict = true;
$depth = 1;
$arr = [];
if (!empty($arResult['SECTIONS'])) {
    $GLOBALS['SHOW_ELEMENTS_OF_CATALOG'] = false;
}

if (Preorder::inPreorderGroup()) {
    $restrict = false;
}

if($arResult["SECTION"]["PATH"][0]["ID"] == 1006){
	$arr[] = [
		"LOGIC" => "OR",
		["PROPERTY_PREDZAKAZ_VALUE" => "Да"],
		["PROPERTY_OSNOVNAYA_KOLLEKTSIYA_VALUE" => "Да"]
	];
}
foreach ($arResult["SECTIONS"] as $arSection) {
	$arFilter =  array(
		"ACTIVE" => "Y",
		"IBLOCK_ID" => $arSection["IBLOCK_ID"],
		"SECTION_ID" => $arSection["ID"],
		">CATALOG_QUANTITY" => "0",
		"INCLUDE_SUBSECTIONS" => "Y"
	) + $arr;

    $dbSectionItems = CIBlockElement::GetList(
        false,
        $arFilter,
        false,
        false,
        false
    );

    $cn = $dbSectionItems->SelectedRowsCount();
    if ($cn > 0) {
        $arSection["ELEMENT_CNT"] = $cn;
        $arResultSections[] = $arSection;
    }
}

$arResult["SECTIONS"] = $arResultSections;