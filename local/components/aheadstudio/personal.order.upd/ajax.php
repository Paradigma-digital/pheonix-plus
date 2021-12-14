<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
	
use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem;
	
	$arResult = [];

	$request = json_decode(file_get_contents("php://input"), true);
	$action = $request["action"];
	$orderId = $request["order_id"];
	
	global $USER;
	
	if($action) {
		
		switch($action) {
			case "submit":
			
				// Получение заказа
				$order = Bitrix\Sale\Order::load($orderId);
			
				// Создание шапки
				$headingID = GCDocs::addHeading([
					"UF_TITLE" => "Акт приемки для заказа №".$orderId,
					"UF_DATE_CREATE" => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL"))),
					"UF_ORDER_ID" => $orderId,
					"UF_ID_1C" => $order->getField("ID_1C"),
					"UF_USER_ID" => $USER->GetID(),
				]);
				
				// Создание товаров
				foreach($request["items"] as $item) {
					CGCHL::add(CGCHL::getHLByName("DocReportRows")["ID"], [
						"UF_TITLE" => $item["NAME"],
						"UF_DOCUMENT_ID" => $headingID,
						"UF_QUANTITY" => $item["QUANTITY"],
						"UF_ARTICLE" => $item["PRODUCT"]["PROPERTY_CML2_ARTICLE_VALUE"],
						"UF_PRODUCT_ID" => $item["PRODUCT_XML_ID"],
					]);
				}
				
				
				
				$arResult = [
					"success" => true,
				];

			break;
			
			case "getOrderItems":
				$arResult = CGCCatalog::getOrderProducts([
					"ORDER_ID" => $orderId,
				]);
			break;
			
			case "addProduct":

				$quantity = (int)($request["quantity"]);
			    $barcode = (int)($request["barcode"]);
			    
			    $arResult = [];
			    
			    // Минимальная проверка
			    if(!$quantity || !$barcode) {
				    $arResult["message"] = "Ошибка запроса. Отсутствуют обязательные параметры.";
				    $arResult["result"] = -1;
				    echo json_encode($arResult);
				    die();
			    }
			    
			    // Ищем товар по его ШК
			    $arProduct = CGCHelper::getIBlockElements([
				    "FILTER" => [
					    [
						    "LOGIC" => "OR",
						    ["PROPERTY_CML2_BAR_CODE" => $barcode],
						    ["PROPERTY_CML2_ARTICLE" => $barcode]
					    ],
					    "ACTIVE" => "Y",
					    "GLOBAL_ACTIVE" => "Y",
				    ],
				    "NAV" => [
					    "nTopCount" => "1"
				    ],
				    "SELECT" => [
					    "ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "PROPERTY_CML2_ARTICLE", "IBLOCK_ID", "XML_ID",
				    ]
			    ]);
			    
			    if(!$arProduct) {
				    $arResult["message"] = "Товар с шк/арт. <b>".$barcode."</b> не найден";
				    $arResult["result"] = -1;
				    echo json_encode($arResult);
				    die();
			    }
			    $arProduct = $arProduct[0];
			    $arProduct["PRODUCT_ID"] = $arProduct["ID"];
			    $arProduct["QUANTITY"] = 1;
			    $arProduct["PRODUCT"] = [
				    "PROPERTY_CML2_ARTICLE_VALUE" => $arProduct["PROPERTY_CML2_ARTICLE_VALUE"],
				    "PREVIEW_PICTURE_SRC" => CFile::GetPath($arProduct["PREVIEW_PICTURE"]),
				    "~NAME" => $arProduct["~NAME"],
			    ];
			    $arProduct["PRODUCT_XML_ID"] = $arProduct["XML_ID"];
			    
			    $arProduct["REAL_QUANTITY"] = 0;
			    
			    $arResult = [
				    "result" => 100,
				    "item" => $arProduct,
			    ];
			    
			    
			break;
		}
		
	}
	
	
	echo json_encode($arResult); 
	die;
	

?>