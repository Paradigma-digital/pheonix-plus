<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Корзина");
$APPLICATION->SetTitle("Корзина");
?>

<div id="basket-holder">
	<?php //include "./basket.php"; ?>
	
<?php

	global $USER;
	$arSaleInfo = CGCUser::getSaleInfo($USER->GetID());
	$arUserInfo = CGCUser::getUserInfo(["ID" => $USER->GetID()]);
	if($_REQUEST["recalc"] || $arUserInfo["UF_UPDATE_BASKET"] == "Y") {
		CGCCatalog::updateUserBasket($USER->GetID());
	}
	
	
$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket",
	"",
	Array(
		"ACTION_VARIABLE" => "basketAction",
		"AUTO_CALCULATION" => "Y",
		"COLUMNS_LIST" => array("NAME","DELETE","PRICE","QUANTITY","SUM"),
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
		"GIFTS_CONVERT_CURRENCY" => "N",
		"GIFTS_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_HIDE_NOT_AVAILABLE" => "N",
		"GIFTS_MESS_BTN_BUY" => "Выбрать",
		"GIFTS_MESS_BTN_DETAIL" => "Подробнее",
		"GIFTS_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_PLACE" => "BOTTOM",
		"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
		"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_IMAGE" => "Y",
		"GIFTS_SHOW_NAME" => "Y",
		"GIFTS_SHOW_OLD_PRICE" => "N",
		"GIFTS_TEXT_LABEL_GIFT" => "Подарок",
		"HIDE_COUPON" => "N",
		"PATH_TO_ORDER" => "/cart/order/",
		"PRICE_VAT_SHOW_VALUE" => "Y",
		"QUANTITY_FLOAT" => "N",
		"SET_TITLE" => "Y",
		"TEMPLATE_THEME" => "blue",
		"USE_GIFTS" => "N",
		"USE_PREPAYMENT" => "N",
		"NDS_INFO" => $arSaleInfo["NDS"],
		"CHECK" => CGCCatalog::checkCart($USER->GetID()), 
	)
);

?>
	
</div>




<?php if($arSaleInfo["GROUP"]["GROUP"]): ?>
	<div class="basket-fastadd-holder">
		<div class="page-inner page-inner--w1">
			<div class="basket-fastadd-title">Вы можете использовать сканер штрихкода для добавления товаров</div>
			<form action="/cart/add/" class="basket-fastadd">
				<input type="text" autocomplete="off" class="form-item form-item--text" name="product_barcode" placeholder="Введите ШК товара" />
				<span class="basket-fastadd-result"></span>
				<button type="submit" class="btn btn--blue">Добавить</button>
			</form>
		</div>
	</div>
<?php endif; ?>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>