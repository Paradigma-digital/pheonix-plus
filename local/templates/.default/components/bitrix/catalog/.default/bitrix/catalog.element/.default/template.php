<?
	global $inCartArray;
?>
            <!--Breadcrumbs-->
            <div itemprop="breadcrumb" class="page-breadcrumbs">
              <div class="page-breadcrumbs-item-holder"><a href="/" itemprop="url" class="page-breadcrumbs-item link link--black"><span itemprop="name" class="page-breadcrumbs-item-name">Главная</span></a>
              </div>
              <div class="page-breadcrumbs-item-holder"><a href="/catalog/" itemprop="url" class="page-breadcrumbs-item link link--black animation-link"><span itemprop="name" class="page-breadcrumbs-item-name">Каталог</span></a>
	      </div>
              <? foreach ($arResult['SECTION']['PATH'] as $arSection) { ?>
		<div class="page-breadcrumbs-item-holder"><a href="<?=$arSection['SECTION_PAGE_URL']?>" itemprop="url" class="page-breadcrumbs-item link link--black animation-link"><span itemprop="name" class="page-breadcrumbs-item-name"><?=$arSection['NAME']?></span></a>
              </div>
	      <? } ?>
<!--		<div class="page-breadcrumbs-item-holder"><span class="page-breadcrumbs-item"><span itemprop="name" class="page-breadcrumbs-item-name"><?=$arResult['NAME']?></span></span>
              </div>-->
            </div>
            <!--//Breadcrumbs-->
            <? //  deb($arResult)?>

<div class="product">
              <div class="product-info-mobile">
                <div class="product-article">арт. <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></div>
                <div class="product-description"><?=$arResult['NAME']?></div>
              </div>
              <div class="product-photos-holder">
                <div class="product-promos">
			<? if (!empty($arResult['PROPERTIES']['SKIDKA']['VALUE'])) { ?>
				<div class="catalog-item-promo-item catalog-item-promo-item--discount"><?php echo $arResult['PROPERTIES']['SKIDKA']['VALUE']; ?>%</div>
			<? } ?>
			<? if (!empty($arResult['PROPERTIES']['NOVINKA']['VALUE'])) { ?>
				<div class="product-promo-item product-promo-item--new"></div>
			<? } ?>
			<? if (!empty($arResult['PROPERTIES']['KHIT']['VALUE'])) { ?>
				<div class="product-promo-item product-promo-item--hit"></div>
			<? } ?>
                </div>

<div data-width="100%" data-ratio="1/0.91" data-arrows="false" data-nav="thumbs" data-margin="0" data-fit="scaledown" data-thumbwidth="95" data-thumbheight="95" data-shadows="false" data-thumbfit="scaledown" data-transitionduration="750" data-loop="true" class="product-photos fotorama <?php if(!$arResult['DETAIL_PICTURE']): ?>product-photos--empty<?php endif; ?>">
    
  
    	<img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>">
    
    <? if (!empty($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])) { ?>
	<? foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $photoID) { ?>
		<img src="<?=CFile::GetPath($photoID)?>">
	<? } ?>
    <? } ?>
