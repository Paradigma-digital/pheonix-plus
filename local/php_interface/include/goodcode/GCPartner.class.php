<?php
	class GCPartner {
		const COOKIE_NAME = "PARTNER_CODE";
		
		public static function setCode() {
			global $APPLICATION;
			
			if($_REQUEST["CODE"]) {
				$APPLICATION->set_cookie(self::COOKIE_NAME, $_REQUEST["CODE"]);
			}
		}
		
		public static function getCode() {
			global $APPLICATION;
			
			return $APPLICATION->get_cookie(self::COOKIE_NAME);
		}
	}
?>