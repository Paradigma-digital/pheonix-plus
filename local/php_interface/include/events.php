<?php
use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem;

include 'events/user/authByEmail.php';
include 'events/user/premoderation.php';
include 'events/license/deleteTopNotice.php';
include 'events/page/deleteByTemplate.php';
//include 'events/cart/getPersonalCart.php';
include 'events/mail/newOrder.php';
include 'events/mail/newUser.php';
include 'events/user/update.php';
include 'events/iblock.php';
include 'events/user/price_groups.php';
include 'events/highload.php';

//include 'events/catalog/updateQantity.php';

$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler("sale", "OnSaleOrderSaved", ["Preorder", "OnSaleOrderSavedHandler"]);
$eventManager->addEventHandler("sale", "OnSaleComponentOrderCreated", ["Preorder", "OnSaleComponentOrderCreatedHandler"]);

$eventManager->addEventHandler(
    'sale',
    'onSalePaySystemRestrictionsClassNamesBuildList',
    function () {
        return new \Bitrix\Main\EventResult(
            \Bitrix\Main\EventResult::SUCCESS,
            array(
                '\RsitePayRestrictionByUserGroup' => '/bitrix/php_interface/include/preorder/rsite_pay_restriction_by_user_group.php', // По группе пользователя.
            )
        );
    }
);


/*AddEventHandler("sale", "OnOrderSave", "OnOrderAddHandler");
function OnOrderAddHandler($orderID, $arFields, $orderFields, $isNew) {
	if($isNew) {
		$order = Order::load($orderID);
		
		// Удаление существующей отгрузки
		$shipmentCollection = $order->getShipmentCollection();
		foreach($shipmentCollection as $shipment) {
			// Пропускаем системную отгрузку
			if($shipment->isSystem()) {
				continue;
			}
			$shipmentItemCollection = $shipment->getShipmentItemCollection();
			foreach($shipmentItemCollection as $item) {
				$item->setQuantity(0);
				$item->delete();
				$item->save();
			}
			$shipment->delete();
			$shipment->save();
		}
		$order->save();		
	}

}*/


AddEventHandler("sale", "OnBeforeOrderAdd", "OnBeforeOrderAddHandler");

function OnBeforeOrderAddHandler(&$arFields) {
	$arBasketItems = array();
	$dbBasketItems = CSaleBasket::GetList(
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
        []
    );
    
    $userID = 0;
    if($arFields["USER_ID"]) {
	    $userID = $arFields["USER_ID"];
    } else {
	    $userID = $USER->GetID();
    }
    
    global $USER;
    $arSaleInfo = CGCUser::getSaleInfo($userID);
	while($arItem = $dbBasketItems->Fetch()) {
		CSaleBasket::Update($arItem["ID"], [
			"PROPS" => [],
			"VAT_RATE" => ($arSaleInfo["NDS"]["TYPE"] == "NO" ? 0 : $arItem["VAT_RATE"]),
			"VAT_INCLUDED" => ($arSaleInfo["NDS"]["TYPE"] == "NO" ? "Y" : $arItem["VAT_INCLUDED"])
		]);
	}
}


