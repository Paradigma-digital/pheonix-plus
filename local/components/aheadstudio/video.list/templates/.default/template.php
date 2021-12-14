<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div class="videos">
	<div class="videos-items">
		<?php foreach($arResult["VIDEOS"]["items"] as $arVideo): ?>
			<a href="https://www.youtube.com/watch?v=<?php echo $arVideo["id"]["videoId"]; ?>" target="_blank" class="popup video-item" data-type="iframe">
				<div class="video-item-photo-holder">
					<img src="<?php echo $arVideo["snippet"]["thumbnails"]["high"]["url"]; ?>" />
				</div>
				<div class="video-item-date">
					<?php echo date("j.m.Y", strtotime($arVideo["snippet"]["publishedAt"])); ?>
				</div>
				<div class="video-item-title">
					<?php echo $arVideo["snippet"]["title"]; ?>
				</div>
				<div class="video-item-description">
					<?php echo $arVideo["snippet"]["description"]; ?>
				</div>
			</a>
		<?php endforeach; ?>
	</div>
</div>