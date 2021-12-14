<?php
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	
	
	global $USER;
	
	$arPost = $_POST;

	if($arPost && isset($arPost["ACTION"]) && $arPost["ACTION"] == "update") {
		
		$arHLiBData = [];
		foreach($arPost as $postItemCode => $postItemValue) {
			if(strpos($postItemCode, "UF_") !== false) {
				$arHLiBData[$postItemCode] = $postItemValue;
			}
		}
		$arResult = [];
		$resultID = CGCHL::update($arParams["HL_ID"], $arPost["ID"], $arHLiBData);
		if($resultID) {
			$arResult["SUCCESS_UPDATE"] = true;
		} else {
			$arResult["ERROR_UPDATE"] = true;
		}
		echo json_encode($arResult);
		die;
		
	}
?>