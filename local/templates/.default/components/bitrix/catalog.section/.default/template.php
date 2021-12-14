<? $this->SetViewTarget('section_title'); ?>
<div itemprop="breadcrumb" class="page-breadcrumbs">
              <div class="page-breadcrumbs-item-holder"><a href="/" itemprop="url" class="page-breadcrumbs-item link link--black"><span itemprop="name" class="page-breadcrumbs-item-name">Главная</span></a>
              </div>
              <div class="page-breadcrumbs-item-holder"><a href="/catalog/" itemprop="url" class="page-breadcrumbs-item link link--black animation-link"><span itemprop="name" class="page-breadcrumbs-item-name">Каталог</span></a>
	      </div>
              <? foreach ($arResult['PATH'] as $arSection) { ?>
			<? if ($arSection['ID'] != $arResult['ID']) { ?>
				<div class="page-breadcrumbs-item-holder"><a href="<?=$arSection['SECTION_PAGE_URL']?>" itemprop="url" class="page-breadcrumbs-item link link--black animation-link"><span itemprop="name" class="page-breadcrumbs-item-name"><?=$arSection['NAME']?></span></a>
				</div>
			<? } ?>
	      <? } ?>
		<div class="page-breadcrumbs-item-holder"><span class="page-breadcrumbs-item"><span itemprop="name" class="page-breadcrumbs-item-name"><?=$arResult['NAME']?></span></span>
              </div>
            </div>
<div class="catalog-heading">
	<h1 class="h1 catalog-heading-title"><?=$arResult['NAME']?></h1>
	<div class="catalog-heading-description"><?=$arResult['DESCRIPTION']?></div>
</div>
<? $this->EndViewTarget(); ?> 
<?
	global $inCartArray;
//	deb($arResult['PATH']);
?>
<? if (!empty($arResult['ITEMS'])) { ?>
    <div class="catalog-inner">
	    <div class="catalog">
		<div class="catalog-items">
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
    <? if (1) { 
	    
		$krat = 1;
		foreach ($arItem['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
		{
			if ($arItem['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'КратностьОтгрузки')
			{
				$krat = (int)$val;
				break;
			}
		}
	    ?>
		<? if ($arItem['CATALOG_QUANTITY'] > 0) { ?>
	                    <div class="catalog-item-market">
				<div class="catalog-item-market-title">цена за 1шт.</div>
				
				
				<div class="catalog-item-price"><? if (!empty($arItem['MIN_PRICE']['DISCOUNT_DIFF']) && $arItem["MIN_PRICE"]["SIMPLE_DISCOUNT"] == "Y") { ?><span class="catalog-item-price-old"><?=$arItem['MIN_PRICE']['PRINT_VALUE']?></span><? } ?><span class="catalog-item-price-current"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></span>
				


				<?php if($arParams["USER_TYPE"] == "SIMPLE"): ?>
					<span class="catalog-item-price-type">розничная цена</span>
				<?php endif; ?>
				
				
				
				</div>
								
				<div class="catalog-item-buy-holder">
					
					<?php //if($arItem["PROPERTIES"]["PROTSENT_DOSTUPNOSTI"]["VALUE"]): ?>
						<div class="catalog-quantity-line" data-value="<?php echo $arItem["PROPERTIES"]["PROTSENT_DOSTUPNOSTI"]["VALUE"]; ?>"></div>
					<?php //endif; ?>
					
				    <input type="text" value="<?=$krat?>" data-pack="<?=$krat?>" data-id="<?=$arItem['ID']?>" class="form-item form--number form-item--text catalog-item-quantity product-quantity"><a href="#" data-q="<?=$inCartArray[$arItem['ID']]['QUANTITY']?>" class="catalog-item-buy btn btn--gray product-buy"><? if (!empty($inCartArray[$arItem['ID']])) { ?>В корзине <?=$inCartArray[$arItem['ID']]['QUANTITY']?><? } else { ?>Купить<? } ?></a>
				</div>
	                    </div>
		<? } ?>
    <? } ?>
			
			<div class="catalog-item-promos">
				<? if (!empty($arItem['PROPERTIES']['SKIDKA']['VALUE'])) { ?>
					<div class="catalog-item-promo-item catalog-item-promo-item--discount"><?php echo $arItem['PROPERTIES']['SKIDKA']['VALUE']; ?>%</div>
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
	    </div>
	    <?=$arResult['NAV_STRING']?>
	</div>
<? } ?>