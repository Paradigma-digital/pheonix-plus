<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	
	global $USER;
	if(!$USER->IsAdmin()) {
		LocalRedirect("/bitrix/admin/");
	}
	
	CModule::IncludeModule("iblock");
	CModule::IncludeModule("sale");
	CModule::IncludeModule("catalog");
	
	
	// Получение списка возможных налоговых ставок
	$dbVats = CCatalogVat::GetList();
	$arVats = [];
	while($arVat = $dbVats->Fetch()) {
		$arVats[$arVat["ID"]] = $arVat;
	}
	//deb($arVats);
	
	
	// Получение списка товаров с их свойствами с индексом по ID товара Инфоблока
	$arIBProducts = [];
	$dbIBProducts = CIBlockElement::GetList(
		false,
		[
			"IBLOCK_ID" => "9",
			//"ID" => "18592"
		],
		false,
		false,
		[
			"ID", "ACTIVE", "PROPERTY_CML2_ARTICLE", "NAME", "DETAIL_PAGE_URL"
		]
	);
	while($arIBProduct = $dbIBProducts->GetNext()) {
		$arIBProducts[$arIBProduct["ID"]] = $arIBProduct;
	}
	//deb($arIBProducts);
	
	
	// Получение списка товаров каталога и формирование массива
	$arCatalogProducts = [];
	$dbCatalogProducts = CCatalogProduct::GetList(
		false,
		[
			"IBLOCK_ID" => "9",
			//"ID" => "18592"
		],
		false,
		[
			//"nTopCount" => "10"
		],
		[
			"ID", "ELEMENT_NAME", "DETAIL_PAGE_URL", "AVAILABLE", "VAT_ID", "QUANTITY"
		]
	);
	
	while($arCatalogProduct = $dbCatalogProducts->GetNext()) {
		//deb($arCatalogProduct);
		//deb($arVats[$arCatalogProduct["VAT_ID"]]);
		$arTmpProduct = [
			"ID" => $arCatalogProduct["ID"],
			"NAME" => $arIBProducts[$arCatalogProduct["ID"]]["NAME"],
			"ARTICLE" => $arIBProducts[$arCatalogProduct["ID"]]["PROPERTY_CML2_ARTICLE_VALUE"],
			"QUANTITY" => $arCatalogProduct["QUANTITY"],
			"ACTIVE" => $arIBProducts[$arCatalogProduct["ID"]]["ACTIVE"],
			"ADMIN_URL" => "http://".SITE_SERVER_NAME."/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=9&type=1c_catalog&ID=".$arCatalogProduct["ID"]."&lang=ru&WF=Y",
			"SITE_URL" => "http://".SITE_SERVER_NAME.$arIBProducts[$arCatalogProduct["ID"]]["DETAIL_PAGE_URL"],
			"NDS" => $arVats[$arCatalogProduct["VAT_ID"]]["RATE"],
		];
		$arCatalogProducts[] = $arTmpProduct;
	}
	//deb($arCatalogProducts);
?>
<?php
$file="products_nds.xls";
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header("Content-Transfer-Encoding: binary ");
header("Content-Disposition: attachment; filename=$file");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>products_nds</title>
	</head>
	<body>
		<table cellspacing="5" cellpadding="5">
			<thead>
				<tr>
					<th>id</th>
					<th>article</th>
					<th>active</th>
					<th>name</th>
					<td>quantity</td>
					<th>nds</th>
					<th>admin_url</th>
					<th>site_url</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($arCatalogProducts as $arCatalogProduct): ?>
					<tr>
						<td><?php echo $arCatalogProduct["ID"]; ?></td>
						<td><?php echo $arCatalogProduct["ARTICLE"]; ?></td>
						<td><?php echo $arCatalogProduct["ACTIVE"]; ?></td>
						<td><?php echo $arCatalogProduct["NAME"]; ?></td>
						<td><?php echo $arCatalogProduct["QUANTITY"]; ?></td>
						<td><?php echo $arCatalogProduct["NDS"]; ?></td>
						<td><?php echo $arCatalogProduct["ADMIN_URL"]; ?></td>
						<td><?php echo $arCatalogProduct["SITE_URL"]; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</body>
</html>