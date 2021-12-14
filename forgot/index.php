<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Феникс – Восстановление пароля");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Забыли пароль");
?>

<?$APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd","",Array())?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>