<? 
define('HAS_LEFT_MENU', 'Y');
if (!empty($arResult)) { ?>
            <nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="page-menu ">
              <ul class="page-menu-inner ">
		<? foreach ($arResult as $arPoint) { ?>
			<li class="page-menu-item-holder   "><a href="<?=$arPoint['LINK']?>" itemprop="url" target="" class="page-menu-item <?php if(!$arPoint["PARAMS"]["IS_SIMPLE"]): ?>animation-link<?php endif; ?> <? if ($APPLICATION->GetCurPage() == $arPoint['LINK'] ) { ?> active<? } ?> "><span itemprop="name" class="page-menu-item-name "><?=$arPoint['TEXT']?></span></a>
			</li>
		<? } ?>
              </ul>
            </nav>
<? } ?>