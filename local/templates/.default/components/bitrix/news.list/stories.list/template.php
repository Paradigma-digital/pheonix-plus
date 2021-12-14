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
<?php if($arResult["ITEMS"]): ?>
	<div class="success-items">
		<?php foreach($arResult["ITEMS"] as $arItem): ?>
			<div class="success-item">
				<?php if($arItem["PICTURE"]): ?>
					<div class="success-item-photo-holder">
						<img src="<?php echo $arItem["PICTURE"]["SRC"]; ?>" />
					</div>
				<?php endif; ?>
				<div class="success-item-info">
					<div class="success-item-name"><?php echo $arItem["NAME"]; ?></div>
					<?php if($arItem["DISPLAY_PROPERTIES"]["POST"]): ?>
						<div class="success-item-post"><?php echo $arItem["DISPLAY_PROPERTIES"]["POST"]["VALUE"]; ?></div>
					<?php endif; ?>
					<?php if($arItem["PREVIEW_TEXT"]): ?>
						<div class="success-item-text">
							<div class="page-text">
								<?php echo $arItem["PREVIEW_TEXT"]; ?>
								<a href="#" class="link link--more">Подробнее</a>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>