<?php
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	
	
	global $USER;
	
	// Определение имени файла и пути его сохранения. Все файлы с кастомной выгрузкой от 1С хранятся по пути /upload/custom_1c/
	$DIR_NAME = $_SERVER["DOCUMENT_ROOT"]."/upload/custom_1c/";
	if (isset($_GET["filename"]) && (strlen($_GET["filename"]) > 0)) {
		
		//This check for 1c server on linux
		$filename = preg_replace("#^(/tmp/|upload/1c/webdata)#", "", $_GET["filename"]);
		$filename = trim(str_replace("\\", "/", trim($filename)), "/");
	
		$io = CBXVirtualIo::GetInstance();
		$bBadFile = HasScriptExtension($filename)
			|| IsFileUnsafe($filename)
			|| !$io->ValidatePathString("/".$filename)
		;
	
		if (!$bBadFile) {
			$FILE_NAME = rel2abs($DIR_NAME, "/".$filename);
			if ((strlen($FILE_NAME) > 1) && ($FILE_NAME === "/".$filename)) {
				$ABS_FILE_NAME = $DIR_NAME.$filename;
				$WORK_DIR_NAME = substr($ABS_FILE_NAME, 0, strrpos($ABS_FILE_NAME, "/")+1);
			}
		}
	}
	
	// Буферизация вывода
	ob_start();
	
	// Авторизация
	if($_GET["mode"] == "checkauth" && $USER->IsAuthorized()) {
		if(
			(COption::GetOptionString("main", "use_session_id_ttl", "N") == "Y")
			&& (COption::GetOptionInt("main", "session_id_ttl", 0) > 0)
			&& !defined("BX_SESSION_ID_CHANGE")
		) {
			echo "failure\n",GetMessage("CC_BCE1_ERROR_SESSION_ID_CHANGE");
		} else {
			echo "success\n";
			echo session_name()."\n";
			echo session_id() ."\n";
			echo bitrix_sessid_get()."\n";
			echo "timestamp=".time()."\n";
		}
	
	// Инициализация
	} elseif ($_GET["mode"]=="init") {
			echo "zip="."no"."\n";
			echo "file_limit="."204800"."\n";
			echo "sessid=".$_REQUEST["sessid"]."\n";
			echo "version="."2.09"."\n";
			
	// Сохранение файла в директории сайта
	} elseif (($_GET["mode"] == "file") && $ABS_FILE_NAME) {
		//Read http data
		$DATA = file_get_contents("php://input");
		$DATA_LEN = defined("BX_UTF")? mb_strlen($DATA, 'latin1'): strlen($DATA);
	
		//And save it the file
		if (isset($DATA) && $DATA !== false) {
			CheckDirPath($ABS_FILE_NAME);
			if ($fp = fopen($ABS_FILE_NAME, "ab")) {
				$result = fwrite($fp, $DATA);
				if ($result === $DATA_LEN) {
					echo "success\n";
					if ($_SESSION["BX_CML2_IMPORT"]["zip"])
						$_SESSION["BX_CML2_IMPORT"]["zip"] = $ABS_FILE_NAME;
				} else {
					echo "failure\n",GetMessage("CC_BSC1_ERROR_FILE_WRITE", array("#FILE_NAME#"=>$FILE_NAME));
				}
			} else {
				echo "failure\n",GetMessage("CC_BSC1_ERROR_FILE_OPEN", array("#FILE_NAME#"=>$FILE_NAME));
			}
		}
		else {
			echo "failure\n",GetMessage("CC_BSC1_ERROR_HTTP_READ");
		}
		
	// Обработка файла и обновление данных в Bitrix
	} elseif ($_GET["mode"] == "import") {
		CGCHL::importHL($ABS_FILE_NAME);
		//unlink($ABS_FILE_NAME);
		echo "success\n";
	}
	
	// Вывод результатов в кодировке windows 1251
	$contents = ob_get_contents();
	ob_end_clean();
	header("Content-Type: application/xml; charset=windows-1251");
	$contents = $APPLICATION->ConvertCharset($contents, LANG_CHARSET, "windows-1251");
	echo $contents;
	die();
?>