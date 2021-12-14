<?php
	define("NO_KEEP_STATISTIC", true);
	define("NO_AGENT_CHECK", true);
	define('PUBLIC_AJAX_MODE', true);
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"]="N";
	$APPLICATION->ShowIncludeStat = false;
	
	use Bitrix\Sale;
	$order = Sale\Order::load($_REQUEST["order_id"]);
	
	$propertyCollection = $order->getPropertyCollection();
	$cancelPropValue = $propertyCollection->getItemByOrderPropertyId(33);
	$cancelPropValue->setValue("Y");
	
	$cancelReasonPropValue = $propertyCollection->getItemByOrderPropertyId(34);
	$cancelReasonPropValue->setValue($_REQUEST["cancel_reason"]);
	
	$order->save();
	
	echo json_encode([
		"SUCCESS" => "Y",
		"RELOAD" => "Y",
	]);
?>