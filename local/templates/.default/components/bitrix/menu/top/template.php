<nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="header-menu ">
    <ul class="header-menu-inner ">
	<? foreach ($arResult as $karLink => $arLink) { ?>
		<? if ($arLink['DEPTH_LEVEL'] == '1') { ?>
		<li class="header-menu-item-holder <?=$arLink['IS_PARENT']?' header-menu-item-holder--has-submenu':''?>"><a href="<?=$arLink['IS_PARENT']?'#':$arLink['LINK']?>" 
							  itemprop="url" target="" 
							  class="header-menu-item <?php if(!$arLink["PARAMS"]["CLASS"]): ?>animation-link<?php endif; ?> <?php echo $arLink["PARAMS"]["CLASS"]; ?>"><span itemprop="name" class="header-menu-item-name "><?=$arLink['TEXT']?></span></a>
			<? if ($arLink['IS_PARENT']) { ?>
			<nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="header-menu-level1 ">
				<ul class="header-menu-level1-inner ">
				    <? foreach ($arResult as $karSubLink => $arSubLink) { ?>
					<? if ($karLink < $karSubLink && $arSubLink['DEPTH_LEVEL'] == '1') { break; } ?>
					<? if ($arSubLink['DEPTH_LEVEL'] == '2' && $karLink < $karSubLink) { ?>
						<li class="header-menu-level1-item-holder   "><a href="<?=$arSubLink['LINK']?>" itemprop="url" target="" class="header-menu-level1-item animation-link "><span itemprop="name" class="header-menu-level1-item-name "><?=$arSubLink['TEXT']?></span></a>
						</li>
					<? } ?>	
				    <? } ?>
				</ul>
			</nav>
			<? } ?>	

		</li>
		<? } ?>
	<? } ?>
    </ul>
</nav>