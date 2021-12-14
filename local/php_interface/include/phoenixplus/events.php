<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/local/lib/phoenixplus/phoenixplusutils.php");

// заполняет размеры товара в корзине, если еще не заполнены
AddEventHandler("sale", "OnBeforeSaleBasketItemSetFields", "PhoenixUpdateBasketItemDimensions");
function PhoenixUpdateBasketItemDimensions($basketItem, $values, $oldValues)
{
	// AddMessage2Log([$basketItem, $values, $oldValues], "PhoenixUpdateBasketDimensions"); // sdemon72
	// Если в параметрах есть вес и ИД, но нет размеров, добавить размеры
	if (!empty($values['PRODUCT_XML_ID']) && array_key_exists('WEIGHT',$values) && empty($values['DIMENSIONS']))
	{
		$dimensions = PhoenixPlusUtils::GetProductDimensions($values['PRODUCT_XML_ID']);
		if ($dimensions)
		{
			// добавить сразу после веса, чтобы правильно рассчитать доставку (нужно раньше количества)
			$weightPosition = array_keys(array_keys($values),'WEIGHT')[0];
			$values = array_slice($values,0,$weightPosition+1) + ['DIMENSIONS' => serialize($dimensions)] + array_slice($values,$weightPosition+1); 
			$eventResultData = array('VALUES' => $values);
		}
	}			
	
	$result = new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, $eventResultData);
	AddMessage2Log($result, "PhoenixUpdateBasketDimensions->result"); // sdemon72
	return  $result;
}

// обновляет линейные размеры товара в секции "Торговый каталог / Параметры" из реквизитов товара
// реквизиты должны иметь имена "Высота", "Глубина", "Ширина"; размеры в реквизитах - в метрах
Bitrix\Main\EventManager::getInstance()->addEventHandler('catalog','\Bitrix\Catalog\Product::OnBeforeUpdate','PhoenixUpdateProductDimensions');


function PhoenixUpdateProductDimensions(\Bitrix\Main\Entity\Event $event)
{
	$result = new \Bitrix\Main\Entity\EventResult();

	// ID товара
	$id = $event->getParameter('primary')['ID'];
	// ID каталога
	$iblockId = CIBlockElement::GetIBlockByID($id);
	// выборка реквизитов товара
	$iterator = CIBlockElement::GetProperty($iblockId, $id, array("sort" => "asc"), array("NAME"=>"Реквизиты"));
	
	// соответствие названий полей
	$arAccording = array(
	'Высота' => 'HEIGHT',
	'Глубина' => 'LENGTH',
	'Ширина' => 'WIDTH');

  	// поля торгового предложения
	$arFields = $event->getParameter('fields');
	
	// сравнить реквизиты с полями
	$isModify = false;
	while ($row = $iterator->Fetch())
	{
		$fieldName = $arAccording[$row['DESCRIPTION']];
		if (!empty($fieldName) && !empty($row['VALUE']))
		{
			$value = PhoenixPlusUtils::ToFloat($row['VALUE'])*1000; // из м в мм
			if ($arFields[$fieldName] != $value)
			{
				$arFields[$fieldName] = $value;
				$isModify = true;
			}
		}
	}
	
	// обновление полей
	if ($isModify)
	{
		$result->modifyFields($arFields);
	}
		
	//AddMessage2Log($result, "result"); // sdemon72

	return  $result;
}


// обновляет в заказе флаг включения НДС в сумму в списке "налоги" из списка "товары"
// (считаем во всех строках товаров флаг одинаковым)
AddEventHandler("sale", "OnAfterSaleOrderFinalAction", "TaxIsInPriceRechange");
function TaxIsInPriceRechange(Bitrix\Sale\Order $order) {
	if(!$order->isUsedVat()) {
		return;
	}
		
	/** @var Basket $basket */
	$basket = $order->getBasket();
	if(empty($basket)) {
		return;
	}
		
	$taxes = $order->getTax();
	$taxList = $taxes->getTaxList();
	if(empty($taxList)) {
		return;
	}

	/** @var BasketItem $basketItem */
	foreach($basket as $basketItem) {
		$vatIncluded = $basketItem->getField('VAT_INCLUDED');
		if($vatIncluded == 'Y' || $vatIncluded == 'N') {
			break;
		}
	}

	if($vatIncluded != 'Y' && $vatIncluded != 'N') {
		return;
	}

	$taxChanged = false;
	foreach($taxList as &$taxListItem) {
		if($taxListItem['CODE'] != 'VAT' || $taxListItem['IS_IN_PRICE'] == $vatIncluded) {
			continue;
		}
		$taxListItem['IS_IN_PRICE'] = $vatIncluded;		
		$taxChanged = true;
	}
	unset($taxListItem);
	
	if($taxChanged) {
		$taxes->initTaxList($taxList);
	}
	
	/*
	// проверка
	$taxes = $order->getTax();
	$taxList = $taxes->getTaxList();
	AddMessage2Log($taxList, "taxList2"); // sdemon72
	*/
	
	
}




