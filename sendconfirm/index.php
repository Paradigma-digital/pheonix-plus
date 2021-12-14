<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Феникс – это один из крупнейших производителей канцелярии и товаров для школы в России");
$APPLICATION->SetTitle("Отправка кода подтверждения");
?>

<div class="page-inner page-inner--w2">
	<div class="page-text center">
		<?php
			$userID = $_REQUEST["USER_ID"];
			if($userID) {
				$dbUser = CUser::GetList(($by = "LAST_NAME"), ($order = "desc"), ["ID" => $userID], []);
				$arUser = $dbUser->Fetch();
				//deb($arUser);
				$sended = CEvent::Send("NEW_USER_CONFIRM", "s1", [
					"EMAIL" => $arUser["EMAIL"],
					"USER_ID" => $arUser["ID"],
					"CONFIRM_CODE" => $arUser["CONFIRM_CODE"],
				], "N");
				if($sended) {
					echo "<h3>Письмо с кодом активации отправлено.<br />Проверьте свою почту и перейдите по ссылке из письма.</h3>";
				} else {
					echo "<h3>Ошибка отправки</h3>";
				}
				
			} else {
				echo "<h3>Ошибка</h3>";
			}
		?>
	</div>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>