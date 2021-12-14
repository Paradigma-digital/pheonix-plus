<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div id="shops-list" class="page-popup mfp-hide">
    <div class="page-popup-title">Где купить</div>
	<div class="shops-list">
		<?php foreach($arResult["ITEMS"] as $arItem): ?>

			<div class="shop-item">
				<?php if($arItem["DISPLAY_PROPERTIES"]["LINK"]): ?>
					<a href="<?php echo $arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]; ?>" target="_blank" class="shop-item-logo">
				<?php else: ?>
					<div class="shop-item-logo">
				<?php endif; ?>
			
					<?php if($arItem["LOGO"]): ?>
						<img src="<?php echo $arItem["LOGO"]["SRC"]; ?>" />
					<?php else: ?>
						<span class="shop-item-logo-text"><?php echo $arItem["NAME"]; ?></span>
					<?php endif; ?>

				<?php if($arItem["DISPLAY_PROPERTIES"]["LINK"]): ?>
					</a>
				<?php else: ?>
					</div>
				<?php endif; ?>

				<div class="shop-item-link">
					<?php if($arItem["DISPLAY_PROPERTIES"]["LINK"]): ?>
						<a href="<?php echo $arItem["DISPLAY_PROPERTIES"]["LINK"]["VALUE"]; ?>" target="_blank" class="btn btn--red">В магазин</a>
					<?php else: ?>
						<span  class="btn btn--red" disabled>Скоро</span>
					<?php endif; ?>
				</div>
			</div>

		<?php endforeach; ?>
	</div>
</div>