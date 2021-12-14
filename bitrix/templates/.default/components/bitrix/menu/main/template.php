<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>
<? if (!empty($arResult)) { ?>
	<nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="home-menu ">              
		<ul class="home-menu-inner ">            
		    <? foreach ($arResult as $arPoint) { ?>
			<li class="home-menu-item-holder   ">
			    <a href="<?=$arPoint['LINK']?>" itemprop="url" target="" class="home-menu-item link link--arrow "><span itemprop="name" class="home-menu-item-name "><?=$arPoint['TEXT']?></span></a>
			</li>
		    <? } ?>
		</ul>           
	</nav>
<? } ?>