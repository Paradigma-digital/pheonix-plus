<?php
	$arPageParams = Array(
		"ADD_PAGE_TEXT_HOLDER" => "N"
	);
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
	$APPLICATION->SetTitle("Где купить");
?>
<div class="page-inner page-inner--w1">
	<div class="page-inner page-inner--w3 page-inner--centered">
	<?$APPLICATION->IncludeComponent(
		"bitrix:news.list",
		"shops.list.page",
		Array(
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"ADD_SECTIONS_CHAIN" => "N",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "N",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"CACHE_TIME" => "36000000",
			"CACHE_TYPE" => "A",
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"DISPLAY_DATE" => "Y",
			"DISPLAY_NAME" => "Y",
			"DISPLAY_PICTURE" => "Y",
			"DISPLAY_PREVIEW_TEXT" => "Y",
			"DISPLAY_TOP_PAGER" => "N",
			"FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", ""),
			"FILTER_NAME" => "",
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",
			"IBLOCK_ID" => CGCHelper::getIBlockIdByCode("shops"),
			"IBLOCK_TYPE" => "content",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"INCLUDE_SUBSECTIONS" => "Y",
			"MESSAGE_404" => "",
			"NEWS_COUNT" => "20",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => ".default",
			"PAGER_TITLE" => "Новости",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"PREVIEW_TRUNCATE_LEN" => "",
			"PROPERTY_CODE" => array("LINK", ""),
			"SET_BROWSER_TITLE" => "N",
			"SET_LAST_MODIFIED" => "N",
			"SET_META_DESCRIPTION" => "N",
			"SET_META_KEYWORDS" => "N",
			"SET_STATUS_404" => "N",
			"SET_TITLE" => "N",
			"SHOW_404" => "N",
			"SORT_BY1" => "SORT",
			"SORT_BY2" => "SORT",
			"SORT_ORDER1" => "ASC",
			"SORT_ORDER2" => "ASC",
			"STRICT_SECTION_CHECK" => "N",
			"RESIZE" => [
				"WIDTH" => "400",
				"HEIGHT" => "200",
			]
		)
	);?>
	</div>
	
	
	<div class="page-inner page-inner--w3 page-inner--centered">
	<?php
		$APPLICATION->IncludeComponent(
			"aheadstudio:shops.list",
			"",
			[
				"HL_ID" => "11",
			]
		);
	?>
	</div>
	
	
	
	<div class="page-inner page-inner--w3 page-inner--centered">
		<div class="page-text">
			<p>&nbsp;</p>
			<a href="https://www.instagram.com/phoenix_partners/" target="_blank" class="btn btn--blue btn--large">Спецпредложения для партнеров</a>
			<p>&nbsp;</p>
		</div>
		
		<!--
		<div class="video">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/n3zpLc4yVQU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>

		<div class="page-text">
			<p>&nbsp;</p>
			<a href="https://skrepkaexpo.ru/priglasitelnyi-bilet/" target="_blank" class="btn btn--red btn--fullwidth btn--large">Получить пригласительный на Скрепка Эскпо 2020</a>
			<p>&nbsp;</p>
		</div>
		-->

	</div>
	
	
</div>
<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>