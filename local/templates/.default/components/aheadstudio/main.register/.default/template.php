<? 
if ($USER->IsAuthorized()): 
	LocalRedirect('/personal/');
else: ?>
	<? if (!empty($arResult['VALUES']['USER_ID'])) { ?>
		<div class="page-inner page-inner--w1">
			<article class="article">
				<h1 class="h1 article-title article-title--left">Спасибо за регистрацию!</h1>
				<div class="article-content">
					<div class="article-text page-text">
					      <p>Для подтверждения регистрации <b>перейдите по ссылке из письма</b>, отправленного на указанный при регистрации e-mail.
					      </p>
					      
					      <?php if(CGCCatalog::getBasketCount()): ?>
					      		<a href="/cart/order/" class="btn btn--blue">Оформить заказ</a>
					      <?php endif; ?>
					</div>
				</div>
			</article>
			<script>
				if(window.ym && window.ym != undefined) {
					ym(48640211, "reachGoal", "event_user_add", {
						"login": "<?php echo $arResult["VALUES"]["LOGIN"]; ?>"
					});
					console.log("Goal event_user_add");
				}
			</script>
		</div>
	<? } else { ?>
		<div class="page-inner page-inner--w1">
			<div class="page-heading">
				<h1 class="h1">Регистрация <?php if($arParams["TYPE"] == "SIMPLE"): ?>покупателя<?php elseif($arParams["TYPE"] == "BUSINESS"): ?>партнера<?php endif; ?></h1>
			</div>
		</div>
		<div class="page-inner page-inner--w1">
		    <div class="profile">
			<div class="profile-section">
			    <div class="profile-section-inner">
				<form class="form form--register" method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
					<?
					if($arResult["BACKURL"] <> ''):
					?>
						<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
					<?
					endif;
					?>
				    <div class="form-title">
					    
					    <?php //deb($arResult); ?>
					    
					    <?php if($arParams["TYPE"] == "SIMPLE"): ?>
						    <!--
						    <div class="form-title-variants">
						    	<a href="/register/simple/" class="btn btn--blue">Пользователь</a>
							    <a href="/register/business/" class="link link--black">Бизнес-партнер</a>
						    </div>
						    -->
						    <input type="hidden" name="UF_USER_TYPE" value="<?php echo $arResult["USER_TYPES"]["SIMPLE"]["ID"]; ?>" />
						    
						    
						    
						    
						    
						    <div class="form-title-text">Вы юр. лицо? <a href="/register/business/" class="link link--black">Получите бизнес-профиль</a></div>
						<?php elseif($arParams["TYPE"] == "BUSINESS"): ?>
						    <!--
						    <div class="form-title-variants">
						    	<a href="/register/simple/" class="link link--black">Пользователь</a>
							    <a href="/register/business/" class="btn btn--blue">Бизнес-партнер</a>
						    </div>
						    -->
						    <input type="hidden" name="UF_USER_TYPE" value="<?php echo $arResult["USER_TYPES"]["BUSINESS"]["ID"]; ?>" />
						    <div class="form-title-text">Не являетесь юр. лицом? <a href="/register/simple/" class="link link--black">Зарегистрируйтесь как покупатель</a></div>
						    
						    <?php if(0): ?>
						    <div class="page-text">
							    <br />
						    	<blockquote class="left">После регистрации в качестве бизнес-партнёра и полного заполнения профиля, Вы получите доступ к ценам и преимущества программ лояльности.</blockquote>
						    </div>
						    <?php endif; ?>

						    
						<?php endif; ?>
						
						
						    
						    <div class="page-text">
							    <br />
						    	<blockquote class="left">
									Для зарегистрированных пользователей доступна поддержка онлайн-консультанта
						    	</blockquote>
						    </div>
						
						
				    </div>
				    
					
					<? if (count($arResult["ERRORS"]) > 0) { ?>
						<div class="form-title">
						<? foreach($arResult["ERRORS"] as $key => $error) {
							$arResult["ERRORS"][$key] = str_replace('Пользователь с логином "'.$arResult["VALUES"]['EMAIL'].'" уже существует.', "", $arResult["ERRORS"][$key]);
							
							if (intval($key) == 0 && $key !== 0) {
								$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);
							}
							if($error == "Неверно введено слово с картинки") {
								$arResult["ERRORS"][$key] = "Подтвердите что вы не робот";
							}
						}

						ShowError(implode("<br />", $arResult["ERRORS"])); ?>
						</div>
					<? } ?>
					

					
					
					<?php if($arParams["TYPE"] == "SIMPLE"): ?>
					
					    <div class="form-row">
						<label for="ff5" class="form-label"><span class="form-label-inner">Имя<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
						    <input type="text" id="ff5" name="REGISTER[NAME]" required data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['NAME']?>" class="form-item form-item--text"><span class="form-item-note">Как к Вам обращаться?</span>
						</div>
					    </div>
		
					
					    <div class="form-row">
						<label for="ff6" class="form-label"><span class="form-label-inner">E-mail<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
						    <input type="email" id="ff6" name="REGISTER[EMAIL]" required data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['EMAIL']?>" class="form-item form-item--text"><span class="form-item-note">Будет Вашим логином для входа в личный кабинет</span>
						    <input type="hidden" name="REGISTER[LOGIN]" value="test"/>
	
						</div>
					    </div>
					    
					    

					

					    
					<?php elseif($arParams["TYPE"] == "BUSINESS"): ?>
					    <div class="form-row">
							<label for="ff1" class="form-label"><span class="form-label-inner">Hазвание организации<span class="form-required">*</span></span></label>
							<div class="form-item-holder">
							    <input type="text" id="ff1" name="REGISTER[WORK_COMPANY]" required data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['WORK_COMPANY']?>" class="form-item form-item--text"><span class="form-item-note">Для заведения в клиентскую базу данных</span>
							</div>
					    </div>
					    
					    
					    
						<div class="form-row">
							<label for="fe2" class="form-label"><span class="form-label-inner">Город<span class="form-required">*</span></span></label>
							<div class="form-item-holder">
							    <input type="text" id="fe2" name="REGISTER[WORK_CITY]" data-error="Обязательное поле" value="<?=$arResult["VALUES"]["WORK_CITY"]?>" required class="form-item form-item--text">
							</div>
						</div>
		
						<div class="form-row">
							<label for="fe3" class="form-label"><span class="form-label-inner">ИНН<span class="form-required">*</span></span></label>
							<div class="form-item-holder">
							    <input type="text" id="fe3" name="UF_INN" data-error="Обязательное поле" required value="<?=$arResult["VALUES"]["UF_INN"]?>" class="form-item form-item--text">
							</div>
						</div>
						
					    
					    
					    <div class="form-row">
							<label for="ff5" class="form-label"><span class="form-label-inner">Имя<span class="form-required">*</span></span></label>
							<div class="form-item-holder">
						    	<input type="text" id="ff5" name="REGISTER[NAME]" required data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['NAME']?>" class="form-item form-item--text">
						    	<span class="form-item-note">Как к Вам обращаться?</span>
							</div>
					    </div>
					    
					    
					    
					    <div class="form-row">
						<label for="ff6" class="form-label"><span class="form-label-inner">Ваш email<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
						    <input type="email" id="ff6" name="REGISTER[EMAIL]" required data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['EMAIL']?>" class="form-item form-item--text"><span class="form-item-note">Будет Вашим логином для входа в личный кабинет</span>
						    <input type="hidden" name="REGISTER[LOGIN]" value="test"/>
	
						</div>
					    </div>
					    
					    <div class="form-row">
						<label for="ff7" class="form-label"><span class="form-label-inner">Телефон<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
						    <input type="text" id="ff7" name="REGISTER[WORK_PHONE]" required data-cmask="phone" data-pattern="mobileRU" data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['WORK_PHONE']?>" class="form-item form-item--text form--number"><span class="form-item-note">телефон для связи</span>
						</div>
					    </div>
					    
					<?php endif; ?>
					
					


				    <div class="form-row">
					<label for="profile-new-password1" class="form-label"><span class="form-label-inner">Пароль<span class="form-required">*</span></span></label>
					<div class="form-item-holder">
					    <input type="password" id="profile-new-password1" name="REGISTER[PASSWORD]" required data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['PASSWORD']?>" autocomplete="off" class="form-item form-item--text"><span class="form-item-note">пароль должен состоять из латинских букв и цифр</span>
					</div>
				    </div>
				    <div class="form-row">
					<label for="profile-new-password2" class="form-label"><span class="form-label-inner">Повтор пароля<span class="form-required">*</span></span></label>
					<div class="form-item-holder">
					    <input type="password" id="profile-new-password2" name="REGISTER[CONFIRM_PASSWORD]" required data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['CONFIRM_PASSWORD']?>" class="form-item form-item--text"><span class="form-item-note">подтвердите пароль</span>
					</div>
				    </div>
					
					
					
					<?php if(0): ?>
				    <div class="form-row">
						<label for="ff1" class="form-label"><span class="form-label-inner">Hазвание организации<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
						    <input type="text" id="ff1" name="REGISTER[WORK_COMPANY]" required data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['WORK_COMPANY']?>" class="form-item form-item--text"><span class="form-item-note">название Вашей компании</span>
						</div>
				    </div>
				    
				    <div class="form-row">
						<label for="ff11" class="form-label"><span class="form-label-inner">Город<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
						    <input type="text" id="ff11" name="REGISTER[WORK_CITY]" required data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['WORK_CITY']?>" class="form-item form-item--text"><span class="form-item-note">город нахождения компании</span>
						</div>
				    </div>
				    
				    
				    
				    
				    <div class="form-row">
					<label for="ff2" class="form-label"><span class="form-label-inner">ИНН<span class="form-required">*</span></span></label>
					<div class="form-item-holder">
					    <input type="text" id="ff2" name="REGISTER[UF_INN]" required data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['UF_INN']?>" class="form-item form-item--text form--number"><span class="form-item-note">данные для выставления счета</span>
					</div>
				    </div>
				    <div class="form-row">
					<label for="ff3" class="form-label"><span class="form-label-inner">БИК<span class="form-required">*</span></span></label>
					<div class="form-item-holder">
					    <input type="text" id="ff3" name="REGISTER[UF_BIK]" required data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['UF_BIK']?>" class="form-item form-item--text form--number"><span class="form-item-note">данные для выставления счета</span>
					</div>
				    </div>
				    <div class="form-row">
					<label for="ff4" class="form-label"><span class="form-label-inner">Номер счета<span class="form-required">*</span></span></label>
					<div class="form-item-holder">
					    <input type="text" id="ff4" name="REGISTER[UF_BILL]" required data-error="Ошибка заполнения" value="<?=$arResult["VALUES"]['UF_BILL']?>" class="form-item form-item--text form--number"><span class="form-item-note">данные для выставления счета</span>
					</div>
				    </div>
				   
				    

				    
				    

				     <?php endif; ?>
				    

				    
				    
					<?php if($arResult["USE_CAPTCHA"] == "Y" && 0): ?>
						<div class="form-row">
							<label for="register-captcha" class="form-label">
								<span class="form-label-inner">Введите код с картинки<span class="form-required">*</span></span>
							</label>
							<div class="form-item-holder">
								<div class="form-captcha-holder">
									<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
									<input type="text" name="captcha_word2" tabindex="100000" value="" class="form-item form-item--text form-item--captcha2" />
									<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
									<a href="#" class="link link--black">Другая картинка</a>
									<input type="text" name="captcha_word" autocomplete="off" maxlength="50" id="register-captcha" class="form-item form-item--text" value="" />
								</div>
							</div>
						</div>
					<?php endif; ?>
					
					
					<?php if($arResult["USE_CAPTCHA"] == "Y"): ?>

									<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
									<input type="text" name="captcha_word2" tabindex="100000" value="" class="form-item form-item--text form-item--captcha2" />
									<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
									<input type="text" name="captcha_word" autocomplete="off" maxlength="50" id="register-captcha" class="form-item form-item--text" value="" />
					<?php endif; ?>	
					
					
							
					
					
					    <div class="form-row">
						<label for="ff_promo" class="form-label"><span class="form-label-inner">Промокод</label>
						<div class="form-item-holder">
						    <input type="text" id="ff_promo" name="REGISTER[UF_REGISTER_PROMO]" value="<?=($arResult["VALUES"]['UF_REGISTER_PROMO'] ? $arResult["VALUES"]['UF_REGISTER_PROMO'] : $arParams["PARTNER_CODE"])?>" class="form-item form-item--text"><span class="form-item-note"></span>
	
						</div>
					    </div>    
				  

				    <div class="form-row form-row--btn">
					<div class="form-checkbox">
					    <input type="checkbox" checked id="chk1" name="UF_SUBSCRIBE_PARTNER" value="1" class="form-item form-item--checkbox">
					    <label for="chk1" class="form-checkbox-label">
					    	<?php if($arParams["TYPE"] == "SIMPLE"): ?>
					    		Получать индивидуальные предложения и рекламную информацию от компании.
					    	<?php elseif($arParams["TYPE"] == "BUSINESS"): ?>
					    		Получать информацию о новостях и акциях для партнёров
							<?php endif; ?>
					    </label>
					</div>
				    </div>
				    
				    
				    <div class="form-row form-row--btn">
					<button type="submit" name="register_submit_button" value="Y" class="btn btn--red btn--large btn--full">Создать профиль</button>
				    </div>
				    
				    <div class="form-row ">
						Нажимая на кнопку "Создать профиль", вы соглашаетесь с нашим <a class="link link--black" target="_blank" href="/upload/terms_of_use.pdf">Пользовательским соглашением</a> и подтверждаете правильность введённых данных, а также принимаете условия <a href="/Политика-Конфеденциальности.pdf" class="link link--black" target="_blank">политики конфиденциальности информации</a>.
				    </div>
				    


				</form>
			    </div>
			</div>
		    </div>
		</div>
	<? } ?>
<?endif?>