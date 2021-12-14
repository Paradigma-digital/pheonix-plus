<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>

<?php if($arResult["DATA_SAVED"] == "Y"):
	$user = new CUser;
	$user->Update(
		$arResult["arUser"]["ID"],
		[
			"UF_PROFILE_COMPLETE" => 1,
			"UF_USER_TYPE" => 5
		]
	);
	?>
		<div class="page-text">
			<blockquote>Ваш запрос обрабатывается менеджером.</blockquote>
		</div>
		<script>
			if(window.ym && window.ym != undefined) {
				ym(48640211, "reachGoal", "event_partner_add");
				console.log("Goal event_partner_add");
			}
		</script>
<?php else: ?>
	<div class="profile">
		<div class="profile-section">
		    <div class="profile-section-inner">
				<form class="form form--register" method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
					<?=$arResult["BX_SESSION_CHECK"]?>
					<input type="hidden" name="lang" value="<?=LANG?>" />
					<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
	
					<div class="page-text">
						<blockquote class="center">Данный статус открывает доступ к ценам и программам лояльности.</blockquote>
						<br />
					</div>
					
				    <div class="form-row">
						<div class="form-checkbox">
						    <input type="checkbox" disabled readonly="readonly" id="chk1" name="chk1" checked readonly class="form-item form-item--checkbox">
						    <label for="chk1" class="form-checkbox-label">Я хочу стать партнером компании ООО &laquo;Феникс+&raquo; и даю согласие на проверку и обработку персональных данных</label>
						</div>
				    </div>
	
					<div class="form-row">
						<label for="fe1" class="form-label"><span class="form-label-inner">Юридическое название<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
						    <input type="text" id="fe1" name="WORK_COMPANY" data-error="Обязательное поле" required value="<?=$arResult["arUser"]["WORK_COMPANY"]?>" class="form-item form-item--text">
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
	
					<div class="form-row">
						<label for="fe4" class="form-label"><span class="form-label-inner">Телефон<span class="form-required">*</span></span></label>
						<div class="form-item-holder">
						    <input type="text" id="fe4" name="PERSONAL_PHONE" data-error="Обязательное поле" required value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" class="form-item form-item--text">
						</div>
					</div>
					
					<div class="form-row form-row--btn">
						<button type="submit" name="save" value="Y" class="btn btn--red btn--large btn--full">Сохранить и отправить</button>
					</div>
				</form>
		    </div>
		</div>
	</div>
<?php endif; ?>