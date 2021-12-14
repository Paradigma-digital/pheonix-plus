<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?php if($arResult["isFormErrors"] == "Y"): ?>
	<div class="form-error">
		<?php echo $arResult["FORM_ERRORS_TEXT"]; ?>
	</div>
<?php endif; ?>

<?php if($arResult["isFormNote"] != "Y"): ?>
	<?php echo $arResult["FORM_HEADER"]; ?>
	<?php if($arResult["FORM_DESCRIPTION"]): ?>
		<div class="form-title"><?php echo $arResult["FORM_DESCRIPTION"]; ?></div>
	<?php endif; ?>
	<?php foreach($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion): ?>
		<?php if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'): ?>
			<?php echo $arQuestion["HTML_CODE"]; ?>
		<?php endif; ?>
		<div class="form-row">
			<label for="f_<?php echo $FIELD_SID; ?>" class="form-label">
				<span class="form-label-inner">
					<?php echo $arQuestion["CAPTION"]; ?>
					<?php if($arQuestion["REQUIRED"] == "Y"): ?>
						<span class="form-required">*</span>
					<?php endif; ?>
				</span>
			</label>
			<div class="form-item-holder">
				<?php echo $arQuestion["HTML_CODE"]; ?>
			</div>
		</div>
	<?php endforeach; ?>
	<?php if($arResult["isUseCaptcha"] == "Y"): ?>
		<div class="form-row">
			<label for="f_captcha" class="form-label">
				<span class="form-label-inner">
					<?php echo GetMessage("FORM_CAPTCHA_FIELD_TITLE"); ?>
					<span class="form-required">*</span>
				</span>
			</label>
			<div class="form-item-holder">
				<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" />
				<input type="text" name="captcha_word" required data-error="<?php echo GetMessage("FORM_CAPTCHA_FIELD_ERROR"); ?>" value="" class="form-item form-item--text" id="f_captcha" />
			</div>
		</div>
	<?php endif; ?>
	<div class="form-row form-row--btn">
		<button type="submit" name="web_form_apply" value="Y" class="btn btn--red btn--large btn--full"><?php echo GetMessage("FORM_SEND"); ?></button>
	</div>
	<div class="form-row form-row--centered">
		<div class="form-checkbox">
			<input type="checkbox" checked id="f_law" name="f_law" required readonly class="form-item form-item--checkbox" disabled />
			<label for="f_law" class="form-checkbox-label"><?php echo GetMessage("FORM_LAW"); ?></label>
		</div>
	</div>
	<?php echo $arResult["FORM_FOOTER"]; ?>
<?php else: ?>
	<div class="form-result">
		<div class="form-result-message"><?php echo ($arParams["FORM_SUCCESS_TEXT"] ? html_entity_decode($arParams["FORM_SUCCESS_TEXT"]) : $arResult["FORM_NOTE"]); ?></div>
	</div>
<?php endif; ?>