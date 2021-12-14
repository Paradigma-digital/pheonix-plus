<?
$inCartArray = Preorder::getUserCarts();
?>
<!--Breadcrumbs-->
<div itemprop="breadcrumb" class="page-breadcrumbs">
    <div class="page-breadcrumbs-item-holder"><a href="/" itemprop="url" class="page-breadcrumbs-item link link--black"><span
                    itemprop="name" class="page-breadcrumbs-item-name">Главная</span></a>
    </div>
    <div class="page-breadcrumbs-item-holder"><a href="/catalog/" itemprop="url"
                                                 class="page-breadcrumbs-item link link--black animation-link"><span
                    itemprop="name" class="page-breadcrumbs-item-name">Каталог</span></a>
    </div>
    <? foreach ($arResult['SECTION']['PATH'] as $arSection) { ?>
        <div class="page-breadcrumbs-item-holder"><a href="<?= $arSection['SECTION_PAGE_URL'] ?>" itemprop="url"
                                                     class="page-breadcrumbs-item link link--black animation-link"><span
                        itemprop="name" class="page-breadcrumbs-item-name"><?= $arSection['NAME'] ?></span></a>
        </div>
    <? } ?>
    <!--		<div class="page-breadcrumbs-item-holder"><span class="page-breadcrumbs-item"><span itemprop="name" class="page-breadcrumbs-item-name"><?= $arResult['NAME'] ?></span></span>
              </div>-->
