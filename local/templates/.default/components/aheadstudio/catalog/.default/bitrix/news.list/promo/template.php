<? if (!empty($arResult['ITEMS'])) { ?>
<div data-width="100%" data-ratio="4.6/1" data-margin="0" data-shadows="false" data-arrows="false" data-autoplay="5000" data-transitionduration="800" data-loop="true" class="catalog-banners">
        <? foreach ($arResult['ITEMS_PER_3'] as $per3) { ?>		
		<div class="catalog-banner-item">
			<? foreach ($per3 as $karItem => $arItem) {
				$class = ""; 
			
			if($karItem == 2) {
				continue;
			}
			
			switch ($karItem) {
				case 0: $class = 'catalog-banner-item-block--large';
					break;
				case 1: $class = 'catalog-banner-item-block--rt';
					break;
				case 2: $class = 'catalog-banner-item-block--rb';
					break;
			}
			if(trim($arItem['NAME']) || $arItem['PREVIEW_TEXT']) {
				$class .= " catalog-banner-item-block--text ";
			}
			
			
		?><a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" class="catalog-banner-item-block <?=$class?>">
		<div style="background-image: url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>')" class="catalog-banner-item-block-img"></div>
		<div class="catalog-banner-item-block-name<? if ($karItem == 2 || true) { ?> catalog-banner-item-block-name--white<? } ?>"><?=$arItem['NAME']?></div>
		<? if (!empty($arItem['PREVIEW_TEXT'])) { ?><div class="catalog-banner-item-block-description<? if ($karItem == 2|| true) { ?> catalog-banner-item-block-name--white<? } ?>"><?=$arItem['PREVIEW_TEXT']?></div><? } ?></a><? } ?></div>		
	<? } ?>
</div>
<? } ?>