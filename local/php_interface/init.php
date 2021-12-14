<?php
include 'include/consts.php';
include 'include/functions.php';
include 'include/events.php';
include 'include/classes/catalog/perpage.php';
include 'include/classes/catalog/sort.php';
include 'include/goodcode/GCCatalog.class.php';
include 'include/goodcode/GCUser.class.php';
include 'include/goodcode/GCHelper.class.php';
include 'include/goodcode/GC1C.class.php';
include 'include/goodcode/GCSettings.class.php';
include 'include/goodcode/GCHL.class.php';
include 'include/goodcode/GCSetting.class.php';
include 'include/goodcode/GCDocs.class.php';
include 'include/goodcode/GCBookmark.class.php';
include 'include/goodcode/GCPartner.class.php';
include 'include/goodcode/usertypes.php';
include 'include/goodcode/admin.php';
include 'include/phoenixplus/events.php'; // sdemon72
include 'include/preorder/preorder.class.php';
include 'include/preorder/rsite_pay_restriction_by_user_group.php';

if(file_exists(__DIR__."/../../vendor/autoload.php")) {
	require __DIR__."/../../vendor/autoload.php";
}

function op($r)
{
    echo "<pre>";
    print_r($r);
    echo "<pre>";
}

function dumps($mass, $el = "")
{
    global $DB, $USER;
    Bitrix\Main\Diag\Debug::writeToFile($mass, $el . " - " . date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL"))), "/log/log_" . $el . ".log");
}

$retailPriceType = false;
$dbPriceType = CCatalogGroup::GetList(
	false,
	[
		"XML_ID" => "2f235eaa-a0b9-11ea-80dc-002590ea7b7b"
	],
	false,
	[
		"nTopCount" => "1"
	]
);
$arPriceType = $dbPriceType->Fetch();
if($arPriceType) {
	$GLOBALS["RETAIL_PRICE_TYPE_ID"] = $arPriceType["ID"];
}