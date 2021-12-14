<?php
AddEventHandler("sale", "OnOrderNewSendEmail", "mailNewOrderHandler");

//-- Собственно обработчик события

function mailNewOrderHandler($orderID, &$eventName, &$arFields)
{
	CModule::IncludeModule("sale");
	CModule::IncludeModule("iblock");
	
	// Достаем менеджера
	$arOrder = CSaleOrder::GetByID($orderID);

	
	
	
    
            
	
	$strOrderList = '<table width="100%" cellspacing="0" style="border-collapse: collapse;">
            <thead>
              <tr>
                <th style="color: #8c8c8c; text-align: left; padding: 10px 20px; font-weight: normal;">Товары в заказе</th>
                <th style="color: #8c8c8c; text-align: center; padding: 10px 20px; font-weight: normal;">Количество</th>
                <th style="color: #8c8c8c; text-align: left; padding: 10px 20px; font-weight: normal;">Сумма</th>
              </tr>
            </thead>
            <tbody style="border: 1px solid #CCC;">';
	$dbBasketItems = CSaleBasket::GetList(
		["NAME" => "ASC"],
		["ORDER_ID" => $orderID],
		false,
		false,
		["PRODUCT_ID", "ID", "NAME", "QUANTITY", "PRICE", "CURRENCY"]
	);
	while($arBasketItem = $dbBasketItems->Fetch()) {
		$dbProduct = CIBlockElement::GetByID($arBasketItem["PRODUCT_ID"]);
		$arProduct = $dbProduct->Fetch();
		
		$arProductActicle = CGCHelper::getIBlockProperty([
			"IBLOCK_ID" => $arProduct["IBLOCK_ID"],
			"ID" => $arProduct["ID"],
			"FILTER" => [
				"CODE" => "CML2_ARTICLE"
			]
		]);
		if($arProductActicle[0]) {
			$arProductActicle = $arProductActicle[0];
		}
		
		$strOrderList .= '<tr>
                <td style="border-top: 1px solid #CCC; padding: 10px 20px; border-bottom: 1px solid #CCC; vertical-align: top;">
                  <table width="100%">
                    <tbody><tr>
                      <td width="100px" style="text-align: center; padding: 0 20px 0 0;"><img src="https://phoenix-plus.ru'.CFile::GetPath($arProduct["DETAIL_PICTURE"]).'" height="100"></td>
                      <td>
                        <p style="padding: 0; margin: 0 0 15px 0;">'.$arBasketItem["NAME"].'<br />арт.: '.$arProductActicle["VALUE"].'</p>
                        <p style="padding: 0; margin: 0;">
                          <b>'.($arBasketItem["PRICE"] * 1).' руб.</b>
                        </p>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
                <td style="border-top: 1px solid #CCC; padding: 10px 20px; text-align: center; border-bottom: 1px solid #CCC; vertical-align: top;">'.$arBasketItem["QUANTITY"].'</td>
                <td style="border-top: 1px solid #CCC; padding: 10px 20px; text-align: left; border-bottom: 1px solid #CCC; vertical-align: top;"><b style="white-space: nowrap;">'.($arBasketItem["QUANTITY"] * $arBasketItem["PRICE"]).' руб.</b></td>
              </tr>';
		
	}
	
	$strOrderList .= '</tbody>
            <tfoot>
              <tr>
                <td height="20" colspan="3"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="left" style="line-height: 1.3;">
                <b style="font-size: 20px; text-transform: uppercase; white-space: nowrap;">Итого: '.$arOrder["PRICE"].' руб.</b></td>
              </tr>
            </tfoot>
          </table>';
	
	$arFields["ORDER_TABLE_ITEMS"] = $strOrderList; 
	
	

	
	//print_r($strOrderList); die;
	
	
	CModule::IncludeModule("iblock"); 
}