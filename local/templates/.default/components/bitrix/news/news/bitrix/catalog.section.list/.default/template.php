<?php
?>
<? $this->SetViewTarget('news_section_list'); ?>
	<? if (!empty($arResult['SECTIONS'])) { ?>
		<div class="page-bar">
			<a href="/news/" class="page-bar-item<? if (empty($arParams['PARENT_SECTION_CODE'])) { ?> active<? } ?>">Все</a>
			<? foreach ($arResult['SECTIONS'] as $arSection) { 
				if($arSection["UF_FOR_REGISTERED"] && $arParams["USER_REGISTERED"] != "Y") {
					continue;
				}
			?>
				<a href="<?=$arSection['SECTION_PAGE_URL']?>" class="page-bar-item<? if ($arParams['PARENT_SECTION_CODE'] == $arSection['CODE']) { ?> active<? } ?>"><?=$arSection['NAME']?></a>
			<? } ?>
		</div>
	<? } ?>
<? $this->EndViewTarget(); ?> 

<!--<a href="#" class="page-bar-item active">Все</a><a href="#" class="page-bar-item">Акции</a>-->