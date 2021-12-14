<?php
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	
	
	$arVideos = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/search?key=".$arParams["API_KEY"]."&channelId=".$arParams["CHANNEL_ID"]."&part=snippet,id&order=date&maxResults=50"), true);
//deb($arVideos);
	
	$arResult = [
		"VIDEOS" => $arVideos,
	];
	
	$this->IncludeComponentTemplate();
?>