<div class="page-inner page-inner--w1">
    <? if (empty($_GET['forgot_password'])) { ?>
    <form class="form form--forgot" name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
	<?
	if (strlen($arResult["BACKURL"]) > 0)
	{
	?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<?
	}
	?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="SEND_PWD">
	<!--<div class="form-error">! EMail не найден в нашей базе клиентов</div>-->
	<div class="form-title">Если вы забыли пароль, введите логин или E-Mail. Контрольная строка для смены пароля, а также ваши регистрационные данные, будут высланы вам по E-Mail.</div>
	<div class="form-row">
	    <label for="ff1" class="form-label form-label--block form-label--large">Выслать пароль на e-mail</label>
	    <div class="form-item-holder form-item-holder--block">
		<input type="text" id="ff1" name="USER_EMAIL" required data-error="Пожалуйста, введите свою почту" class="form-item form-item--text" value="<?=$arResult["LAST_LOGIN"]?>">
	    </div>
	</div>
	<div class="form-row form-row--btn">
	    <button type="submit" name="send_account_info" value="Y" class="btn btn--large btn--blue">Выслать</button>
	</div>
	<div class="form-row"><a href="#login" data-type="inline" class="link link--login popup"><span class="link-text">Вход</span><span class="link-icon"></span></a></div>
    </form>
    <? } else {	    
	    ?>
	<div class="form-result">
              <div class="form-result-message">На <span><?=$_REQUEST['USER_EMAIL']?> </span>выслано письмо с инструкцией о восстановлении пароля</div><a href="#login" data-type="inline" class="link link--login popup"><span class="link-text">Вход</span><span class="link-icon"></span></a>
	</div>
    <? } ?>
</div>