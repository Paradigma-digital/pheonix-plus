<?php if($arResult["ITEMS"]): ?>
	<?php foreach($arResult["ITEMS"] as $arItem): ?> 
		<?php if($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'text' && !empty($arItem['PREVIEW_TEXT'])): ?> 
			<div class="page-text">
				<?php echo $arItem['~PREVIEW_TEXT']; ?>
			</div>
		<?php elseif($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'slider' && $arItem["GALLERY"]): ?> 
			<div class="page-inner page-inner--w3 page-inner--centered">
				<div class="page-slider-holder">
					<div data-shadows="false" data-margin="0" data-width="100%" data-arrows="false" data-nav="false" data-loop="true" data-transitionduration="700" data-autoplay="5000" class="page-slider">
					<?php foreach($arItem["GALLERY"] as $arPhoto): ?>
							<img src="<?php echo $arPhoto["SRC"]; ?>">
					<?php endforeach; ?>
					</div>
					<?php if(count($arItem["GALLERY"]) > 1): ?>
						<div class="page-slider-nav">
							<span class="page-slider-nav-item page-slider-nav-item--prev"></span>
							<span class="page-slider-nav-counter">
								<span class="page-slider-nav-counter-current">1</span>
								<span class="page-slider-nav-divider">/</span>
								<span class="page-slider-nav-all">&nbsp;</span>
							</span>
							<span class="page-slider-nav-item page-slider-nav-item--next"></span>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
