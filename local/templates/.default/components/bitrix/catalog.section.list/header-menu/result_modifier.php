<?php
$arResultSections = array();
$restrict = true;
if (Preorder::inPreorderGroup()) {
    $restrict = false;
}

foreach ($arResult["SECTIONS"] as $arSection) {
    if($restrict && $arSection["ID"] == 1006) continue;
    $dbSectionItems = CIBlockElement::GetList(
        false,
        array(
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $arSection["IBLOCK_ID"],
            "SECTION_ID" => $arSection["ID"],
            ">CATALOG_QUANTITY" => "0",
            "INCLUDE_SUBSECTIONS" => "Y"
        ),
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