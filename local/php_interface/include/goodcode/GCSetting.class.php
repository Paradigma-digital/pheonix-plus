<?php
	class CGCSetting {
		public static function get($name) {
			$settings = CGCHL::getList(CGCHL::getHLByName("settings")["ID"], [
				"FILTER" => [
					"UF_NAME" => $name
				],
				"SELECT" => ["*"]
			]);
			if($settings && $settings[0]) {
				return $settings[0]["UF_VALUE"];
			}
			
			return false;
		}
	}
?>