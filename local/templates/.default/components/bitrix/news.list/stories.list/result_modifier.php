<?php
	foreach($arResult["ITEMS"] as &$arItem) {
		if($arItem["PREVIEW_PICTURE"]) {
			$arItem["PICTURE"] = CGCHelper::resizeImage($arItem["PREVIEW_PICTURE"]["ID"], $arParams["RESIZE"]["WIDTH"], $arParams["RESIZE"]["HEIGHT"]);
		}
	}
?>