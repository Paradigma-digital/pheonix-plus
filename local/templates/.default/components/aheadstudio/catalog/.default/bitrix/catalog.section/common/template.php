<?php if ($arParams["TEMPLATE"]["DISPLAY_BREADCRUMBS"]): ?>
    <?php $this->SetViewTarget('section_title'); ?>
    <div itemprop="breadcrumb" class="page-breadcrumbs">
        <div class="page-breadcrumbs-item-holder">
            <a href="/" itemprop="url" class="page-breadcrumbs-item link link--black"><span itemprop="name"
                                                                                            class="page-breadcrumbs-item-name">Главная</span></a>
        </div>
        <div class="page-breadcrumbs-item-holder">
            <a href="/catalog/" itemprop="url" class="page-breadcrumbs-item link link--black animation-link"><span
                        itemprop="name" class="page-breadcrumbs-item-name">Каталог</span></a>
        </div>
        <?php foreach ($arResult['PATH'] as $arSection): ?>
            <?php if ($arSection['ID'] != $arResult['ID']): ?>
                <div class="page-breadcrumbs-item-holder">
                    <a href="<?= $arSection['SECTION_PAGE_URL'] ?>" itemprop="url"
                       class="page-breadcrumbs-item link link--black animation-link">
                        <span itemprop="name" class="page-breadcrumbs-item-name"><?= $arSection['NAME'] ?></span>
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="page-breadcrumbs-item-holder">
            <span class="page-breadcrumbs-item"><span itemprop="name"
                                                      class="page-breadcrumbs-item-name"><?php echo($arParams["TEMPLATE"]["TITLE"] ? $arParams["TEMPLATE"]["TITLE"] : $arResult["NAME"]); ?></span></span>
        </div>
    </div>

    <div class="catalog-heading">
        <h1 class="h1 catalog-heading-title"><?php echo($arParams["TEMPLATE"]["TITLE"] ? $arParams["TEMPLATE"]["TITLE"] : $arResult["NAME"]); ?></h1>
        <div class="catalog-heading-description"></div>
    </div>
    <?php $this->EndViewTarget(); ?>
<?php endif; ?>

<?php
if ($arResult['ITEMS']):
    $inCartArray = Preorder::getUserCarts();
    ?>
    <div <?php if ($arParams["TEMPLATE"]["IS_SLIDER"] == "Y" && count($arResult['ITEMS']) > 4): ?>class="page-inner page-inner--w1"<?php endif; ?>>
        <div class="catalog-inner">
            <div class="catalog <?php if ($arParams["TEMPLATE"]["IS_SLIDER"] != "Y"): ?>catalog--responsive<?php endif; ?>">
                <?php if ($arParams["TEMPLATE"]["IS_SLIDER"] == "Y" && count($arResult['ITEMS']) > 4): ?>
                    <div class="catalog-header">
                        <div class="catalog-title">

                            <?php if ($arParams["TEMPLATE"]["ALL_LINK"]): ?>
                            <a href="<?php echo $arParams["TEMPLATE"]["ALL_LINK"]; ?>" class="link link--black">
                                <?php endif; ?>
                                <?php echo $arParams["TEMPLATE"]["TITLE"]; ?>
                                <?php if ($arParams["TEMPLATE"]["ALL_LINK"]): ?>
                            </a>
                        <?php endif; ?>
                        </div>
                        <div class="catalog-nav">
                            <span class="catalog-nav-item catalog-nav-item--prev"></span>
                            <span class="catalog-nav-counter">
				    	    	<span class="catalog-nav-counter-current">1</span>
				    	    	<span class="catalog-nav-counter-divider">/</span>
				    	    	<span class="catalog-nav-counter-all">&nbsp;</span>
				    	    </span>
                            <span class="catalog-nav-item catalog-nav-item--next"></span>
                        </div>
                        <?php if ($arParams["TEMPLATE"]["ALL_LINK"]): ?>
                            <div class="catalog-link">
                                <a href="<?php echo $arParams["TEMPLATE"]["ALL_LINK"]; ?>" class="link link--black">Показать
                                    все</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="catalog-items" <?php if ($arParams["TEMPLATE"]["IS_SLIDER"] == "Y" && count($arResult['ITEMS']) > 4): ?>data-slick='{"slidesToShow": 4, "slidesToScroll": 4}'<?php endif; ?>>
                    <?php foreach ($arResult["ITEMS"] as $arItem):