AddEventHandler("main", "OnBeforeEventAdd", array("MailPost", "OnBeforeEventAddHandler"));
class MailPost {
	function OnBeforeEventAddHandler($event, $lid, &$arFields) {

		CModule::IncludeModule("sale");
		CModule::IncludeModule("iblock");

		if(
			strstr($event, "SALE_STATUS_CHANGED") 
			|| 
			strstr($event, "SALE_ORDER") 
			||
			($event == "SALE_NEW_ORDER")
		) {
			$arOrder = CSaleOrder::GetByID($arFields["ORDER_ID"]);
            $saleOder = \Bitrix\Sale\Order::load($arFields["ORDER_ID"]);

            foreach ($saleOder->getBasket() as $basketItem) {
                $price = CCurrencyLang::CurrencyFormat($basketItem->getField('PRICE'), "RUB");
                $arFields["ORDER_TABLE_ITEMS"][] = $basketItem->getField('NAME').' - '.$basketItem->getQuantity().'шт. - '.$price;
            }
            $arFields["ORDER_TABLE_ITEMS"] = implode("<br>", $arFields["ORDER_TABLE_ITEMS"]);
            $arFields["ORDER_DESCRIPTION"] = $saleOder->getField("USER_DESCRIPTION");

            $dbOrderPropsValue = CSaleOrderPropsValue::GetOrderProps($arFields["ORDER_ID"]);
			while($arOrderProp = $dbOrderPropsValue->Fetch()) {
				$arFields["PROP_".$arOrderProp["CODE"]] = $arOrderProp["VALUE"];
			}

			$rsUsers = CUser::GetList(($by = "LAST_NAME"), ($order = "asc"), [
				"ID" => $arOrder["USER_ID"]
			], [
		    	"SELECT" => ["ACTIVE", "EMAIL", "NAME", "UF_MANAGER"],
		    	"NAV_PARAMS" => [
			    	"nTopCount" => "1"
		    	]
			]);

			$arManager = CGCUser::getManager($arOrder["USER_ID"]);
			$arFields["MANAGER_EMAIL"] = $arManager["EMAIL"].",fpl-it@fenixrostov.ru";
			$arUser = $rsUsers->GetNext();
			$managerInfo = "";
			if($arUser["UF_MANAGER"]) {
				$arFields["MANAGER_INFO_TEXT"] = "По вопросам заказа вы можете обратиться к вашему персональному менеджеру:";
				$arUserManager = CGCHelper::getHlElements(3, Array(
					"ID" => $arUser["UF_MANAGER"]
				));
				if($arUserManager) {
					$arUserManager = $arUserManager[0];
				}
				$managerInfo = "<p>
					<b>".$arUserManager["UF_NAME"]."</b><br />";
				if($arUserManager["UF_PHONE"]) {
					$managerInfo .= "тел.: ".$arUserManager["UF_PHONE"]."<br />";
				}
				if($arUserManager["UF_EMAIL"]) {
					$managerInfo .= "эл.почта: ".$arUserManager["UF_EMAIL"]."<br />";
				}
				$managerInfo .= "</p>";
			} else {
				$arFields["MANAGER_INFO_TEXT"] = "По всем вопросам о вашем заказе вы можете обратиться к менеджеру.";
			}
			$arFields["MANAGER_INFO"] = $managerInfo;
			$arFields["ORDER_USER"] = $arFields["USER_NAME"] = $arUser["NAME"];
			dumps($arFields, "order");
		}
	}
}



AddEventHandler("sale", "OnSaleComponentOrderOneStepPersonType", "selectSavedPersonType");
function selectSavedPersonType(&$arResult, &$arUserResult, $arParams) {
	global $USER;
	
	//deb($arUserResult);
	
    foreach($arResult['PERSON_TYPE'] as $key => $type){
        if($type["CHECKED"] == "Y"){
            $arResult["PERSON_TYPE"][$key]["CHECKED"] = "";
        }
    }
	
	//$arUserResult["PERSON_TYPE_CHANGE"] = "Y";
	if(CGCUser::getUserType(["ID" => $USER->GetID()]) == "SIMPLE") {
		$arResult["PERSON_TYPE"][2]["CHECKED"] = "Y";
		$arUserResult["PERSON_TYPE_ID"] = 2;
	} else {
		$arResult["PERSON_TYPE"][1]["CHECKED"] = "Y";
		$arUserResult["PERSON_TYPE_ID"] = 1;	
	}
}



AddEventHandler("sale", "OnSaleComponentOrderJsData", "OnSaleComponentOrderJsDataHandler");
function OnSaleComponentOrderJsDataHandler(&$arResult, &$arParams) {
    $groupParamsId = 7; //ID группы свойств с параметрами доставки
    foreach ($arResult['JS_DATA']['ORDER_PROP']['properties'] as $key => $prop) {
        if ($prop['PROPS_GROUP_ID']==$groupParamsId) {
            $arResult['JS_DATA']['DELIVERY_PROPS']['properties'][] = $arResult['JS_DATA']['ORDER_PROP']['properties'][$key];
            unset($arResult['JS_DATA']['ORDER_PROP']['properties'][$key]);
        }
    }
    foreach ($arResult['JS_DATA']['ORDER_PROP']['groups'] as $key => $group) {
        if ($group['ID']==$groupParamsId) {
            $arResult['JS_DATA']['DELIVERY_PROPS']['groups'][] = $arResult['JS_DATA']['ORDER_PROP']['groups'][$key];
            unset($arResult['JS_DATA']['ORDER_PROP']['groups'][$key]);
        }
    }
}