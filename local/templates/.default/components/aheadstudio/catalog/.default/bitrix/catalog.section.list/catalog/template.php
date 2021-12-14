<? if (!empty($arResult['SECTIONS'])) { ?>
<div class="catalog-sections">
    <div class="catalog-sections-inner">
	<div class="catalog-sections-items">
	    <? foreach ($arResult['SECTIONS'] as $arSection) { ?>
		<? if ( $arSection['ELEMENT_CNT'] > 0) { ?>
	    <div class="catalog-section-item-holder"><a href="<?=$arSection['SECTION_PAGE_URL']?>" 
							    class="catalog-section-item animation-link"><span class="catalog-section-item-name"><?=$arSection['NAME']?></span><span class="catalog-section-item-count">(<?=$arSection['ELEMENT_CNT']?>)</span></a></div>
	    <? } ?>
	    <? } ?>
	</div>
	<div class="catalog-sections-banner">Более 6000<br>наименований</div>
    </div>
    <!--<div class="catalog-sections-all-holder"><a href="#" class="link link--barrow">Показать все категории</a></div>-->
</div>
<? } ?>