</div>
<!--//Breadcrumbs-->
<div class="product <?php if ($arResult["3D"]): ?>product--3d<?php endif; ?> <?php if ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE']): ?>product--morephotos<?php endif; ?>">
    <div class="product-info-mobile">


        <div class="product-article">арт. <?= $arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'] ?></div>
        <div class="product-description"><?= $arResult['NAME'] ?></div>
        <?php if (0): ?>
            <div class="product-about">
                <div class="page-text"><?php echo $arResult["PREVIEW_TEXT"]; ?></div>
            </div>
        <?php endif; ?>
    </div>
    <div class="product-photos-holder">
        <div class="product-promos">
            <!--// sdemon72 20201214 добавил условие "или" на ненулевую скидку-->
            <? if (($arResult['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "Скидка") ||
                (!empty($arResult['PROPERTIES']['SKIDKA']['VALUE']))) { ?>
                <!--// _sdemon72 20201214 -->
                <div class="catalog-item-promo-item catalog-item-promo-item--discount"><?php echo $arResult['PROPERTIES']['SKIDKA']['VALUE']; ?>
                    %
                </div>
            <? } ?>
            <? if ($arResult['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "Новинка") { ?>
                <div class="product-promo-item product-promo-item--new"></div>
            <? } ?>
            <? if ($arResult['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "Хит") { ?>
                <div class="product-promo-item product-promo-item--hit"></div>
            <? } ?>
        </div>


        <div class="catalog-item-add2favorites <?php if (СGCBookmark::isProductInFavorites($arResult["ID"])): ?>added<?php endif; ?>"
             data-id="<?php echo $arResult["ID"]; ?>"></div>

        <?php if ($arResult["PROPERTIES"]["PREDLAGAT_PODAROK"]["VALUE"]): ?>
            <div class="catalog-item-add_gift"></div>
        <?php endif; ?>
        <?php if ($arResult["PROPERTIES"]["PODAROK"]["VALUE"]): ?>
            <div class="catalog-item-is_gift"></div>
        <?php endif; ?>

        <?php if ($arResult["YOUTUBE_VIDEO"]): ?>
            <a href="#t5" class="catalog-item-youtube-link">Видео о товаре</a>
        <?php endif; ?>

        <div data-width="100%" data-ratio="1/0.91" data-arrows="false" data-nav="thumbs" data-auto="false"
             data-margin="0" data-fit="scaledown" data-thumbwidth="95" data-thumbheight="95" data-shadows="false"
             data-thumbfit="scaledown" data-transitionduration="750" data-loop="true"
             class="product-photos fotorama <?php if (!$arResult['DETAIL_PICTURE']): ?>product-photos--empty<?php endif; ?>">

            <img src="<?= $arResult['DETAIL_PICTURE']['SRC'] ?>">

            <? if (!empty($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])) { ?>
                <? foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $photoID) { ?>
                    <img src="<?= CFile::GetPath($photoID) ?>">
                <? } ?>


            <? } ?>
        </div>

        <?php if ($arResult["3D"]): ?>
            <a href="#product-360" data-type="inline" data-modal="false" class="product-360 popup">360</a>
        <?php endif; ?>
    </div>
    <div class="product-info">
        <div class="product-info-desktop">

            <?php if ($arResult["PROPERTIES"]["PREDLAGAT_PODAROK"]["VALUE"] || $arResult["PROPERTIES"]["PODAROK"]["VALUE"] && 0): ?>
                <a href="/gifts/" class="product-gift">Участвуйте в акции!</a>
            <?php endif; ?>

            <div class="product-article">арт. <?= $arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'] ?>
                <div class="catalog-item-name" style="font-size: 15px;line-height: 18px;margin-top: 7px;">
                    <?
                    $shtrih = '';
                    foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
                        if ($arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'Штрихкод единицы товара') {
                            $shtrih = $val;
                            break;
                        }
                    }
                    $in_pack = '';
                    foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
                        if ($arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'ВидыУпаковок') {
                            $in_pack = $val;
                            break;
                        }
                    }
                    ?>
                    <span class="catalog-item-name-pre"><? if (!empty($shtrih)) { ?>штрихкод: <?= $shtrih ?><? } ?><? if (!empty($in_pack)) { ?>,
                            <br/>упаковки: <?= $in_pack ?><? } ?></span>
                </div>
            </div>

            <div class="product-description"><?= $arResult['NAME'] ?></div>
            <?php if (0): ?>
                <div class="product-about">
                    <div class="page-text"><?php echo $arResult["PREVIEW_TEXT"]; ?></div>
                </div>
            <?php endif; ?>
        </div>
        <?
        $same = '';
        foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
            if ($arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'Родитель') {
                $same = $val;
                break;
            }
        }

        if (!empty($same)) {
            $elems = array();
            $elems_t = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'PROPERTY_CML2_TRAITS' => $same, ">CATALOG_QUANTITY" => "0"));
            while ($elem = $elems_t->GetNext()) {

                if ($elem["PREVIEW_PICTURE"]) {
                    $elem["PICTURE"] = CGCHelper::resizeImage($elem['PREVIEW_PICTURE'], "100", "100");
                    //print_r($elem["PICTURE"]); die;
                }
                $elems[$elem['ID']] = $elem;
            }
        }
        ?>
        <? if (!empty($elems)) { ?>
            <div class="product-colors">
                <div class="product-colors-title">Цвет:</div>
                <div class="product-colors-list">
                    <? foreach ($elems as $elem) { ?>
                        <?php if ($elem["PICTURE"]): ?>
                            <a href="<?= $elem['DETAIL_PAGE_URL'] ?>"
                               class="product-color-item animation-link <? if ($elem['ID'] == $arResult['ID']) { ?> active<? } ?>"><img
                                        src="<? echo $elem["PICTURE"]["SRC"]; ?>"></a>
                        <?php else: ?>
                            <a href="<?= $elem['DETAIL_PAGE_URL'] ?>"
                               class="product-color-item product-color-item--empty animation-link <? if ($elem['ID'] == $arResult['ID']) { ?> active<? } ?>"></a>
                        <?php endif; ?>
                    <? } ?>
                </div>
            </div>
        <? } ?>
        <? if (($arResult["MIN_PRICE"])) { ?>
            <? if ($arResult['CATALOG_QUANTITY'] > 0) { ?>
                <?
                $krat = 1;
                foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
                    if ($arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'КратностьОтгрузки') {
                        $krat = (int)$val;
                        break;
                    }
                }

                ?>
                <div class="product-price">
                    <div class="product-price-title">цена за 1шт.</div>

                    <div class="product-price-holder"><? if (!empty($arResult['MIN_PRICE']['DISCOUNT_DIFF']) && $arResult["MIN_PRICE"]["SIMPLE_DISCOUNT"] == "Y") { ?>
                            <span class="product-price-old"><?= $arResult['MIN_PRICE']['PRINT_VALUE'] ?></span><? } ?>
                        <span class="product-price-current"><?= $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></span>
                        <?php if ($arParams["USER_TYPE"] == "SIMPLE"): ?>
                            <span class="catalog-item-price-type">розничная цена</span>
                        <?php endif; ?>

                    </div>
                    <!--<div class="product-price-info">в мини упаковке 50 шт. <br>в коробе 100 шт.</div>-->
                </div>

                <div class="product-quantity">
                    <?php //if($arResult["PROPERTIES"]["PROTSENT_DOSTUPNOSTI"]["VALUE"]): ?>
                    <div class="catalog-quantity-line"
                         data-value="<?php echo $arResult["PROPERTIES"]["PROTSENT_DOSTUPNOSTI"]["VALUE"]; ?>"></div>
                    <?php //endif; ?>


                    <div class="product-quantity-title">шт.</div>
                    <?
                    $preOrder = $arResult["SHOW_PRE_ORDER"] == "Y";
                    $mainCollection = $arResult["SHOW_MAIN_COLLECTION"] == "Y";

                    if ($preOrder) {
                        ?>
                        <div style="margin-bottom: 10px">
                            <input type="text"
                                   value="<?= $krat ?>"
                                   data-pack="<?= $krat ?>"
                                   data-id="<?php echo $arResult['ID']; ?>"
                                   class="form-item form--number form-item--text product-quantity-field product-quantity">
                            <a href="javascript:void(0)"
                               data-q="<?= $inCartArray['UF_PRE_ORDER_CART'][$arResult['ID']] ?>"
                               class="catalog-item-pre_buy btn btn--red btn--large">
                                Предзаказ <?php echo $inCartArray['UF_PRE_ORDER_CART'][$arResult['ID']] ?>
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
                                   data-id="<?php echo $arResult['ID']; ?>"
                                   class="form-item form--number form-item--text product-quantity-field product-quantity">
                            <a
                                    href="javascript:void(0)"
                                    data-q="<?= $inCartArray['UF_PRE_ORDER_CART'][$arResult['ID']] ?>"
                                    class="catalog-item-pre_buy btn btn--red btn--large">
                                Предзаказ <?php echo $inCartArray['UF_PRE_ORDER_CART'][$arResult['ID']] ?>
                            </a>
                        </div>
                        <input type="text" value="<?= $krat ?>" data-pack="<?= $krat ?>" data-id="<?= $arResult['ID'] ?>"
                               class="form-item form--number form-item--text product-quantity-field product-quantity">
                        <a href="#" data-q="<?= $inCartArray[$arResult['ID']]['QUANTITY'] ?>"
                           class="btn btn--red btn--large product-quantity-add product-buy">
                            <? if (!empty($inCartArray['UF_USER_CART'][$arResult['ID']])) { ?>
                                В корзине
                                <?= $inCartArray['UF_USER_CART'][$arResult['ID']] ?><? } else { ?>
                                Купить
                            <? } ?>
                        </a>
                        <?
                    }

                    if ($arResult["SHOW_PRE_ORDER"] == "N" && $arResult["SHOW_MAIN_COLLECTION"] == "N" ) {
                        ?>
                        <input type="text" value="<?= $krat ?>" data-pack="<?= $krat ?>" data-id="<?= $arResult['ID'] ?>"
                               class="form-item form--number form-item--text product-quantity-field product-quantity">
                        <a href="#" data-q="<?= $inCartArray[$arResult['ID']]['QUANTITY'] ?>"
                           class="btn btn--red btn--large product-quantity-add product-buy">
                            <? if (!empty($inCartArray['UF_USER_CART'][$arResult['ID']])) { ?>
                                В корзине
                                <?= $inCartArray['UF_USER_CART'][$arResult['ID']] ?><? } else { ?>
                                Купить
                            <? } ?>
                        </a>
                        <?
                    }
                    ?>
                </div>
            <? } else { ?>
                <?php if (0): ?>
                    <div class="product-price">

                        <div class="product-price-title">цена за 1шт.</div>

                        <div class="product-price-holder"><? if (!empty($arResult['MIN_PRICE']['DISCOUNT_DIFF']) && $arResult["MIN_PRICE"]["SIMPLE_DISCOUNT"] == "Y") { ?>
                                <span class="product-price-old"><?= $arResult['MIN_PRICE']['PRINT_VALUE'] ?></span><? } ?>
                            <span class="product-price-current"><?= $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?></span>
                        </div>
                        <!--<div class="product-price-info">в мини упаковке 50 шт. <br>в коробе 100 шт.</div>-->
                    </div>
                <?php endif; ?>
                <div class="product-price product-price-no">
                    <div class="product-price-title">Нет в наличии</div>
                </div>
            <? } ?>
        <? } ?>


        <?php if (!$USER->IsAuthorized() && 0): ?>
            <div class="product-register">
                <div class="product-register-title">Видеть цены могут только зарегистрированные партнёры.</div>
                <a href="/register/" class="btn btn--red btn--large">Узнать цену</a>
            </div>

            <br/>
            <div class="catalog-item-market">
                <a href="#shops-list" class="btn btn--gray popup" data-type="inline">Где купить?</a>
            </div>

        <?php endif; ?>


        <?php if ($USER->IsAuthorized() && !$arResult["MIN_PRICE"] && $arResult["CATALOG_QUANTITY"] > 0): ?>
            <div class="catalog-item-market">
                <a href="#shops-list" class="btn btn--gray btn--large popup" data-type="inline">Купить</a>
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
                "SOCIAL" => $arResult,
            )
        ); ?>


    </div>
