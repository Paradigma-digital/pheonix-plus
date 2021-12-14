<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

global $USER;

CGCUser::loginIfNotAuth($USER);

$isUserBusiness = CGCUser::isUserBusiness([
	"ID" => $USER->GetID()
]);
if(!$isUserBusiness) {
	LocalRedirect("/personal/profile/");
} else {
	LocalRedirect("/personal/profile/");
}
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>