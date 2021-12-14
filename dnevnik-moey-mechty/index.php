<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Дневник моей мечты");
?>
<div class="page-inner page-inner--w1">
		<?php $APPLICATION->IncludeComponent(
			"bitrix:voting.form",
			"contest.poll",
			Array(
				"CACHE_TIME" => "3600",
				"CACHE_TYPE" => "A",
				"VOTE_ID" => "2",
				"VOTE_RESULT_TEMPLATE" => ""
			)
		); ?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>