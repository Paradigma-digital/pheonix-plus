<?php

use Bitrix\Main\EventManager;
$eventManager = EventManager::getInstance();

class authByEmail
{
	public static function OnBeforeUserRegister(&$arFields)
	{
	    $arFields["LOGIN"] = $arFields["EMAIL"];
		//die;
			
	}
	
	function OnAfterUserRegister($arFields) {
		$user = new CUser;
		$user->Update($arFields["USER_ID"], [
			"XML_ID" => $arFields["USER_ID"]."#".$arFields["LOGIN"]."#"
		]);
	}

	public static function OnBeforeUserLogin(&$arFields)
	{

	    $filter = Array("=EMAIL" => $arFields["LOGIN"]);
	    $rsUsers = CUser::GetList(($by = "LAST_NAME"), ($order = "asc"), $filter, [
		    "SELECT" => ["UF_HARD_DELETE", "ID"]
	    ]);
	    if ($user = $rsUsers->GetNext()) {
		    //deb($user, false);
		   	if((!$user["UF_HARD_DELETE"] || $user["UF_HARD_DELETE"] != "Y") && $user["ACTIVE"] == "N") {
			   	global $APPLICATION;
			   	$APPLICATION->throwException('Ваш логин ожидает утверждения.<br /><a href="/sendconfirm/'.$user["ID"].'/" class="link link--white">Повторно отправить код подтверждения на email</a>.');
			   	return false;
		   	}
			$arFields["LOGIN"] = $user["LOGIN"];
	    }
	    
	    
	}
}

$eventManager->addEventHandler(
    'main',
    'OnBeforeUserLogin',
    array('authByEmail', 'OnBeforeUserLogin')
);
$eventManager->addEventHandler(
    'main',
    'OnBeforeUserRegister',
    array('authByEmail', 'OnBeforeUserRegister')
);
$eventManager->addEventHandler(
    'main',
    'OnAfterUserRegister',
    array('authByEmail', 'OnAfterUserRegister')
);
$eventManager->addEventHandler(
    'main',
    'OnAfterUserAdd',
    array('CGCUser', 'sendRegisterEmail')
);
$eventManager->addEventHandler(
    'main',
    'OnAfterUserRegister',
    array('CGCUser', 'sendRegisterEmail')
);