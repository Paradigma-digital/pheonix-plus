<?php
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	IncludeTemplateLangFile(__FILE__);
	
	global $USER;
	$defArPageParams = Array(
		"IS_HOME" => ($APPLICATION->GetCurDir() == SITE_DIR) ? "Y" : "N",
		"BODY_CLASS" => "",
		"DISPLAY_INTRO" => "N",
	);
	if(isset($arPageParams)) {
		$arPageParams = array_merge($defArPageParams, $arPageParams);
	} else {
		$arPageParams = $defArPageParams;
	}
?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_ID ?>">
<head>
	<meta charset="<?php echo SITE_CHARSET; ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <?php
		$APPLICATION->ShowMeta("keywords");
		$APPLICATION->ShowMeta("description");
		$APPLICATION->ShowMeta("robots");
	?>    
    <title><?php $APPLICATION->ShowTitle(); ?></title>
    
	<link rel="icon" href="<?php echo SITE_DIR; ?>favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/png" href="<?php echo SITE_DIR; ?>favicon.png" />
 
	<?php
		$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap.min.css");
		$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/wiki.css");
		$APPLICATION->ShowCSS();
	?>
	
	<?php //*******/* !JavaScript  */*******//
		$APPLICATION->ShowHead();
    ?>
</head>
<body class="<?php echo $arPageParams["BODY_CLASS2"]; ?>">
	<?php $APPLICATION->ShowPanel(); ?>

	<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
		<p class="h5 my-0 me-md-auto fw-normal"><a href="/wiki/">База знаний Феникс+</a></p>
	</header>
	
	<main class="container">
		<?$APPLICATION->IncludeComponent(
			"bitrix:breadcrumb",
			"",
			Array(
				"PATH" => "",
				"SITE_ID" => "s1",
				"START_FROM" => "2"
			)
		);?>