<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
	
	
	$ffmpeg = FFMpeg\FFMpeg::create();
	$video = $ffmpeg->open($_SERVER["DOCUMENT_ROOT"] . '/upload/iblock/9db/Razvivayushchaya-produktsiya-dlya-detey-_-obzor-novinok-Feniks_.mp4');
	$frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(20));
	$frame->save('image.jpg');

	require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>

