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
<div class="docs-sections">
	<div class="docs-sections-items">
		<?php foreach($arResult["SECTIONS"] as $arSection): ?>
			<a href="<?php echo $arSection["SECTION_PAGE_URL"]; ?>" class="docs-section-item animation-link">
				<span class="docs-section-item-title"><?php echo $arSection["NAME"]; ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</div>