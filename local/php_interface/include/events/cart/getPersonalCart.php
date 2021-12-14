<?php

AddEventHandler("main", "OnBeforeProlog", "sessionStartFunc");

function sessionStartFunc()
{
	global $APPLICATION;
	global $USER;
	
	CModule::IncludeModule("sale");
	global $inCartArray;
	
	$cart = CSaleBasket::GetList(
		array(
			"NAME" => "ASC",
			"ID" => "ASC"
			),
		array(
			"FUSER_ID" => CSaleBasket::GetBasketUserID(),
			"LID" => SITE_ID,
			"ORDER_ID" => "NULL"
			),
		false,
		false,
		array()
	);
	while ($inCart = $cart->Fetch())
	{
		$inCartArray[$inCart['PRODUCT_ID']] = $inCart;
	}
}
