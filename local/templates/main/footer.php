<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<footer itemscope itemtype="http://schema.org/WPFooter" class="page-footer">      
    <div class="footer-row">     
	<div class="page-inner page-inner--w1">      
	    <div class="footer-col footer-col--w1 footer-col--menu1">       
		<?$APPLICATION->IncludeComponent(
			    "bitrix:menu",
			    "footer",
			    Array(
				    "ROOT_MENU_TYPE" => "footer1", 
				    "MAX_LEVEL" => "1", 
				    "CHILD_MENU_TYPE" => "footer1", 
				    "USE_EXT" => "Y", 
				    "MENU_CACHE_TYPE" => "A",
				    "MENU_CACHE_TIME" => "3600",
				    "MENU_CACHE_USE_GROUPS" => "Y",
				    "MENU_CACHE_GET_VARS" => Array()
			    )
		);?>     
	    </div>       
	    <div class="footer-col footer-col--w1 footer-col--menu2">     
		<?$APPLICATION->IncludeComponent(
			    "bitrix:menu",
			    "footer",
			    Array(
				    "ROOT_MENU_TYPE" => "footer2", 
				    "MAX_LEVEL" => "1", 
				    "CHILD_MENU_TYPE" => "footer2", 
				    "USE_EXT" => "Y", 
				    "MENU_CACHE_TYPE" => "A",
				    "MENU_CACHE_TIME" => "3600",
				    "MENU_CACHE_USE_GROUPS" => "Y",
				    "MENU_CACHE_GET_VARS" => Array()
			    )
		);?>        
	    </div>         
	    <div class="footer-col footer-col--w1 footer-col--social">    
		<?$APPLICATION->IncludeComponent(
			  "bitrix:menu",
			  "social",
			  Array(
				  "ROOT_MENU_TYPE" => "social", 
				  "MAX_LEVEL" => "1", 
				  "CHILD_MENU_TYPE" => "social", 
				  "USE_EXT" => "Y", 
				  "MENU_CACHE_TYPE" => "A",
				  "MENU_CACHE_TIME" => "3600",
				  "MENU_CACHE_USE_GROUPS" => "Y",
				  "MENU_CACHE_GET_VARS" => Array()
			  )
		);?>   
	    </div>      
	    <div class="footer-col footer-col--w1 footer-col--contacts">     
		<div class="footer-contacts">
		    <a href="tel:+78632618950" title="Позвонить нам" class="footer-contacts-phone">(863) 261-89-50</a>     
		    <div class="footer-contacts-schedule">с 09:00 до 19:00</div>
		    <a href="mailto:info@phoenixrostov.ru" class="link link--black">info@phoenixrostov.ru</a>  
		</div>     
	    </div>      
	</div>  
    </div>    
    <div class="footer-row">     
	<div class="page-inner page-inner--w1">     
	    <div class="footer-col footer-col--w2">          
		<div class="footer-copyrights">&copy; <?php echo date("Y"); ?> ООО «Феникс»</div>      
	    </div>    
	    <div class="footer-col footer-col--w2">
		<a href="http://ruformat.ru/" target="_blank" title="Разработка интернет-магазинов" class="footer-creators">
		    <span class="footer-creators-title">Разработка сайта </span>
		    <span class="footer-creators-name">RUFORMAT</span>
		</a>
	    </div>   
	</div>     
    </div>    
</footer>
<a href="#top" title="Вверх" class="go-top"></a>
<?/*a href="#feedback" title="Обратная связь" class="feedback"></a*/?>
<? $APPLICATION->IncludeComponent(
	    "bitrix:sale.basket.basket.line",
	    "popup",
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
		    "SHOW_TOTAL_PRICE" => "Y"
	    )
	); ?>
<?$APPLICATION->IncludeComponent(
		"bitrix:system.auth.form",
		"popup",
		Array(
			"REGISTER_URL" => "/auth/", 
			"PROFILE_URL" => "/catalog/" 
		)
	);?>
<div class="mobile-panel">    
    <div class="mobile-panel-inner">     
	<? if (!$USER->IsAuthorized()) { ?>
        <div class="mobile-panel-section"><a href="#login" data-type="inline" class="link link--login mobile-auth popup"><span class="link-text">Вход</span><span class="link-icon"></span></a></div>
        <? } else { ?>
        <div class="mobile-panel-section"><a href="#" class="link link--login mobile-auth"><span class="link-text"><?=$USER->GetFullName()?></span><span class="link-icon"></span></a></div>
	<? } ?>
	<div class="mobile-panel-section">
	    <? $APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"footer-menu",
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
        </div>
	<div class="mobile-panel-section">   
	    <nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="mobile-menu ">      
		<ul class="mobile-menu-inner ">       
		    <li class="mobile-menu-item-holder   ">
			<a href="/news/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">Акции и новости</span></a> 
		    </li>    
		    <li class="mobile-menu-item-holder   ">
			<a href="/info/delivery/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">Доставка и оплата</span></a> 
		    </li>          
		    <li class="mobile-menu-item-holder   ">
			<a href="/download/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">Скачать</span></a>    
		    </li>     
		    <li class="mobile-menu-item-holder   ">
			<a href="/about/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">О компании</span></a>   
		    </li>            
		    <li class="mobile-menu-item-holder   ">
			<a href="/about/contacts/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">Контакты и реквизиты</span></a>      
		    </li>         
       
		    <li class="mobile-menu-item-holder   ">
			<a href="/news/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">Новости</span></a>     
		    </li>  
			<? if ($USER->IsAuthorized()) { ?>           
				<li class="mobile-menu-item-holder   ">
				    <a href="?&logout=yes" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">Выход</span></a>     
				</li>     
			<? } ?>
		</ul>    
	    </nav>       
	</div>    
    </div>   
</div>   
    

<!--Scripts--> 
<? include $_SERVER['DOCUMENT_ROOT'].'/local/common/scripts.php'?>
<!--//Sripts--> 


<?php if(1): ?>

<div style="display: none;">
<!-- Giftsportal.ru counter-->
<a href="https://giftsportal.ru/?rate=5672"><img src="https://rating.giftsportal.ru/?id=5672" width="88" height="31" border="0" alt="Рейтинг сувенирных компаний"></a>
<!--/ Giftsportal.ru counter-->
		<!-- Kanzoboz.ru counter-->
		<a href="https://kanzoboz.ru/?rate=92000"><img src="https://rating.kanzoboz.ru/?id=92000" width="88" height="31" border="0" alt="Рейтинг канцелярских компаний"></a>
		<!--/ Kanzoboz.ru counter-->

<div style="display:none;">
	<!-- KidsOboz.ru counter-->
	<a href="https://kidsoboz.ru/?rate=486603"><img src="https://rating.kidsoboz.ru/?id=486603" width="88" height="31" border="0" alt="Рейтинг детских компаний"></a>
	<!--/ KidsOboz.ru counter-->
</div>


<!-- Kanzoboz.ru counter-->
 <a href="https://kanzoboz.ru/?rate=92000"><img src="https://rating.kanzoboz.ru/?id=92000" width="88" height="31" border="0" alt="Рейтинг канцелярских компаний"></a>
 <!--/ Kanzoboz.ru counter-->

	
</div>

<?php endif; ?>



</body>
</html>