<?php
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	
	
	global $USER;
	
	$arUserProfiles = CGCUser::getProfiles($USER->GetID());
	$arUserProfilesIDs = [];
	foreach($arUserProfiles as $arUserProfileItem) {
		$arUserProfilesIDs[] = $arUserProfileItem["COMPANY_ID"];
	}
	
	$arShops = CGCHL::getList($arParams["HL_ID"], [
		"FILTER" => [
			"UF_VLADELETS" => $arUserProfilesIDs,
		],
		"SELECT" => [
			"ID", "UF_*",
		],
		"ORDER" => [
			"UF_NAIMENOVANIE" => "ASC",
		]
	]);
	//deb($arShops);
	
	$arResult = [
		"SHOPS" => $arShops,
		"PROFILES" => $arUserProfiles,
	];
	
	$this->IncludeComponentTemplate();
?>