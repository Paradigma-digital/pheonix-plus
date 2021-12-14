<?
global $USER;
$isUserBusiness = CGCUser::isUserBusiness([
	"ID" => $USER->GetID()
]);
$aMenuLinks = Array(
	Array(
		"Профиль пользователя", 
		"/personal/profile/", 
		Array(), 
		Array(), 
		"" 
	)
);

$arUserInfo = CGCUser::getUserInfo([
	"ID" => $USER->GetID()
]);

/*
if($arUserInfo["UF_PROFILE_COMPLETE"] && $isUserBusiness) {
	$aMenuLinks[] = Array(
		"Профиль партнера", 
		"/personal/partner/", 
		Array(), 
		Array(), 
		"" 
	);
	$aMenuLinks[] = Array(
		"Мои магазины", 
		"/personal/shops/", 
		Array(), 
		Array(), 
		"" 
	);
}
*/

if($isUserBusiness) {
	$aMenuLinks[] = Array(
		"Профиль партнера", 
		"/personal/partner/", 
		Array(), 
		Array(), 
		"" 
	);
	$aMenuLinks[] = Array(
		"Мои магазины", 
		"/personal/shops/", 
		Array(), 
		Array(), 
		"" 
	);
}
	

	$arUserSale = CGCUser::getSaleInfo($USER->GetID());	
	if($arUserSale["GROUP"]["GROUP"]) {
		$aMenuLinks[] = Array(
			"Список заказов", 
			"/personal/orders/", 
			Array(), 
			Array(), 
			"" 
		);
	}

if($isUserBusiness) {
	$aMenuLinks[] = Array(
		"Опрос для партнеров", 
		"/personal/poll/", 
		Array(), 
		Array("IS_SIMPLE" => "Y"), 
		"" 
	);
}


?>