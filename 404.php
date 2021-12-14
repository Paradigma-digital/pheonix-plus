<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


if (defined('IS_CUSTOM_TEXT_PAGE') && !isset($_GET['add']))
{
	$name = $APPLICATION->GetTitle();
	$code = explode('/', $APPLICATION->GetCurPage());
	if (empty($code[count($code)-1]))
	{
		unset($code[count($code)-1]);
	}
	unset($code[0]);
	$code = str_replace('/', '__', implode('/', $code));
	$code = preg_replace('/[^a-zA-Z0-9_]/', '_', $code);

	$bs = new CIBlockSection;
	$bs->Add(array(
	    'IBLOCK_ID' => 13,
	    'NAME' => $name,
	    'CODE' => $code
	));
	LocalRedirect($APPLICATION->GetCurPage().'?add');
}


$APPLICATION->SetTitle("404 – страница не найдена");

?>
<div class="page-inner page-inner--w1">
            <div class="page404">
              <div class="page404-img"><img src="/local/templates/.default/i/404.jpg"></div>
              <div class="page404-title">Извините страница не найдена или была удалена. <br>Начните, пожалуйста, с главной страницы.</div><a href="/" class="link link--larrow"><span>Перейти на главную</span></a>
            </div>
</div>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>