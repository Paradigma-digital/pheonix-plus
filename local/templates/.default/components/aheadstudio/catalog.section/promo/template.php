<? if (!empty($arResult['ITEMS']))
{
$inCartArray = Preorder::getUserCarts();
?>
	    <div class="catalog">
		    
		    <?php if($arParams["DISPLAY_AS_SLIDER"]): ?>
              <div class="catalog-header">
                <div class="catalog-title"><?php echo $arParams["HEADING"]["TITLE"]; ?></div>
                <div class="catalog-nav"><span class="catalog-nav-item catalog-nav-item--prev"></span><span class="catalog-nav-counter"><span class="catalog-nav-counter-current">1</span><span class="catalog-nav-counter-divider">/</span><span class="catalog-nav-counter-all">&nbsp;</span></span><span class="catalog-nav-item catalog-nav-item--next"></span></div>

              </div>
            <?php else: ?>
            	
            	 <div class="catalog-header">
	            	 <div class="catalog-title"><?php echo $arParams["HEADING"]["TITLE"]; ?></div>
	            	  <div class="catalog-nav"><span class="catalog-nav-item catalog-nav-item--prev"></span><span class="catalog-nav-counter"><span class="catalog-nav-counter-current">1</span><span class="catalog-nav-counter-divider">/</span><span class="catalog-nav-counter-all">&nbsp;</span></span><span class="catalog-nav-item catalog-nav-item--next"></span></div>
            	 </div>
            
            <?php endif; ?>
		    
		 <div <?php if($arParams["DISPLAY_AS_SLIDER"]): ?>data-slick='{"sledesPerRow": 4, "slidesToShow": 4, "slidesToScroll": 4}'<?php else: ?>data-slick='{"sledesPerRow": 4, "slidesToShow": 4, "slidesToScroll": 4, "rows": 2}'<?php endif; ?> class="catalog-items">
                    <? foreach ($arResult['ITEMS'] as $arItem) { //deb($arItem['MIN_PRICE'], false)?>
    	    <div class="catalog-item catalog-item--w1">
		<div class="catalog-item-inner"><a href="<?=customDetailUrl($arItem['DETAIL_PAGE_URL'])?>" class="catalog-item-link">
			<? if (!empty($arItem['PREVIEW_PICTURE'])) { ?>
			    <div class="catalog-item-photo-holder"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>" class="catalog-item-photo"></div>
			<? } else { ?>
				<div class="catalog-item-photo-holder catalog-item-photo-holder--empty"></div>
			<? } ?>
    			<!--<div class="catalog-item-photo-holder"><img src="/local/templates/.default/dummy/catalog/c1.jpg" class="catalog-item-photo out"><img src="/local/templates/.default/dummy/catalog/c2.jpg" class="catalog-item-photo over"></div>-->
    			<div class="catalog-item-name">
				<?
				$shtrih = '';
				foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
				{
					if ($arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == '???????????????? ?????????????? ????????????')
					{
						$shtrih = $val;
						break;
					}
				}
				$in_pack = '';
				foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
				{
					if ($arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == '????????????????????????')
					{
						$in_pack = $val;
						break;
					}
				}
				?>
				<span class="catalog-item-name-pre">??????. <?=$arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']?><? if (!empty($shtrih)) { ?>, ????????????????: <?=$shtrih?><? } ?><? if (!empty($in_pack)) { ?>,<br/>????????????????: <?=$in_pack?><? } ?></span>
				<br><?=$arItem['NAME']?></div></a>
    <? if (($arItem["MIN_PRICE"])) { 
		$krat = 1;
		foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
		{
			if ($arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == '??????????????????????????????????')
			{
				$krat = (int)$val;
				break;
			}
		}?>
		<?php if(!$arParams["HIDE_CONTROLS"]): ?>
			<? if ($arItem['CATALOG_QUANTITY'] > 0 ) { ?>
	                    <div class="catalog-item-market">
				<div class="catalog-item-market-title">???????? ???? 1????.</div>
				
				
				<div class="catalog-item-price"><? if (!empty($arItem['MIN_PRICE']['DISCOUNT_DIFF']) && $arItem["MIN_PRICE"]["SIMPLE_DISCOUNT"] == "Y") { ?><span class="catalog-item-price-old"><?=$arItem['MIN_PRICE']['PRINT_VALUE']?></span><? } ?><span class="catalog-item-price-current"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></span>
				
				
				<?php if($arParams["USER_TYPE"] == "SIMPLE"): ?>
					<span class="catalog-item-price-type">?????????????????? ????????</span>
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
                                            ?????????????????? <?php echo $inCartArray['UF_PRE_ORDER_CART'][$arItem['ID']] ?>
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
                                            ?????????????????? <?php echo $inCartArray['UF_PRE_ORDER_CART'][$arItem['ID']] ?>
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
                                            ?? ??????????????
                                            <?= $inCartArray['UF_USER_CART'][$arItem['ID']] ?><? } else { ?>
                                            ????????????
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
                                            ?? ??????????????
                                            <?= $inCartArray['UF_USER_CART'][$arItem['ID']] ?><? } else { ?>
                                            ????????????
                                        <? } ?>
                                    </a>
                                    <?
                                }
                                ?>
                            </div>
	                    </div>
			<? } else { ?>
				<div class="catalog-item-market">
					<div class="catalog-item-price catalog-item-price-no">?????? ?? ??????????????</div>
				</div>
			<?php } ?>
		<?php endif; ?>
    <? } ?>
	

		<?php if($USER->IsAuthorized() && !$arItem["MIN_PRICE"]): ?>
			<div class="catalog-item-market">
				<a href="#shops-list" class="btn btn--gray btn--full popup" data-type="inline">????????????</a>
			</div>
		<?php endif; ?>
	
	
				<?php $APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					Array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "",
						"EDIT_TEMPLATE" => "",
						"PATH" => "/include/product_social.php",
						"SOCIAL" => $arItem,
					)
				);?>
			
		      <div class="catalog-item-promos">
				<? if($arItem['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "????????????") { ?>
					<div class="catalog-item-promo-item catalog-item-promo-item--discount"><?php echo $arItem['PROPERTIES']['SKIDKA']['VALUE']; ?>%</div>
				<? } ?>
				<? if($arItem['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "??????????????") { ?>
					<div class="catalog-item-promo-item catalog-item-promo-item--new"></div>
				<? } ?>
				<? if($arItem['PROPERTIES']['STATUS_TOVARA']['VALUE_ENUM'] == "??????") { ?>
					<div class="catalog-item-promo-item catalog-item-promo-item--hit"></div>
				<? } ?>
				
				

				
				
               </div>
               
               
				<?php if($arItem["PROPERTIES"]["PREDLAGAT_PODAROK"]["VALUE"]): ?>
					<div class="catalog-item-add_gift"></div>
				<?php endif; ?>
				<?php if($arItem["PROPERTIES"]["PODAROK"]["VALUE"]): ?>
					<div class="catalog-item-is_gift"></div>
				<?php endif; ?>
               
               
               
    		</div>
    	    </div>
	    <? } ?>
		</div>
	    </div>
	    <?=$arResult['NAV_STRING']?>
<? } ?>