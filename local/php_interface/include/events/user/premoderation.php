<?php

use Bitrix\Main\EventManager;
$eventManager = EventManager::getInstance();

class premoderationClass
{
	public static function OnBeforeUserRegister(&$arFields)
	{
	    $arFields["ACTIVE"] = 'N';
	    
	    // Проверка на юзера
	    $arUserTypes = CGCUser::getUserTypes();
	    $arUserTypesCodes = CGCUser::getUserTypesByCodes();
	    if($arUserTypes[$arFields["UF_USER_TYPE"]]["XML_ID"] == "SIMPLE" || !$arFields["UF_USER_TYPE"]) {
		    $priceCode = "2f235eaa-a0b9-11ea-80dc-002590ea7b7b";
		    
		    if(!$arFields["UF_USER_TYPE"]) {
			    $arFields["UF_USER_TYPE"] = $arUserTypesCodes["SIMPLE"]["ID"];
		    }
		    
			$dbGroup = CGroup::GetList($by = "sort", $order = "asc", ["STRING_ID" => $priceCode]);
			$arGroup = $dbGroup->Fetch();
			
			$arFields["UF_NDS"] = "ВСумме";
			
			if($arGroup) {
				$arFields["GROUP_ID"][] = $arGroup["ID"];
				$arFields["UF_PRICE_ID"] = $priceCode;	
			}
			
			$arManagers = CGCHL::getList(CGCHL::getHLByName("Managers")["ID"], [
				"SELECT" => ["ID", "UF_*"],
				"FILTER" => [
					//"UF_NAME" => "%Федорова Ольга Юрьевна%"
					"UF_NAME" => "%".CGCSetting::get("default_retail_manager")."%"
				]
			]);
			if($arManagers) {
				$arFields["UF_MANAGER"] = $arManagers[0]["ID"];
			}
			
			$arProfiles = CGCHL::getList(CGCHL::getHLByName("Kontragenty")["ID"], [
				"SELECT" => ["ID", "UF_*"],
				"FILTER" => [
					"UF_NAME" => "Розница сайт Феникс+"
				]
			]);
			if($arProfiles) {
				$arFields["UF_PROFILES"] = [$arProfiles[0]["ID"]];
			}
			
	    }
	    
	    //deb($arFields); die;
	}
}

$eventManager->addEventHandler(
    'main',
    'OnBeforeUserRegister',
    array('premoderationClass', 'OnBeforeUserRegister')
);


