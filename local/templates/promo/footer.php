<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
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







  </body>
</html>