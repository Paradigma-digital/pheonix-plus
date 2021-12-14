<div class="index-banners">
	<?php foreach($arResult["ITEMS"] as $arItem): ?>
		<?php if($arItem["PROPERTIES"]["LINK"]["VALUE"]): ?>
			<a href="<?php echo $arItem["PROPERTIES"]["LINK"]["VALUE"]; ?>" class="index-banner-item">
		<?php else: ?>
			<div class="index-banner-item">
		<?php endif; ?>
				<img src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"]; ?>" />
		<?php if($arItem["PROPERTIES"]["LINK"]["VALUE"]): ?>
			</a>
		<?php else: ?>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>