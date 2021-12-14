<? if (!empty($arResult['SECTIONS'])) { ?>
<div class="catalog-sectionslist">
    <div class="page-heading">
	<h1 class="h1"><?=$arResult['SECTION']['NAME']?></h1>
    </div>
    <div class="catalog-sectionslist-inner">
	<div class="catalog-sectionslist-items">
	    <? foreach ($arResult['SECTIONS'] as $arSection) { ?>
		<? if ( $arSection['ELEMENT_CNT'] > 0) { ?>
	    <a href="<?=$arSection['SECTION_PAGE_URL']?>" class="catalog-sectionslist-item animation-link">
		<span class="catalog-sectionslist-item-name"><?=$arSection['NAME']?></span>
		<? if (!empty($arSection['PICTURE'])) { 
			
			$img = CFile::ResizeImageGet($arSection['PICTURE'], array('width' => 50, 'height' => 50))
			?>
			<span class="catalog-sectionslist-item-img"><img src="<?=$img['src']?>"></span>
		<? } ?>
	    </a>
		<? } ?>
	    <? } ?>
	</div>
    </div>
</div>
<? } ?>