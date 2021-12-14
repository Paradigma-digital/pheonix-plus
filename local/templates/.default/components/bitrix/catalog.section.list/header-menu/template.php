<? if (!empty($arResult['SECTIONS'])) { ?>
    <nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="catalog-menu ">
        <ul class="catalog-menu-inner ">
            <? foreach ($arResult['SECTIONS'] as $arSection) { ?>
                <? if ($arSection['DEPTH_LEVEL'] == 1) { ?>
                    <li class="catalog-menu-item-holder   "><a href="<?php echo $arSection["SECTION_PAGE_URL"]; ?>"
                                                               data-id="<?= $arSection['ID'] ?>"
                                                               class="catalog-menu-item animation-link"><span
                                    itemprop="name" class="catalog-menu-item-name "><?= $arSection['NAME'] ?></span>
                            <?php if ($arSection['ELEMENT_CNT']): ?>
                                <span class="catalog-menu-item-add">(<?= $arSection['ELEMENT_CNT'] ?>)</span>
                            <?php endif; ?>
                        </a>
                    </li>
                <? } //deb($arSection, false)?>
            <? } ?>
        </ul>
        <? foreach ($arResult['SECTIONS'] as $karSection => $arSection) { ?>
            <? if ($arSection['DEPTH_LEVEL'] == 1) { ?>
                <div class="catalog-menu-sub" id="catalog-menu-sub<?= $arSection['ID'] ?>">
                    <ul class="catalog-menu-sub-inner">
                        <? foreach ($arResult['SECTIONS'] as $karSubSection => $arSubSection) { ?>
                            <?
                            if ($arSubSection['DEPTH_LEVEL'] == 1 && $karSubSection > $karSection) {
                                break;
                            }
                            if ($arSubSection['DEPTH_LEVEL'] > 1 && $karSubSection > $karSection) { ?>
                                <li class="catalog-menu-sub-item-holder   ">
                                    <a href="<?= $arSubSection['SECTION_PAGE_URL'] ?>" itemprop="url" target=""
                                       class="catalog-menu-sub-item<? if ($arSubSection['DEPTH_LEVEL'] > 2) { ?> catalog-menu-sub-item-sub<? } ?> animation-link ">
					<span itemprop="name" class="catalog-menu-sub-item-name "><span
                                class="catalog-menu-sub-item-name-title"><?= $arSubSection['NAME'] ?></span>
					<?php if ($arSubSection['ELEMENT_CNT']): ?>
                        <span class="catalog-menu-sub-item-sub-add">(<?= $arSubSection['ELEMENT_CNT'] ?>)</span>
                    <?php endif; ?>
					</span>
                                    </a>
                                </li>
                            <? }
                            ?>
                        <? } ?>
                    </ul>
                </div>
            <? } ?>
        <? } ?>
    </nav>
<? } ?>
