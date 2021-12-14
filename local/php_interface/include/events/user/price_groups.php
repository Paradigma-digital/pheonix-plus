<?php

use Bitrix\Main\EventManager;
$eventManager = EventManager::getInstance();

class CGCPriceType {
	function AddPriceTypeHandler(&$arFields) {
		self::AddUpdatePriceType(false, $arFields);
	}
	function UpdatePriceTypeHandler($id, &$arFields) {
		//self::AddUpdatePriceType($id, $arFields);
	}
	function AddUpdatePriceType($id, &$arFields) {
	    $dbGroup = CGroup::GetList($by = "sort", $order = "asc", ["STRING_ID" => $arFields["XML_ID"]]);
	    $arGroup = $dbGroup->Fetch();
		//deb($arFields);
	    if(!$arGroup) {
		    $group = new CGroup;
		    $groupID = $group->Add([
			    "NAME" => "Ценовая группа: ".$arFields["NAME"],
			    "STRING_ID" => $arFields["XML_ID"],
			    "C_SORT" => "1000",
			    "ACTIVE" => "Y",
			    "DESCRIPTION" => "Ценовая группа",
		    ]);
		    if(strlen($group->LAST_ERROR) > 0) {
				ShowError($group->LAST_ERROR);
		    }
	    } else {
		    $groupID = $arGroup["ID"];
	    }
		$arFields["USER_GROUP"] = [$groupID];
		$arFields["USER_GROUP_BUY"] = [$groupID];
		
		/*if($arFields["BASE"] == "Y") {
			$arFields["USER_GROUP"][] = "6";
			$arFields["USER_GROUP_BUY"][] = "6";
		}*/
	}
}

$eventManager->addEventHandler(
    'catalog',
    'OnBeforeGroupUpdate',
    ["CGCPriceType", "UpdatePriceTypeHandler"]
);
$eventManager->addEventHandler(
    'catalog',
    'OnBeforeGroupAdd',
    ["CGCPriceType", "AddPriceTypeHandler"]
);