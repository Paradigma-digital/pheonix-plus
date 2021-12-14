<nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="footer-menu ">
    <ul class="footer-menu-inner ">
	<? foreach ($arResult as $karLink => $arLink) { ?>
	<? if ($arLink['DEPTH_LEVEL'] == '1') { ?>
			<li class="footer-menu-item-holder   "><a href="<?= $arLink['LINK'] ?>" itemprop="url" target="" class="footer-menu-item animation-link "><span itemprop="name" class="footer-menu-item-name "><?= $arLink['TEXT'] ?></span></a>
			</li>
	<? } ?>	
	<? } ?>
    </ul>
</nav>
