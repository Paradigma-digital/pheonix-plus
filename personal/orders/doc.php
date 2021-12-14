<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
	CGCUser::loginIfNotAuth($USER);
	$APPLICATION->SetTitle("Акт отгрузки");
?>

<?php $APPLICATION->IncludeComponent(
	"aheadstudio:personal.order.doc",
	"",
	[
		"ORDER_ID" => $_REQUEST["ORDER_ID"],
		"UPD_ID" => $_REQUEST["UPD_ID"],
	],
); ?>
	
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>