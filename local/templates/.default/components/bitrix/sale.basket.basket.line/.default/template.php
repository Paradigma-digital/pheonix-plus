<a href="<?=$arParams['PATH_TO_BASKET']."?mode=order"?>" class="header-basket">
    <div class="header-basket-inner">
	<span class="header-basket-title">
	    <span>Корзина</span>
	    <svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.63 30"><path d="M28.38 30H6.88a.88.88 0 0 1-.83-.59l-6-17.25A.88.88 0 0 1 .88 11h32.87a.88.88 0 0 1 .84 1.14l-5.37 17.25a.87.87 0 0 1-.84.61zM7.5 28.25h20.23l4.83-15.5H2.11z" fill="#000103"/><path d="M24.5 17.87a.87.87 0 0 1-.87-.87V7.37a6 6 0 0 0-12 0v9.62a.875.875 0 1 1-1.75 0V7.37a8.61 8.61 0 0 1 1-3.66c.9-1.7 2.8-3.72 6.79-3.72a7.27 7.27 0 0 1 7.75 7.38v9.62a.87.87 0 0 1-.92.88z" fill="#000103"/></svg>
	</span>
	<span class="header-basket-price"><?=$arResult['TOTAL_PRICE']?></span>
    </div>
    <span class="header-basket-count"><?=$arResult['CNT']?></span>
</a>