<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?><!DOCTYPE html>
<html lang="ru" prefix="og:http://ogp.me/ns#" class="no-js">
  <head>
      <? include $_SERVER['DOCUMENT_ROOT'].'/local/common/head.php'?>
  </head>
  <body itemscope itemtype="http://schema.org/WebPage" class="home-page">
      <?$APPLICATION->ShowPanel();?>
    <div class="page">
      <header itemscope itemtype="http://schema.org/WPHeader" class="page-header">
        <div class="header-row">
          <div class="page-inner page-inner--w1">
            <nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="header-menu ">
              
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
            <div class="header-bar"><a title="Личный кабинет" class="header-bar-item">Иванов В. И.</a><a href="#" title="Выйти" class="header-bar-logout">Выйти</a></div>
          </div>
        </div>
        <div class="header-row">
          <div class="page-inner page-inner--w1">
            <div class="header-contacts"><a href="tel:+78632618950" class="header-contacts-phone">(863) 261-89-50</a>
              <div class="header-contacts-schedule">с 10:00 до 18:00</div>
            </div>
            <div class="header-link"><a href="/about/contacts/" class="header-menu-item">Контакты</a></div><a href="/" class="header-logo"><span class="header-logo-out"></span><span class="header-logo-over"></span></a><a href="/cart/" class="header-basket">
              <div class="header-basket-inner"><span class="header-basket-title"><span>Корзина</span><svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.63 30"><path d="M28.38 30H6.88a.88.88 0 0 1-.83-.59l-6-17.25A.88.88 0 0 1 .88 11h32.87a.88.88 0 0 1 .84 1.14l-5.37 17.25a.87.87 0 0 1-.84.61zM7.5 28.25h20.23l4.83-15.5H2.11z" fill="#000103"/><path d="M24.5 17.87a.87.87 0 0 1-.87-.87V7.37a6 6 0 0 0-12 0v9.62a.875.875 0 1 1-1.75 0V7.37a8.61 8.61 0 0 1 1-3.66c.9-1.7 2.8-3.72 6.79-3.72a7.27 7.27 0 0 1 7.75 7.38v9.62a.87.87 0 0 1-.92.88z" fill="#000103"/></svg></span><span class="header-basket-price">32 000&nbsp;₽</span></div><span class="header-basket-count">7</span></a>
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
				"TOP_DEPTH" => "1",
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
        <div class="mobile-header-inner">
          <div class="mobile-header-logo"></div>
        </div>
        <div class="mobile-header-controls"><a href="/catalog/?q=" class="mobile-header-search"><svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20.87 20.26"><g fill="#000103"><path d="M8.75 17.5a8.75 8.75 0 1 1 8.75-8.75 8.76 8.76 0 0 1-8.75 8.75zm0-15.75a7 7 0 1 0 7 7 7 7 0 0 0-7-7z"/><path d="M19.99 20.25a.87.87 0 0 1-.62-.26l-5.38-5.38a.88.88 0 0 1 1.24-1.24l5.38 5.38a.87.87 0 0 1-.62 1.5z"/></g></svg></a><a href="/cart/" class="mobile-header-basket"><svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.63 30"><path d="M28.38 30H6.88a.88.88 0 0 1-.83-.59l-6-17.25A.88.88 0 0 1 .88 11h32.87a.88.88 0 0 1 .84 1.14l-5.37 17.25a.87.87 0 0 1-.84.61zM7.5 28.25h20.23l4.83-15.5H2.11z" fill="#000103"/><path d="M24.5 17.87a.87.87 0 0 1-.87-.87V7.37a6 6 0 0 0-12 0v9.62a.875.875 0 1 1-1.75 0V7.37a8.61 8.61 0 0 1 1-3.66c.9-1.7 2.8-3.72 6.79-3.72a7.27 7.27 0 0 1 7.75 7.38v9.62a.87.87 0 0 1-.92.88z" fill="#000103"/></svg></a></div>
      </div>
      <div class="mobile-search">
        <form action="/catalog/" name="q" class="mobile-search-inner">
          <input type="text" placeholder="Поиск по слову, артикулу..." class="mobile-search-input form-item form-item--text">
          <button type="submit" class="mobile-search-submit"><svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20.87 20.26"><g fill="#000103"><path d="M8.75 17.5a8.75 8.75 0 1 1 8.75-8.75 8.76 8.76 0 0 1-8.75 8.75zm0-15.75a7 7 0 1 0 7 7 7 7 0 0 0-7-7z"/><path d="M19.99 20.25a.87.87 0 0 1-.62-.26l-5.38-5.38a.88.88 0 0 1 1.24-1.24l5.38 5.38a.87.87 0 0 1-.62 1.5z"/></g></svg>
          </button>
        </form><span class="mobile-search-close"><svg data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7.41 7.41"><g fill="#fff"><path d="M.88 7.4a.88.88 0 0 1-.62-1.49l2.83-2.83a.877.877 0 0 1 1.24 1.24L1.5 7.17a.87.87 0 0 1-.62.23z"/><path d="M3.71 4.58a.87.87 0 0 1-.62-.26L.26 1.49A.877.877 0 0 1 1.5.25l2.83 2.83a.88.88 0 0 1-.62 1.5z"/><path d="M6.58 7.4a.87.87 0 0 1-.62-.26L3.13 4.31a.877.877 0 1 1 1.24-1.24L7.2 5.9a.88.88 0 0 1-.62 1.5z"/><path d="M3.71 4.58a.88.88 0 0 1-.62-1.49L5.92.26A.877.877 0 1 1 7.16 1.5L4.33 4.33a.87.87 0 0 1-.62.25z"/></g></svg></span>
      </div>
      <div class="mobile-header-burger">
        <div class="mobile-header-burger-inner"></div>
      </div>