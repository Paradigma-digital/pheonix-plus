<?php
use Bitrix\Main,
	Bitrix\Sale,
	Bitrix\Sale\Basket,
	Bitrix\Catalog;
	
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');



global $USER;
if(!$USER->IsAdmin()) {
	LocalRedirect("/bitrix/admin/");
}



if($_REQUEST["add"]) {
	
	$dbItems = \Bitrix\Catalog\ProductTable::getList(array(
		'runtime' => array('RAND'=>array('data_type' => 'float', 'expression' => array('RAND()'))),
		'order' => [
			"RAND" => "ASC",
		],
    	'filter' => array(">QUANTITY" => 0),
    	'select' => [
	    	"ID", 'NAME'=>'IBLOCK_ELEMENT.NAME', "QUANTITY", 'CODE'=>'IBLOCK_ELEMENT.CODE'
    	],
    	"limit" => $_REQUEST["count"],
	));

	
	//$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
	
	while ($arItem = $dbItems->fetch()) {
		//deb($arItem);
		/*$item = $basket->createItem('catalog', $arItem["ID"]);
		$item->setFields(array(
		    'QUANTITY' => rand(1, 100),
		    'CURRENCY' => Bitrix\Currency\CurrencyManager::getBaseCurrency(),
		    'LID' => Bitrix\Main\Context::getCurrent()->getSite(),
		    'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
		));*/
		
		Bitrix\Catalog\Product\Basket::addProduct([
			"PRODUCT_ID" => $arItem["ID"], 
			"QUANTITY" => rand(1, 100),
		]);
	}
	
	//$basket->save();
	
	echo "<h2>Успешно добавлено. <a href='/cart/index2.php'>Перейти в корзину</a></h2>";
}
?>
<form method="post">
	<h2>Добавление товаров в корзину</h2>
	<input type="text" name="count" placeholder="Количество товаров" />
	<button type="submit" name="add" value="Y">Добавить товары</button>
</form>