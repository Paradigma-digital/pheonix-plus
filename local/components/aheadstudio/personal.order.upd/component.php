<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
	
	$arResult = [];
	
	$arResult["INFO"] = GCDocs::getUPDInfo([
		"ID" => $arParams["ID"],
	]);
	$arResult["ITEMS"] = GCDocs::getUPDProducts([
		"UPD_ID" => $arParams["ID"],
	]);
	
	//deb($arResult, false);
	
	$this->IncludeComponentTemplate();
?>