<div class="page-inner page-inner--w1">
    <?
    if (!empty($arResult['ITEMS'])) { ?>
	<div class="docs">
	    <div class="docs-items"><?foreach ($arResult['ITEMS'] as $arItem) { 
		   
		    $fileInfo = CFile::GetFileArray($arItem['PROPERTIES']['FILE']['VALUE']);
		    
		    $ext = explode('.', $fileInfo['FILE_NAME']);
		    $ext = $ext[count($ext)-1];
		    ?>
		    
		    <?php if($ext == "mp4"):
			    if(!$arItem["PREVIEW_PICTURE"]) {
					$ffmpeg = FFMpeg\FFMpeg::create();
					$video = $ffmpeg->open($_SERVER["DOCUMENT_ROOT"].$fileInfo['SRC']);
					$frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(15));
					$frame->save($_SERVER["DOCUMENT_ROOT"]."/upload/image.jpg");
					
					$el = new CIBlockElement;
					$el->Update($arItem["ID"], [
						"PREVIEW_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/upload/image.jpg"),
					]);
			    }
		    ?>
		    
			    <div class="doc-item doc-item--video popup" href="#popup<?php echo $arItem["ID"]; ?>" data-type="inline">
			    	<div class="doc-item-inner">
						<div class="doc-item-name"><?=$arItem['NAME']?></div>
						<div class="doc-item-preview">
							<img src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"]; ?>" />
						</div>
						<span class="doc-item-size"><?=CFile::FormatSize($fileInfo['FILE_SIZE'])?> (.<?=$ext?>)</span>
						<a href="<?=$fileInfo['SRC']?>" download="" class="doc-item-download btn btn--gray">Скачать</a>
		    		</div>
		    	</div>
		    	
				<div class="page-popup page-popup--large mfp-hide" id="popup<?php echo $arItem["ID"]; ?>">
					<div class="page-popup-title"><?=$arItem['NAME']?></div>
					<video controls>
						<source src="<?=$fileInfo['SRC']?>#t=0.5" type="video/mp4">
					</video>
				</div>
		    	
		    <?php else: ?>
		    
			    <a href="<?=$fileInfo['SRC']?>" download="" class="doc-item">
			    	<div class="doc-item-inner">
						<div class="doc-item-name"><?=$arItem['NAME']?></div>
						<span class="doc-item-size"><?=CFile::FormatSize($fileInfo['FILE_SIZE'])?> (.<?=$ext?>)</span><span class="doc-item-download btn btn--gray">Скачать</span>
						<div class="doc-item-icon doc-item-icon--doc"></div>
		    		</div>
		    	</a>
		    	
	    	<?php endif; ?>
	    
	    
	    <? } ?></div>
	</div>
	

	
    <? } ?>
</div>  