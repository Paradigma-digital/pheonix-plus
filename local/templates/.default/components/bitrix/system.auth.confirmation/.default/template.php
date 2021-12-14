<? 
if ($USER->IsAuthorized()): 
	LocalRedirect('/catalog/');
else:
	if (!empty($arResult['MESSAGE_CODE']) && in_array($arResult['MESSAGE_CODE'], array('E02')))
	{
		LocalRedirect('/catalog/');
	}
	elseif (!empty($arResult['MESSAGE_CODE']) && in_array($arResult['MESSAGE_CODE'], array('E03','E06')))
	{
		?>
			<div class="page-inner page-inner--w1">
				<div class="page-heading">
					<h1 class="h1">Email успешно подтвержден</h1>
				</div>
				
				
			</div>
		<?
	}
	else
	{
	?>
	<div class="page-inner page-inner--w1">
		<div class="page-heading">
			<h1 class="h1">Подтверждение email</h1>
		</div>
	</div>
	<div class="page-inner page-inner--w1">
	    <div class="profile">
		<div class="profile-section">
		    <div class="profile-section-inner">
			<form class="form form--register" method="post" action="<?echo $arResult["FORM_ACTION"]?>" name="regform" enctype="multipart/form-data">
				<input type="hidden" name="<?echo $arParams["USER_ID"]?>" value="<?echo $arResult["USER_ID"]?>" />
				
				<? if (count($arResult["ERRORS"]) > 0){ ?>
					<div class="form-title">
					<? foreach ($arResult["ERRORS"] as $key => $error)
						if (intval($key) == 0 && $key !== 0) 
							$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

					ShowError(implode("<br />", $arResult["ERRORS"])); ?>
					</div>
				<? } elseif (!empty($arResult['MESSAGE_CODE']) && in_array($arResult['MESSAGE_CODE'], array('E02','E03','E06'))) { ?>
					<? //LocalRedirect('/catalog/'); ?>
				<? } elseif (!empty($arResult['MESSAGE_CODE'])) { ?>
					<div class="form-title" style="color: red;"><?=$arResult['MESSAGE_TEXT']?></div>
				<? } ?>
			    <div class="form-row">
				<label for="ff1" class="form-label"><span class="form-label-inner">Email<span class="form-required">*</span></span></label>
				<div class="form-item-holder">
				    <input type="text" id="ff1" name="<?echo $arParams["LOGIN"]?>" required data-error="Ошибка заполнения" value="<?=$arResult["USER"]["LOGIN"]?>" class="form-item form-item--text">
				</div>
			    </div>
				
				
			    <div class="form-row">
				<label for="ff2" class="form-label"><span class="form-label-inner">Код подтверждения<span class="form-required">*</span></span></label>
				<div class="form-item-holder">
				    <input type="text" id="ff2" name="<?echo $arParams["CONFIRM_CODE"]?>" required data-error="Ошибка заполнения" value="<?echo $arResult["CONFIRM_CODE"]?>" class="form-item form-item--text">
				</div>
			    </div>
				
			    <div class="form-row form-row--btn">
				<button type="submit" name="register_submit_button" value="Y" class="btn btn--red btn--large btn--full">Подтвердить</button>
			    </div>
			</form>
		    </div>
		</div>
	    </div>
	</div>
	<? } ?>
<?endif?>