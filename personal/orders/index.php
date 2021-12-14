<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

CGCUser::loginIfNotAuth($USER);

$APPLICATION->SetTitle("Заказы");
?>

<?php
	$isUserBusiness = CGCUser::isUserBusiness([
		"ID" => $USER->GetID()
	]);
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

<?
	$_REQUEST["show_all"] = "Y";
	$_REQUEST["show_canceled"] = "Y";
	$_REQUEST["filter_date_from"] = "01.01.2019";
	$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.list",
	"orders",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ALLOW_INNER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DEFAULT_SORT" => "DATE_INSERT",
		"DISALLOW_CANCEL" => "N",
		"HISTORIC_STATUSES" => array("F"),
		"ID" => $ID,
		"NAV_TEMPLATE" => "",
		"ONLY_INNER_FULL" => "N",
		"ORDERS_PER_PAGE" => "10",
		"PATH_TO_BASKET" => "/cart/?recalc=Y",
		"PATH_TO_CANCEL" => "",
		"PATH_TO_CATALOG" => "/catalog/",
		"PATH_TO_COPY" => "",
		"PATH_TO_DETAIL" => "/personal/orders/#ID#/",
		"PATH_TO_PAYMENT" => "/personal/orders/payment.php",
		"REFRESH_PRICES" => "N",
		"RESTRICT_CHANGE_PAYSYSTEM" => array("0"),
		"SAVE_IN_SESSION" => "Y",
		"SET_TITLE" => "N",
		"STATUS_COLOR_F" => "gray",
		"STATUS_COLOR_N" => "green",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
		"USER_TYPE" => CGCUser::getUserType([
			"ID" => $USER->GetID()
		])
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>