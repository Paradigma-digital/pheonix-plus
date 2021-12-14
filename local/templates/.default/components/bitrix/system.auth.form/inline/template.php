
    <form name="system_auth_form<?=$arResult["RND"]?>" method="post" action="<?=$arResult["AUTH_URL"]?>" class="form">
	<?if($arResult["BACKURL"] <> ''):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<?endif?>
	
	    <?php  if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']): ?>
	   	 <div class="form-error"><?php echo $arResult['ERROR_MESSAGE']["MESSAGE"]; ?></div>
	   	<?php endif; ?>
	
	<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
	<?endforeach?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" />
        <div class="form-row">
	    <label for="login_user2" class="form-label form-label--block"><span class="form-label-inner">Логин (электронная почта)</span></label>
	    <div class="form-item-holder form-item-holder--block">
		<input type="text" id="login_user2" name="USER_LOGIN" required class="form-item form-item--text">
		<script>
			BX.ready(function() {
				var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
				if (loginCookie)
				{
					var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
					var loginInput = form.elements["USER_LOGIN"];
					loginInput.value = loginCookie;
				}
			});
		</script>
	    </div>
        </div>
        <div class="form-row">
	    <label for="lf22" class="form-label form-label--block"><span class="form-label-inner">Пароль</span></label>
	    <div class="form-item-holder form-item-holder--block">
		<input type="password" id="lf22" name="USER_PASSWORD" required data-error="Пожалуйста, введите пароль" class="form-item form-item--text">
	    </div>
        </div>
	<?if ($arResult["CAPTCHA_CODE"]):?>
		<div class="form-row">
		    <label for="captcha_word2" class="form-label form-label--block"><span class="form-label-inner">Введите код с картинки</span></label>
		    <div class="form-item-holder form-item-holder--block">
			<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br /><br />
			<input type="text" name="captcha_word" id="captcha_word2" maxlength="50" class="form-item form-item--text" value="" />
		    </div>
		</div>
	<?endif?>
        <div class="form-row form-row--nowrap">
	    <div class="form-checkbox form-checkbox--inline">
		<input type="checkbox" id="lf32" name="OTP_REMEMBER" value="Y" class="form-item form-item--checkbox">
		<label for="lf3" class="form-checkbox-label">Запомнить меня</label>
	    </div><a href="/forgot/" class="link link--black">Забыли пароль</a>
        </div>
        <div class="form-row">
	    <button type="submit" class="btn btn--blue btn--large btn--full">Войти</button>
        </div>
        <div class="form-row"><a href="/register/" class="link link--black">Регистрация</a></div>
    </form>
