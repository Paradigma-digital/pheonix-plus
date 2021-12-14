<?php if($arResult["ITEMS"]): ?>
	<div class="accordion">
		<?php foreach($arResult["ITEMS"] as $arItem): ?>
			<div class="accordion-item">
				<div class="accordion-item-header">
					<span class="accordion-item-header-name"><?php echo $arItem["NAME"]; ?></span>
					<span class="accordion-item-header-toggler"></span>
				</div>
				<div class="accordion-item-content">
					<div class="page-text">
						<?php foreach($arItem["DISPLAY_PROPERTIES"] as $arItemProp): ?>
							<h3><?php echo $arItemProp["NAME"]; ?>:</h3>
							<ul>
								<?php foreach($arItemProp["VALUE"] as $propVal): ?>
									<li><?php echo $propVal; ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endforeach; ?>
					</div>
					<a href="/career/send-resume/?vacancy=<?php echo $arItem["NAME"]; ?>" class="btn btn--red animation-link"><?php echo GetMessage("VACANCY_FEEDBACK"); ?></a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>