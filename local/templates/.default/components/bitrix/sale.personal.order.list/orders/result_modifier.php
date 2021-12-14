<?php
	foreach($arResult["ORDERS"] as &$arOrder) {
		
		$arOrder["PROPS"] = [];
		
		$dbOrderProps = CSaleOrderPropsValue::GetOrderProps($arOrder["ORDER"]["ID"]);
		while($arOrderProp = $dbOrderProps->Fetch()) {
			if($arOrderProp["CODE"] == "COMPANY_ID") {
				$arOrder["PROPS"]["COMPANY"] = CGCHelper::getHlElements(2, [
					"UF_XML_ID" => $arOrderProp["VALUE"]
				])[0];
			} else if(($arOrderProp["CODE"] == "1C_ACCOUNT") || $arOrderProp["CODE"] == "1C_DATE" || $arOrderProp["CODE"] == "CANCELLED") {
				$arOrder["PROPS"][$arOrderProp["CODE"]] = $arOrderProp["VALUE"];
			} else {
				continue;
			}
		}
		
	}
	
?>