</div>
<?

$propsShow = array();
foreach ($arResult['PROPERTIES'] as $arProp) {
    if ($arProp['SORT'] > 500 && !empty($arProp['VALUE'])) {
        $propsShow[] = $arProp;
    }
}

$packPostfix = array(
    'WEIGHT' => 'кг',
    'VOLUME' => 'м<sup>3</sup>',
);
$packInfo = array(
    'indiv' => array(
        'TITLE' => 'Единица товара',
        'NAME' => 'Единица товара',
        'WEIGHT' => 'Вес единицы товара',
        'VOLUME' => 'Объем единицы товара',
        'SIZE' => 'Размеры единицы товара',
        'SHTIH' => 'Штрихкод единицы товара',
    ),
    'mini' => array(
        'TITLE' => 'Миниупаковка',
        'NAME' => 'В миниупаковке',
        'WEIGHT' => 'Вес миниупаковки',
        'VOLUME' => 'Объем миниупаковки',
        'SIZE' => 'Размеры миниупаковки',
        'SHTIH' => '',
    ),
    'korob' => array(
        'TITLE' => 'Коробка',
        'NAME' => 'В коробке',
        'WEIGHT' => 'Вес коробки',
        'VOLUME' => 'Объем коробки',
        'SIZE' => 'Размеры коробки',
        'SHTIH' => '',
    ),
);

