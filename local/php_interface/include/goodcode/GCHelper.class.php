<?php
	use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
	
	class CGCHelper {
		
		function getHlElements($hlId, $arFilter = false) {
			CModule::IncludeModule("highloadblock");
		    $hlblock = HLBT::getById($hlId)->fetch();   
		    $entity = HLBT::compileEntity($hlblock);
		    $entity_data_class = $entity->getDataClass();
			$rsData = $entity_data_class::getList(array(
			   "select" => Array("ID", "UF_*"),
			   "order" => Array("UF_NAME" => "ASC"),
			   "filter" => ($arFilter ? $arFilter : Array()),
			));
			$arResult = Array();
			while($el = $rsData->fetch()){
			    $arResult[] = $el;
			}
			return $arResult;
		}
		
		function addHLElement($hlId, $data) {
			CModule::IncludeModule("highloadblock");
			$hlblock = HLBT::getById($hlId)->fetch(); 
			$entity = HLBT::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();
			
			$result = $entity_data_class::add($data);
			$ID = $result->getId();
			return $ID;
		}
		
		function updateHLElement($hlId, $elementId, $data) {
			CModule::IncludeModule("highloadblock");
			$hlblock = HLBT::getById($hlId)->fetch(); 
			$entity = HLBT::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();
			
			$result = $entity_data_class::update($elementId, $data);
		}
		
		function resizeImage($id, $width, $height, $type = BX_RESIZE_IMAGE_PROPORTIONAL, $sizes = true, $addWatermark = false) {
	
			if(!$id || !$width || !$height) {
				return null;
			}
			// get the file by ID
			$dbFile = CFile::GetBYID($id);
			if(!($arFile = $dbFile->Fetch())) {
				return null;
			}
			// handle with watermark
			$arWatermarkFilter = false;
			if($addWatermark) {
				$arWatermarkFilter[] = array(
					"name" => "watermark",
					"position" => "bottomright",
					"type" => "image",
					"size" => "real",
					"alpha_level" => "30",
					"file" => $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/i/watermark1.png"
				);
			}
			// resize the picture
			$arPicture = CFile::ResizeImageGet(
				$id,
				array("width" => $width, "height" => $height),
				$type,
				$sizes,
				$arWatermarkFilter
			);
			// write an output array
			$arRet = array(
				"SRC" => $arPicture["src"],
				"DESCRIPTION" => $arFile["DESCRIPTION"]
			);
			if($sizes) {
				$arRet["WIDTH"] = $arPicture["width"];
				$arRet["HEIGHT"] = $arPicture["height"];
			}
			
			return $arRet;
			
		}
		
		
		function getIBlockElements($arParams) {
			CModule::IncludeModule("iblock");
			$dbElements = CIBlockElement::GetList(
				array_merge(Array(
					"SORT" => "ASC"
				), $arParams["SORT"]),
				$arParams["FILTER"],
				false,
				$arParams["NAV"] ? $arParams["NAV"] : false,
				$arParams["SELECT"]
			);
			$arElements = [];
			while($arElement = $dbElements->GetNext()) {
				$arElements[] = $arElement;
			}
			return $arElements;
		}
		
		function getIBlockSections($arParams) {
			CModule::IncludeModule("iblock");
			$dbSections = CIBlockSection::GetList(
				array_merge(Array(
					"SORT" => "ASC"
				), $arParams["SORT"]),
				$arParams["FILTER"],
				false,
				$arParams["SELECT"],
				$arParams["NAV"] ? $arParams["NAV"] : false
			);
			$arSections = [];
			while($arSection = $dbSections->GetNext()) {
				$arSections[] = $arSection;
			}
			return $arSections;
		}
		
		function getIBlockProperty($arParams) {
			$arProperties = [];
			$dbProperty = CIBlockElement::GetProperty(
				$arParams["IBLOCK_ID"],
				$arParams["ID"],
				["SORT" => "ASC"],
				$arParams["FILTER"]
			);
			while($arProperty = $dbProperty->Fetch()) {
				$arProperties[] = $arProperty;
			}
			return $arProperties;
		}
		
		function getIBlockIdByCode($iBlockCode) {
			CModule::IncludeModule("iblock");
			$dbIBlock = CIBlock::GetList(
				false,
				Array(
					"CODE" => $iBlockCode,
					"SITE_ID" => SITE_ID
				)
			);
			$arIBlock = $dbIBlock->Fetch();
			return $arIBlock["ID"];
		}
		
		
		function getPropertyIDByCode($code, $name) {
			$dbEnum = CIBlockProperty::GetPropertyEnum($code, [], ["IBLOCK_ID" => "9", "VALUE" => $name]);
			$arEnum = $dbEnum->Fetch();
			
			return $arEnum["ID"];
		}
		
		
		function printTel($value) {
			echo "tel:".str_replace([" ", "-", "(", ")"], "", $value);
		}

	}
?>