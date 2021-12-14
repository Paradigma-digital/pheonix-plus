<? if (!empty($arResult['ITEMS'])) { ?>

	<div class="features">
		<? foreach ($arResult['ITEMS'] as $arItem) { ?>
			<a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" 
			   style='<? if (!empty($arItem['PREVIEW_PICTURE'])) { ?>  background: none no-repeat center center/cover; background-image: url(<?=$arItem['PREVIEW_PICTURE']['SRC']?>);<? } elseif (!empty($arItem['CODE'])) { ?> background-color: <?=$arItem['CODE']?>;<? } ?>'
			   class="feature-item"><span class="feature-item-name"><?=$arItem['~PREVIEW_TEXT']?></span></a>
		<? } ?>
        </div>
<? } ?>