$packShow = array();
foreach ($packInfo as $packKey => $packVal) {
    $found = false;
    foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
        if ($arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == $packVal['NAME']) {
            $found = true;
            break;
        }
    }

    if ($found) {
        $pack = array(
            'TITLE' => $packVal['TITLE']
        );
        foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
            if (!empty($packVal['NAME']) && $arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == $packVal['NAME']) {
                $pack['NAME'] = $val;
            }
            if (!empty($packVal['WEIGHT']) && $arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == $packVal['WEIGHT']) {
                $pack['WEIGHT'] = $val;
            }
            if (!empty($packVal['VOLUME']) && $arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == $packVal['VOLUME']) {
                $pack['VOLUME'] = $val;
            }
            if (!empty($packVal['SIZE']) && $arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == $packVal['SIZE']) {
                $pack['SIZE'] = $val;
            }
            if (!empty($packVal['SHTIH']) && $arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == $packVal['SHTIH']) {
                $pack['SHTIH'] = $val;
            }
        }
        $packShow[$packKey] = $pack;
    }
}
?>
<? if (!empty($propsShow) || !empty($arResult['DETAIL_TEXT']) || !empty($packShow)) { ?>
    <div class="product-features">
        <div class="product-features-heading">
            <? $active = false; ?>

            <? if (!empty($propsShow)) { ?>
                <span data-id="t1" class="product-features-heading-item<? if (!$active) {
                    $active = true; ?> active<? } ?>">Характеристики</span>
            <? } ?>

            <? if (!empty($arResult['DETAIL_TEXT'])) { ?>
                <span data-id="t2" class="product-features-heading-item<? if (!$active) {
                    $active = true; ?> active<? } ?>">Описание</span>
            <? } ?>


            <? if (!empty($packShow)) { ?>
                <span data-id="t3" class="product-features-heading-item<? if (!$active) {
                    $active = true; ?> active<? } ?>">Упаковка</span>
            <? } ?>

            <span data-id="t4" class="product-features-heading-item">Отзывы <span id="reviews-count"></span></span>


            <?php if ($arResult["YOUTUBE_VIDEO"]): ?>
                <span data-id="t5" class="product-features-heading-item">Видео</span>
            <?php endif; ?>

        </div>

        <div class="product-features-content">
            <? $active = false; ?>



            <? if (!empty($propsShow)) { ?>


                <div id="t1" class="product-features-content-item<? if (!$active) {
                    $active = true; ?> active<? } ?>">
                    <div data-id="t1" class="product-features-content-item-heading">Характеристики</div>
                    <div class="product-features-content-item-inner">
                        <div class="page-text">
                            <div class="dl">

                                <!---->

                                <?
                                foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val) {
                                    if ($arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'Страна происхождения') {
                                        ?>
                                        <div class="row">
                                            <div class="dt">Страна</div>
                                            <div class="dd"><?= $val ?></div>
                                        </div>
                                        <?
                                        break;
                                    }
                                }
                                ?>

                                <? foreach ($propsShow as $arProp) { ?>
                                    <div class="row">
                                        <div class="dt"><?= $arProp['NAME'] ?></div>
                                        <div class="dd"><?= $arProp['VALUE'] ?></div>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>

            <? } ?>



            <? if (!empty($arResult['DETAIL_TEXT'])) { ?>
                <div id="t2" class="product-features-content-item<? if (!$active) {
                    $active = true; ?> active<? } ?>">
                    <div data-id="t2" class="product-features-content-item-heading">Описание</div>
                    <div class="product-features-content-item-inner">
                        <div class="page-text">
                            <p><?= $arResult['~DETAIL_TEXT'] ?></p>
                        </div>
                    </div>
                </div>
            <? } ?>


            <? if (!empty($packShow)) { ?>
                <div id="t3" class="product-features-content-item">
                    <div data-id="t3" class="product-features-content-item-heading">Упаковка</div>
                    <div class="product-features-content-item-inner">
                        <div class="page-text">
                            <? foreach ($packShow as $packKey => $packVal) { ?>
                                <h3><?= $packVal['TITLE'] ?></h3>
                                <div class="dl">
                                    <? foreach ($packVal as $kPackProp => $vPackProp) { ?>
                                        <? if ($kPackProp == 'TITLE') continue; ?>
                                        <div class="row">
                                            <div class="dt"><?= $packInfo[$packKey][$kPackProp] ?></div>
                                            <div class="dd"><?= $vPackProp ?><? if (!empty($packPostfix[$kPackProp])) { ?> <?= $packPostfix[$kPackProp] ?><? } ?></div>
                                        </div>
                                    <? } ?>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </div>
            <? } ?>



            <?php if ($arResult["YOUTUBE_VIDEO"]): ?>
                <div id="t5" class="product-features-content-item">
                    <div data-id="t5" class="product-features-content-item-heading">Видео</div>
                    <div class="product-features-content-item-inner">
                        <div class="page-text">
                            <?php foreach ($arResult["YOUTUBE_VIDEO"] as $videoCode): ?>
                                <div class="video">
                                    <iframe width="560" height="315"
                                            src="https://www.youtube.com/embed/<?php echo $videoCode; ?>"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div id="t4" class="product-features-content-item">
                <div data-id="t4" class="product-features-content-item-heading">Отзывы</div>
                <div class="product-features-content-item-inner">

                    <?php if (0): ?>
                        <div id="mc-container"></div>
                        <script type="text/javascript">
                            cackle_widget = window.cackle_widget || [];
                            cackle_widget.push({widget: 'Comment', id: 74168});
                            (function () {
                                var mc = document.createElement('script');
                                mc.type = 'text/javascript';
                                mc.async = true;
                                mc.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cackle.me/widget.js';
                                var s = document.getElementsByTagName('script')[0];
                                s.parentNode.insertBefore(mc, s.nextSibling);
                            })();
                        </script>
                        <a id="mc-link" href="http://cackle.me">Комментарии для сайта <b style="color:#4FA3DA">Cackl</b><b
                                    style="color:#F65077">e</b></a>
                    <?php endif; ?>


                    <?php $APPLICATION->IncludeComponent(
                        "cackle.comments",
                        "",
                        array(
                            "CHANNEL_ID" => "product_" . $arResult["ID"]
                        ),
                        false
                    ); ?>


                </div>
            </div>
        </div>


    </div>
    </div>
<? } ?>
</div>


<?php if ($arResult["3D"]): ?>
    <div class="page-popup mfp-hide" id="product-360">
        <img
                src="<?php echo $arResult['DETAIL_PICTURE']['SRC']; ?>"
                class="reel"
                data-image="<?php echo $arResult["3D"]; ?>"
                data-frames="38"
                data-footage="6"
                data-revolution="800"
        />
    </div>
<?php endif; ?>