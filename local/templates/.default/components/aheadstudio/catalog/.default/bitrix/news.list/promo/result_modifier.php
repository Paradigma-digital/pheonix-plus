<?php

$arResult['ITEMS_PER_3'] = array();
if (!empty($arResult['ITEMS']))
{
	$per3 = array();
	foreach ($arResult['ITEMS'] as $arItem)
	{
		if($arItem["PROPERTIES"]["FOR_REGISTERED"]["VALUE"] && $arParams["USER_REGISTERED"] != "Y") {
			continue;
		}
		if (count($per3) == 3)
		{
			$arResult['ITEMS_PER_3'][] = $per3;
			$per3 = array();
		}
		$per3[] = $arItem;
	}
	$arResult['ITEMS_PER_3'][] = $per3;
}