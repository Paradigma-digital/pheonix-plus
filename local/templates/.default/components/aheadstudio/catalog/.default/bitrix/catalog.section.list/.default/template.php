<? if (!empty($arResult['SECTIONS'])) { ?>
<div class="catalog-sectionslist" style="margin-bottom: 0;">
	<ul class="catalog-menu-sub-inner">
		<?php foreach($arResult["SECTIONS"] as $arSection): ?>
			<li class="catalog-menu-sub-item-holder">
				<a href="<?php echo $arSection["SECTION_PAGE_URL"]; ?>" class="catalog-menu-sub-item <?php if($arSection["DEPTH_LEVEL"] > ($arResult["SECTION"]["DEPTH_LEVEL"])): ?>catalog-menu-sub-item-sub<?php endif; ?>">
					<span itemprop="name" class="catalog-menu-sub-item-name">
						<span class="catalog-menu-sub-item-name-title"><?php echo $arSection["NAME"]; ?></span>
						<span class="catalog-menu-sub-item-sub-add">(<?php echo $arSection["ELEMENT_CNT"]; ?>)</span>
					</span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>

</div>
<? } ?>