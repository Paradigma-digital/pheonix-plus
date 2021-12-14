<? if (!empty($arResult['ITEMS'])) { 
	
	$arItem = $arResult['ITEMS'][0];
	?>
<a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" data-id="15" class="page-action hidden">
	<div class="page-action-title"><?=$arItem['NAME']?></div>
	<div style="background-image: url(<?=$arItem['PREVIEW_PICTURE']['SRC']?>)" class="page-action-bg"></div><span class="page-action-close"></span></a>
	
<? } ?>