<? if (!empty($arResult['ITEMS'])) { ?>
    <div class="catalog">
        <?php if ($arParams["DISPLAY_AS_SLIDER"]): ?>
            <div class="catalog-header">
                <div class="catalog-title">
                    <?php if ($arParams["HEADING"]["URL"]): ?><a href="<?php echo $arParams["HEADING"]["URL"]; ?>"
                                                                 class="link link--black"><?php endif; ?>
                        <?php echo $arParams["HEADING"]["TITLE"]; ?>
                        <?php if ($arParams["HEADING"]["URL"]): ?></a><?php endif; ?>
                </div>
                <div class="catalog-nav"><span class="catalog-nav-item catalog-nav-item--prev"></span><span
                            class="catalog-nav-counter"><span class="catalog-nav-counter-current">1</span><span
                                class="catalog-nav-counter-divider">/</span><span
                                class="catalog-nav-counter-all">&nbsp;</span></span><span
                            class="catalog-nav-item catalog-nav-item--next"></span></div>
                <div class="catalog-link">
                    <?php if ($arParams["HEADING"]["URL"]): ?><a href="<?php echo $arParams["HEADING"]["URL"]; ?>"
                                                                 class="link link--black">Показать
                            все</a><?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div
            <?php if ($arParams["DISPLAY_AS_SLIDER"]): ?>data-slick="{&quot;slidesToShow&quot;: 4, &quot;slidesToScroll&quot;: 4}"<?php endif; ?>
            class="catalog-items">
            <? foreach ($arResult['ITEMS'] as $arItem) { //deb($arItem['MIN_PRICE'], false)?>
                <div class="catalog-item catalog-item--w1 catalog-item--gift">
                    <div class="catalog-item-inner">
                        <div class="catalog-item-link">
                            <? if (!empty($arItem['PREVIEW_PICTURE'])) { ?>
                                <div class="catalog-item-photo-holder"><img
                                            src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                            alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>" class="catalog-item-photo">
                                </div>
                            <? } else { ?>
                                <div class="catalog-item-photo-holder catalog-item-photo-holder--empty"></div>
                            <? } ?>
                            <!--<div class="catalog-item-photo-holder"><img src="/local/templates/.default/dummy/catalog/c1.jpg" class="catalog-item-photo out"><img src="/local/templates/.default/dummy/catalog/c2.jpg" class="catalog-item-photo over"></div>-->
                            <div class="catalog-item-name">
                                <?
                                $shtrih = '';
                                foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
                                    if ($arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'Штрихкод единицы товара') {
                                        $shtrih = $val;
                                        break;
                                    }
                                }
                                $in_pack = '';
                                foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
                                    if ($arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'ВидыУпаковок') {
                                        $in_pack = $val;
                                        break;
                                    }
                                }
                                ?>
                                <span class="catalog-item-name-pre">арт. <?= $arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'] ?><? if (!empty($shtrih)) { ?>, штрихкод: <?= $shtrih ?><? } ?><? if (!empty($in_pack)) { ?>,
                                        <br/>упаковки: <?= $in_pack ?><? } ?></span>
                                <br><?= $arItem['NAME'] ?></div>
                        </div>
                        <? if ($USER->IsAuthorized() && ($arItem["MIN_PRICE"])) {
                            $krat = 1;
                            foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
                                if ($arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'КратностьОтгрузки') {
                                    $krat = (int)$val;
                                    break;
                                }
                            } ?>
                            <? if ($arItem['CATALOG_QUANTITY'] > 0) { ?>
                                <div class="catalog-item-market">


                                    <div class="catalog-item-buy-holder">
                                        <?php if ($krat > 1): ?>
                                            <div class="catalog-item-buy-pack">набор из <?php echo $krat; ?>
                                            шт.</div><?php endif; ?>
                                        <div class="catalog-item-spinner">
                                            <div class="catalog-item-spinner-minus btn btn--gray" data-add="-1">–</div>
                                            <input type="text" readonly
                                                   value="<?php if ($arParams["GIFTS_IN_BASKET"] && $arParams["GIFTS_IN_BASKET"][$arItem["ID"]]): ?><?php echo $arParams["GIFTS_IN_BASKET"][$arItem["ID"]]["QUANTITY"]; ?><?php else: ?>0<?php endif; ?>"
                                                   placeholder="0" data-pack="<?= $krat ?>"
                                                   data-price="<?php echo $arItem["MIN_PRICE"]["DISCOUNT_VALUE"]; ?>"
                                                   data-id="<?= $arItem['ID'] ?>"
                                                   data-category="<?php echo $arItem["PROPERTIES"]["PODAROK"]["VALUE"]; ?>"
                                                   class="form-item form--number form-item--text catalog-item-quantity product-quantity"
                                                   data-max="<?php echo $arItem['CATALOG_QUANTITY']; ?>">
                                            <div class="catalog-item-spinner-plus btn btn--gray" data-add="1">+</div>
                                        </div>
                                    </div>
                                </div>
                            <? } else { ?>
                                <div class="catalog-item-market">
                                    <div class="catalog-item-price catalog-item-price-no">Нет в наличии</div>
                                </div>
                            <?php } ?>
                        <? } ?>


                        <?php if ($USER->IsAuthorized() && !$arItem["MIN_PRICE"]): ?>
                            <div class="catalog-item-market">
                                <a href="#shops-list" class="btn btn--gray btn--full popup"
                                   data-type="inline">Купить</a>
                            </div>
                        <?php endif; ?>




                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/product_social.php",
                                "SOCIAL" => $arItem,
                            )
                        ); ?>

                        <div class="catalog-item-promos">
                            <? if ($arItem['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "Скидка") { ?>
                                <div class="catalog-item-promo-item catalog-item-promo-item--discount"><?php echo $arItem['PROPERTIES']['SKIDKA']['VALUE']; ?>
                                    %
                                </div>
                            <? } ?>
                            <? if ($arItem['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "Новинка") { ?>
                                <div class="catalog-item-promo-item catalog-item-promo-item--new"></div>
                            <? } ?>
                            <? if ($arItem['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "Хит") { ?>
                                <div class="catalog-item-promo-item catalog-item-promo-item--hit"></div>
                            <? } ?>
                        </div>

                        <?php if ($arItem["PROPERTIES"]["PREDLAGAT_PODAROK"]["VALUE"]): ?>
                            <div class="catalog-item-add_gift"></div>
                        <?php endif; ?>
                        <?php if ($arItem["PROPERTIES"]["PODAROK"]["VALUE"]): ?>
                            <div class="catalog-item-is_gift"></div>
                        <?php endif; ?>

                    </div>
                </div>
            <? } ?>
        </div>
    </div>
    <?= $arResult['NAV_STRING'] ?>
<? } ?>


