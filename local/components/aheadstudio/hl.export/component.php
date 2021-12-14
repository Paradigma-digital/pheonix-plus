<?php
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	
	
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
			
			// Название справочника
			$_SESSION["reference_name"] = $_REQUEST["filename"];
			
			// Формирование массива для обработки
			$arItems = CGCHL::exportItems($_SESSION["reference_name"]);

			$_SESSION["get_reference_FOR_EXPORT"] = $arItems["DATA"];
			$_SESSION["get_reference_EXPORTED_IDS"] = [];
			$_SESSION["get_reference_LAST_EXPORTED_INDEX"] = 0;
			
			//deb($arItems);
			
		// Отдаем файл
		} elseif($_GET["mode"] == "query") {
		
			//deb($_SESSION["get_reference_EXPORTED_IDS"]);
		
			// Удаляем запись из сервисной таблицы
			if($_SESSION["get_reference_EXPORTED_IDS"]) {
				$strError = "";
				foreach($_SESSION["get_reference_EXPORTED_IDS"] as $exportedItemID) {
					CGCHL::removeFromFix($_SESSION["reference_name"], $exportedItemID);
				}
			}
			$_SESSION["get_reference_EXPORTED_IDS"] = [];


			// Если есть элементы для выгрузки, то отдаём их в XML и обновляем признак выгрузки
			if($_SESSION["get_reference_FOR_EXPORT"]) {
				if($fp = fopen("php://output", "ab")) {
					$firstItem = true;
					$lastItem = false;
					
					// Просто отдаем пустой файл
					if($_SESSION["get_reference_LAST_EXPORTED_INDEX"] == -1) {
					
						fwrite($fp, CGCHL::makeXMLFromTemplate(false, true, false, [
							"reference_name" => $_SESSION["reference_name"],
						]));
						fwrite($fp, CGCHL::makeXMLFromTemplate(false, false, true));
						$i = -1;
					
					} else {
					
						// Случай одного
						if(count($_SESSION["get_reference_FOR_EXPORT"]) == 1) {
							$arExportItem = $_SESSION["get_reference_FOR_EXPORT"][0];
		
							fwrite($fp, CGCHL::makeXMLFromTemplate([$arExportItem], true, false, [
							"reference_name" => $_SESSION["reference_name"],
						]));
							fwrite($fp, CGCHL::makeXMLFromTemplate(false, false, true));
		
							$_SESSION["get_reference_EXPORTED_IDS"][] = $arExportItem["ID"];
							$i = -1;
							
						// Случай нескольких
						} else {
					
							for($i = $_SESSION["get_reference_LAST_EXPORTED_INDEX"]; $i < count($_SESSION["get_reference_FOR_EXPORT"]); $i++) {
								$arExportItem = $_SESSION["get_reference_FOR_EXPORT"][$i];
								if($firstItem) {
									$exportItemXml = CGCHL::makeXMLFromTemplate([$arExportItem], true, false, [
										"reference_name" => $_SESSION["reference_name"],
									]);
									$firstItem = false;
								} else {
									$exportItemXml = CGCHL::makeXMLFromTemplate([$arExportItem], false, false);
									if((ob_get_length() + strlen($exportItemXml)) >= 204800 * 0.9) {
										$exportItemXml = CGCHL::makeXMLFromTemplate(false, false, true);
										$lastItem = true;
									}
								}
								fwrite($fp, $exportItemXml);
								
								if($lastItem) {
									break;
								} else {
									$_SESSION["get_reference_EXPORTED_IDS"][] = $arExportItem["ID"];
								}
							}
							
							if(!$lastItem && ($_SESSION["get_reference_LAST_EXPORTED_INDEX"] < count($_SESSION["get_reference_FOR_EXPORT"]) - 1)) {
								fwrite($fp, CGCHL::makeXMLFromTemplate(false, false, true));
							}
							
							if($firstItem && ($_SESSION["get_reference_LAST_EXPORTED_INDEX"] == count($_SESSION["get_reference_FOR_EXPORT"]))) {
								// Отдаем последний пустой файл
								fwrite($fp, CGCHL::makeXMLFromTemplate(false, true, false, [
									"reference_name" => $_SESSION["reference_name"],
								]));
								fwrite($fp, CGCHL::makeXMLFromTemplate(false, false, true));
							}
						}
					}
					
					$_SESSION["get_reference_LAST_EXPORTED_INDEX"] = $i;
					header('Content-Type: application/xml; charset=windows-1251');
					fclose($fp);
				}
			} else {
				if($fp = fopen("php://output", "ab")) {
					// Отдаем последний пустой файл
					fwrite($fp, CGCHL::makeXMLFromTemplate(false, true, false, [
						"reference_name" => $_SESSION["reference_name"],
					]));
					fwrite($fp, CGCHL::makeXMLFromTemplate(false, false, true));
					header('Content-Type: application/xml; charset=windows-1251');
					fclose($fp);
				}
			}
		
		// Если файл был успешно получен
		} elseif($_GET["mode"]=="success") {
			
			$_SESSION["get_reference_LAST_EXPORTED_INDEX"] = false;
			$_SESSION["get_reference_EXPORTED_IDS"] = false;
			$_SESSION["get_reference_FOR_EXPORT"] = false;
			
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
?>