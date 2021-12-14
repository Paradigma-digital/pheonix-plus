<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?php if(!$arResult["SHOPS"]): ?>
	<div class="page-text">
		<blockquote>Пока что у вас нет добавленных магазинов. Начните прямо сейчас.</blockquote>
		<br />
		<a href="/personal/shops/add/" class="btn btn--blue popup">Добавить первый магазин</a>
	</div>
<?php else: ?>
	<div class="accordion">
		<?php foreach($arResult["SHOPS"] as $arShopItem): ?>
			<div class="accordion-item">
				<div class="accordion-item-header">
					<span class="accordion-item-header-name"><?php echo $arShopItem["UF_NAIMENOVANIE"]; ?>, <?php echo $arShopItem["UF_ADRES"]; ?></span>
					<span class="accordion-item-header-toggler"></span>
				</div>
				<div class="accordion-item-content">
					<form class="form shop-form" action="/personal/shops/update/">
						<input type="hidden" name="ID" value="<?php echo $arShopItem["ID"]; ?>" />
						<input type="hidden" name="ACTION" value="update" />
						<div class="form-row">
							<label for="UF_VLADELETS_<?php echo $arShopItem["ID"]; ?>" class="form-label">
								<span class="form-label-inner">Грузополучатель</span>
							</label>
							<div class="form-item-holder">
								<select name="UF_VLADELETS" id="UF_VLADELETS_<?php echo $arShopItem["ID"]; ?>" class="form-item form-item--select">
									<?php foreach($arResult["PROFILES"] as $arUserProfileItem): ?>
										<option value="<?php echo $arUserProfileItem["COMPANY_ID"]; ?>" <?php if($arUserProfileItem["COMPANY_ID"] == $arShopItem["UF_VLADELETS"]): ?>selected<?php endif; ?>><?php echo $arUserProfileItem["COMPANY_TITLE"]; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<?php foreach($arParams["SHOW_FIELDS"] as $arFormShowFieldItem): ?>
							<div class="form-row">
								<label for="<?php echo $arFormShowFieldItem["CODE"]; ?>_<?php echo $arShopItem["ID"]; ?>" class="form-label">
									<span class="form-label-inner"><?php echo $arFormShowFieldItem["TITLE"]; ?></span>
								</label>
								<div class="form-item-holder">
									<input type="text" id="<?php echo $arFormShowFieldItem["CODE"]; ?>_<?php echo $arShopItem["ID"]; ?>" name="<?php echo $arFormShowFieldItem["CODE"]; ?>" value="<?php echo htmlspecialchars($arShopItem[$arFormShowFieldItem["CODE"]]); ?>" class="form-item form-item--text" />
								</div>
							</div>
						<?php endforeach; ?>
						
						<div class="form-row form-row--btn">
							<button type="submit" name="save" value="Y" class="btn btn--red">Сохранить изменения</button>
						</div>
					</form>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	
	
	<a href="/personal/shops/add/" class="btn btn--blue popup">Добавить новый магазин</a>
	
<?php endif; ?>