
    <div id="page-basket_in">
        <div class="page-basket-items">
	    <? foreach ($arResult['CATEGORIES']['READY'] as $arPosition) { ?>
		<div class="page-basket-item">
		    <div class="page-basket-item-info">
			<p><?=$arPosition['NAME']?></p>
			<p>цена за 1шт.: <?=$arPosition['PRICE_FORMATE']?><br>кол-во: <?=$arPosition['QUANTITY']?> шт.</p>
		    </div>
		    <div class="page-basket-item-photo-holder"><img src="<?=$arPosition['PICTURE_SRC']?>"></div>
		    <div class="page-basket-item-summary">сумма: <?=$arPosition['SUM']?></div><span title="Удалить" class="page-basket-item-remove"></span>
		</div>
	    <? } ?>
        </div>
        <div class="page-basket-info">
	    <div class="page-basket-info-summary">Товаров на сумму: <?=$arResult['TOTAL_PRICE']?></div><a href="<?=$arParams['PATH_TO_ORDER']?>" class="btn btn--red btn--large page-basket-info-order animation-link">Оформить заказ</a><a href="<?=$arParams['PATH_TO_BASKET']?>" class="link link--arrow page-basket-info-basket animation-link">В корзину</a>
        </div>
    </div>