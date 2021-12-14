<?php
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
	$arGroups = [
		[
			"ID" => "undefined",
			"NAME" => "Канц опт",
			"STRING_ID" => "23983791-729c-11e1-a859-00259003b1ef",
		]
	];
	while($arGroup = $dbGroups->Fetch()) {
		$arGroups[] = $arGroup;
	}
	//deb($arGroups);
	
	$dbUsers = CUser::GetList(
		($by = "EMAIL"), 
		($order= "ASC"),
		[
		
		],
		[
			"SELECT" => [
				"ID", "NAME", "EMAIL"
			]
		]
	);
	$arUsers = [];
	while($arUser = $dbUsers->Fetch()) {
		$arTmpUser = [
			"NAME" => $arUser["NAME"],
			"EMAIL" => $arUser["EMAIL"],
			"ID" => $arUser["ID"],
		];
		$arTmpUserGroups = [];
		$dbTmpUserGroups = CUser::GetUserGroupList($arUser["ID"]);
		while($arTmpUserGroup = $dbTmpUserGroups->Fetch()) {
			foreach($arGroups as $arGroup) {
				if($arTmpUserGroup["GROUP_ID"] == $arGroup["ID"]) {
					$arTmpUserGroups[] = $arGroup;
					break;
				}
			}
		}
		if(!$arTmpUserGroups) {
			$arTmpUserGroups[] = $arGroups[0];
		}
		$arTmpUser["GROUPS"] = $arTmpUserGroups;
		$arUsers[] = $arTmpUser;
	}
	unset($arUser);
	
	//deb($arUsers);
?>
<?php
$file="users_group_report.xls";
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header("Content-Transfer-Encoding: binary ");
header("Content-Disposition: attachment; filename=$file");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>users_group_report</title>
	</head>
	<body>
		<table cellspacing="5" cellpadding="5">
			<thead>
				<tr>
					<th>email</th>
					<th>price_group_xmlid</th>
					<th>price_group</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($arUsers as $arUser): ?>
					<?php foreach($arUser["GROUPS"] as $arUserGroup): ?>
						<tr>
							<td><?php echo $arUser["EMAIL"]; ?></td>
							<td><?php echo $arUserGroup["STRING_ID"]; ?></td>
							<td><?php echo $arUserGroup["NAME"]; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>
</html>