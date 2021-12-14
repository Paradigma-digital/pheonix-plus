<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?$APPLICATION->ShowHead()?>
<title><?$APPLICATION->ShowTitle()?></title>

<meta property="og:type" content="website"/>
<meta property="og:title" content="<?php $APPLICATION->ShowTitle() ?>"/>
<meta property="og:site_name" content="PhoenixPlus"/>
<meta property="og:description" content="<?php echo $APPLICATION->GetProperty("description"); ?>"/>
<meta property="og:url" content="http://<?php echo SITE_SERVER_NAME.$APPLICATION->GetCurDir(); ?>"/>

<link href="/local/templates/.default/i/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
<link href="/local/templates/.default/i/favicon.ico" rel="icon" type="image/x-icon"/>

<?php //$APPLICATION->SetAdditionalCSS("https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;amp;subset=cyrillic-ext"); ?>
<?php $APPLICATION->SetAdditionalCSS("/local/templates/.default/css/plugins/fotorama.css"); ?>
<?php $APPLICATION->SetAdditionalCSS("/local/templates/.default/css/plugins/tooltipster.bundle.min.css"); ?>
<?php $APPLICATION->SetAdditionalCSS("/local/templates/.default/css/plugins/magnific-popup.min.css"); ?>
<?php $APPLICATION->SetAdditionalCSS("/local/templates/.default/css/plugins/slick.css"); ?>
<?php $APPLICATION->SetAdditionalCSS("/local/templates/.default/css/waves.css"); ?>
<?php $APPLICATION->SetAdditionalCSS("/local/templates/.default/css/phoenix.css?v=12-04-19"); ?>
<?php $APPLICATION->SetAdditionalCSS("/local/templates/.default/css/phoenix.responsive.css?v=12-04-19"); ?>
<?php $APPLICATION->SetAdditionalCSS("/local/templates/.default/css/custom.css?v=12-04-19"); ?>
<?php $APPLICATION->SetAdditionalCSS("/local/templates/.default/css/phoenix_2020.css?v=2"); ?>

<?php
	CJSCore::Init(array("ajax", "fx", "popup", "currency"));
?>

<!-- Facebook Pixel Code -->
<script>
 !function(f,b,e,v,n,t,s)
 {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
 n.callMethod.apply(n,arguments):n.queue.push(arguments)};
 if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
 n.queue=[];t=b.createElement(e);t.async=!0;
 t.src=v;s=b.getElementsByTagName(e)[0];
 s.parentNode.insertBefore(t,s)}(window, document,'script',
 'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '509150109662962');
 fbq('track', 'PageView');
</script>
<noscript></noscript>
<!-- End Facebook Pixel Code -->