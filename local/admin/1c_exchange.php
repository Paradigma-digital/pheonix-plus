<?
define('BX_SESSION_ID_CHANGE', false);
define('BX_SKIP_POST_UNQUOTE', true);
define('NO_AGENT_CHECK', true);
define("STATISTIC_SKIP_ACTIVITY_CHECK", true);


if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "crm")
{
	define("ADMIN_SECTION", true);
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if($_REQUEST["test"]) {
	COption::SetOptionString("sale", "secure_1c_exchange", "N");
}

if($type=="sale")
{
	$APPLICATION->IncludeComponent("aheadstudio:sale.export.1c", "", Array(
	//$APPLICATION->IncludeComponent("bitrix:sale.export.1c", "", Array(
		"SITE_LIST" => COption::GetOptionString("sale", "1C_SALE_SITE_LIST", ""),
		"EXPORT_PAYED_ORDERS" => COption::GetOptionString("sale", "1C_EXPORT_PAYED_ORDERS", ""),
		"EXPORT_ALLOW_DELIVERY_ORDERS" => COption::GetOptionString("sale", "1C_EXPORT_ALLOW_DELIVERY_ORDERS", ""),
		"EXPORT_FINAL_ORDERS" => COption::GetOptionString("sale", "1C_EXPORT_FINAL_ORDERS", ""),
		"CHANGE_STATUS_FROM_1C" => COption::GetOptionString("sale", "1C_CHANGE_STATUS_FROM_1C", ""),
		"FINAL_STATUS_ON_DELIVERY" => COption::GetOptionString("sale", "1C_FINAL_STATUS_ON_DELIVERY", "F"),
		"REPLACE_CURRENCY" => COption::GetOptionString("sale", "1C_REPLACE_CURRENCY", ""),
		"GROUP_PERMISSIONS" => explode(",", COption::GetOptionString("sale", "1C_SALE_GROUP_PERMISSIONS", "1")),
		"USE_ZIP" => COption::GetOptionString("sale", "1C_SALE_USE_ZIP", "Y"),
		"INTERVAL" => COption::GetOptionString("sale", "1C_INTERVAL", 30),
		"FILE_SIZE_LIMIT" => COption::GetOptionString("sale", "1C_FILE_SIZE_LIMIT", 200*1024),
		"SITE_NEW_ORDERS" => COption::GetOptionString("sale", "1C_SITE_NEW_ORDERS", "s1"),
		"IMPORT_NEW_ORDERS" => COption::GetOptionString("sale", "1C_IMPORT_NEW_ORDERS", "N"),
		)
	);
}
elseif($type=="crm")
{
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$orderId = intval($_POST["ORDER_ID"]);
		$modifLabel = intval($_POST["MODIFICATION_LABEL"]);
		$ZZZ = intval($_POST["ZZZ"]);
		$IMPORT_SIZE = intval($_POST["IMPORT_SIZE"]);
		$GZ_COMPRESSION_SUPPORTED = intval($_POST["GZ_COMPRESSION_SUPPORTED"]);
	}
	else
	{
		$orderId = intval($_GET["ORDER_ID"]);
		$modifLabel = intval($_GET["MODIFICATION_LABEL"]);
		$ZZZ = intval($_GET["ZZZ"]);
		$IMPORT_SIZE = intval($_GET["IMPORT_SIZE"]);
		$GZ_COMPRESSION_SUPPORTED = intval($_GET["GZ_COMPRESSION_SUPPORTED"]);
	}

	$APPLICATION->IncludeComponent("bitrix:sale.export.1c", "", Array(
			"CRM_MODE" => "Y",
			"ORDER_ID" => $orderId,
			"MODIFICATION_LABEL" => $modifLabel,
			"ZZZ" => $ZZZ,
			"IMPORT_SIZE" => $IMPORT_SIZE,
			"GZ_COMPRESSION_SUPPORTED" => $GZ_COMPRESSION_SUPPORTED,
			"GROUP_PERMISSIONS" => explode(",", COption::GetOptionString("sale", "1C_SALE_GROUP_PERMISSIONS", "1")),
			"REPLACE_CURRENCY" => COption::GetOptionString("sale", "1C_REPLACE_CURRENCY", ""),
			"USE_ZIP" => "N",
		)
	);
}
elseif($type=="catalog")
{
	//$APPLICATION->IncludeComponent("aheadstudio:catalog.import.1c", "", Array(
	$APPLICATION->IncludeComponent("bitrix:catalog.import.1c", "", Array(
		"IBLOCK_TYPE" => COption::GetOptionString("catalog", "1C_IBLOCK_TYPE", "-"),
		"SITE_LIST" => array(COption::GetOptionString("catalog", "1C_SITE_LIST", "-")),
		"INTERVAL" => COption::GetOptionString("catalog", "1C_INTERVAL", "-"),
		"GROUP_PERMISSIONS" => explode(",", COption::GetOptionString("catalog", "1C_GROUP_PERMISSIONS", "1")),
		"GENERATE_PREVIEW" => COption::GetOptionString("catalog", "1C_GENERATE_PREVIEW", "Y"),
		"PREVIEW_WIDTH" => COption::GetOptionString("catalog", "1C_PREVIEW_WIDTH", "100"),
		"PREVIEW_HEIGHT" => COption::GetOptionString("catalog", "1C_PREVIEW_HEIGHT", "100"),
		"DETAIL_RESIZE" => COption::GetOptionString("catalog", "1C_DETAIL_RESIZE", "Y"),
		"DETAIL_WIDTH" => COption::GetOptionString("catalog", "1C_DETAIL_WIDTH", "300"),
		"DETAIL_HEIGHT" => COption::GetOptionString("catalog", "1C_DETAIL_HEIGHT", "300"),
		"ELEMENT_ACTION" => COption::GetOptionString("catalog", "1C_ELEMENT_ACTION", "D"),
		"SECTION_ACTION" => COption::GetOptionString("catalog", "1C_SECTION_ACTION", "D"),
		"FILE_SIZE_LIMIT" => COption::GetOptionString("catalog", "1C_FILE_SIZE_LIMIT", 200*1024),
		"USE_CRC" => COption::GetOptionString("catalog", "1C_USE_CRC", "Y"),
		"USE_ZIP" => COption::GetOptionString("catalog", "1C_USE_ZIP", "Y"),
		"USE_OFFERS" => COption::GetOptionString("catalog", "1C_USE_OFFERS", "N"),
		"FORCE_OFFERS" => COption::GetOptionString("catalog", "1C_FORCE_OFFERS", "N"),
		"USE_IBLOCK_TYPE_ID" => COption::GetOptionString("catalog", "1C_USE_IBLOCK_TYPE_ID", "N"),
		"USE_IBLOCK_PICTURE_SETTINGS" => COption::GetOptionString("catalog", "1C_USE_IBLOCK_PICTURE_SETTINGS", "N"),
		"TRANSLIT_ON_ADD" => COption::GetOptionString("catalog", "1C_TRANSLIT_ON_ADD", "Y"),
		"TRANSLIT_ON_UPDATE" => COption::GetOptionString("catalog", "1C_TRANSLIT_ON_UPDATE", "Y"),
		"TRANSLIT_REPLACE_CHAR" => COption::GetOptionString("catalog", "1C_TRANSLIT_REPLACE_CHAR", "_"),
		"SKIP_ROOT_SECTION" => COption::GetOptionString("catalog", "1C_SKIP_ROOT_SECTION", "N"),
		"DISABLE_CHANGE_PRICE_NAME" => COption::GetOptionString("catalog", "1C_DISABLE_CHANGE_PRICE_NAME")
		)
	);
}
elseif($type=="reference")
{
	$APPLICATION->IncludeComponent("aheadstudio:catalog.import.hl", "", Array(
		"INTERVAL" => COption::GetOptionString("catalog", "1C_INTERVAL", "-"),
		"GROUP_PERMISSIONS" => explode(",", COption::GetOptionString("catalog", "1C_GROUP_PERMISSIONS", "1")),
		"FILE_SIZE_LIMIT" => COption::GetOptionString("catalog", "1C_FILE_SIZE_LIMIT", 200*1024),
		"USE_CRC" => COption::GetOptionString("catalog", "1C_USE_CRC", "Y"),
		"USE_ZIP" => COption::GetOptionString("catalog", "1C_USE_ZIP", "Y"),
		)
	);
}




