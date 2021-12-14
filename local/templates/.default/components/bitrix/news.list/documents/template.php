
    <?
    if (!empty($arResult['ITEMS'])) { ?>
	<div class="docs">
	    <div class="docs-items">
		    <?foreach ($arResult['ITEMS'] as $arItem) { 
		   
		    $fileInfo = CFile::GetFileArray($arItem['PROPERTIES']['ATTACH']['VALUE']);
		    
		    $ext = explode('.', $fileInfo['FILE_NAME']);
		    $ext = $ext[count($ext)-1];
		    ?>
		    
			    <a href="<?=$fileInfo['SRC']?>" target="_blank" class="doc-item">
			    	<div class="doc-item-inner">
						<div class="doc-item-name"><?=$arItem['NAME']?></div>
						<span class="doc-item-size"><?=CFile::FormatSize($fileInfo['FILE_SIZE'])?> (.<?=$ext?>)</span><span class="doc-item-download btn btn--gray">Скачать</span>
						<div class="doc-item-icon doc-item-icon--doc"></div>
		    		</div>
		    	</a>
	    
	   
	    <? } ?>
	
		 </div>
	</div> 
    <? } ?>
 