<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
	CGCUser::loginIfNotAuth($USER);
	$APPLICATION->SetTitle("Просмотр УПД");
?>
	
<?php $APPLICATION->IncludeComponent(
	"aheadstudio:personal.order.upd",
	"",
	[
		"ORDER_ID" => $_REQUEST["ORDER_ID"],
		"ID" => $_REQUEST["UPD_ID"],
	],
); ?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>