<div class="page-inner page-inner--w1">
    <div class="articles">
	<? if (!empty($arResult['ITEMS'])) { ?>
	<div class="articles-items">
	    <div class="article-item"><?foreach ($arResult['ITEMS'] as $arItem) { ?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="article-item-inner animation-link">
                    <div class="article-item-photo-holder cover-holder"><img src="<?=$arItem["PICTURE"]['SRC']?>" class="article-item-photo cover"></div>
                    <div class="article-item-name-holder"><span class="article-item-name link link--arrow"><?=$arItem['NAME']?></span></div>
                    <time class="article-item-date"><?=$arItem['DISPLAY_ACTIVE_FROM']?></time></a></div>
	    <div class="article-item"><? } ?></div>
	</div>
	<? } ?>
    </div>
    <!--<div class="pager"><a href="#" class="pager-item">1</a><span class="pager-item current">2</span><a href="#" class="pager-item">3</a><a href="#" class="pager-item">4</a><a href="#" class="pager-item">...</a><a href="#" class="pager-item">24</a><a href="#" class="pager-item">25</a></div>-->
    
    <?php if($arParams["DISPLAY_BOTTOM_PAGER"] == "Y"): ?>
    	<?php echo $arResult["NAV_STRING"]; ?>
    <?php endif; ?>
    
</div>