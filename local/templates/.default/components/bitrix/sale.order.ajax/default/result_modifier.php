<?php

$user_info = $USER->GetList(($by = "NAME"), ($order = "desc"), array('ID' => $USER->GetID()), array('SELECT' => array('UF_*'), 'FIELDS' => array('*')));
$user_info = $user_info->Fetch();
//deb($user_info, false);

$links = array(
    'COMPANY_NAME' => "",
    'COMPANY_CITY' => "",
    'BIK' => "",
    "COMPANY_INN" => "",
    "COMPANY_KPP" => "",
    "COMPANY_OKPO" => "",
    'COMPANY_BILL' => "",
    'COMPANY_FIO' => 'NAME',
    'EMAIL' => 'EMAIL',
    'PHONE' => 'PERSONAL_PHONE',
    'ADDRESS' => '',
    'COMMENT' => '',
);


//deb($arResult['ORDER_PROP']);

// Get user profiles
$arResult["USER_PROFILES"] = CGCUser::getProfiles($USER->GetID());


// Get user manager
if(!$arResult["USER_PROFILES"]) {
	$arResult["USER_MANAGER"] = CGCUser::getManager($USER->GetID());
}


if(count($arResult["USER_PROFILES"]) == 1) {
	$profile = array_shift($arResult["USER_PROFILES"]);
	//deb($profile);
	foreach ($arResult['ORDER_PROP']['USER_PROPS_Y'] as $propID => $arProp) {
		//echo $arResult["USER_PROFILES"][$arProp["CODE"]]."<br />";
		if($profile[$arProp["CODE"]]) {
			$arResult['ORDER_PROP']['USER_PROPS_Y'][$propID]['VALUE_FORMATED'] = htmlspecialchars($profile[$arProp["CODE"]], ENT_QUOTES, 'UTF-8');
		}
	}
	$arResult["USER_PROFILES"][] = $profile;
} else {
	foreach ($arResult['ORDER_PROP']['USER_PROPS_Y'] as $propID => $arProp) {
		$arResult['ORDER_PROP']['USER_PROPS_Y'][$propID]['VALUE_FORMATED'] = "";
	}
}


if($arParams["NDS_INFO"]["BASKET_COL_SUMMARY_VALUE"]["DISPLAY"] == "Y") {
	$arResult["ORDER_PRICE_FORMATED"] = CurrencyFormat(($arResult["JS_DATA"]["TOTAL"]["ORDER_PRICE"] - $arResult["JS_DATA"]["TOTAL"]["VAT_SUM"]), "RUB");
}

//deb($arResult['ORDER_PROP']['USER_PROPS_Y']);
//deb($arParams["NDS_INFO"]);





//deb($arResult['ORDER_PROP']['USER_PROPS_Y']);
