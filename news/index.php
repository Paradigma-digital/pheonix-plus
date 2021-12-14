<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "акции и новости, распродажа, мастер класс, интересное о феникс, канцелярские выставки, конференция феникс, собственная конференция, школьная коллекция, новая коллекция, офисная коллекция, ребрендинг, стенд феникс, новинка эскалада, видеообзор канцелярских, видео обзор канцелярии, мир детства");
$APPLICATION->SetPageProperty("keywords", "акции, новости, видео, мастер класс, новинки, юные таланты, школьную коллекцию, спонсор, всероссийских соревнований, скрепка экспо, золотая скрепка, победители, номинанты, феникс+");
$APPLICATION->SetPageProperty("description", "Акции и новости Феникс +. Российский производитель канцелярии, товаров для школы и офиса");
$APPLICATION->SetPageProperty("title", "Новости Феникс+. Российский производитель канцелярии, товаров для школы и офиса");
$APPLICATION->SetTitle("Акции и новости");
?><?$APPLICATION->IncludeComponent(
	"bitrix:news",
	"news",
	Array(
		"ADD_ELEMENT_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array("",""),
		"DETAIL_PAGER_SHOW_ALL" => "N",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array("PHOTO",""),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FILE_404" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "7",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array("",""),
		"LIST_PROPERTY_CODE" => array("",""),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "15",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "/news/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => Array("detail"=>"#SECTION_CODE#/#ELEMENT_CODE#/","news"=>"","section"=>"#SECTION_CODE#/"),
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N"
	)
);?>
<? /*if ($APPLICATION->GetCurPage() == '/news/') { $APPLICATION->SetTitle("Акции и новости"); ?>
    
          <div class="page-inner page-inner--w1">
            <div class="articles">
              <div class="articles-items">
                <div class="article-item"><a href="/news/letnie-nastroenie-letnie-skidki-na-novyj-assortiment/" class="article-item-inner animation-link">
                    <div class="article-item-photo-holder cover-holder"><img src="/local/templates/.default/dummy/articles/1.jpg" class="article-item-photo cover"></div>
                    <div class="article-item-name-holder"><span class="article-item-name link link--arrow">Летние настроение, летние скидки на новый ассортимент</span></div>
                    <time class="article-item-date">15.04.2017</time></a></div>
                <div class="article-item"><a href="/news/novye-tekhnologii-perepleta-net-ogranichenij-i-ramok/" class="article-item-inner animation-link">
                    <div class="article-item-photo-holder cover-holder"><img src="/local/templates/.default/dummy/articles/2.jpg" class="article-item-photo cover"></div>
                    <div class="article-item-name-holder"><span class="article-item-name link link--arrow">Новые технологии переплета, нет ограничений и рамок</span></div>
                    <time class="article-item-date">12.04.2017</time></a></div>
              </div>
            </div>
            <!--<div class="pager"><a href="#" class="pager-item">1</a><span class="pager-item current">2</span><a href="#" class="pager-item">3</a><a href="#" class="pager-item">4</a><a href="#" class="pager-item">...</a><a href="#" class="pager-item">24</a><a href="#" class="pager-item">25</a></div>-->
            </div>
<? } elseif ($APPLICATION->GetCurPage() == '/news/letnie-nastroenie-letnie-skidki-na-novyj-assortiment/') { ?>
	<div class="page-inner page-inner--w1">
            <article class="article">
              <h1 class="h1 article-title article-title--left">Летние настроение, летние скидки на новый ассортимент</h1>
              <div class="article-date">15.04.2017</div>
              <div class="article-content">
                <div class="page-slider-holder">
                  <div data-shadows="false" data-margin="0" data-width="100%" data-arrows="false" data-nav="false" data-loop="true" data-transitionduration="700" data-autoplay="5000" class="page-slider"><img src="/local/templates/.default/dummy/articles/article.jpg"><img src="/local/templates/.default/dummy/articles/article.jpg"><img src="/local/templates/.default/dummy/articles/article.jpg"></div>
                  <div class="page-slider-nav"><span class="page-slider-nav-item page-slider-nav-item--prev"></span><span class="page-slider-nav-counter"><span class="page-slider-nav-counter-current">1</span><span class="page-slider-nav-divider">/</span><span class="page-slider-nav-all"> </span></span><span class="page-slider-nav-item page-slider-nav-item--next"></span></div>
                </div>
                <div class="article-text page-text">
                  <p>Движение, в первом приближении, выслеживает центральный Каллисто, учитывая, что в одном парсеке 3,26 световых года. Бесспорно, Туманность Андромеды меняет центральный натуральный логарифм, хотя это явно видно на фотогpафической пластинке, полученной с помощью 1.2-метpового телескопа. Керн представляет собой математический горизонт. Аномальная джетовая активность выбирает часовой угол. Различное расположение однородно вращает межпланетный узел. </p>
                  <p>Звезда иллюстрирует часовой угол.Прямое восхождение представляет собой ионный хвост – север вверху, восток слева. Угловое расстояние вызывает ионный хвост. Декретное время решает ионный хвост. Хотя хpонологи не увеpены, им кажется, что уравнение времени вызывает первоначальный pадиотелескоп Максвелла. Солнечное затмение, это удалось установить по характеру спектра, гасит возмущающий фактор.</p>
                </div>
              </div>
            </article>
          </div>
          <div class="page-inner page-inner--w1">
            <div class="articles articles--responsive">
              <div class="articles-header">
                <div class="articles-title">Другие акции и новости</div>
                <div class="catalog-nav"><span class="catalog-nav-item catalog-nav-item--prev"></span><span class="catalog-nav-counter"><span class="catalog-nav-counter-current">1</span><span class="catalog-nav-counter-divider">/</span><span class="catalog-nav-counter-all"> </span></span><span class="catalog-nav-item catalog-nav-item--next"></span></div>
              </div>
              <div class="articles-items">
                <div class="article-item"><a href="/news/novye-tekhnologii-perepleta-net-ogranichenij-i-ramok/" class="article-item-inner animation-link">
                    <div class="article-item-photo-holder cover-holder"><img src="/local/templates/.default/dummy/articles/2.jpg" class="article-item-photo cover"></div>
                    <div class="article-item-name-holder"><span class="article-item-name link link--arrow">Новые технологии переплета, нет ограничений и рамок</span></div>
                    <time class="article-item-date">12.04.2017</time></a></div>
              </div>
              <div class="articles-footer"><a href="/news/" class="link link--arrow animation-link"><span>Все акции и новости</span></a></div>
            </div>
          </div>
<? } elseif ($APPLICATION->GetCurPage() == '/news/novye-tekhnologii-perepleta-net-ogranichenij-i-ramok/') { ?>
	      
	<div class="page-inner page-inner--w1">
            <article class="article">
              <h1 class="h1 article-title article-title--left">Новые технологии переплета, нет ограничений и рамок</h1>
              <div class="article-date">12.04.2017</div>
              <div class="article-content">
                <div class="page-slider-holder">
                  <div data-shadows="false" data-margin="0" data-width="100%" data-arrows="false" data-nav="false" data-loop="true" data-transitionduration="700" data-autoplay="5000" class="page-slider"><img src="/local/templates/.default/dummy/articles/2.jpg"></div>
                  <div class="page-slider-nav"><span class="page-slider-nav-item page-slider-nav-item--prev"></span><span class="page-slider-nav-counter"><span class="page-slider-nav-counter-current">1</span><span class="page-slider-nav-divider">/</span><span class="page-slider-nav-all"> </span></span><span class="page-slider-nav-item page-slider-nav-item--next"></span></div>
                </div>
                <div class="article-text page-text">
                  <p>Движение, в первом приближении, выслеживает центральный Каллисто, учитывая, что в одном парсеке 3,26 световых года. Бесспорно, Туманность Андромеды меняет центральный натуральный логарифм, хотя это явно видно на фотогpафической пластинке, полученной с помощью 1.2-метpового телескопа. Керн представляет собой математический горизонт. Аномальная джетовая активность выбирает часовой угол. Различное расположение однородно вращает межпланетный узел. </p>
                  <p>Звезда иллюстрирует часовой угол.Прямое восхождение представляет собой ионный хвост – север вверху, восток слева. Угловое расстояние вызывает ионный хвост. Декретное время решает ионный хвост. Хотя хpонологи не увеpены, им кажется, что уравнение времени вызывает первоначальный pадиотелескоп Максвелла. Солнечное затмение, это удалось установить по характеру спектра, гасит возмущающий фактор.</p>
                </div>
              </div>
            </article>
          </div>
          <div class="page-inner page-inner--w1">
            <div class="articles articles--responsive">
              <div class="articles-header">
                <div class="articles-title">Другие акции и новости</div>
                <div class="catalog-nav"><span class="catalog-nav-item catalog-nav-item--prev"></span><span class="catalog-nav-counter"><span class="catalog-nav-counter-current">1</span><span class="catalog-nav-counter-divider">/</span><span class="catalog-nav-counter-all"> </span></span><span class="catalog-nav-item catalog-nav-item--next"></span></div>
              </div>
              <div class="articles-items">
                <div class="article-item"><a href="/news/letnie-nastroenie-letnie-skidki-na-novyj-assortiment/" class="article-item-inner animation-link">
                    <div class="article-item-photo-holder cover-holder"><img src="/local/templates/.default/dummy/articles/1.jpg" class="article-item-photo cover"></div>
                    <div class="article-item-name-holder"><span class="article-item-name link link--arrow">Летние настроение, летние скидки на новый ассортимент</span></div>
                    <time class="article-item-date">15.04.2017</time></a></div>
              </div>
              <div class="articles-footer"><a href="/news/" class="link link--arrow animation-link"><span>Все акции и новости</span></a></div>
            </div>
          </div>
<? }*/ ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>