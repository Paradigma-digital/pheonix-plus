<?php
	use Bitrix\Highloadblock as HL;
	use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
	CModule::IncludeModule("highloadblock");
	
	class CGCHL {
		
		private static $logStr;
		
		// Получение запрашиваемого справочника по его имени
		function getHLByName($hlName) {
			CModule::IncludeModule("highloadblock");
			
			$hlblock = HLBT::getList([
				"filter" => [
					"NAME" => $hlName
				]
			])->fetch();
			return $hlblock;
		}
		
		
		function addOrUpdate() {
			
		}

		
		// Получение списка
		function getList($hlId, $arParams) {
			CModule::IncludeModule("highloadblock");

		    $hlblock = HLBT::getById($hlId)->fetch();   
		    $entity = HLBT::compileEntity($hlblock);
		    $entity_data_class = $entity->getDataClass();
			$rsData = $entity_data_class::getList([
			   "select" => ($arParams["SELECT"] ? $arParams["SELECT"] : []),
			   "order" => ($arParams["ORDER"] ? $arParams["ORDER"] : []),
			   "filter" => ($arParams["FILTER"] ? $arParams["FILTER"] : []),
			   "group" => ($arParams["GROUP"] ? $arParams["GROUP"] : []),
			]);
			$arResult = Array();
			while($el = $rsData->fetch()){
			    $arResult[] = $el;
			}
			return $arResult;
		}
		
		// Добавление нового
		function add($hlId, $arParams) {
			CModule::IncludeModule("highloadblock");
			
			$hlblock = HLBT::getById($hlId)->fetch(); 
			$entity = HLBT::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();
			
			$result = $entity_data_class::add($arParams);
			//deb($result->getErrors());
			return $result->getId();
		}
		
		// Изменение
		function update($hlId, $elementId, $arParams) {
			CModule::IncludeModule("highloadblock");
			
			$hlblock = HLBT::getById($hlId)->fetch(); 
			$entity = HLBT::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();
			
			$result = $entity_data_class::update($elementId, $arParams);
			return $result->getId();
		}
		
		// Удаление
		function remove($hlId, $elementId) {
			CModule::IncludeModule("highloadblock");
			
			$hlblock = HLBT::getById($hlId)->fetch(); 
			$entity = HLBT::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();
			
			$result = $entity_data_class::delete($elementId);
			//return $result->getId();
		}
		
		// Удаление из фиксационной таблицы
		function removeFromFix($hlName, $elementId) {
			CModule::IncludeModule("highloadblock");
			
			$arItems = self::getList(self::getServiceTableID(), [
				"FILTER" => [
					"UF_ELEMENT_ID" => $elementId,
					"UF_TABLE_NAME" => $hlName,
				],
				"SELECT" => ["ID"]
			]);
			foreach($arItems as $arItem) {
				self::remove(self::getServiceTableID(), $arItem["ID"]);
			}
		}
		
		function getServiceTableID() {
			return self::getHLByName("HLservice")["ID"];
		}
		
		// Фиксация изменений
		function fixUpdate($hlName, $elementId) {
			$arElements = self::getList(self::getServiceTableID(), [
				"FILTER" => [
					"UF_ELEMENT_ID" => $elementId,
					"UF_TABLE_NAME" => $hlName,
				],
				"SELECT" => ["UF_DATE_UPDATE", "ID"],
				"ORDER" => [
					"UF_DATE_UPDATE" => "DESC",
				],
			]);
			
			// Получаем текущее время
			global $DB;
			$dateTime = date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time());
			
			if(!$arElements) {
				self::add(self::getServiceTableID(), [
					"UF_ELEMENT_ID" => $elementId,
					"UF_DATE_UPDATE" => $dateTime,
					"UF_TABLE_NAME" => $hlName,
				]);
			} else {
				self::update(self::getServiceTableID(), $arElements[0]["ID"], [
					"UF_DATE_UPDATE" => $dateTime,
				]);
			}
		}
		
		// Список элементов для экспорта в 1С
		function exportItems($hlName) {
			CModule::IncludeModule("highloadblock");
			
			// Получение ID запрашиваемого справочника
			$hlblock = self::getHLByName($hlName);
			if(!$hlblock) {
				return false;
			}
			
			// Получение измененных/добавленных элементов из сервисной таблицы
			$arExportElements = self::getList(self::getServiceTableID(), [
				"FILTER" => [
					"UF_TABLE_NAME" => $hlName,
				],
				"SELECT" => ["ID", "UF_ELEMENT_ID"],
			]);
			$arExportElementsIDs = [];
			foreach($arExportElements as $arExportElement) {
				$arExportElementsIDs[] = $arExportElement["UF_ELEMENT_ID"];
			}
			
			// Выборка согласно ID из предыдущего списка
			$arItems = self::getList($hlblock["ID"], [
				"SELECT" => ["ID", "UF_*"],
				"FILTER" => [
					"ID" => $arExportElementsIDs
				]
			]);
			//deb($arItems);
			
			// Поиск наличия таблицы в связке строки-шапки
			$arHeadingRows = self::getList(self::getHLByName("DocsHeadingRows")["ID"], [
				"SELECT" => ["ID", "UF_*"],
				"FILTER" => [
					"UF_HEADER_NAME" => $hlName
				]
			]);
			// Поиск связанных строк
			if($arHeadingRows) {
				$arItem["ITEMS"] = [];
				foreach($arHeadingRows as $arHeadingRowItem) {
					foreach($arItems as &$arItem) {
						$arItem["ITEMS"][$arHeadingRowItem["UF_TABLE_NAME"]] = self::getList(self::getHLByName($arHeadingRowItem["UF_TABLE_NAME"])["ID"], [
							"SELECT" => ["ID", "UF_*"],
							"FILTER" => [
								"UF_DOCUMENT_ID" => $arItem["ID"]
							]
						]);
					}
					unset($arItem);
					unset($arHeadingRowItem);
				}
			}
			//deb($arItems); die;
			
			// Выходной массив
			$arResult = [
				"DATA" => $arItems,
				"IDS" => [],
			];
			foreach($arItems as $arItem) {
				$arResult["IDS"][] = $arItem["ID"];
			}
			
			//deb($arResult);
			return $arResult;
		}
		
		
		// Формирование XML
		function makeXMLFromTemplate($arItems, $addHeader = true, $addFooter = true, $arParams = []) {
			$xml = "";
			if($addHeader) {
				$xml .= '<?xml version="1.0" encoding="windows-1251"?>'.PHP_EOL.
							'<КоммерческаяИнформация xmlns="urn:1C.ru:commerceml_3" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '.
							' ВерсияСхемы="3.1" ДатаФормирования="'.date(DATE_ISO8601, time()).'">'.
							'<ПользовательскиеОбъекты Имя="'.$arParams["reference_name"].'" СодержитТолькоИзменения="true">'.
								'<Объекты>';
			}
			
			if($arItems) {
				foreach($arItems as $arItem) {
					$xml .= '<Объект>';
					foreach($arItem as $itemCode => $itemValue) {
						if(is_array($itemValue)) {
							foreach($itemValue as $rowsCode => $rowsItems) {
								$xml .= '<Строки title="'.$rowsCode.'">';
								foreach($rowsItems as $arItemSub) {
									$xml .= '<Строка>';
									foreach($arItemSub as $itemSubCode => $itemValueCode) {
										
										if(strstr($itemSubCode, "DATE") && 0) {
											$value = date(DATE_ISO8601, strtotime($itemValueCode));
										} else {
											$value = htmlspecialchars($itemValueCode);
										}
										

										
										$xml .= '<'.$itemSubCode.'>'.$value.'</'.$itemSubCode.'>';
									}
									$xml .= '</Строка>';
								}
								$xml .= '</Строки>';
							}

						} else {
							
							if(strstr($itemCode, "DATE") && 0) {
								$value = date(DATE_ISO8601, strtotime($itemValue));
							} else {
								$value = htmlspecialchars($itemValue);
							}
							
							if($itemCode == "UF_USER_ID") {
								$dbUser = CUser::GetByID($itemValue);
								if(($arUser = $dbUser->Fetch())) {
									$value = $arUser["XML_ID"];
								}
							}
							
							$xml .= '<'.$itemCode.'>'.$value.'</'.$itemCode.'>';
						}
						
					}
					$xml .=	'</Объект>';

				}
				unset($arItem);
			}
			
			if($addFooter) {
				$xml .= 		'</Объекты>'.
							'</ПользовательскиеОбъекты>'.
						'</КоммерческаяИнформация>';
			}
					
			return $xml;
		}
		
		
		
		
		// Формирование структуры
		private function getHLStructure($arXMLObject, $arParams = false) {
			//deb($arXMLObject);
			$arStructureItem = [
				"CODE" => $arXMLObject["Ид"],
				"NAME" => $arXMLObject["Ид"],
				"FIELDS" => [
					[
						"NAME" => "XML_ID",
						"TYPE" => "Строка",
					], [
						"NAME" => "VERSION",
						"TYPE" => "Строка",
					]
				],
				"ITEMS" => [],
			];
			
			// Добавление поля для родителя
			if($arParams["IS_TABLE"]) {
				$arStructureItem["FIELDS"][] = [
					"NAME" => "DOCUMENT_ID",
					"TYPE" => "Строка",
				];
			}
			
			foreach($arXMLObject["Реквизиты"]["Реквизит"] as $arXMLObjectField) {
				$arStructureItem["FIELDS"][] = [
					"NAME" => $arXMLObjectField["Ид"],
					"TYPE" => $arXMLObjectField["ТипЗначений"],
				];
							
			}
			
			// Добавление объектов
			if($arXMLObject["Объекты"]["Объект"]) {
				if($arXMLObject["Объекты"]["Объект"][0]) {
					foreach($arXMLObject["Объекты"]["Объект"] as $arXMLObjectItem) {
						$arStructureItem["ITEMS"][] = self::getItemFromXML($arXMLObjectItem);
					}
				} else {
					$arStructureItem["ITEMS"][] = self::getItemFromXML($arXMLObject["Объекты"]["Объект"]);
				}
			}
	
			if($arXMLObject["ТабличныеЧасти"]) {
				$arStructureItem["TABLES"] = [];
				if($arXMLObject["ТабличныеЧасти"]["ТабличнаяЧасть"][0]) {
					foreach($arXMLObject["ТабличныеЧасти"]["ТабличнаяЧасть"] as $arXMLObjectTable) {
						$arStructureItem["TABLES"][] = self::getHLStructure($arXMLObjectTable, [
							"IS_TABLE" => "Y"
						]);
					}
				} else {
					$arStructureItem["TABLES"][] = self::getHLStructure($arXMLObject["ТабличныеЧасти"]["ТабличнаяЧасть"], [
						"IS_TABLE" => "Y"
					]);
				}
			}
			
			return $arStructureItem;
		}
		
		// Получение объекта
		private function getItemFromXML($xmlObject) {
			//deb($xmlObject);
			$arItem = [
				"ITEM" => [
					"UF_XML_ID" => $xmlObject["Ид"],
					"UF_VERSION" => $xmlObject["НомерВерсии"],
				]
			];
			foreach($xmlObject["ЗначенияРеквизитов"]["ЗначениеРеквизита"] as $xmlObjectField) {
				
				if(strstr($xmlObjectField["Наименование"], "Дата")) {
					$xmlObjectField["Значение"] = date("j.m.Y H:i:s", strtotime($xmlObjectField["Значение"]));
				}
				if($xmlObjectField["Значение"] === "false") {
					$xmlObjectField["Значение"] = false;
				}
				if($xmlObjectField["Значение"] === "true") {
					$xmlObjectField["Значение"] = true;
				}				
				
				$arItem["ITEM"][substr("UF_".Cutil::translit($xmlObjectField["Наименование"], "ru", [
						"change_case" => "U"
				]), 0, 19)] = $xmlObjectField["Значение"];
			}
			
			//deb($arItem);
			
			// Добавление строк
			if($xmlObject["ТабличныеЧасти"]["ТабличнаяЧасть"]) {
				$arItem["TABLES"] = [];
				if($xmlObject["ТабличныеЧасти"]["ТабличнаяЧасть"][0]) {
					foreach($xmlObject["ТабличныеЧасти"]["ТабличнаяЧасть"] as $xmlObjectTable) {
						$arItem["TABLES"][] = [
							"ENTITY_NAME" => ucfirst(Cutil::translit($xmlObjectTable["Наименование"], "ru", [
								"replace_space" => "",
								"replace_other" => "",
							])),
							"ITEMS" => self::getStringsFromXML($xmlObjectTable),
						];
					}
				} else {

					$arItem["TABLES"][] = [
						"ENTITY_NAME" => ucfirst(Cutil::translit($xmlObject["ТабличныеЧасти"]["ТабличнаяЧасть"]["Наименование"], "ru", [
							"replace_space" => "",
							"replace_other" => "",
						])),
						"ITEMS" => self::getStringsFromXML($xmlObject["ТабличныеЧасти"]["ТабличнаяЧасть"]),
					];
				}
			}
			
			if($xmlObject["СтрокиТабличнойЧасти"]["СтрокаТабличнойЧасти"]) {
				if($arXMLObject["СтрокиТабличнойЧасти"]["СтрокаТабличнойЧасти"][0]) {
					foreach($arXMLObject["СтрокиТабличнойЧасти"]["СтрокаТабличнойЧасти"] as $arXMLObjectString) {
						$arStructureItem["ITEMS"][] = self::getItemFromXML($arXMLObjectString);
					}
				} else {
					$arStructureItem["ITEMS"][] = self::getItemFromXML($arXMLObject["СтрокиТабличнойЧасти"]["СтрокаТабличнойЧасти"]);
				}
			}
			
			//deb($arItem);
			return $arItem;
		}
		
		// Получение строки
		private function getStringsFromXML($xmlObject) {
			$arStrings = [];
			
			if($xmlObject["СтрокиТабличнойЧасти"]["СтрокаТабличнойЧасти"][0]) {
				foreach($xmlObject["СтрокиТабличнойЧасти"]["СтрокаТабличнойЧасти"] as $xmlObjectString) {
					$arStrings[] = self::getString($xmlObjectString);
				}
			} else {
				$arStrings[] = self::getString($xmlObject["СтрокиТабличнойЧасти"]["СтрокаТабличнойЧасти"]);
			}
			
			return $arStrings;
		}
		
		private function getString($xmlString) {
			$arString = [
				"UF_XML_ID" => $xmlString["НомерСтроки"]
			];
			foreach($xmlString["ЗначенияРеквизитов"]["ЗначениеРеквизита"] as $xmlStringProp) {
				
				if(strstr($xmlStringProp["Наименование"], "Дата")) {
					$xmlStringProp["Значение"] = date("j.m.Y H:i:s", strtotime($xmlStringProp["Значение"]));
				}
				if($xmlStringProp["Значение"] === "false") {
					$xmlStringProp["Значение"] = false;
				}
				if($xmlStringProp["Значение"] === "true") {
					$xmlStringProp["Значение"] = true;
				}
				
				$arString[substr("UF_".Cutil::translit($xmlStringProp["Наименование"], "ru", [
						"change_case" => "U"
				]), 0, 19)] = $xmlStringProp["Значение"];
				
				
				
			}
			
			return $arString;
		}
		
		// Получение мета-данных таблицы
		private function getMeta($hlId) {
			$arMeta = [
				"FIELDS" => [],
				"FIELDS_BY_LABELS" => []
			];
			
			$dbFields = CUserTypeEntity::GetList(
				[
					"ID" => "ASC"
				],
				[
					"ENTITY_ID" => "HLBLOCK_".$hlId,
					"LANG" => "ru",
				]
			);
			while($arField = $dbFields->Fetch()) {
				$arMeta["FIELDS"][] = $arField;
				$arMeta["FIELDS_BY_LABELS"][$arField["EDIT_FORM_LABEL"]] = $arField;
			}

			return $arMeta;
		}
		
		// Создание сущностей и полей
		private function createHLStructure($arStructureTable, $arParams = false) {
			$tableName = Cutil::translit($arStructureTable["NAME"], "ru", [
				"replace_space" => "",
				"replace_other" => "",
			]);
			
			// Проверка существования таблицы и создаем если её еще нет
			$dbTable = HL\HighloadBlockLangTable::getList([
				"filter" => [
					"NAME" => $arStructureTable["NAME"]
				]
			]);
			$arTable = $dbTable->Fetch();
			if(!$arTable) {
				$addTable = HLBT::add([
					"NAME" => ucfirst($tableName),
					"TABLE_NAME" => $tableName, 
				]);
				if($addTable->isSuccess()) {
					$arTable = [
						"ID" => $addTable->getId(),
						"NAME" => $tableName,
					];
					HL\HighloadBlockLangTable::add(array(
						"ID" => $arTable["ID"],
						"LID" => "ru",
						"NAME" => $arStructureTable["NAME"]
					));
				} else {
					deb($addTable->getErrorMessages());
				}
			}
			$arTable["ENTITY_NAME"] = ucfirst($tableName);
			
			$arTableFields = self::getMeta($arTable["ID"]);
			
			//deb($arStructureTable["FIELDS"]);
			
			// Проверка полей сущности и добавление если их нет
			foreach($arStructureTable["FIELDS"] as $arStructureTableField) {
				
				// Если поле уже есть
				if($arTableFields["FIELDS_BY_LABELS"][$arStructureTableField["NAME"]]) {
					continue;
				}
				
				$arField = [
					"ENTITY_ID" => "HLBLOCK_".$arTable["ID"],
					"FIELD_NAME" => substr("UF_".Cutil::translit($arStructureTableField["NAME"], "ru", [
						"change_case" => "U"
					]), 0, 19),
					"EDIT_FORM_LABEL" => ["ru" => $arStructureTableField["NAME"]],
					"LIST_COLUMN_LABEL" => ["ru" => $arStructureTableField["NAME"]],
					"LIST_FILTER_LABEL" => ["ru" => $arStructureTableField["NAME"]],
				];
				switch($arStructureTableField["TYPE"]) {
					case "Строка":
						$arField["USER_TYPE_ID"] = "string";
					break;
					case "Булево":
						$arField["USER_TYPE_ID"] = "boolean";
					break;
					case "Дата":
						$arField["USER_TYPE_ID"] = "datetime";
					break;
					case "Число":
						$arField["USER_TYPE_ID"] = "double";
						$arField["SETTINGS"] = [
							"PRECISION" => "2"
						];
					break;
					default:
						$arField["USER_TYPE_ID"] = "string";
					break;
				}
				//deb($arField, false);
				$dbField = new CUserTypeEntity;
				$dbField->Add($arField);
			}
			
			return $arTable;
			
		}
		
		function importHL($xmlFileName) {
			self::startLog();
			
			// Получение массива данных из файла
			$arXMLArray = json_decode(json_encode(simplexml_load_file($xmlFileName)), true);
			self::addLog("Массив обработан");
			self::addLog(print_r($arXMLArray, true));
			
			
			// Парсинг структуры в массив
			$arStructure = [];

			if($arXMLArray["ПользовательскиеОбъекты"]["ПользовательскийОбъект"][0]) {
				foreach($arXMLArray["ПользовательскиеОбъекты"]["ПользовательскийОбъект"] as $arXMLObject) {
					$arStructure[] = self::getHLStructure($arXMLObject);
				}
			} else {
				$arStructure[] = self::getHLStructure($arXMLArray["ПользовательскиеОбъекты"]["ПользовательскийОбъект"]);
			}
			//deb($arStructure);
			
			
			// Создание структуры
			foreach($arStructure as $arStructureBlock) {
				$arStructureBlockResult = self::createHLStructure($arStructureBlock);
				foreach($arStructureBlock["TABLES"] as $arStructureTable) {
					$arStructureTableResult = self::createHLStructure($arStructureTable, [
						"IS_TABLE" => true
					]);
					
					// Добавление в таблицу связей если связи еще нет
					if(!self::getList(self::getHLByName("DocsHeadingRows")["ID"], [
							"FILTER" => [
								"UF_TABLE_NAME" => $arStructureBlockResult["ENTITY_NAME"],
								"UF_HEADER_NAME" => $arStructureTableResult["ENTITY_NAME"],
							]
						])) {
						self::add(self::getHLByName("DocsHeadingRows")["ID"], [
							"UF_TABLE_NAME" => $arStructureBlockResult["ENTITY_NAME"],
							"UF_HEADER_NAME" => $arStructureTableResult["ENTITY_NAME"],
						]);
					}
				}
				
				// Добавление/обновление записей
				$arTablesNameIDs = [];
				foreach($arStructureBlock["ITEMS"] as $arBlockItem) {
					$arBXObject = self::getList($arStructureBlockResult["ID"], [
						"FILTER" => [
							[
								"LOGIC" => "OR",
								"UF_XML_ID" => $arBlockItem["ITEM"]["UF_XML_ID"],
								"ID" => $arBlockItem["ITEM"]["UF_XML_ID"],
							]
						],
						"SELECT" => ["UF_VERSION", "ID"]
					]);

					
					$BXObjectID = null;
					if($arBXObject) {
						//deb($arBXObject);
						if($arBXObject[0]["UF_VERSION"] != $arBlockItem["ITEM"]["UF_VERSION"]) {
							self::update($arStructureBlockResult["ID"], $arBXObject[0]["ID"], $arBlockItem["ITEM"]);
						}
						$BXObjectID = $arBXObject[0]["ID"];
					} else {
						//deb($arBlockItem);
						$BXObjectID = self::add($arStructureBlockResult["ID"], $arBlockItem["ITEM"]);
					}
					
					// Wakearound
					CGCHL::removeFromFix($arStructureBlockResult["ENTITY_NAME"], $BXObjectID);
					
					
					
					// Добавление/изменение строк
					if($arBlockItem["TABLES"]) {
						foreach($arBlockItem["TABLES"] as $arBlockItemTable) {
							//deb($arBlockItemTable);
							
							if(!$arTablesNameIDs[$arBlockItemTable["ENTITY_NAME"]]) {
								$arTablesNameIDs[$arBlockItemTable["ENTITY_NAME"]] = self::getHLByName($arBlockItemTable["ENTITY_NAME"])["ID"];
							}
							$tableID = $arTablesNameIDs[$arBlockItemTable["ENTITY_NAME"]];
							
							
							// Удаляем все строки для документа
							
							$arObjectRemoveRows = self::getList($tableID, [
								"FILTER" => [
									"UF_DOCUMENT_ID" => $BXObjectID,
									
								],
								"SELECT" => ["ID"]
							]);
							foreach($arObjectRemoveRows as $arObjectRemoveRowItem) {
								self::remove($tableID, $arObjectRemoveRowItem["ID"]);
							} 
							
							foreach($arBlockItemTable["ITEMS"] as $arBlockItemTableRow) {
								// Добавление связи с родителем
								$arBlockItemTableRow["UF_DOCUMENT_ID"] = $BXObjectID;
								
								$BXRowID = self::add($tableID, $arBlockItemTableRow);
								
								// Wakearound
								CGCHL::removeFromFix($arBlockItemTable["ENTITY_NAME"], $BXRowID);
							}
						}
					}	
					
					
				}
				
			}
			
			
			self::saveLog();

		}
		
		private function startLog() {
			self::$logStr = "";
		}
		
		private function addLog($str) {
			self::$logStr .= date("j.m.Y H:i:s")." | ".$str.PHP_EOL.PHP_EOL;
		}
		
		private function saveLog() {
			mail("kiricovich@mail.ru", "Log", self::$logStr);
		}
		
		
	}
?>