//                        op($arItem['PREVIEW_PICTURE']);
                        ?>
                        <div class="catalog-item catalog-item--w1">
                            <div class="catalog-item-inner">
                                <a href="<?php echo customDetailUrl($arItem['DETAIL_PAGE_URL']); ?>"
                                   class="catalog-item-link">

                                    <div class="catalog-item-photo-holder <?php if (!$arItem['PREVIEW_PICTURE']): ?>catalog-item-photo-holder--empty<?php endif; ?>">
                                        <img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC']; ?>"
                                             alt="<?php echo $arItem['PREVIEW_PICTURE']['ALT']; ?>"
                                             class="catalog-item-photo"/>

                                        <?php if ($arParams["TEMPLATE"]["DISPLAY_REMOVE_FROM_FAVORITES"] == "Y"): ?>
                                            <div class="catalog-item-removeFromfavorites"
                                                 data-id="<?php echo $arItem["ID"]; ?>"></div>
                                        <?php else: ?>
                                            <div class="catalog-item-add2favorites <?php if (СGCBookmark::isProductInFavorites($arItem["ID"])): ?>added<?php endif; ?>"
                                                 data-id="<?php echo $arItem["ID"]; ?>"></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="catalog-item-name">
										<span class="catalog-item-name-pre">
											арт. <?php echo $arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']; ?>
                                            <?php if ($arItem["PRODUCT_INFO"]["BARCODE"]): ?>,
                                                <br/>штрихкод: <?php echo $arItem["PRODUCT_INFO"]["BARCODE"]; ?><?php endif; ?>
                                            <?php if ($arItem["PRODUCT_INFO"]["IN_PACK"]): ?>,
                                                <br/>упаковки: <?php echo $arItem["PRODUCT_INFO"]["IN_PACK"]; ?><?php endif; ?>
										</span>
                                        <br>
                                        <?php echo $arItem["NAME"]; ?>
                                    </div>
                                </a>
                                <?php
                                if ($arItem["MIN_PRICE"]): ?>
                                    <?php if ($arItem["CATALOG_QUANTITY"] > 0): ?>
                                        <div class="catalog-item-market">
                                            <div class="catalog-item-market-title">цена за 1шт.</div>

                                            <div class="catalog-item-price <?php if (!empty($arItem['MIN_PRICE']['DISCOUNT_DIFF']) && $arItem["MIN_PRICE"]["SIMPLE_DISCOUNT"] == "Y"): ?>catalog-item-price--has_old<?php endif; ?>">
                                                <?php if (!empty($arItem['MIN_PRICE']['DISCOUNT_DIFF']) && $arItem["MIN_PRICE"]["SIMPLE_DISCOUNT"] == "Y"): ?>
                                                    <span class="catalog-item-price-old"><?php echo $arItem['MIN_PRICE']['PRINT_VALUE']; ?></span>
                                                <?php endif; ?>
                                                <span class="catalog-item-price-current"><?php echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?></span>
                                                <?php
                                                if ($arItem['MIN_PRICE']["PRICE_ID"] == $GLOBALS["RETAIL_PRICE_TYPE_ID"]): ?>
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
                                                               value="<?= $arItem["PRODUCT_INFO"]["MULTIPLE"] ?>"
                                                               data-pack="<?= $arItem["PRODUCT_INFO"]["MULTIPLE"]; ?>"
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
                                                               value="<?= $arItem["PRODUCT_INFO"]["MULTIPLE"] ?>"
                                                               data-pack="<?= $arItem["PRODUCT_INFO"]["MULTIPLE"]; ?>"
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
                                                            value="<?= $arItem["PRODUCT_INFO"]["MULTIPLE"] ?>"
                                                            data-pack="<?= $arItem["PRODUCT_INFO"]["MULTIPLE"]; ?>"
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
                                                            value="<?= $arItem["PRODUCT_INFO"]["MULTIPLE"] ?>"
                                                            data-pack="<?= $arItem["PRODUCT_INFO"]["MULTIPLE"]; ?>"
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
                                    <?php else: ?>
                                        <div class="catalog-item-market">
                                            <div class="catalog-item-price catalog-item-price-no">Нет в наличии</div>
                                        </div>
                                    <?php endif;
                                    ?>
                                <?php endif;?>
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
                                    <?php if (($arItem['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "Скидка") || (!empty($arItem['PROPERTIES']['SKIDKA']['VALUE']))): ?>
                                        <div class="catalog-item-promo-item catalog-item-promo-item--discount"><?php echo $arItem['PROPERTIES']['SKIDKA']['VALUE']; ?>
                                            %
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($arItem['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "Новинка"): ?>
                                        <div class="catalog-item-promo-item catalog-item-promo-item--new"></div>
                                    <?php endif; ?>

                                    <?php if ($arItem['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "Хит"): ?>
                                        <div class="catalog-item-promo-item catalog-item-promo-item--hit"></div>
                                    <?php endif; ?>
                                </div>

                                <?php if ($arItem["PROPERTIES"]["PREDLAGAT_PODAROK"]["VALUE"]): ?>
                                    <div class="catalog-item-add_gift"></div>
                                <?php endif; ?>

                                <?php if ($arItem["PROPERTIES"]["PODAROK"]["VALUE"]): ?>
                                    <div class="catalog-item-is_gift"></div>
                                <?php endif; ?>

                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

                <?php if ($arParams["TEMPLATE"]["DISPLAY_FOOTER"] == "Y"): ?>
                    <div class="catalog-footer">
                        <a href="<?php echo $arParams["TEMPLATE"]["FOOTER_LINK"]; ?>"
                           class="link link--arrow animation-link">Все товары</a>
                    </div>
                <?php endif; ?>

            </div>

            <?php if ($arParams["DISPLAY_BOTTOM_PAGER"] == "Y"): ?>
                <?php echo $arResult["NAV_STRING"]; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>