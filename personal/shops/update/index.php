<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?php
	$APPLICATION->IncludeComponent(
		"aheadstudio:user.shop.update",
		"",
		[
			"HL_ID" => "11",
		]
	);
?>
<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>