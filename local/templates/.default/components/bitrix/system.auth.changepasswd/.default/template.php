<?
//deb($arResult);
/*$send = false;
if (!empty($arResult['USER_PASSWORD']) && $arResult['USER_PASSWORD'] == $arResult['USER_CONFIRM_PASSWORD'])
{
	$send = true;
}*/

//deb($arResult, false);

?><div class="page-inner page-inner--w1">
	
	<?php if($arResult["ERROR_MESSAGE"] && $arResult["ERROR_MESSAGE"]["TYPE"] == "ERROR"): ?>
		<div class="form-error">
			<p><?php echo $arResult["ERROR_MESSAGE"]["MESSAGE"]; ?></p>
		</div>
	<?php endif; ?>
	
	<?php if($arResult["ERROR_MESSAGE"] && $arResult["ERROR_MESSAGE"]["TYPE"] == "OK"): ?>
		<div class="form-success">
			<p><?php echo $arResult["ERROR_MESSAGE"]["MESSAGE"]; ?></p>
		</div>
		<div class="form-result">
			<a href="#login" data-type="inline" class="link link--login popup"><span class="link-text">Вход</span><span class="link-icon"></span></a>
		</div>
	<?php endif; ?>
	
	<? if($arResult["SHOW_FORM"] && $arResult["ERROR_MESSAGE"]["TYPE"] != "OK"): ?>

            <div class="profile">
              <div class="profile-section">
                <div class="profile-section-inner">
                  <form class="form form--register" method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
			<?if (strlen($arResult["BACKURL"]) > 0): ?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<? endif ?>
			<input type="hidden" name="AUTH_FORM" value="Y">
			<input type="hidden" name="TYPE" value="CHANGE_PWD">
                    <div class="form-row">
                      <label for="ff1" class="form-label"><span class="form-label-inner">Email<span class="form-required">*</span></span></label>
                      <div class="form-item-holder">
                        <input type="text" id="ff1" readonly name="USER_LOGIN" required value="<?=$arResult["LAST_LOGIN"]?>" data-error="Ошибка заполнения" class="form-item form-item--text">
                      </div>
                    </div>
                    <div class="form-row">
                      <label for="ff2" class="form-label"><span class="form-label-inner">Контрольное слово<span class="form-required">*</span></span></label>
                      <div class="form-item-holder">
                        <input type="text" id="ff2" name="USER_CHECKWORD" required value="<?=$arResult["USER_CHECKWORD"]?>" data-error="Ошибка заполнения" class="form-item form-item--text" readonly>
                      </div>
                    </div>
                    
                    <div class="form-row">
                      <label for="profile-new-password1" class="form-label"><span class="form-label-inner">Пароль<span class="form-required">*</span></span></label>
                      <div class="form-item-holder">
                        <input type="password" id="profile-new-password1" name="USER_PASSWORD" required data-error="Ошибка заполнения" class="form-item form-item--text"><span class="form-item-note"><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></span>
                      </div>
                    </div>
                    <div class="form-row">
                      <label for="profile-new-password2" class="form-label"><span class="form-label-inner">Повтор пароля<span class="form-required">*</span></span></label>
                      <div class="form-item-holder">
                        <input type="password" id="profile-new-password2" name="USER_CONFIRM_PASSWORD" required data-error="Ошибка заполнения" class="form-item form-item--text"><span class="form-item-note"><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></span>
                      </div>
                    </div>
                    <div class="form-row form-row--btn">
                      <button type="submit" class="btn btn--red btn--large btn--full" name="change_pwd" value="Y">Сменить пароль</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
	<? endif; ?>
          </div>