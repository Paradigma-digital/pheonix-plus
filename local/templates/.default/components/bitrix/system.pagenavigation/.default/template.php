<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

if($arResult["NavPageCount"] > 1)
{
?>
<!--<div class="pager">
    <a href="#" class="pager-item">1</a>
    <span class="pager-item current">2</span>
    <a href="#" class="pager-item">3</a>
    <a href="#" class="pager-item">4</a>
    <a href="#" class="pager-item">...</a>
    <a href="#" class="pager-item">24</a>
    <a href="#" class="pager-item">25</a>
</div>-->

<div class="pager">
    <? if ($arResult["NavPageNomer"] > 1) { ?>
    <a class="pager-item pager-item-first" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageNomer"]-1?>">&nbsp</a>
    <? } else { ?>
    <span class="pager-item pager-item-first current">&nbsp</span>
    <? } ?>
<?
if($arResult["bDescPageNumbering"] === true):
	$bFirst = true;
	if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
		
		if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
			$bFirst = false;
			if($arResult["bSavePage"]):
?>
			<a class="pager-item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">1</a>
<?
			else:
?>
			<a class="pager-item" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
<?
			endif;
?>
<?
			if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):
?>
			<a href="#" class="pager-item">...</a>
<?
			endif;
		endif;
	endif;
	do
	{
		$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;
		
		if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
?>
		<span class="pager-item current"><?=$NavRecordGroupPrint?></span>
<?
		elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
?>
		<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="pager-item"><?=$NavRecordGroupPrint?></a>
<?
		else:
?>
		<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"<?
			?> class="pager-item"><?=$NavRecordGroupPrint?></a>
		
<?
		endif;
		?>
		<?
		
		$arResult["nStartPage"]--;
		$bFirst = false;
	} while($arResult["nStartPage"] >= $arResult["nEndPage"]);
	
	if ($arResult["NavPageNomer"] > 1):
		if ($arResult["nEndPage"] > 1):
			if ($arResult["nEndPage"] > 2):
?>
		<a href="#" class="pager-item">...</a>
<?
			endif;
?>
		<a class="pager-item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=$arResult["NavPageCount"]?></a>
<?
		endif;
	
?>
		<a class="pager-item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_next")?></a>
<?
	endif; 

else:
	$bFirst = true;

	if ($arResult["NavPageNomer"] > 1):
?>
<?
		
		if ($arResult["nStartPage"] > 1):
			$bFirst = false;
			if($arResult["bSavePage"]):
?>
			<a class="pager-item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a>
<?
			else:
?>
			<a class="pager-item" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
<?
			endif;
?>
<?
			if ($arResult["nStartPage"] > 2):
?>
			<a href="#" class="pager-item">...</a>
<?
			endif;
		endif;
	endif;

	do
	{
		if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
?>
		<span class="pager-item current"><?=$arResult["nStartPage"]?></span>
<?
		elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
?>
		<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="pager-item"><?=$arResult["nStartPage"]?></a>
<?
		else:
?>
		<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"<?
			?> class="pager-item"><?=$arResult["nStartPage"]?></a>
<?
		endif;
?>
<?
		$arResult["nStartPage"]++;
		$bFirst = false;
	} while($arResult["nStartPage"] <= $arResult["nEndPage"]);
	
	if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
		if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
			if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
?>
		<a href="#" class="pager-item">...</a>
<?
			endif;
?>
		<a class="pager-item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a>
<?
		endif;
?>
		
<?
	endif;
endif;

?>
    <? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) { ?>
    <a class="pager-item pager-item-last" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageNomer"]+1?>">&nbsp</a>
    <? } else { ?>
    <span class="pager-item pager-item-last current">&nbsp</span>
    <? } ?>
</div>
<?
}
?>