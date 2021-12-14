<?php
	AddEventHandler("main", "OnBeforeEventSend", "mailNewUserHandler");
	
	function mailNewUserHandler(&$arFields, $arTemplate) {
		switch($arTemplate["EVENT_NAME"]) {
			case "NEW_USER":
				$arFields["SALE_EMAIL"] = COption::GetOptionString("sale", "order_email");
			break;
		}
	}
?>