<? if (!empty($arResult['ITEMS'])) { ?>
<?
	global $inCartArray;
?>
    <div class="page-inner page-inner--w1">
        <div class="catalog catalog--responsive">
    	<div class="catalog-header">
    	    <div class="catalog-title">Популярные товары</div>
    	    <div class="catalog-nav"><span class="catalog-nav-item catalog-nav-item--prev"></span><span class="catalog-nav-counter"><span class="catalog-nav-counter-current">1</span><span class="catalog-nav-counter-divider">/</span><span class="catalog-nav-counter-all">&nbsp;</span></span><span class="catalog-nav-item catalog-nav-item--next"></span></div>
    	</div>
    	<div class="catalog-items">
	    <? foreach ($arResult['ITEMS'] as $arItem) { //deb($arItem['MIN_PRICE'], false)?>
    	    <div class="catalog-item catalog-item--w1">
		<div class="catalog-item-inner"><a href="<?=customDetailUrl($arItem['DETAIL_PAGE_URL'])?>" class="catalog-item-link">
			<? if (!empty($arItem['PREVIEW_PICTURE'])) { ?>
			    <div class="catalog-item-photo-holder"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>" class="catalog-item-photo"></div>
			<? } ?>
    			<!--<div class="catalog-item-photo-holder"><img src="/local/templates/.default/dummy/catalog/c1.jpg" class="catalog-item-photo out"><img src="/local/templates/.default/dummy/catalog/c2.jpg" class="catalog-item-photo over"></div>-->
    			<div class="catalog-item-name">
				<?
				$shtrih = '';
				foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
				{
					if ($arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'Штрихкод единицы товара')
					{
						$shtrih = $val;
						break;
					}
				}
				$in_pack = '';
				foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
				{
					if ($arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'ВидыУпаковок')
					{
						$in_pack = $val;
						break;
					}
				}
				?>
				<span class="catalog-item-name-pre">арт. <?=$arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']?><? if (!empty($shtrih)) { ?>, штрихкод: <?=$shtrih?><? } ?><? if (!empty($in_pack)) { ?>,<br/>упаковки: <?=$in_pack?><? } ?></span>
				<br><?=$arItem['NAME']?></div></a>
    <? if ($USER->IsAuthorized())
    { 
		$krat = 1;
		foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
		{
			if ($arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'КратностьОтгрузки')
			{
				$krat = (int)$val;
				break;
			}
		}?>
		<? if ($arItem['CATALOG_QUANTITY'] > 0) { ?>
	                    <div class="catalog-item-market">
				<div class="catalog-item-market-title">цена за 1шт.</div>
				<div class="catalog-item-price"><? if (!empty($arItem['MIN_PRICE']['DISCOUNT_DIFF'])) { ?><span class="catalog-item-price-old"><?=$arItem['MIN_PRICE']['PRINT_VALUE']?></span><? } ?><span class="catalog-item-price-current"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></span></div>
				<div class="catalog-item-buy-holder">
				    <input type="text" value="<?=$krat?>" data-pack="<?=$krat?>" data-id="<?=$arItem['ID']?>" class="form-item form--number form-item--text catalog-item-quantity product-quantity"><a data-q="<?=$inCartArray[$arItem['ID']]['QUANTITY']?>" href="#" class="catalog-item-buy btn btn--gray product-buy"><? if (!empty($inCartArray[$arItem['ID']])) { ?>В корзине <?=$inCartArray[$arItem['ID']]['QUANTITY']?><? } else { ?>Купить<? } ?></a>
				</div>
	                    </div>
		<? } ?>
    <? } ?>
<div class="catalog-item-promos">
				<? if (!empty($arItem['PROPERTIES']['SKIDKA']['VALUE'])) { ?>
					<div class="catalog-item-promo-item catalog-item-promo-item--5"></div>
				<? } ?>
				<? if (!empty($arItem['PROPERTIES']['NOVINKA']['VALUE'])) { ?>
					<div class="catalog-item-promo-item catalog-item-promo-item--new"></div>
				<? } ?>
				<? if (!empty($arItem['PROPERTIES']['KHIT']['VALUE'])) { ?>
					<div class="catalog-item-promo-item catalog-item-promo-item--hit"></div>
				<? } ?>
				<? if (!empty($arItem['PROPERTIES']['SALE']['VALUE'])) { ?>
					<div class="catalog-item-promo-item catalog-item-promo-item--sale"></div>
				<? } ?>
                        </div>
    		</div>
    	    </div>
	    <? } ?>
    	</div>
    	<!--<div class="catalog-footer"><a href="/catalog/" class="link link--arrow animation-link">Все товары</a></div>-->
        </div>
    </div>
<? } ?>