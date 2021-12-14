<div class="page-inner page-inner--w1">
    <div class="order-success">
	<div class="order-success-title">Ваш заказ №<?=$arResult['ORDER_ID']?> от <?=$arResult['ORDER']['DATE_INSERT']?> успешно создан. </div>
	<div class="order-success-text">Наш менеджер подготовит необходимую информацию по заказу и свяжется с Вами в ближайшее время.
		<br /><br />
		Следить за своими заказами вы можете в <a class="link link--black" href="/personal/orders/">личном кабинете</a>.
		
	</div>
	<div class="order-success-footer">Спасибо!</div>
    </div>
</div>
<? //deb($arResult['ORDER_ID'], false)?>