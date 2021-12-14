<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

	<div class="page-popup">
		<div class="page-popup-title">Добавить магазин</div>
		<div class="page-popup-content">
						
			<form class="form form--large shop-form" action="<?php echo $APPLICATION->GetCurDir(); ?>">
				<input type="hidden" name="ACTION" value="add" />
				<div class="form-row">
					<label for="UF_VLADELETS_new" class="form-label">
						<span class="form-label-inner">Грузополучатель</span>
						<span class="form-required">*</span>
					</label>
					<div class="form-item-holder">
						<select name="UF_VLADELETS" id="UF_VLADELETS_new" class="form-item form-item--select" required>
							<?php foreach($arResult["PROFILES"] as $arUserProfileItem): ?>
								<option value="<?php echo $arUserProfileItem["COMPANY_ID"]; ?>"><?php echo $arUserProfileItem["COMPANY_TITLE"]; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<?php foreach($arParams["SHOW_FIELDS"] as $arFormShowFieldItem): ?>
					<div class="form-row">
						<label for="<?php echo $arFormShowFieldItem["CODE"]; ?>_new" class="form-label">
							<span class="form-label-inner"><?php echo $arFormShowFieldItem["TITLE"]; ?></span>
							<?php if($arFormShowFieldItem["REQUIRED"]): ?>
								<span class="form-required">*</span>
							<?php endif; ?>
						</label>
						<div class="form-item-holder">
							<input type="text" id="<?php echo $arFormShowFieldItem["CODE"]; ?>_new" data-error="Поле обязательно для заполнения" name="<?php echo $arFormShowFieldItem["CODE"]; ?>" class="form-item form-item--text" <?php if($arFormShowFieldItem["REQUIRED"]): ?>required<?php endif; ?> />
						</div>
					</div>
				<?php endforeach; ?>
				
				<div class="form-row form-row--btn">
					<button type="submit" name="save" value="Y" class="btn btn--fullwidth btn--red">Добавить</button>
				</div>
			</form>
			
		</div>
	</div>