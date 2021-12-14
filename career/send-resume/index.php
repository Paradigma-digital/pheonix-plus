<?php
	$arPageParams = Array(
		"ADD_PAGE_TEXT_HOLDER" => "N"
	);
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
	$APPLICATION->SetTitle("Отправить резюме");
?>
<div class="page-inner page-inner--w3">
	<?$APPLICATION->IncludeComponent(
		"bitrix:form.result.new",
		"form",
		Array(
			"CACHE_TIME" => "3600",
			"CACHE_TYPE" => "A",
			"CHAIN_ITEM_LINK" => "",
			"CHAIN_ITEM_TEXT" => "",
			"EDIT_URL" => "",
			"IGNORE_CUSTOM_TEMPLATE" => "N",
			"LIST_URL" => "",
			"SEF_MODE" => "N",
			"SUCCESS_URL" => "",
			"USE_EXTENDED_ERRORS" => "N",
			"VARIABLE_ALIASES" => Array(
				"RESULT_ID" => "RESULT_ID",
				"WEB_FORM_ID" => "WEB_FORM_ID"
			),
			"WEB_FORM_ID" => "1",
			"FORM_SUCCESS_TEXT" => "Ваш отклик успешно отправлен.<br />В ближайшее время с Вами свяжется менеджер.",
			"DEFAULT_VALUES" => Array(
				"RESUME_POST" => $_REQUEST["vacancy"]
			)
		)
	);?>
</div>
<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>