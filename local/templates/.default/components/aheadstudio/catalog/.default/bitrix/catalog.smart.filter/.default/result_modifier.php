<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (isset($arParams["TEMPLATE_THEME"]) && !empty($arParams["TEMPLATE_THEME"]))
{
	$arAvailableThemes = array();
	$dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
	if (is_dir($dir) && $directory = opendir($dir))
	{
		while (($file = readdir($directory)) !== false)
		{
			if ($file != "." && $file != ".." && is_dir($dir.$file))
				$arAvailableThemes[] = $file;
		}
		closedir($directory);
	}

	if ($arParams["TEMPLATE_THEME"] == "site")
	{
		$solution = COption::GetOptionString("main", "wizard_solution", "", SITE_ID);
		if ($solution == "eshop")
		{
			$templateId = COption::GetOptionString("main", "wizard_template_id", "eshop_bootstrap", SITE_ID);
			$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? "eshop_adapt" : $templateId;
			$theme = COption::GetOptionString("main", "wizard_".$templateId."_theme_id", "blue", SITE_ID);
			$arParams["TEMPLATE_THEME"] = (in_array($theme, $arAvailableThemes)) ? $theme : "blue";
		}
	}
	else
	{
		$arParams["TEMPLATE_THEME"] = (in_array($arParams["TEMPLATE_THEME"], $arAvailableThemes)) ? $arParams["TEMPLATE_THEME"] : "blue";
	}
}
else
{
	$arParams["TEMPLATE_THEME"] = "blue";
}

$arParams["FILTER_VIEW_MODE"] = (isset($arParams["FILTER_VIEW_MODE"]) && toUpper($arParams["FILTER_VIEW_MODE"]) == "HORIZONTAL") ? "HORIZONTAL" : "VERTICAL";
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";




if($arResult["ITEMS"]) {
	function filterValuesCmp($a, $b) {
		return ($a["SORT_INDEX"] < $b["SORT_INDEX"] ? -1 : 1);
	}
	$arResultItemsValues = Array();
	$arResultItems = Array();
	foreach($arResult["ITEMS"] as &$arItem) {
		//usort($arItem["VALUES"], "filterValuesCmp");
		if($arItem["VALUES"] && !$arItem["PRICE"]) {
			foreach($arItem["VALUES"] as &$arItemValue) {
				$arItemValue["PROPERTY_CODE"] = $arItem["CODE"];
				$arItemValue["VALUE"] = $arItemValue["VALUE"];
				$arResultItemsValues[$arItem["CODE"]][] = $arItemValue["VALUE"];
			}
			natsort($arResultItemsValues[$arItem["CODE"]]);
			$arResultItemsValues[$arItem["CODE"]] = array_values($arResultItemsValues[$arItem["CODE"]]);
			foreach($arItem["VALUES"] as &$arItemValue) {
				$arItemValue["SORT_INDEX"] = array_search($arItemValue["VALUE"], $arResultItemsValues[$arItem["CODE"]]);
			}
		}
	}
	foreach($arResult["ITEMS"] as &$arItem) {
		if($arItem["VALUES"] && !$arItem["PRICE"]) {
			usort($arItem["VALUES"], "filterValuesCmp");
		}
	}
}