// Экспорт HL на сторону 1С
else if($type == "get_highloads") {
	$APPLICATION->IncludeComponent("aheadstudio:hl.export", "", []);
}

// Импорт документов с 1С
else if($type == "send_highloads") {
	$APPLICATION->IncludeComponent("aheadstudio:hl.import", "", []);
}




// Экспорт документов на сторону 1С
else if($type == "get_doc") {
	$APPLICATION->IncludeComponent("aheadstudio:doc.export", "", []);
}





elseif($type=="get_catalog")
{
	$APPLICATION->IncludeComponent("bitrix:catalog.export.1c", "", Array(
		"IBLOCK_ID" => COption::GetOptionString("catalog", "1CE_IBLOCK_ID", ""),
		"INTERVAL" => COption::GetOptionString("catalog", "1CE_INTERVAL", "-"),
		"ELEMENTS_PER_STEP" => COption::GetOptionString("catalog", "1CE_ELEMENTS_PER_STEP", 100),
		"GROUP_PERMISSIONS" => explode(",", COption::GetOptionString("catalog", "1CE_GROUP_PERMISSIONS", "1")),
		"USE_ZIP" => COption::GetOptionString("catalog", "1CE_USE_ZIP", "Y"),
		)
	);
}
elseif($type=="listen")
{
	$APPLICATION->RestartBuffer();

	CModule::IncludeModule('sale');

	$timeLimit = 60;//1 minute
	$startExecTime = time();
	$max_execution_time = (intval(ini_get("max_execution_time")) * 0.75);
	$max_execution_time = ($max_execution_time > $timeLimit )? $timeLimit:$max_execution_time;

	if(CModule::IncludeModule("sale") && defined("CACHED_b_sale_order"))
	{
		while(!$CACHE_MANAGER->getImmediate(CACHED_b_sale_order, "sale_orders"))
		{
			usleep(1000);

			if(intVal(time() - $startExecTime) > $max_execution_time)
			{
				break;
			}
		}
	}

	if($CACHE_MANAGER->getImmediate(CACHED_b_sale_order, "sale_orders"))
	{
		echo "success\n";
	}
	else
	{
		CHTTP::SetStatus("304 Not Modified");
	}
}



