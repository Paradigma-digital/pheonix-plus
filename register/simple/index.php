<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Феникс – это один из крупнейших производителей канцелярии и товаров для школы в России");
$APPLICATION->SetTitle("Регистрация покупателя");
?>
<?$APPLICATION->IncludeComponent(
	"aheadstudio:main.register",
	"",
	Array(
		"AUTH" => "N",
		"REQUIRED_FIELDS" => array("NAME","EMAIL"),
		"SET_TITLE" => "N",
		"SHOW_FIELDS" => array("NAME","EMAIL", "WORK_CITY", "WORK_COMPANY","PERSONAL_PHONE","UF_INN","UF_BIK","UF_BILL", "UF_REGISTER_PROMO"),
		"SUCCESS_PAGE" => "",
		"USER_PROPERTY" => array("UF_INN","UF_BIK","UF_BILL", "UF_REGISTER_PROMO"),
		"USE_BACKURL" => "N",
		"USE_CAPTCHA" => "Y",
		"TYPE" => "SIMPLE",
		"CACHE_TYPE" => "N",
		"PARTNER_CODE" => GCPartner::getCode(),
	)
);?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>