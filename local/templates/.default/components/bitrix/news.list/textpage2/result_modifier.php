<?php
	foreach($arResult["ITEMS"] as &$arItem) {
		if($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'slider' && !empty($arItem['PROPERTIES']['PHOTOS']['VALUE'])) {
			$arItem["GALLERY"] = Array();
			foreach($arItem['PROPERTIES']['PHOTOS']['VALUE'] as $photoId) {
				$arItem["GALLERY"][] = CGCHelper::resizeImage($photoId, "1000", "800");
			}
			
			
		}
	}
?>