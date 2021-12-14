<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @var array $arUrls */
/** @var array $arHeaders */

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Heading
$sheet->setCellValue("A1", "ИД");
$sheet->setCellValue("B1", "Артикул");
$sheet->setCellValue("C1", "Штрихкод");
$sheet->setCellValue("D1", "Наименование");
$sheet->setCellValue("E1", "Цена, руб.");
$sheet->setCellValue("F1", "Количество");
$sheet->setCellValue("G1", "Сумма, руб.");
if($arParams["NDS_INFO"]["BASKET_COL_VAT_RATE"]["DISPLAY"] == "Y") {
	$sheet->setCellValue("H1", $arParams["NDS_INFO"]["BASKET_COL_VAT_RATE"]["TITLE"].", %");
}
if($arParams["NDS_INFO"]["BASKET_COL_VAT_VALUE"]["DISPLAY"] == "Y") {
	$sheet->setCellValue("I1", $arParams["NDS_INFO"]["BASKET_COL_VAT_VALUE"]["TITLE"].", руб.");
}
if($arParams["NDS_INFO"]["BASKET_COL_SUMMARY_VALUE"]["DISPLAY"] == "Y") {
	$sheet->setCellValue("J1", $arParams["NDS_INFO"]["BASKET_COL_SUMMARY_VALUE"]["TITLE"].", руб.");
}

//Content
$lineNum = 1;
foreach($arResult["GRID"]["ROWS"] as $arItem) {
	$dbElement = CIBlockElement::GetList(array(), array('IBLOCK_ID' => iblock_id_catalog, 'ID' => $arItem['PRODUCT_ID'], 'ACTIVE' => 'Y'))->GetNextElement();
	$arElement = $dbElement->GetFields();
	$arElement["PROPERTIES"] = $dbElement->GetProperties();
	
	if(!$arElement) {
		continue;
	}
	
	$lineNum++;
	

	
	$sheet->setCellValue("A".$lineNum, $arElement["ID"]);
	$sheet->setCellValue("B".$lineNum, $arElement["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]);
	$sheet->setCellValue("C".$lineNum, $arElement["PROPERTIES"]["CML2_BAR_CODE"]["VALUE"]);
	$sheet->setCellValue("D".$lineNum, $arElement["NAME"]);
	$sheet->setCellValue("E".$lineNum, $arItem['PRICE']);
	$sheet->setCellValue("F".$lineNum, $arItem['QUANTITY']);
	$sheet->setCellValue("G".$lineNum, $arItem['SUM_VALUE']);
	
	if($arParams["NDS_INFO"]["BASKET_COL_VAT_RATE"]["DISPLAY"] == "Y") {
		$sheet->setCellValue("H".$lineNum, (int)($arItem['VAT_RATE']*100));
	}
	if($arParams["NDS_INFO"]["BASKET_COL_VAT_VALUE"]["DISPLAY"] == "Y") {
		$sheet->setCellValue("I".$lineNum, html_entity_decode($arItem["NDS"]));
	}
	if($arParams["NDS_INFO"]["BASKET_COL_SUMMARY_VALUE"]["DISPLAY"] == "Y") {
		$sheet->setCellValue("J".$lineNum, $arItem["SUM_FULL_PRICE"]);
	}
}

$file = "phoenix__".date("d.m.Y_H.i").".xlsx";

$writer = new Xlsx($spreadsheet);
$writer->save($file);

// define file $mime type here
ob_end_clean(); // this is solution
header('Content-Description: File Transfer');
header('Content-Type: ' . $mime);
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . basename($file) . "\"");
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
readfile($file);
?>
