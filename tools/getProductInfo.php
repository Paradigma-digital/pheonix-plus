<?php
	//print_r($_REQUEST); die;
	
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	CModule::IncludeModule("iblock");
	
	$code = $_REQUEST["CODE"];
	$type = $_REQUEST["TYPE"];
	if(!$code || !$type) {
		if(!$code) {
			die("Не указан идентификатор номенклатуры.");
		}
		if(!$type) {
			die("Не указан тип запроса: карточка или картинка?");
		}
	}

	//echo '<pre>'; print_r($arProduct); '</pre>'; die;
	switch($type) {
		case "card":
			$arProduct = CGCCatalog::getProductInfoByCode($code);
			if(!$arProduct) {
				die("Товар с идентификатором номенклатуры ".$code." не найден.");
			}
			LocalRedirect($arProduct["DETAIL_PAGE_URL"]);
		break;
		case "image":
			$arProduct = CGCCatalog::getProductInfoByCode($code);
			if(!$arProduct) {
				die("Товар с идентификатором номенклатуры ".$code." не найден.");
			}
			//echo CFile::ShowImage($arProduct["DETAIL_PICTURE"]);
			//echo CFile::GetPath($arProduct["DETAIL_PICTURE"]); die;
			$img = file_get_contents($_SERVER["DOCUMENT_ROOT"].CFile::GetPath($arProduct["DETAIL_PICTURE"]));
			header("Content-type: image/jpeg;");
			//header("Content-Length: " . strlen($img));
			echo $img;
			
		
		break;
		case "imageByCode":
			global $DB;
			//echo 'SELECT SUBDIR FROM b_file WHERE FILE_NAME LIKE "%'.$code.'%"';
			$dbFile = $DB->Query('SELECT SUBDIR, FILE_NAME FROM b_file WHERE (ORIGINAL_NAME LIKE "%'.$code.'%") ORDER BY FILE_SIZE DESC');
			$arFile = $dbFile->GetNext();
			//echo CFile::ShowImage("/upload/".$arFile["SUBDIR"]."/".$arFile["FILE_NAME"]);
			LocalRedirect("/upload/".$arFile["SUBDIR"]."/".$arFile["FILE_NAME"]);
		break;
	}
?>