<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

	
<div class="doc-form">	
	<a href="/personal/orders/<?php echo $arParams["ORDER_ID"]; ?>/">← Вернуться в заказ</a>
	
	<h2>УПД <?php echo $arResult["INFO"]["UF_NOMERUPD"]; ?> от <?php echo $arResult["INFO"]["UF_DATA"]; ?></h2>
	
	<div class="basket columns--7">
		<div class="basket-row basket-row--heading">
			<div class="basket-col basket-col--name basket-heading-item">Товар</div>
			<div class="basket-col basket-col--quantity basket-heading-item">Количество шт.</div>
			<div class="basket-col basket-col--quantity basket-heading-item">Цена</div>
			<div class="basket-col basket-col--quantity basket-heading-item">Сумма</div>
			<div class="basket-col basket-col--nds basket-heading-item">Ставка НДС</div>
			<div class="basket-col basket-col--nds basket-heading-item">Сумма НДС</div>
			<div class="basket-col basket-col--nds basket-heading-item">Сумма с НДС</div>
		</div>
		
		<?php foreach($arResult["ITEMS"] as $arItem): ?>
			<div class="basket-row">
				
				<div class="basket-col basket-col--name basket-item-name-holder">
					<div class="basket-item-name">
						арт. <?php echo $arItem["PRODUCT"]["PROPERTY_CML2_ARTICLE_VALUE"]; ?><br>
						<a href="<?php echo $arItem["PRODUCT"]["DETAIL_PAGE_URL"]; ?>" target="_blank" class="link link--black link--inverse"><?php echo $arItem["PRODUCT"]["NAME"]; ?></a>
					</div>
				</div>
				
				<div class="basket-col basket-col--quantity basket-item-quantity-holder">
					<div class="basket-item-mobile-title">Количество шт.</div>
					<span><?php echo $arItem["UF_KOLICHESTVO"]; ?></span>
				</div>
				
				<div class="basket-col basket-col--quantity basket-item-quantity-holder">
					<div class="basket-item-mobile-title">Цена</div>
					<span><?php echo $arItem["UF_TSENA"]; ?></span>
				</div>
				
				<div class="basket-col basket-col--quantity basket-item-quantity-holder">
					<div class="basket-item-mobile-title">Сумма</div>
					<span><?php echo $arItem["UF_SUMMA"]; ?> ₽</span>
				</div>
				
				<div class="basket-col basket-col--nds basket-item-quantity-holder">
					<div class="basket-item-mobile-title">Ставка НДС</div>
					<span><?php echo $arItem["UF_STAVKANDS"]; ?></span>
				</div>
				
				<div class="basket-col basket-col--nds basket-item-quantity-holder">
					<div class="basket-item-mobile-title">Сумма НДС</div>
					<span><?php echo $arItem["UF_SUMMANDS"]; ?> ₽</span>
				</div>
				
				<div class="basket-col basket-col--nds basket-item-quantity-holder">
					<div class="basket-item-mobile-title">Сумма с НДС</div>
					<span><?php echo $arItem["UF_SUMMASNDS"]; ?> ₽</span>
				</div>

			</div>
		<?php endforeach; ?>
		
		<div class="basket-row basket-row--footer">
			<div class="basket-col basket-col--results">
				<div class="basket-order">
					<div class="basket-order-summary">
						<div class="basket-order-summary-item basket-order-summary-item--novat">Товарных позиций: <?php echo count($arResult["ITEMS"]); ?></div>
						<div class="basket-order-summary-item basket-order-summary-item--novat">Сумма: <?php echo $arResult["INFO"]["UF_SUMMADOKUMENTA"]; ?> ₽</div>
					</div>

				</div>
			</div>
		</div>
			
	</div>
	
</div>







