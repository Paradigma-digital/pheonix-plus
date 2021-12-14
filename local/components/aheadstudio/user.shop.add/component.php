<?php
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	
	global $USER;
	
	$arPost = $_POST;

	if($arPost && isset($arPost["ACTION"]) && $arPost["ACTION"] == "add") {
		
		$arHLiBData = [];
		foreach($arPost as $postItemCode => $postItemValue) {
			if(strpos($postItemCode, "UF_") !== false) {
				$arHLiBData[$postItemCode] = $postItemValue;
			}
		}
		
		$arResult = [];
		$resultID = CGCHL::add($arParams["HL_ID"], $arHLiBData);
		if($resultID) {
			$arResult["SUCCESS_ADD"] = true;
			$arResult["RELOAD"] = true;
		} else {
			$arResult["ERROR_ADD"] = true;
		}
		echo json_encode($arResult);
		die;
		
	} else {
		
		$arUserProfiles = CGCUser::getProfiles($USER->GetID());
		$arResult = [
			"PROFILES" => $arUserProfiles,
		];
		$this->IncludeComponentTemplate();
		
	}

?>