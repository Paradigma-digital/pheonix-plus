<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?php
	$arResult["FORM_HEADER"] = str_replace('method="POST"', 'method="POST" class="form"', $arResult["FORM_HEADER"]);
	foreach($arResult["QUESTIONS"] as &$arQuestion) {
		switch($arQuestion["STRUCTURE"][0]["FIELD_TYPE"]) {
			case "email":
				$arQuestion["HTML_CODE"] = str_replace('type="text"', 'type="email"', $arQuestion["HTML_CODE"]);
			break;
		}
	}
	if($arParams["DEFAULT_VALUES"]) {
		foreach($arParams["DEFAULT_VALUES"] as $defaultFieldName => $defaultFieldVal) {
			foreach($arResult["QUESTIONS"] as $fieldName => &$arQuestion) {
				if($fieldName == $defaultFieldName) {
					$arQuestion["HTML_CODE"] = str_replace('value=""', 'value="'.$defaultFieldVal.'"', $arQuestion["HTML_CODE"]);
				}
			}
		}
	}
	
?>