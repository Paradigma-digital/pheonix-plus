<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Феникс – это один из крупнейших производителей канцелярии и товаров для школы в России");
?>

      
          <div class="page-inner page-inner--w1">
            <div class="catalog-info">
              <div class="catalog-search">
		  <div class="catalog-search-title"><span>Вы искали </span><?=  htmlspecialchars($_GET['q'])?></div>
              </div>
            </div>
            <div class="search-empty">По вашему запросу ничего не найдено.</div>
          </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>