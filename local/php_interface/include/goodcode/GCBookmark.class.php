<?php
	class СGCBookmark {
		static private $COOKIE_NAME = "FAVORITES";
		
		function addProduct($userType, $productId) {
			//if($userType == "SIMPLE") {
				self::addProductSimple($productId);
			//}
		}

		function addProducts($userType, $arProductsIds) {
			//if($userType == "SIMPLE") {
				self::addProductsSimple($arProductsIds);
			//}
		}
		
		function removeProduct($userType, $productId) {
			//if($userType == "SIMPLE") {
				self::removeProductSimple($productId);
			//}
		}
		
		private static function addProductSimple($productId) {
			$arProducts = self::getFavoritesArray();
			if(!$arProducts) {
				$arProducts = [];
			}
			if(!in_array($productId, $arProducts)) {
				$arProducts[] = $productId;
				self::saveFromArray($arProducts);
			}
		}
		
		private static function addProductsSimple($arProductsIds) {
			$arProducts = self::getFavoritesArray();
			if(!$arProducts) {
				$arProducts = [];
			}
			foreach($arProductsIds as $productId) {
				if(!in_array($productId, $arProducts)) {
					$arProducts[] = $productId;
				}
			}
			self::saveFromArray($arProducts);
		}
		
		private static function removeProductSimple($productId) {
			$arProducts = self::getFavoritesArray();
			if(in_array($productId, $arProducts)) {
				array_splice($arProducts, array_search($productId, $arProducts), 1);
				self::saveFromArray($arProducts);
			}
		}
		
		private static function getFavoritesArray() {
			global $APPLICATION;
			
			$strProducts = $APPLICATION->get_cookie(self::$COOKIE_NAME);
			if($strProducts) {
				return unserialize($strProducts);
			}
			return false;
		}
		
		private static function saveFromArray($arProducts) {
			global $APPLICATION;
			
			$APPLICATION->set_cookie(self::$COOKIE_NAME, serialize($arProducts), time() + 60 * 60 * 24 * 30);
	
	        $application = \Bitrix\Main\Application::getInstance();
	        $context = $application->getContext();
	        $context->getResponse()->flush('');
		}
		
		
		function getFavorites() {
			global $USER;
			$userType = CGCUser::getUserType([
				"ID" => $USER->GetID()
			]);
			
			//if($userType == "SIMPLE") {
				return self::getFavoritesSimple();
			//}
		}
		
		function isProductInFavorites($productId) {
			$arProducts = self::getFavoritesArray();
			if(in_array($productId, $arProducts)) {
				return true;
			}
			return false;
		}
		
		private static function getFavoritesSimple() {
			global $APPLICATION;
			
			$arProducts = [];
			$jsonProducts = $APPLICATION->get_cookie(self::$COOKIE_NAME);
			if($jsonProducts) {
				$arProducts = unserialize($jsonProducts);
			}
			return $arProducts;
		}
		
		
		
		function toBasket($iDs) {
			global $USER;
			$arUserSale = CGCUser::getSaleInfo($USER->GetID());
		
			$arBasketParams = [];
			
			if($arUserSale["NDS"]["TYPE"] == "OVER") {
				$arBasketParams["PRODUCT_PROVIDER_CLASS"] = "CCatalogPhoenixProductProvider";
				$arBasketParams["CUSTOM_PRICE"] = "Y";
			}
			
			foreach($iDs as $id) {
				
				$dbProduct = CIBlockElement::GetList(
					[], 
					['IBLOCK_ID' => iblock_id_catalog, 'ID' => $id], 
					false, 
					false, 
					['ID', 'NAME', 'CODE', 'IBLOCK_ID', 'PROPERTY_CML2_LINK', 'PROPERTY_SIZE', 'CATALOG_QUANTITY', 'DETAIL_PAGE_URL', "PROPERTY_FIXED_PRICE"]
				);
				$arProduct = $dbProduct->GetNext();
				
				if($arProduct["PROPERTY_FIXED_PRICE_VALUE"]) {
					$arBasketParams["PRODUCT_PROVIDER_CLASS"] = "CCatalogPhoenixProductActionProvider";
					$arBasketParams["CUSTOM_PRICE"] = "Y";
				}
				
				echo Add2BasketByProductID($id, 1, $arBasketParams, []);
				
			}

		}
	}
?>