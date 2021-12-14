<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");



$APPLICATION->SetPageProperty("keywords_inner", "о компании феникс, отзывы феникс, феникс плюс, история компании, эскалада, феникс арт, escalada, fenix art, бренды феникс, канцтовары потом");
$APPLICATION->SetPageProperty("keywords", "канцтовары, феникс +, российский, производитель канцелярии, товары для школы, товары для офиса, о компании, бренды, группа компаний, реализация бумажной продукции, escalada, fenix art, оптовые компании, оптово розничные, профессионализм, надёжность, высокое качество, канцелярии");
$APPLICATION->SetPageProperty("description", "История компании Феникс +  Российский производитель канцелярии, товаров для школы и офиса");
$APPLICATION->SetPageProperty("title", "Феникс +  Российский производитель канцелярии, товаров для школы и офиса");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");

global $USER;
if($USER->IsAuthorized()) {
	LocalRedirect("/catalog/");
}
?>
<div class="page-inner page-inner--w1">
	<div class="page-heading">
				  <h1 class="h1">Авторизация</h1>
				</div>
	<div class="page-inner page-inner--w3 page-inner--centered">
		<?$APPLICATION->IncludeComponent(
			"aheadstudio:system.auth.form",
			"inline",
			Array(
				"REGISTER_URL" => "/auth/", 
				"PROFILE_URL" => "/catalog/",
				"SHOW_ERRORS" => "Y",
			)
		);?>
	</div>
</div>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>