<? if (!empty($arResult['ITEMS'])) { ?>
    <?
    $inCartArray = Preorder::getUserCarts();
    ?>
    <div class="page-inner page-inner--w1">
        <div class="catalog ">
            <div class="catalog-header">
                <div class="catalog-title"><a href="/catalog/actions/" class="link link--black">Акции</a></div>
                <div class="catalog-nav"><span class="catalog-nav-item catalog-nav-item--prev"></span><span
                            class="catalog-nav-counter"><span class="catalog-nav-counter-current">1</span><span
                                class="catalog-nav-counter-divider">/</span><span
                                class="catalog-nav-counter-all">&nbsp;</span></span><span
                            class="catalog-nav-item catalog-nav-item--next"></span></div>
                <?php if ($arParams["DISPLAY_ALL_LINK"] == "Y"): ?>
                    <div class="catalog-link">
                        <a href="/catalog/actions/" class="link link--black">Показать все</a>
                    </div>
                <?php endif; ?>
            </div>
            <div data-slick="{&quot;slidesToShow&quot;: 4, &quot;slidesToScroll&quot;: 4}" class="catalog-items">
                <? foreach ($arResult['ITEMS'] as $arItem) {
                    ?>
                    <div class="catalog-item catalog-item--w1">
                        <div class="catalog-item-inner"><a href="<?= customDetailUrl($arItem['DETAIL_PAGE_URL']) ?>"
                                                           class="catalog-item-link">
                                <? if (!empty($arItem['PREVIEW_PICTURE'])) { ?>
                                    <div class="catalog-item-photo-holder">
                                        <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                             alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>" class="catalog-item-photo">

                                        <div class="catalog-item-add2favorites <?php if (СGCBookmark::isProductInFavorites($arItem["ID"])): ?>added<?php endif; ?>"
                                             data-id="<?php echo $arItem["ID"]; ?>"></div>
                                    </div>
                                <? } else { ?>
                                    <div class="catalog-item-photo-holder catalog-item-photo-holder--empty">
                                        <div class="catalog-item-add2favorites <?php if (СGCBookmark::isProductInFavorites($arItem["ID"])): ?>added<?php endif; ?>"
                                             data-id="<?php echo $arItem["ID"]; ?>"></div>
                                    </div>
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
                            </a>
                            <? if (($arItem["MIN_PRICE"])) {

                                $krat = 1;
                                foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
                                    if ($arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'КратностьОтгрузки') {
                                        $krat = (int)$val;
                                        break;
                                    }
                                }
                                ?>
                                <? if ($arItem['CATALOG_QUANTITY'] > 0) { ?>
                                    <div class="catalog-item-market">
                                        <div class="catalog-item-market-title">цена за 1шт.</div>
                                        <div class="catalog-item-price"><? if (!empty($arItem['MIN_PRICE']['DISCOUNT_DIFF']) && $arItem["MIN_PRICE"]["SIMPLE_DISCOUNT"] == "Y") { ?>
                                                <span class="catalog-item-price-old"><?= $arItem['MIN_PRICE']['PRINT_VALUE'] ?></span><? } ?>
                                            <span class="catalog-item-price-current"><?= $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></span>


                                            <?php if ($arItem['MIN_PRICE']["PRICE_ID"] == $GLOBALS["RETAIL_PRICE_TYPE_ID"]): ?>
                                                <span class="catalog-item-price-type">розничная цена</span>
                                            <?php endif; ?>


                                        </div>
                                        <div class="catalog-item-buy-holder">
                                            <div class="catalog-quantity-line" data-value="<?php echo $arItem["PROPERTIES"]["PROTSENT_DOSTUPNOSTI"]["VALUE"]; ?>"></div>
                                            <?
                                            $preOrder = $arItem["SHOW_PRE_ORDER"] == "Y";
                                            $mainCollection = $arItem["SHOW_MAIN_COLLECTION"] == "Y";

                                            if ($preOrder) {
                                                ?>
                                                <div style="margin-bottom: 10px">
                                                    <input type="text"
                                                           value="<?= $krat ?>"
                                                           data-pack="<?= $krat ?>"
                                                           data-id="<?php echo $arItem['ID']; ?>"
                                                           class="form-item form--number form-item--text catalog-item-quantity product-quantity">
                                                    <a
                                                            href="javascript:void(0)"
                                                            data-q="<?= $inCartArray['UF_PRE_ORDER_CART'][$arItem['ID']] ?>"
                                                            class="catalog-item-pre_buy btn btn--gray">
                                                        Предзаказ <?php echo $inCartArray['UF_PRE_ORDER_CART'][$arItem['ID']] ?>
                                                    </a>
                                                </div>
                                                <?
                                            }

                                            if($mainCollection) {
                                                ?>
                                                <div style="margin-bottom: 10px">
                                                    <input type="text"
                                                           value="<?= $krat ?>"
                                                           data-pack="<?= $krat ?>"
                                                           data-id="<?php echo $arItem['ID']; ?>"
                                                           class="form-item form--number form-item--text catalog-item-quantity product-quantity">
                                                    <a
                                                            href="javascript:void(0)"
                                                            data-q="<?= $inCartArray['UF_PRE_ORDER_CART'][$arItem['ID']] ?>"
                                                            class="catalog-item-pre_buy btn btn--gray">
                                                        Предзаказ <?php echo $inCartArray['UF_PRE_ORDER_CART'][$arItem['ID']] ?>
                                                    </a>
                                                </div>
                                                <input
                                                        type="text"
                                                        value="<?= $krat ?>"
                                                        data-pack="<?= $krat ?>"
                                                        data-id="<?= $arItem['ID'] ?>"
                                                        class="form-item form--number form-item--text catalog-item-quantity product-quantity">
                                                <a
                                                        href="javascript:void(0)"
                                                        data-q="<?= $inCartArray[$arItem['ID']]['QUANTITY'] ?>"
                                                        class="catalog-item-buy btn btn--gray product-buy">
                                                    <? if (!empty($inCartArray['UF_USER_CART'][$arItem['ID']])) { ?>
                                                        В корзине
                                                        <?= $inCartArray['UF_USER_CART'][$arItem['ID']] ?><? } else { ?>
                                                        Купить
                                                    <? } ?>
                                                </a>
                                                <?
                                            }

                                            if ($arItem["SHOW_PRE_ORDER"] == "N" && $arItem["SHOW_MAIN_COLLECTION"] == "N" ) {
                                                ?>
                                                <input
                                                        type="text"
                                                        value="<?= $krat ?>"
                                                        data-pack="<?= $krat ?>"
                                                        data-id="<?= $arItem['ID'] ?>"
                                                        class="form-item form--number form-item--text catalog-item-quantity product-quantity">
                                                <a
                                                        href="javascript:void(0)"
                                                        data-q="<?= $inCartArray[$arItem['ID']]['QUANTITY'] ?>"
                                                        class="catalog-item-buy btn btn--gray product-buy">
                                                    <? if (!empty($inCartArray['UF_USER_CART'][$arItem['ID']])) { ?>
                                                        В корзине
                                                        <?= $inCartArray['UF_USER_CART'][$arItem['ID']] ?><? } else { ?>
                                                        Купить
                                                    <? } ?>
                                                </a>
                                                <?
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <? } ?>
                            <? } ?>


                            <?php if ($USER->IsAuthorized() && !$arItem["MIN_PRICE"]): ?>
                                <div class="catalog-item-market">
                                    <a href="#shops-list" class="btn btn--gray btn--full popup" data-type="inline">Купить</a>
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
                                <!--// sdemon72 20201214 добавил условие "или" на ненулевую скидку-->
                                <? if (($arItem['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "Скидка") ||
                                    (!empty($arItem['PROPERTIES']['SKIDKA']['VALUE']))) { ?>
                                    <!--// _sdemon72 20201214 -->
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
            <!--<div class="catalog-footer"><a href="/catalog/" class="link link--arrow animation-link">Все товары</a></div>-->
        </div>
    </div>
<? } ?>