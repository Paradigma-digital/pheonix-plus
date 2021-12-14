<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	CJSCore::Init(array("fx"));
	$APPLICATION->ShowHead();
	$code = $_REQUEST["QR_CODE"];
	if(!$code) {
		LocalRedirect("/catalog/", true);
		die;
	}
	
	$arQrItem = CGCHelper::getIBlockElements([
		"FILTER" => [
			"CODE" => $code,
			"IBLOCK_ID" => "32",
			"ACTIVE" => "Y"
		],
		"SELECT" => [
			"ID", "NAME", "PROPERTY_PDF", "PROPERTY_AUDIO", "PROPERTY_LINK_VIEW",  "PROPERTY_SHOW_PDF", "PROPERTY_PASSWORD"
		]
	]);
	if($arQrItem) {
		$arQrItem = $arQrItem[0];

		if($arQrItem["PROPERTY_PDF_VALUE"]) {
			$qrItemFileImg = CFile::GetPath($arQrItem["PROPERTY_PDF_VALUE"]);
			/*
			$arItemFile = pathinfo($qrItemFile);
	
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="'.$arItemFile["basename"].'"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');
			@readfile($_SERVER["DOCUMENT_ROOT"].$qrItemFile);
            */
		}
		if($arQrItem["PROPERTY_AUDIO_VALUE"]) {
			$qrItemFileAudio = CFile::GetPath($arQrItem["PROPERTY_AUDIO_VALUE"]);

			?>

			<?
			//LocalRedirect($qrItemFile, true);
			
			/*
			$arItemFile = pathinfo($qrItemFile);

			header('Content-type: audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3');
			header('Content-length: '.filesize($_SERVER["DOCUMENT_ROOT"].$qrItemFile));
			header('Content-Disposition: filename="'.$arItemFile["basename"].'"');
			header('X-Pad: avoid browser bug');
			header('Cache-Control: no-cache');
			readfile($_SERVER["DOCUMENT_ROOT"].$qrItemFile);
			*/
		}
		?>
	<style>
		.content{
			width: 100%;
			text-align: center;
			display: block;
		}
        .content a{
            color: #777;
            padding: 5px;
            text-decoration: none;
            display: block;
        }
		.content img{
			max-width: 50%;
		}
		audio{
			margin-top:30px;
				margin-bottom: 1em
		}
		#seeMore ~ input{
			width: 30px;
		}
		.popup{
			margin: 10px 0;
		}
		@media (max-width: 576px) {
		.content img{
			max-width: 90%;
			}
		}
	</style>

<meta name="viewport" content="width=device-width, initial-scale=1">
	<div class="content">
<audio controls autoplay id="audio" allow="autoplay" preload="auto" src="<?=$qrItemFileAudio?>"></audio>
	<br/><img src="<?=$qrItemFileImg?>"/><br/><br/>
        <?
        if($arQrItem["PROPERTY_LINK_VIEW_VALUE"]) {
            ?>
			<div style="display:inline-block">
				<a href="javascript:void(0)" id="seePdfMore">Увидеть продолжение</a>
				<div class="popup" style="display: none">
					Для продолжения введите пароль<br/>
					<input type="text" value="">
					<input type="submit" id="inputSeePdfMore" value="Отправить" attrHref="<?=$arQrItem["PROPERTY_LINK_VIEW_VALUE"]?>">
				</div>
			</div>
			<br/>
            <?
        }

        if($arQrItem["PROPERTY_SHOW_PDF_VALUE"]) {
            ?>
			<div style="display:inline-block">
				<a href="<?=$arQrItem["PROPERTY_SHOW_PDF_VALUE"]?>" target="_blank" >Посмотреть ответы</a>

			</div>
			<br/>
            <?
        }
        ?>
		<script>
			BX.ready(function(){
				BX.bind(BX("inputSeePdfMore"), 'click', BX.proxy(function(e){
					let val = BX.findPreviousSibling(e.srcElement, {'tag':'input'}).value;
					let link = e.srcElement.getAttribute('attrHref');
					if(val == <?=$arQrItem["PROPERTY_PASSWORD_VALUE"]?>){
						window.location.replace(link);
					}
				}, this));

				BX.bind(BX("seePdfMore"), 'click', BX.proxy(function(e){
					let node = BX.findNextSibling(e.srcElement, {'tag':'div'});
					node.style.display = 'block';
				}, this));
			});
		</script>
	</div>
<?
	} else {
		LocalRedirect("/catalog/", true);
		die;
	}
?>