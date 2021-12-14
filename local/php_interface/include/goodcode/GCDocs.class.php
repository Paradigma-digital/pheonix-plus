<?php
class GCDocs {
	function getProducts($arParams) {
		if($arParams["ACT_ID"]) {
			$arProducts = self::getActProducts([
				"ACT_ID" => $arParams["ACT_ID"]
			]);
		} else {
			$arProducts = self::getUPDProducts([
				"UPD_ID" => $arParams["UPD_ID"]
			]);
		}
		
		return $arProducts;
		
		//deb($arProducts);
		
	}
	
	
	
	function getRefund($arParams) {
		$arRefunds = CGCHL::getList(CGCHL::getHLByName("Zayavkanavozvrat")["ID"], [
			"FILTER" => [
				"UF_DOKUMENTOSNOVANI" => $arParams["ORDER_ID"],
			],
			"SELECT" => ["ID", "UF_*"]
		]);
		return $arRefund[0];
	}

	
	
	
	
	function getUPD($arParams) {
		$arUPDs = CGCHL::getList(CGCHL::getHLByName("Realizatsiyatovarovuslug")["ID"], [
			"FILTER" => [
				"UF_ZAKAZPOKUPATELYA" => $arParams["ORDER_ID"],
				"UF_PROVEDEN" => "1",
			],
			"SELECT" => ["ID", "UF_*"]
		]);
		
		foreach($arUPDs as &$arUpdItem) {
			$arUpdItem["ACT"] = CGCHL::getList(CGCHL::getHLByName("Aktpokupatelya")["ID"], [
				"FILTER" => [
					"UF_DOKUMENTOSNOVANI" => $arUpdItem["UF_XML_ID"],
				],
				"SELECT" => ["ID", "UF_*"]
			]);
			if($arUpdItem["ACT"]) {
				$arUpdItem["ACT"] = $arUpdItem["ACT"][0];
			}
		}
		unset($arUpdItem);
		
		//deb($arUPDs);
		return $arUPDs;
	}
	
