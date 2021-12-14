<?php
	header("Content-Type: image/jpeg");
	$im = @imagecreate(130, 30);
    $background_color = imagecolorallocate($im, 255, 255, 255);
	$text_color = imagecolorallocate($im, 0, 0, 0);
  //Рисуем текст ttf-шрифтом
  imageTtfText($im, 12, 0, 5, 20, $text_color, "./ArialMT.ttf", "FKOПФ018626");
imageJpeg($im);
imagedestroy($im);
?>