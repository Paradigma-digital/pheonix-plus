<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Феникс – Смена пароля");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Смена пароля");
?>

<?$APPLICATION->IncludeComponent("bitrix:system.auth.changepasswd","",Array())?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>