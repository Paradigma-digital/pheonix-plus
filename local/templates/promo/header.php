<?php
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	IncludeTemplateLangFile(__FILE__);
	if(isset($arPageParams)) {
		$arPageParams = array_merge($defArPageParams, $arPageParams);
	} else {
		$arPageParams = $defArPageParams;
	}
?>
<!DOCTYPE html>
<html lang="ru" prefix="og:http://ogp.me/ns#" class="no-js">
	<head>
		<?php include $_SERVER["DOCUMENT_ROOT"]."/local/common/head.php"; ?>
		<?php $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/promo.css"); ?>
	</head>
	<body itemscope itemtype="http://schema.org/WebPage" class="<? if ($USER->IsAuthorized()) { ?>registered<? } ?>">
		<?php $APPLICATION->ShowPanel(); ?>
		<div class="page">	    
			<header itemscope itemtype="http://schema.org/WPHeader" class="page-header">
				<div class="header-row">
					<div class="page-inner page-inner--w1">
						<a href="/" class="header-logo">
							<span class="header-logo-out"></span>
							<span class="header-logo-over"></span>
						</a>

						<div class="header-row-inner">
							<div class="header-col">
								
								<?php $APPLICATION->IncludeComponent(
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
								); ?>
								
							</div>
							<div class="header-col">
										          	
								<div class="header-contacts">
									<div class="header-link">
										<a href="/about/contacts/" class="header-menu-item">Контакты</a>
									</div>
									<a href="tel:+78632618962" class="header-contacts-phone">+7 (863) 261-89-62</a>
									<div class="header-contacts-schedule">с 09:00 до 19:00</div>
								</div>
							
							</div>
						</div>
					</div>
				</div>
			</header>
			
			<div class="mobile-header">
				<div class="mobile-header-inner">
					<a href="/" class="mobile-header-logo"></a>
				</div>
			</div>
			
			<main class="page-content">
				<div class="page-content-inner">