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
	$updId = $request["upd_id"];
	$actId = $request["act_id"];
	
	global $USER;
	
	if($action) {
		
		switch($action) {
			case "getInfo":
				$arResult = GCDocs::getUPDInfo([
					"ID" => $updId,
				]);
			break;
			
			case "save":
			case "fix":
			
				if(!$actId) {
					global $USER;
					$arUser = CGCUser::getUserInfo([
						"ID" => $USER->GetID(),
					]);
					
					$arUPD = GCDocs::getUPDInfo([
						"ID" => $updId,
					]);
					$actId = CGCHL::add(CGCHL::getHLByName("Aktpokupatelya")["ID"], [
						"UF_DOKUMENTOSNOVANI" => $arUPD["UF_XML_ID"],
						"UF_STATUS" => "Формируется",
						"UF_POLZOVATELSAYTA" => $arUser["XML_ID"],
					]);
				} else {
					$arObjectRemove = CGCHL::getList(CGCHL::getHLByName("Aktpokupatelyatovary")["ID"], [
						"FILTER" => [
							"UF_DOCUMENT_ID" => $actId,
							
						],
						"SELECT" => ["ID"]
					]);
					foreach($arObjectRemove as $arObjectRemoveItem) {
						CGCHL::remove(CGCHL::getHLByName("Aktpokupatelyatovary")["ID"], $arObjectRemoveItem["ID"]);
					} 
				}
				
				CGCHL::update(CGCHL::getHLByName("Aktpokupatelya")["ID"], $actId, [
					"UF_DATASOZDANIYA" => date("j.m.Y H:i:s"),
					"UF_KOMMENTARIY" => $request["comment"],
				]);
				
				foreach($request["items"] as $item) {
					CGCHL::add(CGCHL::getHLByName("Aktpokupatelyatovary")["ID"], [
						"UF_DOCUMENT_ID" => $actId,
						"UF_NOMENKLATURA" => ($item["PRODUCT_XML_ID"] ? $item["PRODUCT_XML_ID"] : $item["PRODUCT"]["EXTERNAL_ID"]),
						"UF_KOLICHESTVOPRINY" => $item["UF_KOLICHESTVO"],
						"UF_KOLICHESTVOBRAK" => $item["UF_KOLICHESTVOBRAK"],
						"UF_KOLICHESTVOPODOK" => $item["UF_REAL_QUANTITY"]
					]);
				}
				
				if($action == "fix") {
					CGCHL::update(CGCHL::getHLByName("Aktpokupatelya")["ID"], $actId, [
						"UF_STATUS" => "КИсполнению"
					]);
				}
			break;

			
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
				$arResult = GCDocs::getProducts([
					"UPD_ID" => $updId,
					"ACT_ID" => $actId,
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
			    $arProduct["UF_KOLICHESTVO"] = 1;
			    $arProduct["PRODUCT"] = [
				    "ID" => $arProduct["ID"],
				    "PROPERTY_CML2_ARTICLE_VALUE" => $arProduct["PROPERTY_CML2_ARTICLE_VALUE"],
				    "PREVIEW_PICTURE_SRC" => CFile::GetPath($arProduct["PREVIEW_PICTURE"]),
				    "~NAME" => $arProduct["~NAME"],
			    ];
			    $arProduct["PRODUCT_XML_ID"] = $arProduct["XML_ID"];
			    
			    $arProduct["UF_REAL_QUANTITY"] = 0;
			    
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