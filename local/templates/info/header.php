<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);



$defArPageParams = Array(
	"ADD_PAGE_TEXT_HOLDER" => "Y",
);
if(isset($arPageParams)) {
	$arPageParams = array_merge($defArPageParams, $arPageParams);
} else {
	$arPageParams = $defArPageParams;
}



$uss_list = array();
$uss_total = array();
$uss = CUser::GetList(($by="personal_country"), ($order="desc"), array(), array('FIELDS' => array('LOGIN', 'EMAIL', 'ACTIVE')));
while ($us = $uss->Fetch())
{
	if ($us['ACTIVE'] == 'N')
	{
		$uss_list[] = md5($us['LOGIN']);
		$uss_list[] = md5($us['EMAIL']);
	}
	$uss_total[] = md5($us['LOGIN']);
	$uss_total[] = md5($us['EMAIL']);
}	

?><!DOCTYPE html>
<html lang="ru" prefix="og:http://ogp.me/ns#" class="no-js">
  <head>
      <? include $_SERVER['DOCUMENT_ROOT'].'/local/common/head.php'?>
      <script>
	      var not_active_u = <?=  json_encode($uss_list)?>;
	      var total_u = <?=  json_encode($uss_total)?>;
      </script>
  </head>
  <body itemscope itemtype="http://schema.org/WebPage" class="<? if ($USER->IsAuthorized()) { ?>registered<? } ?>">
      <?$APPLICATION->ShowPanel();?>
    <div class="page">
	    
	    
		<?php global $USER; if(CGCCatalog::isOldBasket($USER->GetID())): ?>
			<a href="/cart/" class="page-message" id="old-basket-message">
				<div class="page-inner page-inner--w1">
					<div class="page-message-inner">
						<div class="page-message-content">Товары в корзине скоро могут закончиться. Поторопитесь.<br /><u>Перейти в корзину и оформить заказ</u>.</div>
						<div class="page-message-close"></div>
					</div>
				</div>
			</a>
		<?php endif; ?>
	    
	    
      <header itemscope itemtype="http://schema.org/WPHeader" class="page-header">
        <div class="header-row">
          <div class="page-inner page-inner--w1">
	    <?$APPLICATION->IncludeComponent(
			"bitrix:menu",
			"top",
			Array(
				"ROOT_MENU_TYPE" => "top", 
				"MAX_LEVEL" => "2", 
				"CHILD_MENU_TYPE" => "top_more", 
				"USE_EXT" => "Y", 
				"MENU_CACHE_TYPE" => "A",
				"MENU_CACHE_TIME" => "3600",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"MENU_CACHE_GET_VARS" => Array()
			)
	    );?> 
            
            <? if (!$USER->IsAuthorized()) { ?>
            <div class="header-login">
              <div class="header-login-text">Для получения доступа к ценам необходимо пройти регистрацию.</div><a href="#login" data-type="inline" class="link link--login header-login-auth popup"><span class="link-text">Вход</span><span class="link-icon"></span></a>
            </div>
            <? } else { ?>
            <div class="header-bar"><a href="/personal/" title="Личный кабинет" class="header-bar-item"><?php echo $USER->GetFullName(); ?></a><a href="?&logout=yes" title="Выйти" class="header-bar-logout">Выйти</a></div>
            <? } ?>
          </div>
        </div>
        <div class="header-row">
          <div class="page-inner page-inner--w1">
            <div class="header-contacts"><a href="tel:+78632618962" class="header-contacts-phone">+7 (863) 261-89-62</a>
              <div class="header-contacts-schedule">с 10:00 до 18:00</div>
            </div>
	      <? if (!$USER->IsAuthorized()) { ?>
            <div class="header-link"><a href="/about/contacts/" class="header-menu-item">Контакты</a></div><a href="/" class="header-logo"><span class="header-logo-out"></span><span class="header-logo-over"></span></a><a href="/register/" class="header-register animation-link">Зарегистрироваться</a>
	    <? } else { ?>
	    <div class="header-link"><a href="/about/contacts/" class="header-menu-item">Контакты</a></div><a href="/" class="header-logo"><span class="header-logo-out"></span><span class="header-logo-over"></span></a><?
	   	global $USER;
	   	$arSaleInfo = CGCUser::getSaleInfo($USER->GetID());
	   	if($arSaleInfo["GROUP"]["GROUP"]) {
		    $APPLICATION->IncludeComponent(
			    "bitrix:sale.basket.basket.line",
			    ".default",
			    Array(
				    "HIDE_ON_BASKET_PAGES" => "Y",
				    "PATH_TO_BASKET" => SITE_DIR."cart/",
				    "PATH_TO_ORDER" => SITE_DIR."cart/order/",
				    "POSITION_FIXED" => "N",
				    "SHOW_AUTHOR" => "N",
				    "SHOW_EMPTY_VALUES" => "Y",
				    "SHOW_NUM_PRODUCTS" => "Y",
				    "SHOW_PERSONAL_LINK" => "N",
				    "SHOW_PRODUCTS" => "Y",
				    "SHOW_TOTAL_PRICE" => "Y",
				    "NDS_INFO" => $arSaleInfo["NDS"],
			    )
		    ); 
	   	}
	    ?>
	    <? } ?>
          </div>
        </div>
        <div class="header-row">
          <div class="page-inner page-inner--w1">
		<? $APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"header-menu",
			Array(
				"ADD_SECTIONS_CHAIN" => "N",
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"COUNT_ELEMENTS" => "Y",
				"IBLOCK_ID" => "9",
				"IBLOCK_TYPE" => "1c_catalog",
				"SECTION_CODE" => "",
				"SECTION_FIELDS" => array(0=>"",),
				"SECTION_ID" => "",
				"SECTION_URL" => "/catalog/#SECTION_CODE_PATH#/",
				"SECTION_USER_FIELDS" => array(),
				"SHOW_PARENT_NAME" => "Y",
				"TOP_DEPTH" => "5",
				"VIEW_MODE" => "LINE"
			)
		); ?>
            <div class="header-actions"><a href="/news/" class="header-menu-item animation-link">Акции и новости</a></div>
            <form action="/catalog/" class="header-search">
              <input type="text" name="q" placeholder="Поиск" class="header-search-field">
              <button type="submit" title="Найти" class="header-search-submit"><svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20.87 20.26"><g fill="#000103"><path d="M8.75 17.5a8.75 8.75 0 1 1 8.75-8.75 8.76 8.76 0 0 1-8.75 8.75zm0-15.75a7 7 0 1 0 7 7 7 7 0 0 0-7-7z"/><path d="M19.99 20.25a.87.87 0 0 1-.62-.26l-5.38-5.38a.88.88 0 0 1 1.24-1.24l5.38 5.38a.87.87 0 0 1-.62 1.5z"/></g></svg>
              </button>
            </form>
          </div>
        </div>
      </header>
      <div class="mobile-header">
        <div class="mobile-header-inner"><a href="/" class="mobile-header-logo"></a>
        </div>
        <div class="mobile-header-controls"><a href="/catalog/?q=" class="mobile-header-search"><svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20.87 20.26"><g fill="#000103"><path d="M8.75 17.5a8.75 8.75 0 1 1 8.75-8.75 8.76 8.76 0 0 1-8.75 8.75zm0-15.75a7 7 0 1 0 7 7 7 7 0 0 0-7-7z"/><path d="M19.99 20.25a.87.87 0 0 1-.62-.26l-5.38-5.38a.88.88 0 0 1 1.24-1.24l5.38 5.38a.87.87 0 0 1-.62 1.5z"/></g></svg></a><a href="/cart/" class="mobile-header-basket"><svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.63 30"><path d="M28.38 30H6.88a.88.88 0 0 1-.83-.59l-6-17.25A.88.88 0 0 1 .88 11h32.87a.88.88 0 0 1 .84 1.14l-5.37 17.25a.87.87 0 0 1-.84.61zM7.5 28.25h20.23l4.83-15.5H2.11z" fill="#000103"/><path d="M24.5 17.87a.87.87 0 0 1-.87-.87V7.37a6 6 0 0 0-12 0v9.62a.875.875 0 1 1-1.75 0V7.37a8.61 8.61 0 0 1 1-3.66c.9-1.7 2.8-3.72 6.79-3.72a7.27 7.27 0 0 1 7.75 7.38v9.62a.87.87 0 0 1-.92.88z" fill="#000103"/></svg></a></div>
      </div>
      <div class="mobile-search">
        <form action="/catalog/" class="mobile-search-inner">
          <input type="text" name="q" placeholder="Поиск по слову, артикулу..." class="mobile-search-input form-item form-item--text">
          <button type="submit" class="mobile-search-submit"><svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20.87 20.26"><g fill="#000103"><path d="M8.75 17.5a8.75 8.75 0 1 1 8.75-8.75 8.76 8.76 0 0 1-8.75 8.75zm0-15.75a7 7 0 1 0 7 7 7 7 0 0 0-7-7z"/><path d="M19.99 20.25a.87.87 0 0 1-.62-.26l-5.38-5.38a.88.88 0 0 1 1.24-1.24l5.38 5.38a.87.87 0 0 1-.62 1.5z"/></g></svg>
          </button>
        </form><span class="mobile-search-close"><svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7.41 7.41"><g fill="#fff"><path d="M.88 7.4a.88.88 0 0 1-.62-1.49l2.83-2.83a.877.877 0 0 1 1.24 1.24L1.5 7.17a.87.87 0 0 1-.62.23z"/><path d="M3.71 4.58a.87.87 0 0 1-.62-.26L.26 1.49A.877.877 0 0 1 1.5.25l2.83 2.83a.88.88 0 0 1-.62 1.5z"/><path d="M6.58 7.4a.87.87 0 0 1-.62-.26L3.13 4.31a.877.877 0 1 1 1.24-1.24L7.2 5.9a.88.88 0 0 1-.62 1.5z"/><path d="M3.71 4.58a.88.88 0 0 1-.62-1.49L5.92.26A.877.877 0 1 1 7.16 1.5L4.33 4.33a.87.87 0 0 1-.62.25z"/></g></svg></span>
      </div>
      <div class="mobile-header-burger">
        <div class="mobile-header-burger-inner"></div>
      </div>
	<main class="page-content">
		<div class="page-content-inner">
		    <div class="page-inner page-inner--w1">
			<div class="page-heading">
			  <h1 class="h1"><?$APPLICATION->ShowTitle(false)?></h1>
			</div>
			<?$APPLICATION->ShowViewContent('news_section_list');?>
		    </div>
			<div class="page-inner page-inner--w1">
			    <?$APPLICATION->IncludeComponent(
			"bitrix:menu",
			"left",
			Array(
				"ROOT_MENU_TYPE" => "left", 
				"MAX_LEVEL" => "1", 
				"CHILD_MENU_TYPE" => "left", 
				"USE_EXT" => "Y", 
				"MENU_CACHE_TYPE" => "N",
				"MENU_CACHE_TIME" => "3600",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"MENU_CACHE_GET_VARS" => Array()
			)
	    );?> 
			    <div class="text-holder">
              <?php if($arPageParams["ADD_PAGE_TEXT_HOLDER"] == "Y"): ?>
              	<div class="page-text">
	          <?php endif; ?>