### CUSTOM ###
# Кастомный код по отправке и принятию xml файла с контрагентами.


// Отдача файла с контрагентами на сторону 1С
else if($type == "get_contragents") {
	global $USER;
	

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
		}
		else {
			echo "success\n";
			echo session_name()."\n";
			echo session_id() ."\n";
			echo bitrix_sessid_get()."\n";
		}
	}
	else {
		// Инициализация. Захардкодили некоторые параметры ответа.
		if($_GET["mode"]=="init") {
			echo "zip="."no"."\n";
			echo "file_limit="."204800"."\n";
			echo "sessid=".$_REQUEST["sessid"]."\n";
			echo "version="."2.09"."\n";
			
			// Формирование массива для обработки
			$arUsers = CGC1C::exportUsers();
			//deb($arUsers);
			$_SESSION["get_contragents_USERS_FOR_EXPORT"] = $arUsers["DATA"];
			$_SESSION["get_contragents_EXPORTED_USERS_IDS"] = [];
			$_SESSION["get_contragents_LAST_EXPORTED_INDEX"] = 0;
			
			//deb($_SESSION["get_contragents_USERS_FOR_EXPORT"]);
			
		// Отдаем файл с юзерами
		} elseif($_GET["mode"] == "query") {
		
			//deb($_SESSION["get_contragents_EXPORTED_USERS_IDS"]);
		
			// Обновляем признак выгрузки контрагента в Битрикс
			if($_SESSION["get_contragents_EXPORTED_USERS_IDS"]) {
				$strError = "";
				foreach($_SESSION["get_contragents_EXPORTED_USERS_IDS"] as $exportedUserID) {
					$dbUser = new CUser;
					$dbUser->Update($exportedUserID, [
						"UF_EXPORTED_1C" => "Y",
					]);
				}
				unset($dbUser);
			}
			$_SESSION["get_contragents_EXPORTED_USERS_IDS"] = [];
			
			
			//deb($_SESSION["get_contragents_USERS_FOR_EXPORT"]);
			
			// Если есть юзеры для выгрузки, то отдаём их в XML и обновляем признак выгрузки
			if($_SESSION["get_contragents_USERS_FOR_EXPORT"]) {
				if($fp = fopen("php://output", "ab")) {
					$firstItem = true;
					$lastItem = false;
					
					// Просто отдаем пустой файл
					if($_SESSION["get_contragents_LAST_EXPORTED_INDEX"] == -1) {
					
						fwrite($fp, CGC1C::makeXMLFromTemplate(false, true, false));
						fwrite($fp, CGC1C::makeXMLFromTemplate(false, false, true));
						$i = -1;
					
					} else {
						
						// Случай одного
						if(count($_SESSION["get_contragents_USERS_FOR_EXPORT"]) == 1) {
							$arExportUser = $_SESSION["get_contragents_USERS_FOR_EXPORT"][0];
		
							fwrite($fp, CGC1C::makeXMLFromTemplate([$arExportUser], true, false));
							fwrite($fp, CGC1C::makeXMLFromTemplate(false, false, true));
		
							$_SESSION["get_contragents_EXPORTED_USERS_IDS"][] = $arExportUser["BX_ID"];
							$i = -1;
							
						// Случай нескольких
						} else {
							for($i = $_SESSION["get_contragents_LAST_EXPORTED_INDEX"]; $i < count($_SESSION["get_contragents_USERS_FOR_EXPORT"]); $i++) {
								$arExportUser = $_SESSION["get_contragents_USERS_FOR_EXPORT"][$i];
								
								if($firstItem) {
									$exportUserXml = CGC1C::makeXMLFromTemplate([$arExportUser], true, false);
									$firstItem = false;
								} else {
									$exportUserXml = CGC1C::makeXMLFromTemplate([$arExportUser], false, false);
									if((ob_get_length() + strlen($exportUserXml)) >= 204800 * 0.9) {
										$exportUserXml = CGC1C::makeXMLFromTemplate(false, false, true);
										$lastItem = true;
									}
								}
								
								fwrite($fp, $exportUserXml);
								
								if($lastItem) {
									break;
								} else {
									$_SESSION["get_contragents_EXPORTED_USERS_IDS"][] = $arExportUser["BX_ID"];
								}
							}
							
							if(!$lastItem && ($_SESSION["get_contragents_LAST_EXPORTED_INDEX"] < count($_SESSION["get_contragents_USERS_FOR_EXPORT"]) - 1)) {
								fwrite($fp, CGC1C::makeXMLFromTemplate(false, false, true));
							}
							
							if($firstItem && ($_SESSION["get_contragents_LAST_EXPORTED_INDEX"] == count($_SESSION["get_contragents_USERS_FOR_EXPORT"]))) {
								// Отдаем последний пустой файл
								fwrite($fp, CGC1C::makeXMLFromTemplate(false, true, false));
								fwrite($fp, CGC1C::makeXMLFromTemplate(false, false, true));
							}
						}
						
					}
					
					$_SESSION["get_contragents_LAST_EXPORTED_INDEX"] = $i;
					header('Content-Type: application/xml; charset=windows-1251');
					fclose($fp);

				}
			} else {
				if($fp = fopen("php://output", "ab")) {
					// Отдаем последний пустой файл
					fwrite($fp, CGC1C::makeXMLFromTemplate(false, true, false));
					fwrite($fp, CGC1C::makeXMLFromTemplate(false, false, true));
					header('Content-Type: application/xml; charset=windows-1251');
					fclose($fp);
				}
			}
		
		// Если файл был успешно получен
		} elseif($_GET["mode"]=="success") {
			
			$_SESSION["get_contragents_LAST_EXPORTED_INDEX"] = false;
			$_SESSION["get_contragents_EXPORTED_USERS_IDS"] = false;
			$_SESSION["get_contragents_USERS_FOR_EXPORT"] = false;
			
			echo "success\n";
			
		// Обработка остальных случаев
		} else {
			echo "failure\n",GetMessage("CC_BCE1_ERROR_UNKNOWN_COMMAND");
		}
	}
	
	// Вывод результатов в кодировке windows 1251
	$contents = ob_get_contents();
	ob_end_clean();
	header("Content-Type: application/xml; charset=windows-1251");
	$contents = $APPLICATION->ConvertCharset($contents, LANG_CHARSET, "windows-1251");
	echo $contents;
	die();
}

// Обработка файла с контрагентами от 1С
else if($type == "send_contragents") {
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
		CGC1C::importUsers($ABS_FILE_NAME);
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
}


### //CUSTOM ###



else
{
	$APPLICATION->RestartBuffer();
	echo "failure\n";
	echo "Unknown command type.";
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>