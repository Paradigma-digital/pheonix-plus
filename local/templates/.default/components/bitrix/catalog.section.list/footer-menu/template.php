<nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="mobile-menu ">
    <ul class="mobile-menu-inner ">
	<li class="mobile-menu-item-holder   "><a href="/catalog/" itemprop="url" target="" class="mobile-menu-item mobile-menu-item--large "><span itemprop="name" class="mobile-menu-item-name ">Каталог</span></a>
	</li>
	<? foreach ($arResult['SECTIONS'] as $arSection) { ?>
		<? if ($arSection['DEPTH_LEVEL'] == 1 && $arSection['ELEMENT_CNT'] > 0) { ?>
			<li class="mobile-menu-item-holder   ">
			    <a href="<?=$arSection['SECTION_PAGE_URL']?>" itemprop="url" target="" class="mobile-menu-item ">
				<span itemprop="name" class="mobile-menu-item-name "><?=$arSection['NAME']?></span>
				<span class="mobile-menu-item-add">(<?=$arSection['ELEMENT_CNT']?>)</span>
			    </a>      
			</li>   
		<? } ?>
	<? } ?>
    </ul>
</nav>