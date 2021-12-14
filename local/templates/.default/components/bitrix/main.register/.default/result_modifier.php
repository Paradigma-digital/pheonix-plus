<?php
	$arUserTypes = [];
	$arTmpUserTypes = CGCUser::getUserTypes();
	foreach($arTmpUserTypes as $arTmpUserType) {
		$arUserTypes[$arTmpUserType["XML_ID"]] = $arTmpUserType;
	}
	$arResult["USER_TYPES"] = $arUserTypes;
?>