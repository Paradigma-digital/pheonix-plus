<?php
AddEventHandler("main", "OnAdminListDisplay", "OnAdminListDisplayHandler");
AddEventHandler("main", "OnBeforeProlog", "OnBeforePrologHandler");
AddEventHandler("main", "OnBuildGlobalMenu", "OnBuildGlobalMenu");

function OnBeforePrologHandler() {
	//deb($_REQUEST); die;
	if($GLOBALS["USER"]->IsAdmin() && $_REQUEST["grid_id"] == "tbl_user" && $_REQUEST["ID"] && $_REQUEST["action"]["action_button_tbl_user"] == "clear_export") {
		$arIDs = [];
		if($_REQUEST["action_all_rows_tbl_user"] == "Y") {
			$dbUsers = CUser::GetList(
				($order = "ID"),
				($desc = "DESC"),
				Array(
					"UF_EXPORTED_1C" => "Y",
				),
				Array(
					"SELECT" => ["ID"],
				)
			);
			while($arUser = $dbUsers->Fetch()) {
				$arIDs[] = $arUser["ID"];
			}
		} else {
			$arIDs = $_REQUEST["ID"];
		}
		foreach($arIDs as $userID) {
			$dbUser = new CUser;
			$dbUser->Update($userID, [
				"UF_EXPORTED_1C" => ""
			]);
		}
	}
	
	if($GLOBALS["USER"]->IsAdmin() && $_REQUEST["grid_id"] == "tbl_user" && $_REQUEST["ID"] && $_REQUEST["action"]["action_button_tbl_user"] == "fix_xml_id") {
		$arUsers = [];
		$dbUsers = CUser::GetList(
			($order = "ID"),
			($desc = "DESC"),
			[
				"ID" => (($_REQUEST["action_all_rows_tbl_user"] == "Y") ? "" : implode(" | ", $_REQUEST["ID"])),
			],
			[
				"SELECT" => ["ID", "LOGIN"],
			]
		);
		while($arUser = $dbUsers->Fetch()) {
			$arUsers[] = $arUser;
			
			$dbUser = new CUser;
			$dbUser->Update($arUser["ID"], [
				"XML_ID" => htmlspecialcharsbx(trim($arUser["ID"]."#".$arUser["LOGIN"]."#")),
			]);
		}
		unset($dbUser);
	}
}

function OnAdminListDisplayHandler(&$list) {
	if($list->table_id == "tbl_user") {
		$list->arActions["clear_export"] = "сбросить флаг выгрузки";
		$list->arActions["fix_xml_id"] = "исправить внешний код";
	}
}







function OnBuildGlobalMenu(&$adminMenu, &$moduleMenu){
	$moduleMenu[] = array(
		"parent_menu" => "global_menu_services", // поместим в раздел "Сервис"
		"section" => "Отчеты",
		"sort"        => 5000,                    // сортировка пункта меню
		"url"         => "",  // ссылка на пункте меню
		"text"        => 'Отчеты',       // текст пункта меню
		"title"       => 'Отчеты', // текст всплывающей подсказки
		"icon"        => "form_menu_icon", // малая иконка
		"page_icon"   => "form_page_icon", // большая иконка
		"items_id"    => "menu_ahead_reports",  // идентификатор ветви
		"items"       => [
			[
				"url" => "/tools/checkProductsNDS.php",  // ссылка на пункте меню
				"text" => 'Отчет по товарам',       // текст пункта меню
			], [
				"url" => "/tools/userGroupsReport.php",  // ссылка на пункте меню
				"text" => 'Группы пользователей',       // текст пункта меню
			], [
				"url" => "/tools/basketTriggerReport.php",  // ссылка на пункте меню
				"text" => 'Брошенные корзины',       // текст пункта меню
			]
		]
	);
}
?>