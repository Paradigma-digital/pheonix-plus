<?
if(isset($_REQUEST["video"]) && $_REQUEST["video"]) {
	setcookie("HIDE_VIDEO", "", time() - 3600, "/");
	header('Location: /');
}
if(isset($_COOKIE["HIDE_VIDEO"]) && $_COOKIE["HIDE_VIDEO"] == "Y") {
	header('Location: /catalog/');
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "канцтовары,феникс плюс, феникс официальный сайт, компания феникс, fenix официальный сайт, корпорация феникс, гк феникс, феникс ростов, феникс интернет магазин, фирма феникс, канцтовары, phoenix plus, сайт феникса, реквизиты феникс, феникс канцелярия, видео с ракетой, выбрать лучшее, 6000 товаров, паттерн, российский производитель");
$APPLICATION->SetPageProperty("description", "Феникс + Российский производитель канцелярии, товаров для школы и офиса");
$APPLICATION->SetPageProperty("keywords", "феникс +, российский, производитель канцелярии, товары для школы, товары для офиса, о компании, бренды, акции и новости, контакты и реквизиты, интернет магазин, для бизнеса, для школы,канцелярия, канцтовары");
$APPLICATION->SetPageProperty("title", "Феникс+ Российский производитель канцелярии, товаров для школы и офиса");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Феникс+ Российский производитель канцелярии, товаров для школы и офиса");
?>
<div class="home ">        
    <div class="home-info">          
	<div class="home-info-header">            
	    <div class="home-info-header-logo"><span class="home-info-header-logo-out"></span><span class="home-info-header-logo-over"> </span></div>            
	    <div class="home-info-header-contacts">
		<a href="tel:+78632618962" title="Позвонить нам" class="home-info-header-contacts-phone">+7 (863) 261-89-62</a>              
		<div class="home-info-header-contacts-schedule"><?$APPLICATION->IncludeFile("/include/common/worktime.php", Array(), Array("MODE" => "html"))?></div>            
	    </div>          
	</div>          
	<div class="home-info-content">            
	    <h1 class="home-info-heading"><?$APPLICATION->IncludeFile("/include/main/h1.php", Array(), Array("MODE" => "html"))?></h1>     
		<?$APPLICATION->IncludeComponent(
			"bitrix:menu",
			"main",
			Array(
				"ROOT_MENU_TYPE" => "main", 
				"MAX_LEVEL" => "1", 
				"CHILD_MENU_TYPE" => "main", 
				"USE_EXT" => "Y", 
				"MENU_CACHE_TYPE" => "A",
				"MENU_CACHE_TIME" => "3600",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"MENU_CACHE_GET_VARS" => Array()
			)
		);?>
	           
	</div>          
	<div class="home-info-footer">            
	    <div class="home-info-copyrights"><?$APPLICATION->IncludeFile("/include/common/copyright.php", Array(), Array("MODE" => "html"))?></div>          
	</div>        
    </div>        
    <div class="home-shop">          
	<div class="home-shop-content">            
	    <div class="home-shop-heading"><?$APPLICATION->IncludeFile("/include/main/title.php", Array(), Array("MODE" => "html"))?></div>           
	    <div class="home-shop-title"><?$APPLICATION->IncludeFile("/include/main/text.php", Array(), Array("MODE" => "text"))?></div>
	    <a href="/catalog/" class="home-shop-link"><span class="home-shop-link-icon"><svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.63 30"><path d="M28.38 30H6.88a.88.88 0 0 1-.83-.59l-6-17.25A.88.88 0 0 1 .88 11h32.87a.88.88 0 0 1 .84 1.14l-5.37 17.25a.87.87 0 0 1-.84.61zM7.5 28.25h20.23l4.83-15.5H2.11z" fill="#000103"/><path d="M24.5 17.87a.87.87 0 0 1-.87-.87V7.37a6 6 0 0 0-12 0v9.62a.875.875 0 1 1-1.75 0V7.37a8.61 8.61 0 0 1 1-3.66c.9-1.7 2.8-3.72 6.79-3.72a7.27 7.27 0 0 1 7.75 7.38v9.62a.87.87 0 0 1-.92.88z" fill="#000103"/></svg></span><span class="home-shop-link-text">В интернет-магазин</span></a>     
	</div>
	
	<?$APPLICATION->IncludeComponent(
	"bitrix:news.detail",
	"main-video",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BROWSER_TITLE" => "-",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_CODE" => "main-video",
		"ELEMENT_ID" => "",
		"FIELD_CODE" => array("", ""),
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "content",
		"IBLOCK_URL" => "",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Страница",
		"PROPERTY_CODE" => array("VIDEO_FILES", ""),
		"SET_BROWSER_TITLE" => "N",
		"SET_CANONICAL_URL" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_SHARE" => "N"
	)
);?>       
	<div class="home-shop-bg"></div>     
	<div class="home-shop-footer">
	    <a href="http://ruformat.ru" target="_blank" title="Разработка интернет-магазинов" class="home-shop-creators">
		<span class="home-shop-creators-title"> Разработка сайта </span>
		<span class="home-shop-creators-name">RUFORMAT</span>
	    </a>
	    

	    <label class="hide-video">
		    <input type="checkbox" value="Y" name="hide_video" class="form-item form-item--checkbox hide-video-checkbox" <?php if(isset($_COOKIE["HIDE_VIDEO"]) && $_COOKIE["HIDE_VIDEO"] == "Y"): ?>checked="checked"<?php endif; ?> />
		    <span class="hide-video-title">Больше не показывать</span>
	    </label>
	    
	</div>      
    </div>   
</div> 
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>