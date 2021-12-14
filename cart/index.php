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
	
	
	$userType = CGCUser::getUserType([
		"ID" => $USER->GetID()
	]);
	
	
	use Bitrix\Sale;
	
	if($userType == "BUSINESS" || $userType == "SIMPLE") {
		
		$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
		if(!$request->getCookie("FINISH_FEBRUARY_GIFTS")) {
			$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
			foreach($basket as $basketItem) {
				$basketItemProps = $basketItem->getPropertyCollection();
				$arBasketItemProps = $basketItemProps->getPropertyValues();
				
				if($arBasketItemProps["IS_GIFT_FEBRUARY"]) {
					$basketItem->delete();
				}
			}
			$basket->save();
			\Bitrix\Main\Application::getInstance()->getContext()->getResponse()->addCookie(new \Bitrix\Main\Web\Cookie("FINISH_FEBRUARY_GIFTS", "Y", time()+ 86400 * 30));
		}
	}
	
	
	
	

	if($userType == "SIMPLE") {
		$arSaleInfo["NDS"]["BASKET_COL_VAT_RATE"]["DISPLAY"] = "N";
		$arSaleInfo["NDS"]["BASKET_COL_VAT_VALUE"]["DISPLAY"] = "N";
		$arSaleInfo["NDS"]["BASKET_COL_SUMMARY_VALUE"]["DISPLAY"] = "N";
		//deb($arSaleInfo);
	}
	
	
	
	
	
	
	
	
?>
	
<?php if($USER->IsAdmin() && 0): ?>
	<div class="page-inner page-inner--w2">
		<div class="page-text">
			<blockquote>
				<h1 class="center">Акция!</h1>
				<h2>При единовременном заказе от 2000 до 2999 рублей предоставляется скидка в размере 10%</h2>
	
				<h2>При единовременном заказе от 3000 до 4999 рублей предоставляется скидка в размере 15%</h2>
		
				<h2>При единовременном заказе от 5000 рублей предоставляется скидка в размере 20%</h2>
			</blockquote>
		</div>
		<br class="only-desktop" />
		<br />
	</div>
<?php endif; ?>
	
	
<?php
	 $APPLICATION->IncludeComponent(
	"aheadstudio:sale.basket.basket",
	"",
	Array(
        "MODE" => $_REQUEST["mode"] == "pre_order" ? "Y" : "N",
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
		"USER_INFO" => $arUserInfo,
		"NDS_INFO" => $arSaleInfo["NDS"],
		"CHECK" => CGCCatalog::checkCart($USER->GetID()), 
		"IBLOCK_ID" => "9",
		"CORRECT_RATIO" => "N",
		//"ENABLE_GIFTS" => (($userType == "SIMPLE" && $USER->IsAuthorized() ? "Y" : "N")),
		//"ENABLE_GIFTS" => ($USER->IsAdmin() ? "Y" : "N"),
		//"ENABLE_GIFTS" => ($USER->IsAuthorized() ? "Y" : "N"),
		"ENABLE_GIFTS" => "N",
		"USER_TYPE" => $userType,
	)
);

?>





	
</div>






<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>