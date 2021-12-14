<?php
	$arResultSections = Array();
	foreach($arResult["SECTIONS"] as $arSection) {
		//deb($arSection);
		$dbSectionItems = CIBlockElement::GetList(
			false,
			Array(
				"ACTIVE" => "Y",
				"IBLOCK_ID" => $arSection["IBLOCK_ID"],
				"SECTION_ID" => $arSection["ID"],
				">CATALOG_QUANTITY" => "0",
				"INCLUDE_SUBSECTIONS" => "Y",
			),
			false,
			false,
			false
		);
		//$arSectionItems = $dbSectionItems->Fetch();
		if($dbSectionItems->SelectedRowsCount()) {
			//echo $arSection["NAME"]." – ".$arSectionItems["CNT"];
			$arSection["ELEMENT_CNT"] = $dbSectionItems->SelectedRowsCount();
			$arResultSections[] = $arSection;
		}
		
		
	}
	$arResult["SECTIONS"] = $arResultSections;
?>