<?php
	foreach($arResult["ITEMS"] as &$arItem) {
		CGCCatalog::getProductDiscount($arItem);
	}
?>