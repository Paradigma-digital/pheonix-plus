<?php
	$arPageParams = [
		//"HIDE_LEFT_MENU" => "N",
	];
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
	$APPLICATION->SetTitle("Опрос клиентов от «Феникс+»");
?>
<div class="page-inner page-inner--w1">
	<?php
		global $USER;
		if(!$USER->IsAuthorized()):
	?>
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
	<?php else: ?>
		<?php $APPLICATION->IncludeComponent(
			"bitrix:voting.form",
			"poll.form",
			Array(
				"CACHE_TIME" => "3600",
				"CACHE_TYPE" => "A",
				"VOTE_ID" => "1",
				"VOTE_RESULT_TEMPLATE" => ""
			)
		); ?>
	<?php endif; ?>
</div>
<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>