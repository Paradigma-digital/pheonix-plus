<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	
	use Bitrix\Sale;
	
	
	$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
	foreach($basket as $basketItem) {
		$basketItemProps = $basketItem->getPropertyCollection();
		$arBasketItemProps = $basketItemProps->getPropertyValues();
		
		if($arBasketItemProps["IS_GIFT_FEBRUARY"]) {
			$basketItem->delete();
		}
	}
	$basket->save();
?>