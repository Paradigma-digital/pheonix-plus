<?php
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	
	
	$arShops = CGCHL::getList($arParams["HL_ID"], [
		"FILTER" => [],
		"SELECT" => [
			"ID", "UF_*",
		],
		"ORDER" => [
			"UF_NAIMENOVANIE" => "ASC",
		]
	]);
	
	// Cities
	$arCities = [];
	foreach($arShops as $arShopItem) {
		$arShopItem["UF_GOROD"] = trim($arShopItem["UF_GOROD"]);
		if($arShopItem["UF_GOROD"] && !in_array($arShopItem["UF_GOROD"], $arCities)) {
			$arCities[] = $arShopItem["UF_GOROD"];
		}
	}
	sort($arCities);
	
	$arResult = [
		"SHOPS" => $arShops,
		"CITIES" => $arCities,
	];
	
	$this->IncludeComponentTemplate();
?>