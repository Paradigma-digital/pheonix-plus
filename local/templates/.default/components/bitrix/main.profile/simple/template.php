<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<?php if($arResult["DATA_SAVED"] == "Y"): ?>
	<div class="form-success">Данные сохранены</div>
<?php endif; ?>
<div class="profile">
	<div class="profile-section">
	    <div class="profile-section-inner">
			<form class="form form--register" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
				
				<?php echo $arResult["BX_SESSION_CHECK"]; ?>
				<input type="hidden" name="lang" value="<?=LANG?>" />
				<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
				
				<div class="form-row">
					<label for="fe1" class="form-label"><span class="form-label-inner">E-mail (имя входа)</span></label>
					<div class="form-item-holder">
					    <input type="email" id="fe1" readonly name="EMAIL" required value="<?=$arResult["arUser"]["EMAIL"]?>" class="form-item form-item--text">
					    <span class="form-item-note">не редактируется</span>
					</div>
				</div>

				<?php if($arParams["USER_TYPE"] == "BUSINESS"): ?>
				    <div class="form-row">
						<label for="fe22" class="form-label"><span class="form-label-inner">Hазвание организации<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
					    	<input type="text" id="fe22" name="WORK_COMPANY" required data-error="Ошибка заполнения" value="<?=$arResult["arUser"]["WORK_COMPANY"]?>" class="form-item form-item--text">
					    	<span class="form-item-note">Для заведения в клиентскую базу данных</span>
						</div>
				    </div>

					<div class="form-row">
						<label for="fe2" class="form-label"><span class="form-label-inner">Город<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
						    <input type="text" id="fe2" name="WORK_CITY" data-error="Обязательное поле" value="<?=$arResult["arUser"]["WORK_CITY"]?>" required class="form-item form-item--text">
						</div>
					</div>
	
					<div class="form-row">
						<label for="fe3" class="form-label"><span class="form-label-inner">ИНН<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
						    <input type="text" id="fe3" name="UF_INN" data-error="Обязательное поле" required value="<?=$arResult["arUser"]["UF_INN"]?>" class="form-item form-item--text">
						</div>
					</div>
				    
			    <?php endif; ?>
				
			    <div class="form-row">
					<label for="fe2" class="form-label"><span class="form-label-inner">Ф.И.О.<span class="form-required">*</span></span></label>
					<div class="form-item-holder">
				    	<input type="text" id="fe2" name="NAME" required data-error="Ошибка заполнения" value="<?=$arResult["arUser"]["NAME"]?>" class="form-item form-item--text">
				    	<span class="form-item-note">Фамилия, имя, отчество</span>
					</div>
			    </div>
			    
			    <div class="form-row">
					<label for="fe3" class="form-label"><span class="form-label-inner">Телефон</span></label>
					<div class="form-item-holder">
				    	<input type="text" id="fe3" name="WORK_PHONE" value="<?=$arResult["arUser"]["WORK_PHONE"]?>" class="form-item form-item--text">
				    	<span class="form-item-note">телефон для связи (необязательно)</span>
					</div>
			    </div>
			    
				<?php if($arResult["CAN_EDIT_PASSWORD"]): ?>
				    <div class="form-row">
						<label for="fe4" class="form-label"><span class="form-label-inner">Пароль<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
					    	<input type="password" id="fe4" name="NEW_PASSWORD" autocomplete="off" class="form-item form-item--text">
					    	<span class="form-item-note">пароль должен состоять из латинских букв и цифр</span>
						</div>
				    </div>
				    
				    <div class="form-row">
						<label for="fe5" class="form-label"><span class="form-label-inner">Повтор пароля<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
					    	<input type="password" id="fe5" name="NEW_PASSWORD_CONFIRM" autocomplete="off" class="form-item form-item--text">
					    	<span class="form-item-note">пароль должен состоять из латинских букв и цифр</span>
						</div>
				    </div>
				<?php endif; ?>
				
				<div class="form-row form-row--btn">
					<div class="form-checkbox">
						<input type="hidden" value="0" name="UF_SUBSCRIBE_PARTNER">
					    <input type="checkbox" <?php if($arResult["arUser"]["UF_SUBSCRIBE_PARTNER"]): ?>checked<?php endif; ?> value="1" id="chk1" name="UF_SUBSCRIBE_PARTNER" class="form-item form-item--checkbox">
					    <label for="chk1" class="form-checkbox-label">Быть в курсе всех выгодных предложений (подписка на рассылку актуальных предложений)</label>
					</div>
				</div>
				
				<div class="form-row form-row--btn">
					<button type="submit" name="save" value="Y" class="btn btn--red btn--large btn--full">Записать</button>
				</div>
				

				
			</form>
	    </div>
	</div>
</div>