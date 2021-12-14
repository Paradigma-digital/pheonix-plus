<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div class="buy">
	<div class="page-text center">
		<h2>Розничные магазины</h2>
	</div>
	<div class="buy-header">
		<select class="form-item form-item--select" id="buy-select" placeholder="Выберите город">
			<option value="all">Все города</option>
			<?php foreach($arResult["CITIES"] as $cityName): ?>
				<option value="<?php echo $cityName; ?>"><?php echo $cityName; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="buy-items">
		<?php foreach($arResult["SHOPS"] as $arShop): ?>
			<div class="buy-item" data-city="<?php echo $arShop["UF_GOROD"]; ?>">
				<div class="buy-item-title"><?php echo $arShop["UF_NAIMENOVANIE"]; ?></div>
				<div class="buy-item-address">
					<?php if($arShop["UF_GOROD"]): ?>
						<?php echo $arShop["UF_GOROD"]; ?>, 
					<?php endif; ?>
					<?php echo $arShop["UF_ADRES"]; ?>
					<?php if($arShop["UF_TELEFON"]): ?>
						<br />тел.: <?php echo $arShop["UF_TELEFON"]; ?>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>