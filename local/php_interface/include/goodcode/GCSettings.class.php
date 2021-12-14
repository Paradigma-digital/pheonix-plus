<?php
	class GCSettings {
		function get($code) {
		 
			CModule::IncludeModule("iblock");
		 
			$arSetting = [];
			$dbSetting = CIBlockElement::GetList(
				false,
				[
					"IBLOCK_ID" => CGCHelper::getIBlockIdByCode("settings")
				],
				false,
				[
					"nTopCount" => "1"
				],
				[
					"ID", "NAME", "CODE", "ACTIVE"
				]
			);
			$arSetting = $dbSetting->Fetch();
			if($arSetting) {
				$arSetting["OPTIONS"] = [];
				$dbSettingProps = CIBlockElement::GetProperty(
					CGCHelper::getIBlockIdByCode("settings"), $arSetting["ID"], false, ["CODE" => "OPTIONS"]
				);
				while($arSettingProp = $dbSettingProps->Fetch()) {
					$arSetting["OPTIONS"][$arSettingProp["DESCRIPTION"]] = $arSettingProp["VALUE"];
				}
			}

			return $arSetting;
		}
	}
?>