<?php
	class CGCCatalog {
		function OnProductUpdateHandler($id, $arFields) {
			deb($arFields); die;
		}

		function getProductInfoByArticle($code) {
			$dbProduct = CIBlockElement::GetList(
				false,
				Array(
					"IBLOCK_ID" => "9",
					"PROPERTY_CML2_ARTICLE" => $code
				),
				false,
				Array(
					"nTopCount" => "1"
				),
				Array(
					"ID", "NAME", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "ACTIVE", "PREVIEW_PICTURE"
				)
			);
			$arProduct = $dbProduct->GetNext();
			
			return ($arProduct ? $arProduct : null);
		}
		
		function getProductInfoByCode($code) {
			$dbProduct = CIBlockElement::GetList(
				false,
				Array(
					"IBLOCK_ID" => "9",
					"PROPERTY_CML2_TRAITS" => Array($code)
				),
				false,
				Array(
					"nTopCount" => "1"
				),
				Array(
					"ID", "NAME", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "PREVIEW_PICTURE", "PROPERTY_CML2_ARTICLE"
				)
			);
			$arProduct = $dbProduct->GetNext();
			
			return ($arProduct ? $arProduct : null);
		}
		
		function getProductInfoByXML($xmlID) {
			$dbProduct = CIBlockElement::GetList(
				false,
				Array(
					"IBLOCK_ID" => "9",
					"XML_ID" => $xmlID
				),
				false,
				Array(
					"nTopCount" => "1"
				),
				Array(
					"ID", "NAME", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "PREVIEW_PICTURE", "PROPERTY_CML2_ARTICLE"
				)
			);
			$arProduct = $dbProduct->GetNext();
			
			return ($arProduct ? $arProduct : null);
		}
		
		function getProductDiscount(&$arProduct) {
			if($arProduct["PROPERTIES"]["FIXED_PRICE"]["VALUE"]) {
				$arProduct["MIN_PRICE"]["DISCOUNT_DIFF"] = "Y";
				
				//$arProduct["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"] = $arProduct["MIN_PRICE"]["PRINT_VALUE"];
				
				$arProduct["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"] = CurrencyFormat($arProduct["PROPERTIES"]["FIXED_PRICE"]["VALUE"], $arProduct["MIN_PRICE"]["CURRENCY"]);
				
				$arProduct["MIN_PRICE"]["SIMPLE_DISCOUNT"] = "Y";
				
			} else if($arProduct["PROPERTIES"]["SKIDKA"]["VALUE"]) {
				$arProduct["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"] = $arProduct["PROPERTIES"]["SKIDKA"]["VALUE"];
				$arProduct["MIN_PRICE"]["DISCOUNT_DIFF"] = "Y";
				$arProduct["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"] = $arProduct["MIN_PRICE"]["PRINT_VALUE"];
				
				$precision = 0;
				global $USER;
				if(CGCUser::isUserBusiness(["ID" => $USER->GetID()])) {
					$precision = 1;
				}

				
				if($precision == 1) {
					$arProduct["MIN_PRICE"]["VALUE"] = round($arProduct["MIN_PRICE"]["VALUE"] / (1 - $arProduct["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"] / 100), $precision);
				} else {
					$arProduct["MIN_PRICE"]["VALUE"] = ceil($arProduct["MIN_PRICE"]["VALUE"] / (1 - $arProduct["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"] / 100));
				}
				
				$arProduct["MIN_PRICE"]["PRINT_VALUE"] = CurrencyFormat($arProduct["MIN_PRICE"]["VALUE"], $arProduct["MIN_PRICE"]["CURRENCY"]);
				$arProduct["MIN_PRICE"]["SIMPLE_DISCOUNT"] = "Y";
				//deb($arProduct['MIN_PRICE']); die;
			}
		}
		
		
		function generateCustomPicture($arFields) {
			if($arFields["ID"]) {
				$arElement = CGCHelper::getIBlockElements([
					"FILTER" => [
						"IBLOCK_ID" => $arFields["IBLOCK_ID"],
						"ID" => $arFields["ID"]
					],
					"NAV" => [
						"nTopCount" => "1"
					],
					"SELECT" => [
						"ID", "NAME", "DETAIL_PICTURE"
					]
				]);
				if($arElement) {
					$arElement = $arElement[0];
					if($arElement["DETAIL_PICTURE"]) {
						$arElementPicture = CFile::GetFileArray($arElement["DETAIL_PICTURE"]);
						CFile::CopyFile($arElement["DETAIL_PICTURE"], false, "products/".$arElementPicture["ORIGINAL_NAME"]);
					}
					
					$arPhotos = CGCHelper::getIBlockProperty([
						"IBLOCK_ID" => $arFields["IBLOCK_ID"],
						"ID" => $arFields["ID"],
						"FILTER" => [
							"CODE" => "MORE_PHOTO",
						]
					]);
					foreach($arPhotos as $arPhotoItem) {
						$arPhotoItemPicture = CFile::GetFileArray($arPhotoItem["VALUE"]);
						CFile::CopyFile($arPhotoItem["VALUE"], false, "products/".$arPhotoItemPicture["ORIGINAL_NAME"]);
					}
					//deb($arPhotos); die;
				}
			}
		}
		
		function deleteCustomPicture($id) {
			if($id) {
				$arElement = CGCHelper::getIBlockElements([
					"FILTER" => [
						"ID" => $id
					],
					"NAV" => [
						"nTopCount" => "1"
					],
					"SELECT" => [
						"ID", "NAME", "DETAIL_PICTURE", "IBLOCK_ID"
					]
				]);
				if($arElement) {
					$arElement = $arElement[0];
					if($arElement["IBLOCK_ID"] == "9" && $arElement["DETAIL_PICTURE"]) {
						$arElementPicture = CFile::GetFileArray($arElement["DETAIL_PICTURE"]);
						unlink($_SERVER["DOCUMENT_ROOT"]."/upload/products/".$arElementPicture["FILE_NAME"]);
					}
				}
			}
		}
		
		
		function updateUserBasket($userID) {
			
			// Получаем товары юзера
			$arUserCart = [];
			$dbUserCart = CSaleBasket::GetList(
				[
					"NAME" => "ASC",
					"ID" => "ASC",
				], [
					"FUSER_ID" => CSaleBasket::GetBasketUserID(),
					"LID" => SITE_ID,
					"ORDER_ID" => "NULL",
					"DELAY" => "N",
					"CAN_BUY" => "Y",
				],
				false, false, [
					"PRODUCT_ID", "ID", "NAME", "QUANTITY",
				]
			);
			while($arUserCartItem = $dbUserCart->Fetch()) {
				$arUserCart[$arUserCartItem["PRODUCT_ID"]] = $arUserCartItem["QUANTITY"];
			}
			
			if(!$arUserCart) {
				return false;
			}
			
			// Очищаем корзину
			CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
			
			// Проверка НДС пользователя
			$arUserSale = CGCUser::getSaleInfo($userID);
			$arBasketParams = [];
			if($arUserSale["NDS"]["TYPE"] == "OVER") {
				$arBasketParams["PRODUCT_PROVIDER_CLASS"] = "CCatalogPhoenixProductProvider";
				$arBasketParams["CUSTOM_PRICE"] = "Y";
			}
			
			// Добавление товаров в корзину
			foreach($arUserCart as $productID => $productQuantity) {
				Add2BasketByProductID($productID, $productQuantity, $arBasketParams, []);	
			}
			
			// Обновление параметра
			$user = new CUser;
			$user->Update($userID, [
				"UF_UPDATE_BASKET" => "N",
			]);
		}
		
		
		
		function getBasketCount() {
			$result = \Bitrix\Sale\Internals\BasketTable::getList(array(
			    'filter' => array(
			        'FUSER_ID' => Bitrix\Sale\Fuser::getId(), 
			        'ORDER_ID' => null,
			        'LID' => SITE_ID,
			        'CAN_BUY' => 'Y',
			    ),
			    'select' => array('BASKET_COUNT', 'BASKET_SUM'),
			    'runtime' => array(
			        new \Bitrix\Main\Entity\ExpressionField('BASKET_COUNT', 'SUM(QUANTITY)'),
			        new \Bitrix\Main\Entity\ExpressionField('BASKET_SUM', 'SUM(PRICE*QUANTITY)'),
			    )
			))->fetch();
			return (int)$result["BASKET_COUNT"];
			
			
			//return CSaleBasket::GetList(false, ["FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"], [], false, ['ID']);
		}
		
		
		
		function checkCart($userID) {
			// Результирующий массив
			$arResult = [
				"ITEMS" => [],
				"ERRORS" => 0,
			];
			
			// Получаем товары юзера
			$arUserCart = [];
			$dbUserCart = CSaleBasket::GetList(
				[
					"NAME" => "ASC",
					"ID" => "ASC",
				], [
					"FUSER_ID" => CSaleBasket::GetBasketUserID(),
					"LID" => SITE_ID,
					"ORDER_ID" => "NULL",
					"DELAY" => "N",
					"CAN_BUY" => "Y",
				],
				false, false, [
					"PRODUCT_ID", "ID", "NAME", "QUANTITY",
				]
			);
			while($arUserCartItem = $dbUserCart->Fetch()) {
				$arBxProduct = CCatalogProduct::GetByID($arUserCartItem["PRODUCT_ID"]);
				if($arUserCartItem["QUANTITY"] > $arBxProduct["QUANTITY"]) {
					$arResult["ITEMS"][$arBxProduct["ID"]] = $arBxProduct["QUANTITY"];
					$arResult["ERRORS"]++;
				}
			}
			
			//deb($arResult); die;
			
			return $arResult;
		}
		
		
		function isOldBasket($userID) {
			if(!$userID) {
				return false;
			}
			
			$checkInterval = (12 * 60 * 60);
			//$checkInterval = (60);
			$maxCartDate = false;
			$dbUserCart = CSaleBasket::GetList(
				[
					"NAME" => "ASC",
					"ID" => "ASC",
				], [
					"FUSER_ID" => CSaleBasket::GetBasketUserID(),
					"LID" => SITE_ID,
					"ORDER_ID" => "NULL",
					"DELAY" => "N",
					"CAN_BUY" => "Y",
				],
				false, false, [
					"PRODUCT_ID", "ID", "NAME", "QUANTITY", "DATE_UPDATE", "DATE_INSERT",
				]
			);
			while($arUserCartItem = $dbUserCart->Fetch()) {
				if($arUserCartItem["DATE_UPDATE"]->getTimestamp() > $maxCartDate) {
					$maxCartDate = $arUserCartItem["DATE_UPDATE"]->getTimestamp();
				}
			}
			
			if(!$maxCartDate) {
				return false;
			}

			if(time() - $maxCartDate >= $checkInterval) {
				return true;
			} else {
				return false;
			}
			
			return false;
		}
		
		
		
		function getOrderProducts($arParams) {
			$obBasket = \Bitrix\Sale\Basket::getList(array('filter' => array('ORDER_ID' => $arParams["ORDER_ID"])));
			$arCart = [];
			while($bItem = $obBasket->Fetch()){
				$arItemProduct = CGCHelper::getIBlockElements([
					"FILTER" => [
						"ID" => $bItem["PRODUCT_ID"],
						"IBLOCK_ID" => "9"
					],
					"SELECT" => [
						"NAME", "PROPERTY_CML2_ARTICLE", "PREVIEW_PICTURE", "DETAIL_PAGE_URL"
					]
				]);
				$arItemProduct = $arItemProduct[0];
				if($arItemProduct["PREVIEW_PICTURE"]) {
					$arItemProduct["PREVIEW_PICTURE_SRC"] = CFile::GetPath($arItemProduct["PREVIEW_PICTURE"]);
				}
				
				$bItem["QUANTITY"] = intval($bItem["QUANTITY"]);
				$bItem["REAL_QUANTITY"] = $bItem["QUANTITY"];
				
				$bItem["PRODUCT"] = $arItemProduct;
				$arCart[] = $bItem;
			}
			return $arCart;
		}
		
		
		
		
	}
	
	
	
	




	CModule::IncludeModule("catalog");
	CModule::IncludeModule("sale");
	
	
	class CCatalogPhoenixProductProvider extends CCatalogProductProvider {
		public static function GetProductData($arParams) {
	    	$arResult = CCatalogProductProvider::GetProductData($arParams);
	    	$arResult["VAT_INCLUDED"] = "N";

	    	return $arResult;
	        
	    }
		public static function OrderProduct($arParams) {
	    	$arResult = CCatalogProductProvider::GetProductData($arParams);
	    	$arResult["VAT_INCLUDED"] = "N";

	    	return $arResult;
	        
	    }
	}
	

	
	class CCatalogPhoenixProductActionProvider extends CCatalogProductProvider {
		public static function GetProductData($arParams) {
	    	$arResult = CCatalogProductProvider::GetProductData($arParams);
	    	
	    	$arCustomPrice = CIBlockElement::GetProperty(9, $arParams["PRODUCT_ID"], array("sort" => "asc"), Array("CODE"=>"FIXED_PRICE"))->Fetch();
	    	if($arCustomPrice) {
		    	$arResult["PRICE"] = $arCustomPrice["VALUE"];
		    	$arResult["BASE_PRICE"] = $arCustomPrice["VALUE"];
	    	}

	    	return $arResult;
	        
	    }
		public static function OrderProduct($arParams) {
	    	$arResult = CCatalogProductProvider::GetProductData($arParams);

	    	$arCustomPrice = CIBlockElement::GetProperty(9, $arParams["PRODUCT_ID"], array("sort" => "asc"), Array("CODE"=>"FIXED_PRICE"))->Fetch();
	    	if($arCustomPrice) {
		    	$arResult["PRICE"] = $arCustomPrice["VALUE"];
		    	$arResult["BASE_PRICE"] = $arCustomPrice["VALUE"];
	    	}

	    	return $arResult;
	        
	    }
	}
	
	

	class CCatalogPhoenixGiftProvider extends CCatalogProductProvider {
		public static function GetProductData($arParams) {
	    	$arResult = CCatalogProductProvider::GetProductData($arParams);
	    	
	    	global $USER;
	    	if($USER->GetID()) {
		    	$arResult["DISCOUNT_PRICE"] = $arResult["PRICE"];
	    	} else {
		    	$arResult["DISCOUNT_PRICE"] = 0;
	    	}
	    	

	    	return $arResult;
	        
	    }
		public static function OrderProduct($arParams) {
	    	$arResult = CCatalogProductProvider::GetProductData($arParams);
	    	

	    	return $arResult;
	        
	    }
	}
	

?>