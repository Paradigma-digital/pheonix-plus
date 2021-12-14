<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
	
	$arResult = [];

	
	$action = $_REQUEST["action"];
	$orderId = $_REQUEST["ORDER_ID"];
	
	if($action) {
		
		switch($action) {
			case "getOrderItems":
				$arResult = GCCatalog::getOrderProducts([
					"ORDER_ID" => $orderId,
				]);
			break;
		}
		
		echo json_encode($arResult); 
		die;
		
	} else {
		$this->IncludeComponentTemplate();
	}
	
	

?>