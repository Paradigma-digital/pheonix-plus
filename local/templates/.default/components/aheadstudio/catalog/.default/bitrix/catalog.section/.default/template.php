<?
$this->SetViewTarget('section_title'); ?>
<div itemprop="breadcrumb" class="page-breadcrumbs">
    <div class="page-breadcrumbs-item-holder"><a href="/" itemprop="url" class="page-breadcrumbs-item link link--black"><span
                    itemprop="name" class="page-breadcrumbs-item-name">Главная</span></a>
    </div>
    <div class="page-breadcrumbs-item-holder"><a href="/catalog/" itemprop="url"
                                                 class="page-breadcrumbs-item link link--black animation-link"><span
                    itemprop="name" class="page-breadcrumbs-item-name">Каталог</span></a>
    </div>
    <? foreach ($arResult['PATH'] as $arSection) { ?>
        <? if ($arSection['ID'] != $arResult['ID']) { ?>
            <div class="page-breadcrumbs-item-holder"><a href="<?= $arSection['SECTION_PAGE_URL'] ?>" itemprop="url"
                                                         class="page-breadcrumbs-item link link--black animation-link"><span
                            itemprop="name" class="page-breadcrumbs-item-name"><?= $arSection['NAME'] ?></span></a>
            </div>
        <? } ?>
    <? } ?>
    <div class="page-breadcrumbs-item-holder"><span class="page-breadcrumbs-item"><span itemprop="name"
                                                                                        class="page-breadcrumbs-item-name"><?= $arResult['NAME'] ?></span></span>
    </div>
</div>
<div class="catalog-heading">
    <h1 class="h1 catalog-heading-title"><?= $arResult['NAME'] ?></h1>
    <div class="catalog-heading-description"><?= $arResult['DESCRIPTION'] ?></div>
</div>
<? $this->EndViewTarget();

if (!empty($arResult['ITEMS'])) {
    $inCartArray = Preorder::getUserCarts();
    ?>
    <div class="catalog-inner">
        <?
        $GLOBALS['SHOW_ELEMENTS_OF_CATALOG'] = true;
        /*
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "section.nav",
            array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "SECTION_ID" => $arResult["ORIGINAL_PARAMETERS"]["SECTION_ID"],
                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "CACHE_TYPE" => "N",
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                //"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
                "TOP_DEPTH" => ($arResult["DEPTH_LEVEL"]),
                "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
                "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
                "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                "ADD_SECTIONS_CHAIN" => "N"
            ),
            $component,
            array("HIDE_ICONS" => "Y")
        );*/
        ?>
        <div class="catalog">
            <div class="catalog-items">
                <? foreach ($arResult['ITEMS'] as $arItem) { ?>
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
                            <?
							// op($arItem["MIN_PRICE"]);
                            if ($arItem["MIN_PRICE"] && $arItem["MIN_PRICE"]["VALUE"] > 0) {
                                $krat = 1;
                                foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
                                    if ($arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'КратностьОтгрузки') {
                                        $krat = (int)$val;
                                        break;
                                    }
                                }

                                if ($arItem['CATALOG_QUANTITY'] > 0) { ?>
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
                                <? 
								} 
							} else {
								if ($USER->IsAuthorized() && $arItem["MIN_PRICE"]["VALUE"] == 0)
								{ 
								?>
									<div class="catalog-item-market">
										<a href="#shops-list" class="btn btn--gray btn--full popup" data-type="inline">Купить</a>
									</div>
								<?
								}
							}
							?>
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
        </div>
        <div class="catalog-sort catalog-sort--footer">
            <div class="catalog-sort-item catalog-sort-item--large"><span
                        class="catalog-sort-item-title">Сортировать по</span>
                <select name='sort' class="form-item--select"
                        onchange="document.location = '<?= $APPLICATION->GetCurPage() ?>?sort='+$(this).val();">
                    <? foreach (sortClass::$points as $kpoint => $point) { ?>
                        <option<? if ($kpoint == sortClass::getValue()) { ?> selected=""<? } ?>
                                value="<?= $kpoint ?>"><?= $point['TEXT'] ?></option>
                    <? } ?>
                </select>
            </div>
            <div class="catalog-sort-item catalog-sort-item--small"><span
                        class="catalog-sort-item-title">показывать по</span>
                <select class="form-item--select"
                        onchange="document.location = '<?= $APPLICATION->GetCurPage() ?>?perpage='+$(this).val();">
                    <? foreach (perPageClass::$points as $kpoint => $point) { ?>
                        <option<? if ($kpoint == perPageClass::getValue()) { ?> selected=""<? } ?>
                                value="<?= $kpoint ?>"><?= $point ?></option>
                    <? } ?>
                </select>
            </div>
            <a href="#filter" data-type="inline" class="catalog-filter-mobile popup"><span
                        class="catalog-filter-mobile-title">Фильтр</span><span class="catalog-filter-mobile-icon"><span
                            class="catalog-filter-mobile-icon-item catalog-filter-mobile-icon-item--1"></span><span
                            class="catalog-filter-mobile-icon-item catalog-filter-mobile-icon-item--2"></span><span
                            class="catalog-filter-mobile-icon-item catalog-filter-mobile-icon-item--3"></span></span></a>
        </div>
        <?= $arResult['NAV_STRING'] ?>
    </div>
<? } else { ?>
    <div class="catalog-empty">
        <!--<div class="catalog-empty-img"><img src="/local/templates/.default/svg/hourglass.svg"></div>-->
        <div class="catalog-empty-title">Извините, товар ожидается к поступлению.</div>
        <div class="catalog-empty-action"><a href="/" class="link link--larrow"><span>Перейти на главную</span></a>
        </div>
    </div>
<?php } ?>