	function getUPDInfo($arParams) {
		$arUPD = CGCHL::getList(CGCHL::getHLByName("Realizatsiyatovarovuslug")["ID"], [
			"FILTER" => [
				"ID" => $arParams["ID"],
			],
			"SELECT" => ["ID", "UF_*"]
		]);
		if($arUPD) {
			$arUPD = $arUPD[0];
			
			$arUPD["ACT"] = CGCHL::getList(CGCHL::getHLByName("Aktpokupatelya")["ID"], [
				"FILTER" => [
					"UF_DOKUMENTOSNOVANI" => $arUPD["UF_XML_ID"],
				],
				"SELECT" => ["ID", "UF_*"]
			]);
			if($arUPD["ACT"]) {
				$arUPD["ACT"] = $arUPD["ACT"][0];
				if($arUPD["ACT"]["UF_DATASOZDANIYA"]) {
					$arUPD["ACT"]["UF_DATA"] = $arUPD["ACT"]["UF_DATASOZDANIYA"]->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "DD.MM.YYYY")));
				}
				if($arUPD["ACT"]["UF_STATUS"] == "КИсполнению") {
					$arUPD["ACT"]["UF_STATUS"] = "В обработке";
				}
				
			} else {
				$arUPD["ACT"] = false;
			}
		}
		if($arUPD["UF_DATA"]) {
			$arUPD["UF_DATA"] = $arUPD["UF_DATA"]->toString(new \Bitrix\Main\Context\Culture(array("FORMAT_DATETIME" => "DD.MM.YYYY")));
		}
		
		
		return $arUPD;
	}
	
	function getUPDProducts($arParams) {
		$arTmpProducts = CGCHL::getList(CGCHL::getHLByName("Realizatsiyatovarovuslugtovary")["ID"], [
			"FILTER" => [
				"UF_DOCUMENT_ID" => $arParams["UPD_ID"],
			],
			"SELECT" => ["ID", "UF_*"]
		]);
		$arProducts = [];
		foreach($arTmpProducts as &$arTmpProduct) {
			$arTmpProduct["PRODUCT"] = CGCCatalog::getProductInfoByXML($arTmpProduct["UF_NOMENKLATURA"]);
			if(!$arTmpProduct["PRODUCT"]) {
				continue;
			}
			if($arTmpProduct["PRODUCT"]["PREVIEW_PICTURE"]) {
				$arTmpProduct["PRODUCT"]["PREVIEW_PICTURE_SRC"] = CFile::GetPath($arTmpProduct["PRODUCT"]["PREVIEW_PICTURE"]);
 			}
 			
 			$arTmpProduct["UF_REAL_QUANTITY"] = $arTmpProduct["UF_KOLICHESTVO"];
 			
			$arProducts[] = $arTmpProduct;
		}
		return $arProducts;
	}
	
	function getActProducts($arParams) {
		$arTmpProducts = CGCHL::getList(CGCHL::getHLByName("Aktpokupatelyatovary")["ID"], [
			"FILTER" => [
				"UF_DOCUMENT_ID" => $arParams["ACT_ID"],
			],
			"SELECT" => ["ID", "UF_*"]
		]);
		$arProducts = [];
		foreach($arTmpProducts as &$arTmpProduct) {
			$arTmpProduct["PRODUCT"] = CGCCatalog::getProductInfoByXML($arTmpProduct["UF_NOMENKLATURA"]);
			if(!$arTmpProduct["PRODUCT"]) {
				continue;
			}
			if($arTmpProduct["PRODUCT"]["PREVIEW_PICTURE"]) {
				$arTmpProduct["PRODUCT"]["PREVIEW_PICTURE_SRC"] = CFile::GetPath($arTmpProduct["PRODUCT"]["PREVIEW_PICTURE"]);
 			}
 			
 			$arTmpProduct["UF_REAL_QUANTITY"] = $arTmpProduct["UF_KOLICHESTVOPODOK"];
 			$arTmpProduct["UF_KOLICHESTVO"] = ($arTmpProduct["UF_KOLICHESTVOPRINY"] ? $arTmpProduct["UF_KOLICHESTVOPRINY"] : 0);
 			
			$arProducts[] = $arTmpProduct;
		}
		return $arProducts;
	}
	
	function isDocExists($arParams) {
		$arDocs = CGCHL::getList(CGCHL::getHLByName("DocReportHeading")["ID"], [
			"FILTER" => [
				"UF_ORDER_ID" => $arParams["ORDER_ID"],
			]
		]);
		if($arDocs) {
			$arDoc = $arDocs[0];
			return $arDoc;
		} else {
			return false;
		}
	}
	
	function addHeading($arParams) {
		return CGCHL::add(CGCHL::getHLByName("DocReportHeading")["ID"], $arParams);
	}
	
	function exportItems($hlName) {
		CModule::IncludeModule("highloadblock");
		
		// Получение ID запрашиваемого справочника
		$hlblock = CGCHL::getHLByName($hlName);
		if(!$hlblock) {
			return false;
		}
		
		// Получение измененных/добавленных элементов из сервисной таблицы
		$arExportHeadingsIDs = [];
		$arExportHeadings = CGCHL::getList($hlblock["ID"], [
			"FILTER" => [
				"UF_EXPORTED" => false,
			],
			"SELECT" => ["ID", "UF_TITLE", "UF_DATE_CREATE", "UF_ORDER_ID", "UF_DATA"],
		]);
		foreach($arExportHeadings as &$arExportHeading) {
			$arExportHeading["ITEMS"] = CGCHL::getList(CGCHL::getHLByName("BDocRows")["ID"], [
				"SELECT" => ["ID", "UF_*"],
				"FILTER" => [
					"UF_DOCUMENT_ID" => $arExportHeading["ID"]
				]
			]);
			$arExportHeadingsIDs[] = $arExportHeading["ID"];
		}
		
		// Выходной массив
		$arResult = [
			"DATA" => $arExportHeadings,
			"IDS" => $arExportHeadingsIDs,
		];

		return $arResult;
	}
	
	// Формирование XML
	function makeXMLFromTemplate($arItems, $addHeader = true, $addFooter = true, $arParams = []) {		
		$xml = "";
		if($addHeader) {
			$xml .= '<?xml version="1.0" encoding="windows-1251"?>'.PHP_EOL.
						'<КоммерческаяИнформация xmlns="urn:1C.ru:commerceml_3" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '.
						' ВерсияСхемы="3.1" ДатаФормирования="'.date(DATE_ISO8601, time()).'">'.
						'<Акты Имя="'.$arParams["reference_name"].'" СодержитТолькоИзменения="true">';
		}
		
		if($arItems) {
			foreach($arItems as $arItem) {
				$xml .= '<Акт>'.
							'<Ид>'.$arItem["ID"].'</Ид>'.
							'<Заголовок>'.$arItem["UF_TITLE"].'</Заголовок>'.
							'<ИдЗаказа>'.$arItem["UF_ORDER_ID"].'</ИдЗаказа>'.
							'<ДатаСоздания>'.$arItem["UF_DATE_CREATE"].'</ДатаСоздания>';
				
				if($arItem["UF_DATA"]) {
					$arItemData = json_decode($arItem["UF_DATA"], true);
					if($arItemData["ID_1C"]) {
						$xml .= '<Ид1С>'.$arItemData["ID_1C"].'</Ид1С>';
					}
				}
							
				if($arItem["ITEMS"]) {
					$xml .= '<Товары>';
					foreach($arItem["ITEMS"] as $arProduct) {
						$productData = json_decode($arProduct["UF_DATA"], true);
						$xml .= '<Товар>'.
									'<Артикул>'.$productData["ARTICLE"].'</Артикул>'.
									'<Количество>'.$productData["QUANTITY"].'</Количество>';
						if($productData["PRODUCT_XML_ID"]) {
							$xml .= '<Ид>'.$productData["PRODUCT_XML_ID"].'</Ид>';
						}
						$xml .= '</Товар>';
								
					}
					$xml .= '</Товары>';
				}
				$xml .=	'</Акт>';

			}
			unset($arItem);
		}
		
		if($addFooter) {
			$xml .= 	'</Акты>'.
					'</КоммерческаяИнформация>';
		}
				
		return $xml;
	}
}
?>