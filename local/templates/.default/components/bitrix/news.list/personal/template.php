<?/*div class="page-inner page-inner--w1">
    <?
    if (!empty($arResult['ITEMS'])) { ?>
	<div class="docs">
	    <div class="docs-items"><?foreach ($arResult['ITEMS'] as $arItem) { 
		   
		    $fileInfo = CFile::GetFileArray($arItem['PROPERTIES']['FILE']['VALUE']);
		    
		    $ext = explode('.', $fileInfo['FILE_NAME']);
		    $ext = $ext[count($ext)-1];
		    ?><a href="<?=$fileInfo['SRC']?>" download="" class="doc-item">
		    <div class="doc-item-inner">
			<div class="doc-item-name"><?=$arItem['NAME']?></div><span class="doc-item-size"><?=CFile::FormatSize($fileInfo['FILE_SIZE'])?> (.<?=$ext?>)</span><span class="doc-item-download btn btn--gray">Скачать </span>
			<div class="doc-item-icon doc-item-icon--doc"></div>
	    </div></a><? } ?></div>
	</div>
    <? } ?>
</div*/?>  
<div class="page-inner page-inner--w1">
	<div class="accordion">
		<? foreach ($arResult['SECTS'] as $arSection) { ?>
		<div class="accordion-item">
			<div class="accordion-item-header">
				<span class="accordion-item-header-name"><?=$arSection['NAME']?></span><span class="accordion-item-header-toggler"></span>
			</div>
			<div class="accordion-item-content">
				<div class="persons">
					<? foreach ($arSection['ELEMS'] as $arItem) { 
						
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
						?>
					<div class="person" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						<? if (!empty($arItem['PREVIEW_PICTURE'])) { ?>
						<div class="person-photo-holder">
						    <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" class="person-photo">
						</div>
						<? } ?>
						<div class="person-post">
							<?=$arItem['NAME']?>
						</div>
						<div class="person-info page-text"><?=$arItem['~PREVIEW_TEXT']?></div>
					</div>
					<? } ?>
				</div>
			</div>
		</div>
		<? } ?>
	</div>
</div>