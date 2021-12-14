<?php
	//print_r($_REQUEST); die;
	
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

	
	global $USER;
	if(!$USER->IsAdmin()) {
		LocalRedirect("/bitrix/admin/");
	}
	
	// Get user groups
	$dbGroups = CGroup::GetList(
		($by="c_sort"),
		($order="desc"),
		[
			"NAME" => "%группа%"
		]
	);
	while($arGroup = $dbGroups->Fetch()) {
		$arGroups[] = $arGroup;
	}
	//deb($arGroups);

	
	
	// Get user list
	$dbUsers = CUser::GetList(
		($by = "EMAIL"), 
		($order= "ASC"),
		[
			//"EMAIL" => "fenixkancopt1@mail.ru",
			"ACTIVE" => "Y",
		],
		[
			"SELECT" => [
				"ID", "NAME", "EMAIL", "UF_PRICE_ID"
			]
		]
	);
	$arUsers = [];
	while($arUser = $dbUsers->Fetch()) {
		//deb($arUser);
		$updateUserGroup = true;
		$arUserGroups = [];
		$dbUserGroups = CUser::GetUserGroupList($arUser["ID"]);
		while($arUserGroup = $dbUserGroups->Fetch()) {
			foreach($arGroups as $arGroup) {
				if($arUserGroup["GROUP_ID"] == $arGroup["ID"]) {
					$updateUserGroup = false;
				}
			}
			$arUserGroups[] = $arUserGroup["GROUP_ID"];
		}
		if($updateUserGroup) {
			$neededGroup = false;
			foreach($arGroups as $arGroup) {
				if($arGroup["STRING_ID"] == $arUser["UF_PRICE_ID"]) {
					$neededGroup = $arGroup;
				}
			}
			//deb($arUserGroups);
			$arUserGroups[] = $neededGroup["ID"];
			//deb($neededGroup);
			//deb($arUserGroups);
			echo $arUser["EMAIL"]." needs update – ".$arGroup["NAME"]."<br />";
			//deb($arUser["ID"], $arUserGroups);
			CUser::SetUserGroup($arUser["ID"], $arUserGroups);
			
		} else {
			//echo $arUser["EMAIL"]." – OK<br />";
		}
	}
?>