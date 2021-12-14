<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Феникс – это один из крупнейших производителей канцелярии и товаров для школы в России");
$APPLICATION->SetTitle("Регистрация");
LocalRedirect("/register/simple/");
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>