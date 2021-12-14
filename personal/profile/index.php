<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Личный кабинет (Вход|Регистрация)");
$APPLICATION->SetPageProperty("keywords", "Личный кабинет, партнеры, оптовые поставки канцтоваров");
$APPLICATION->SetPageProperty("title", "Личный кабинет (Вход|Регистрация)");

	CGCUser::loginIfNotAuth($USER);

	$isUserBusiness = CGCUser::isUserBusiness([
		"ID" => $USER->GetID()
	]);

	if($isUserBusiness) {
		$APPLICATION->SetTitle("Личный кабинет партнера");
	} else {
		$APPLICATION->SetTitle("Личный кабинет покупателя");
	}
	
?>

<?php

	$arUserInfo = CGCUser::getUserInfo([
		"ID" => $USER->GetID()
	]);
	if(!$arUserInfo["UF_PROFILE_COMPLETE"] && 0):
?>
	<div class="page-text">
		<blockquote>
			<div class="row">
				<div class="col col--28 col--left">
					<a href="/personal/partner/" class="btn btn--blue">Стать партнером</a>
				</div>
				<div class="col col--70 col--right">
					Заполните профиль партнера, чтобы получить доступ к ценам и преимущества программ лояльности
				</div>
			</div>
		</blockquote>
		<br />
	</div>
<?php endif; ?>

<?php
	$APPLICATION->IncludeComponent(
		"bitrix:main.profile",
		"simple",
		Array(
			"CHECK_RIGHTS" => "N",
			"SEND_INFO" => "N",
			"SET_TITLE" => "N",
			"USER_PROPERTY" => array("UF_SUBSCRIBE_PARTNER"),
			"USER_PROPERTY_NAME" => "",
			"USER_TYPE" => ($isUserBusiness ? "BUSINESS" : "SIMPLE"),
		)
); ?>
<?php
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>