</div>
              </div>
              <div class="product-info">
                <div class="product-info-desktop">
                  <div class="product-article">арт. <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?>
		      <div class="catalog-item-name" style="font-size: 15px;line-height: 18px;margin-top: 7px;">
				<?
				$shtrih = '';
				foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
				{
					if ($arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'Штрихкод единицы товара')
					{
						$shtrih = $val;
						break;
					}
				}
				$in_pack = '';
				foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
				{
					if ($arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'ВидыУпаковок')
					{
						$in_pack = $val;
						break;
					}
				}
				?>
				<span class="catalog-item-name-pre"><? if (!empty($shtrih)) { ?>штрихкод: <?=$shtrih?><? } ?><? if (!empty($in_pack)) { ?>,<br/>упаковки: <?=$in_pack?><? } ?></span>
			</div></div>
				
                  <div class="product-description"><?=$arResult['NAME']?></div>
                </div>
		<?
		$same = '';
		foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
		{
			if ($arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'Родитель')
			{
				$same = $val;
				break;
			}
		}
		
		if (!empty($same))
		{
			$elems = array();
			$elems_t = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'PROPERTY_CML2_TRAITS' => $same, ">CATALOG_QUANTITY" => "0"));
			while ($elem = $elems_t->GetNext())
			{
				
				if($elem["PREVIEW_PICTURE"]) {
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
					<?php if($elem["PICTURE"]): ?>
						<a href="<?=$elem['DETAIL_PAGE_URL']?>" class="product-color-item animation-link <? if ($elem['ID'] == $arResult['ID']) { ?> active<? } ?>"><img src="<? echo $elem["PICTURE"]["SRC"]; ?>"></a>
					<?php else: ?>
						<a href="<?=$elem['DETAIL_PAGE_URL']?>" class="product-color-item product-color-item--empty animation-link <? if ($elem['ID'] == $arResult['ID']) { ?> active<? } ?>"></a>
					<?php endif; ?>
				<? } ?>
			</div>
                </div>
		<? } ?>
	<? if ($USER->IsAuthorized()) { ?>
		<? if ($arResult['CATALOG_QUANTITY'] > 0) { ?>
			<?
			$krat = 1;
			foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
			{
				if ($arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'КратностьОтгрузки')
				{
					$krat = (int)$val;
					break;
				}
			}

			?>
			<div class="product-price">
			  <div class="product-price-title">цена за 1шт.</div>

			  <div class="product-price-holder"><? if (!empty($arResult['MIN_PRICE']['DISCOUNT_DIFF']) && $arResult["MIN_PRICE"]["SIMPLE_DISCOUNT"] == "Y") { ?><span class="product-price-old"><?=$arResult['MIN_PRICE']['PRINT_VALUE']?></span><? } ?><span class="product-price-current"><?=$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></span></div>
			  <!--<div class="product-price-info">в мини упаковке 50 шт. <br>в коробе 100 шт.</div>-->
			</div>
			<div class="product-quantity">
			  <div class="product-quantity-title">шт.</div>
			  <input type="text" value="<?=$krat?>" data-pack="<?=$krat?>" data-id="<?=$arResult['ID']?>" class="form-item form--number form-item--text product-quantity-field product-quantity"><a href="#" data-q="<?=$inCartArray[$arResult['ID']]['QUANTITY']?>" class="btn btn--red btn--large product-quantity-add product-buy"><? if (!empty($inCartArray[$arResult['ID']])) { ?>В корзине <?=$inCartArray[$arResult['ID']]['QUANTITY']?><? } else { ?>Купить<? } ?></a>
			</div>
		<? } else { ?>
		  <div class="product-price">
			  <div class="product-price-title">цена за 1шт.</div>

			  <div class="product-price-holder"><? if (!empty($arResult['MIN_PRICE']['DISCOUNT_DIFF']) && $arResult["MIN_PRICE"]["SIMPLE_DISCOUNT"] == "Y") { ?><span class="product-price-old"><?=$arResult['MIN_PRICE']['PRINT_VALUE']?></span><? } ?><span class="product-price-current"><?=$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></span></div>
			  <!--<div class="product-price-info">в мини упаковке 50 шт. <br>в коробе 100 шт.</div>-->
		  </div>
		  <div class="product-price product-price-no">
			  <div class="product-price-title">Нет в наличии</div>
		  </div>
		<? } ?>
	<? } else { ?>

                <div class="product-register">
                  <div class="product-register-title">Зарегистрируйтесь и получите доступ <br>к ценам, и возможность купить. <br>Для юридических лиц.</div><a href="/register/" class="btn btn--red btn--large">Цены</a>
                </div>
	<? } ?>
              </div>
            </div>
		<?
		
		$propsShow = array();
		foreach ($arResult['PROPERTIES'] as $arProp)
		{
			if ($arProp['SORT'] > 500 && !empty($arProp['VALUE']))
			{
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
		foreach ($packInfo as $packKey => $packVal)
		{
			$found = false;
			foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
			{
				if ($arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == $packVal['NAME'])
				{
					$found = true;
					break;
				}
			}
			
			if ($found)
			{
				$pack = array(
				    'TITLE' => $packVal['TITLE']
				);
				foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
				{
					if (!empty($packVal['NAME']) && $arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == $packVal['NAME'])
					{
						$pack['NAME'] = $val;
					}
					if (!empty($packVal['WEIGHT']) && $arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == $packVal['WEIGHT'])
					{
						$pack['WEIGHT'] = $val;
					}
					if (!empty($packVal['VOLUME']) && $arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == $packVal['VOLUME'])
					{
						$pack['VOLUME'] = $val;
					}
					if (!empty($packVal['SIZE']) && $arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == $packVal['SIZE'])
					{
						$pack['SIZE'] = $val;
					}
					if (!empty($packVal['SHTIH']) && $arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == $packVal['SHTIH'])
					{
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
		  <? $active = false;?>
		  <? if (!empty($propsShow)) { ?>
			<span data-id="t1" class="product-features-heading-item<? if (!$active) { $active = true; ?> active<? } ?>">Характеристики</span>
		  <? } ?>
		  <? if (!empty($arResult['DETAIL_TEXT'])) { ?>
			<span data-id="t2" class="product-features-heading-item<? if (!$active) { $active = true; ?> active<? } ?>">Описание</span>
		  <? } ?>
		  <? if (!empty($packShow)) { ?>
			<span data-id="t3" class="product-features-heading-item<? if (!$active) { $active = true; ?> active<? } ?>">Упаковка</span>
		  <? } ?>
			  <?/*<span data-id="t4" class="product-features-heading-item">Сертификаты</span*/?></div>
              <div class="product-features-content">
		  <? $active = false;?>
		<? if (!empty($propsShow)) { ?>
			<div id="t1" class="product-features-content-item<? if (!$active) { $active = true; ?> active<? } ?>">
			  <div data-id="t1" class="product-features-content-item-heading">Характеристики</div>
			  <div class="product-features-content-item-inner">
			    <div class="page-text">
			      <div class="dl">
				  
				  <!---->
				  
				<?
				foreach ($arResult['PROPERTIES']['CML2_TRAITS']['VALUE'] as $kval => $val)
				{
					if ($arResult['PROPERTIES']['CML2_TRAITS']['DESCRIPTION'][$kval] == 'Страна происхождения')
					{
						?>
						<div class="row">
							<div class="dt">Страна</div>
							<div class="dd"><?=$val?></div>
						</div>
						<?
						break;
					}
				}
				?>
				  
				<? foreach ($propsShow as $arProp) { ?>
					<div class="row">
						<div class="dt"><?=$arProp['NAME']?></div>
						<div class="dd"><?=$arProp['VALUE']?></div>
					</div>
				<? } ?>
			      </div>
			    </div>
			  </div>
			</div>
		<? } ?>
		<? if (!empty($arResult['DETAIL_TEXT'])) { ?>
                <div id="t2" class="product-features-content-item<? if (!$active) { $active = true; ?> active<? } ?>">
                  <div data-id="t2" class="product-features-content-item-heading">Описание</div>
                  <div class="product-features-content-item-inner">
                    <div class="page-text">
                      <p><?=$arResult['DETAIL_TEXT']?></p>
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
                      <h3><?=$packVal['TITLE']?></h3>
			<div class="dl">
			    <? foreach ($packVal as $kPackProp => $vPackProp) { ?>
				<? if ($kPackProp == 'TITLE') continue; ?>
				<div class="row">
				  <div class="dt"><?=$packInfo[$packKey][$kPackProp]?></div>
				  <div class="dd"><?=$vPackProp?><? if (!empty($packPostfix[$kPackProp])) { ?> <?=$packPostfix[$kPackProp]?><? } ?></div>
				</div>
			    <? } ?>
			</div>
		      <? } ?>
                    </div>
                  </div>
                </div>
		<? } ?>
<!--                
                <div id="t4" class="product-features-content-item">
                  <div data-id="t4" class="product-features-content-item-heading">Сертификаты</div>
                  <div class="product-features-content-item-inner">
                    <div class="link-holder"><a href="#" class="link link--doc"><span class="link-icon"> </span><span class="link-content"><span class="link-title">Сертификат соответствия</span><span class="link-size">1 Мбайт (.jpg)</span></span></a></div>
                    <div class="link-holder"><a href="#" class="link link--doc"><span class="link-icon"></span><span class="link-content"><span class="link-title">Декларация соответствия</span><span class="link-size">5 Мбайт (.jpg)</span></span></a></div>
                    <div class="link-holder"><a href="#" class="link link--doc"><span class="link-icon"> </span><span class="link-content"><span class="link-title">Сертификат происхождения</span><span class="link-size">14.4 Мбайт (.jpg)</span></span></a></div>
                    <div class="link-holder"><a href="#" class="link link--doc"><span class="link-icon"> </span><span class="link-content"><span class="link-title">Гигиенический сертификат</span><span class="link-size">5.8 Мбайт (.jpg)</span></span></a></div>
                    <div class="link-holder"><a href="#" class="link link--doc"><span class="link-icon"> </span><span class="link-content"><span class="link-title">Импортное карантинное заключение - Сертификат соответствия техническому регламенту</span><span class="link-size">1 Мбайт (.jpg)</span></span></a></div>
                    <div class="link-holder"><a href="#" class="link link--doc"><span class="link-icon"> </span><span class="link-content"><span class="link-title">Фитосанитарный сертификат</span><span class="link-size"> 1.5 Мбайт (.jpg)</span></span></a></div>
                  </div>
                </div>-->
              </div>
            </div>
		<? } ?>
          </div>