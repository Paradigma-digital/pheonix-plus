<?
class UserDataHiBMore extends CUserTypeInteger {
	function GetUserTypeDescription() {
		return array(
			"USER_TYPE_ID" => "hibmore",
			"CLASS_NAME" => "UserDataHiBMore",
			"DESCRIPTION" => "Множественная привязка к справочнику",
			"BASE_TYPE" => "int",
		);
 	}
 	

	function GetEditFormHTML($arUserField, $arHtmlControl)
	{
		$arElements = CGCHelper::getHlElements(2);
		
		//deb($arElements);
		
		if($arUserField["ENTITY_VALUE_ID"]<1 && strlen($arUserField["SETTINGS"]["DEFAULT_VALUE"])>0)
			$arHtmlControl["VALUE"] = htmlspecialcharsbx($arUserField["SETTINGS"]["DEFAULT_VALUE"]);
		$arHtmlControl["VALIGN"] = "middle";
		
		$optionsStr = '';
		$currentName = "";
		foreach($arElements as $arItem) {
			if($arItem["ID"] == $arHtmlControl["VALUE"]) {
				$selected = "selected";
				$currentName = $arItem["UF_NAME"];
			} else {
				$selected = "";
			}
			$optionsStr .= '<option '.$selected.' value="'.$arItem["ID"].'">'.$arItem["UF_NAME"].'</option>';
		}
		return 
			//'<input type="text" name="'.$arHtmlControl["NAME"].'" value="'.$arHtmlControl["VALUE"].'" />'.
			//'<select onchange="this.previousSibling.value = this.value;">'.$optionsStr.'</select>'
			'<datalist id="list_'.$arHtmlControl["NAME"].'">'.$optionsStr.'</datalist>'.
			'<input size="8" type="text" name="'.$arHtmlControl["NAME"].'" value="'.$arHtmlControl["VALUE"].'" list="list_'.$arHtmlControl["NAME"].'" />'.
			'<span style="margin-left: 5px;">'.$currentName.'</span>'
		;
	}
	
	
}

AddEventHandler("main", "OnUserTypeBuildList", array("UserDataHiBMore", "GetUserTypeDescription"));

