<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sender/admin/page_header.php");

/** @var \CAllMain $APPLICATION */
/** @var array $senderAdminPaths */

$APPLICATION->IncludeComponent("bitrix:sender.trigger", "", array(
	'SEF_MODE' => 'N',
	'PATH_TO_LETTER_EDIT' => $senderAdminPaths['LETTER_EDIT'],
	'PATH_TO_LETTER_ADD' => $senderAdminPaths['LETTER_ADD'],
	'PATH_TO_ABUSES' => $senderAdminPaths['ABUSES'],
));

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sender/admin/page_footer.php");