<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

		 <?php if(strpos($APPLICATION->GetCurPage(), '/info/') !== false ||
			 strpos($APPLICATION->GetCurPage(), '/career/') !== false || 
			 strpos($APPLICATION->GetCurPage(), '/personal/') !== false): ?>    
		    </div>
              <?php if($arPageParams["ADD_PAGE_TEXT_HOLDER"] == "Y"): ?>
              	</div>
              <?php endif; ?>
            </div>
		 <?php endif; ?>

</div>
</main>
</div>
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
	            <a href="tel:+78632618962" title="Позвонить нам" class="footer-contacts-phone">+7 (863) 261-89-62</a>
              <div class="footer-contacts-schedule">с 09:00 до 19:00</div>
              <a href="mailto:sale@phoenix-plus.ru" class="link link--black">sale@phoenix-plus.ru</a>
              
              <?php
	          	$arItSupport = GCSettings::get("nashli-oshibku");
	          	if($arItSupport && $arItSupport["ACTIVE"] == "Y"):
	          ?><br /><br />
	          	<a href="mailto:<?php echo $arItSupport["OPTIONS"]["IT_EMAIL"]; ?>?subject=<?php echo $arItSupport["OPTIONS"]["TITLE"]; ?>" class="link link--black">Нашли ошибку?</a>
	          <?php endif; ?>
              
            </div>
          </div>
        </div>
      </div>
      <div class="footer-row">
        <div class="page-inner page-inner--w1">
          <div class="footer-col footer-col--w2">
            <div class="footer-copyrights"><?$APPLICATION->IncludeFile("/include/common/copyright.php", Array(), Array("MODE" => "html"))?></div>
          </div>
          <div class="footer-col footer-col--w2"><a href="http://ruformat.ru/" target="_blank" title="Разработка интернет-магазинов" class="footer-creators"><span class="footer-creators-title">Разработка сайта </span><span class="footer-creators-name">RUFORMAT</span></a></div>
        </div>
      </div>
    </footer><a href="#top" title="Вверх" class="go-top"></a><?/*a href="#feedback" title="Обратная связь" class="feedback"></a*/?>
    
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
			"PROFILE_URL" => "/catalog/",
			"SHOW_ERRORS" => "Y" 
		)
	);?>
	

<?php global $USER; if(1): ?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"shops.list.popup",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array("NAME", "PREVIEW_PICTURE", ""),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => CGCHelper::getIBlockIdByCode("shops"),
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array("LINK", ""),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"RESIZE" => [
			"WIDTH" => "400",
			"HEIGHT" => "200",
		]
	)
);?>
<?php endif; ?>
    
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
              <li class="mobile-menu-item-holder   "><a href="/news/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">Акции и новости</span></a>
              </li>
              <li class="mobile-menu-item-holder   "><a href="/info/delivery/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">Доставка и оплата</span></a>
              </li>
              <li class="mobile-menu-item-holder   "><a href="/download/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">Скачать</span></a>
              </li>
              <li class="mobile-menu-item-holder   "><a href="/about/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">О компании</span></a>
              </li>
              <li class="mobile-menu-item-holder   "><a href="/about/contacts/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">Контакты и реквизиты</span></a>
              </li>
              <li class="mobile-menu-item-holder   "><a href="/news/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">Новости</span></a>
              </li>
              <li class="mobile-menu-item-holder   "><a href="/where-buy/" itemprop="url" target="" class="mobile-menu-item "><span itemprop="name" class="mobile-menu-item-name ">Где купить</span></a>
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

<div style="display:none;">
<!-- Kanzoboz.ru counter-->
<a href="https://kanzoboz.ru/?rate=92000"><img src="https://rating.kanzoboz.ru/?id=92000" width="88" height="31" border="0" alt="Рейтинг канцелярских компаний"></a>
<!--/ Kanzoboz.ru counter-->
</div>

</div>

<?php endif; ?>



	<?php if(1): ?>
		<?php
			global $USER;
			if($USER->IsAuthorized()):
				$arUser = CGCUser::getUserInfo([
					"ID" => $USER->GetID(),
				]);
				//deb($arUser);
		?>
			<script type="text/javascript"> 
				window.addEventListener("onBitrixLiveChat", function(event) {
				  var widget = event.detail.widget;
				  
				  console.log("widget");
				  
				  // Установка внешней авторизации пользователя
				  widget.setUserRegisterData({
				    "hash": "<?php echo md5($arUser["ID"]."_phoenix_plus_"."__pps2"); ?>",
				    "name": "<?php echo $arUser["NAME"]; ?>",
				    "email": "<?php echo $arUser["EMAIL"]; ?>",
				  });
				  
				  //Дополнительные данные
				  widget.setCustomData([
				  	{
					  	"USER": {
						  	"NAME": "<?php echo $arUser["NAME"]; ?>",
						},
					}, {
						"GRID": [
							{
								"NAME": "Телефон",
								"DISPLAY": "LINE",
					  			"VALUE" : "<?php echo $arUser["WORK_PHONE"]." | ".$arUser["PERSONAL_PHONE"]; ?>",
				    		}, {
								"NAME": "Эл.почта",
								"DISPLAY": "LINE",
					  			"VALUE" : "<?php echo $arUser["EMAIL"]; ?>",
				    		}
				    	]
				    }
				 ]);
				  
				});
			</script> 
		<?php endif; ?>
	
			<script>
		        (function(w,d,u){
		                var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
		                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
		        })(window,document,'https://cdn.bitrix24.ru/b8036887/crm/site_button/loader_4_icq01n.js');
			</script>
		
	<?php endif; ?>





  </body>
</html>