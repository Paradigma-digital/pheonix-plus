<?php
	//print_r($_REQUEST); die;
	
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

	die;
	global $USER;
	if(!$USER->IsAdmin()) {
		LocalRedirect("/bitrix/admin/");
	}
	
	
	$rsUsers = CUser::GetList(($by = "LAST_NAME"), ($order = "asc"), false, [
    	"SELECT" => ["ID", "NAME", "WORK_COMPANY", "UF_INN", "WORK_PHONE", "WORK_CITY", "UF_PROFILE_COMPLETE"],
	]);
	while($arUser = $rsUsers->GetNext()) {
		$user = new CUser;
		$user->Update($arUser["ID"], [
			"UF_PROFILE_COMPLETE" => 1,
			"UF_SUBSCRIBE_PARTNER" => 1,
			"UF_USER_TYPE" => 5
		]);
	}
?>