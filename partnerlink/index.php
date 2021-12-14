<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Партнерская программа");
?>
<div class="page-inner page-inner--w3 page-inner--centered">
	<div class="page-text">
		<blockquote>
			<h2>Заголовок</h2>
			<p>Описание</p>
			<div class="center">
				<a href="/register/business/" class="btn btn--red">Зарегистрироваться</a>
			</div>
		</blockquote>
	</div>
</div>
<?php
	GCPartner::setCode();
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>