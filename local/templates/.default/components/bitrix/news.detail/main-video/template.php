<div class="home-shop-video-holder">         
    <video muted="muted" loop="loop" autoplay="autoplay" width="100%" playsinline poster="<?=CFile::GetPath($arResult['PROPERTIES']['VIDEO_PREVIEW']['VALUE'])?>" class="home-shop-video">   
		<? foreach ($arResult['PROPERTIES']['VIDEO_FILES']['VALUE'] as $video) { 
			$fileInfo = CFile::GetFileArray($video);
			$ext = explode('.', $fileInfo['FILE_NAME']);
			$ext = $ext[count($ext)-1];			
			?>
			<source src="<?=$fileInfo['SRC']?>" type="video/<?=$ext?>">
		<? } ?>    
	</video>         
</div> 