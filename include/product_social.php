<?php  if($arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_V_FB"]["VALUE"] || 
		$arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_V_VK"]["VALUE"] ||
		$arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_V_INSTAGRAM"]["VALUE"] || 
		$arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_NA_YUTUB"]["VALUE"] || 
		$arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_V_KANTSOBOZ"]["VALUE"]): ?>
	<div class="product-social">
		<div class="product-social-note">Посмотреть в соцсетях:</div>
		<div class="product-social-items">
			
			<?php if($arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_V_FB"]["VALUE"]): ?>
				<a href="<?php echo $arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_V_FB"]["VALUE"]; ?>" class="footer-social-item product-social-item" target="_blank">
					<img src="/local/templates/.default/svg/fb.svg" />
				</a>
			<?php endif; ?>
			
			<?php if($arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_V_VK"]["VALUE"]): ?>
				<a href="<?php echo $arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_V_VK"]["VALUE"]; ?>" class="footer-social-item product-social-item" target="_blank">
					<img src="/local/templates/.default/svg/vk.svg" />
				</a>
			<?php endif; ?>

			<?php if($arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_V_INSTAGRAM"]["VALUE"]): ?>
				<a href="<?php echo $arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_V_INSTAGRAM"]["VALUE"]; ?>" class="footer-social-item product-social-item" target="_blank">
					<img src="/local/templates/.default/svg/ig.svg" />
				</a>
			<?php endif; ?>

			<?php if($arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_NA_YUTUB"]["VALUE"]): ?>
				<a href="<?php echo $arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_NA_YUTUB"]["VALUE"]; ?>" class="footer-social-item product-social-item" target="_blank">
					<img src="/local/templates/.default/svg/youtube.svg" />
				</a>
			<?php endif; ?>
			
			<?php if($arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_V_KANTSOBOZ"]["VALUE"]): ?>
				<a href="<?php echo $arParams["SOCIAL"]["PROPERTIES"]["SSYLKA_V_KANTSOBOZ"]["VALUE"]; ?>" class="footer-social-item product-social-item" target="_blank">
					<img src="/local/templates/.default/svg/canc.svg" />
				</a>
			<?php endif; ?>
			
		</div>
	</div>
<?php endif; ?>

