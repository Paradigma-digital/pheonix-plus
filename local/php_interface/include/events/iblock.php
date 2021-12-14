<?php
	AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "OnAfterIBlockElementUpdateHandler");
	AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnAfterIBlockElementAddHandler");
	AddEventHandler("iblock", "OnBeforeIBlockElementDelete", "OnBeforeIBlockElementDeleteHandler");
	
	function OnAfterIBlockElementUpdateHandler($arFields) {
		switch($arFields["IBLOCK_ID"]) {
			case "9":
				$dbProduct = CIBlockElement::GetByID($arFields["ID"]);
				$arProduct = $dbProduct->Fetch();
				if(!$arProduct["DETAIL_PICTURE"] && $arProduct["PREVIEW_PICTURE"]) {
					$el = new CIBlockELement;
					$el->Update($arFields["ID"], Array(
						"PREVIEW_PICTURE" => Array("del" => "Y"),
					));
				} else if($arProduct["DETAIL_PICTURE"] && !$arProduct["PREVIEW_PICTURE"]) {
					$arDetailPicture = CFile::GetByID($arProduct["DETAIL_PICTURE"])->Fetch();
					//deb($arDetailPicture);
					
					$arPreviewPicture = CGCHelper::resizeImage($arProduct["DETAIL_PICTURE"], "400", "400");
					
					$arPicture = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$arPreviewPicture["SRC"]);
					$arPicture["description"] = $arDetailPicture["DESCRIPTION"];
					//deb($arPicture);
					
					$el = new CIBlockELement;
					$el->Update($arFields["ID"], Array(
						"PREVIEW_PICTURE" => $arPicture,
					));
				}
				
				CGCCatalog::generateCustomPicture($arFields);
				
			break;
		}
	}
	
	function OnAfterIBlockElementAddHandler($arFields) {
		switch($arFields["IBLOCK_ID"]) {
			case "9":
				CGCCatalog::generateCustomPicture($arFields);
			break;
		}
	}
	
	function OnBeforeIBlockElementDeleteHandler($id) {
		CGCCatalog::deleteCustomPicture($id);
	}
?>