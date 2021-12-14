<?php
//deb($section['DESCRIPTION']);
$APPLICATION->SetTitle("");
?>
<div class="page-inner page-inner--w1">
            <article class="article">
		<?
		$section = $arResult['SECTION']['PATH'][0];
//		deb($section, false);
		
		$arButtons = CIBlock::GetPanelButtons(
			$section["IBLOCK_ID"],
			0,
			$section["ID"],
			array("SESSID"=>false, "CATALOG"=>true)
		);
		$section["EDIT_LINK"] = $arButtons["edit"]["edit_section"]["ACTION_URL"];
		$section["DELETE_LINK"] = $arButtons["edit"]["delete_section"]["ACTION_URL"];
		
		$strSectionEdit = CIBlock::GetArrayByID($section["IBLOCK_ID"], "SECTION_EDIT");
		$strSectionDelete = CIBlock::GetArrayByID($section["IBLOCK_ID"], "SECTION_DELETE");
		$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

		$this->AddEditAction($section['ID'], $section['EDIT_LINK'], $strSectionEdit);
		$this->AddDeleteAction($section['ID'], $section['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

		if (!empty($section['DESCRIPTION'])) { ?>
			<h1 class="h1 article-title" id="<? echo $this->GetEditAreaId($section['ID']); ?>"><?=$section['~DESCRIPTION']?> </h1>
		<? } else { ?>
			<h1 class="h1 article-title" id="<? echo $this->GetEditAreaId($section['ID']); ?>"><?=$section['NAME']?> </h1>
		<? } ?>
<? if (!empty($arResult['ITEMS'])) { ?>
	<div class="article-content">
		<? foreach ($arResult['ITEMS'] as $arItem) { 
	?>
			<? if ($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'text' && !empty($arItem['PREVIEW_TEXT'])) { 
				
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<div class="article-text page-text" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<?=$arItem['~PREVIEW_TEXT']?>
				</div>
			<? } if ($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'slider' && !empty($arItem['PROPERTIES']['PHOTOS']['VALUE'])) { 
				
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<div class="page-slider-holder" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<div data-shadows="false" data-margin="0" data-width="100%" data-arrows="false" data-nav="false" data-loop="true" data-transitionduration="700" data-autoplay="5000" class="page-slider">
					    <? foreach ($arItem['PROPERTIES']['PHOTOS']['VALUE'] as $arPhoto) { ?>
						<img src="<?=CFile::GetPath($arPhoto)?>">
					    <? } ?>
					</div>
					<div class="page-slider-nav"><span class="page-slider-nav-item page-slider-nav-item--prev"></span><span class="page-slider-nav-counter"><span class="page-slider-nav-counter-current">1</span><span class="page-slider-nav-divider">/</span><span class="page-slider-nav-all">&nbsp;</span></span><span class="page-slider-nav-item page-slider-nav-item--next"></span></div>
				</div>
			<? } if ($arItem['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'accordeon' && !empty($arItem['PROPERTIES']['ACCORDEON']['VALUE'])) { 
				
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
	</div>
	</article>
	</div>
				<div class="page-inner page-inner--w2">
					<div class="accordion" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						<? foreach ($arItem['PROPERTIES']['ACCORDEON']['~VALUE'] as $key => $val) { ?>
							<div class="accordion-item">
								<div class="accordion-item-header"><span class="accordion-item-header-name"><?=$arItem['PROPERTIES']['ACCORDEON']['DESCRIPTION'][$key]?></span><span class="accordion-item-header-toggler"></span></div>
								<div class="accordion-item-content page-text">
								  <?=$val['TEXT']?>
								</div>
							</div>
						<? } ?>
					</div>
				</div>
	<div class="page-inner page-inner--w1">
	<article class="article">
	<div class="article-content">
			<? } ?>
		<? } ?>
	</div>
<? } ?>

            </article>
          </div>