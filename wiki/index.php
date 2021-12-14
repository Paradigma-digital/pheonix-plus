<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Wiki");
?>
<div class="page-inner page-inner--w1">
	<div class="page-text">
<?$APPLICATION->IncludeComponent(
	"bitrix:wiki", 
	".default", 
	array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"ELEMENT_NAME" => $_REQUEST["title"],
		"IBLOCK_ID" => "34",
		"IBLOCK_TYPE" => "wiki",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"NAME_TEMPLATE" => "",
		"NAV_ITEM" => "",
		"PATH_TO_USER" => "",
		"RATING_TYPE" => "like",
		"SEF_MODE" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_RATING" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"USE_REVIEW" => "Y",
		"MESSAGES_PER_PAGE" => "10",
		"USE_CAPTCHA" => "Y",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"FORUM_ID" => "1",
		"URL_TEMPLATES_READ" => "",
		"SHOW_LINK_TO_FORUM" => "N",
		"POST_FIRST_MESSAGE" => "N",
		"SEF_FOLDER" => "/wiki/",
		"SEF_URL_TEMPLATES" => array(
			"index" => "index.php",
			"post" => "#wiki_name#/",
			"post_edit" => "#wiki_name#/edit/",
			"categories" => "categories/",
			"discussion" => "#wiki_name#/discussion/",
			"history" => "#wiki_name#/history/",
			"history_diff" => "#wiki_name#/history/diff/",
			"search" => "search/",
		)
	),
	false
);?>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>