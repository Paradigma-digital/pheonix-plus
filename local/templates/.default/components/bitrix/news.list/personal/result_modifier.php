<?php

$arResult['SECTS'] = array();
$sects = CIBlockSection::GetList(array('sort' => 'asc'), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y'));
while ($sect = $sects->Fetch())
{
	$sect['ELEMS'] = array();
	$arResult['SECTS'][$sect['ID']] = $sect;
}

foreach ($arResult['ITEMS'] as $arItem)
{
	if (!empty($arItem['IBLOCK_SECTION_ID']))
	{
		$arResult['SECTS'][$arItem['IBLOCK_SECTION_ID']]['ELEMS'][$arItem['ID']] = $arItem;
	}
}