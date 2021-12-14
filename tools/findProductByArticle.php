<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	CModule::IncludeModule("iblock");
	
	$code = $_REQUEST["CODE"];
	$code = trim($code, "/");
	
	
	if(!$code) {
		return false;
	}
	$arProduct = CGCCatalog::getProductInfoByArticle($code);
	
	$utmString = "?";
	foreach($_REQUEST as $reqCode => $reqValue) {
		if($reqValue && strstr($reqCode, "utm_") !== false) {
			$utmString .= $reqCode."=".$reqValue."&";
		}
	}
	if($utmString == "?") {
		$utmString = "";
	} else {
		$utmString = substr($utmString, 0, strlen($utmString) - 1);
	}
	
	if($arProduct && $arProduct["ACTIVE"] == "Y") {
		LocalRedirect($arProduct["DETAIL_PAGE_URL"].$utmString);
	} else {
		require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
		echo '<div class="page-inner page-inner--w1"><div class="catalog-info">
              <div class="catalog-search">
		  <div class="catalog-search-title"><span>Вы искали</span> '.$code.'</div>
              </div>
            </div><div class="search-empty">По вашему запросу ничего не найдено.</div></div>';
		require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
	}
	
?>