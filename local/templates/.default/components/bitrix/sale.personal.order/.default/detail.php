<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//deb($arResult['VARIABLES']['ID']);

$show_order = false;
$order = array();
$id = (int)$arResult['VARIABLES']['ID'];
if (!empty($id) && $id > 0)
{
	CModule::IncludeModule("sale");
	$order = CSaleOrder::GetByID($id);
	
	if ($order['USER_ID'] == $USER->GetID())
	{
		$show_order = true;
	}
}


if ($show_order)
{
	global $APPLICATION;
	$APPLICATION->RestartBuffer();
	?>
	<!DOCTYPE html>
	<html lang="ru">
	  <head>
	    <style type="text/css">
	      a:hover,
	      a:hover > span {
		text-decoration: none !important;
	      }
	      a:hover p {
		text-decoration: underline;
	      } 

	    </style>
	  </head>
	  <body onload="window.print();">
	    <table width="720" align="center" cellspacing="0" cellpadding="0" style="font-family: Arial; font-size: 14px; line-height: 1.2; color: #333; background-color: #FFF; margin: 70px auto;">
	      <tr>
		<td width="100%" style="text-align: center;"><a href="http://<?=$_SERVER['HTTP_HOST']?>/" style="text-decoration: none;"><img src="http://<?=$_SERVER['HTTP_HOST']?>/local/templates/.default/i/logo_main.png"></a></td>
	      </tr>
	      <tr>
		<td width="100%" height="70px"></td>
	      </tr>
	      <tr>
		<td width="100%" style="text-align: center;">
		  <p style="margin: 0; padding: 0; font-size: 20px;"><?=$order['USER_NAME']?>, здравствуйте!</p>
		</td>
	      </tr>
	      <tr>
		<td width="100%" height="40px"></td>
	      </tr>
	      <tr>
		<td width="100%" style="text-align: center;">
		  <p style="margin: 0; padding: 0; font-size: 24px; font-weight: bold; line-height: 30px;">Ваш заказ №<?=$order['ID']?> от <?=$order['DATE_INSERT']?> успешно создан.</p>
		</td>
	      </tr>
	      <tr>
		<td width="100%" height="30px"></td>
	      </tr>
	      <tr>
		<td width="100%" style="text-align: center;">
		  <p style="margin: 0; padding: 0; font-size: 14px; line-height: 16px;">Наш менеджер подготовит необходимую информацию <br>по заказу и свяжется с Вами в ближайшее время.</p>
		</td>
	      </tr>
	      <tr>
		<td width="100%" height="45px"></td>
	      </tr>
	      <tr>
		<td width="100%" style="text-align: center;">
		  <p style="margin: 0; padding: 0; font-size: 20px;">Спасибо!</p>
		</td>
	      </tr>

	      <tr>
		<td width="100%" height="100px"></td>
	      </tr>
	      <tr>
		<td width="100%">
		  <p style="margin: 0; padding: 0; font-size: 14px; line-height: 20px;">По всем вопросам о вашем заказе вы можете обратиться к менеджерам.<br>При обращении назовите номер вашего заказа: <?=$order['ID']?>. Благодарим за заказ!</p>
		</td>
	      </tr>


	      <tr>
		<td width="100%" height="30px"></td>
	      </tr>
	      <tr>
		<td width="100%">
		  <table width="100%">
		    <tr>
		      <td>
			<p style="margin: 0 0 5px 0; padding: 0; font-weight: bold;"><a href="tel:+78632618950" style="text-decoration: none; color: #333; font-size: 14px;">(863) 261-89-50</a></p>
			<p style="margin: 0; padding: 0;">с 10:00 до 18:00</p>
		      </td>
		      <td><a href="mailto:info@phoenixrostov.ru" style="color: #333;">info@phoenixrostov.ru</a></td>
		    </tr>
		  </table>
		</td>
	      </tr>
	      <tr>
		<td width="100%" height="35px"></td>
	      </tr>
	      <tr>
		<td width="100%">
		  <table width="100%">
		    <tr>
		      <td><span style="display: inline-block; vertical-align: middle; margin-right: 5px;">Оставайтесь с нами — </span><a href="#" target="_blank" style="display: inline-block; vertical-align: middle; margin-right: 5px; text-decoration: none;"><img src="http://<?=$_SERVER['HTTP_HOST']?>/local/templates/.default/i/ig.png"></a><a href="#" target="_blank" style="display: inline-block; vertical-align: middle; margin-right: 5px; text-decoration: none;"><img src="http://<?=$_SERVER['HTTP_HOST']?>/local/templates/.default/i/fb.png"></a><a href="#" target="_blank" style="display: inline-block; vertical-align: middle; margin-right: 5px; text-decoration: none;"><img src="http://<?=$_SERVER['HTTP_HOST']?>/local/templates/.default/i/vk.png"></a></td>
		      <td style="text-align: right;"><a href="#"  style="display: inline-block; vertical-align: middle;"><img src="http://<?=$_SERVER['HTTP_HOST']?>/local/templates/.default/i/print.png" style="display: inline-block; vertical-align: middle; margin-right: 15px; text-decoration: none;"><span style="display: inline-block; vertical-align: middle; color: #333; text-decoration: underline;">Распечатать</span></a></td>
		    </tr>
		  </table>
		</td>
	      </tr>
	    </table>
	  </body>
	</html>
	<?
	exit;
}
else
{
	$APPLICATION->SetTitle("");
	?>
	<div class="page-inner page-inner--w1">
		    <div class="page404">
		      <div class="page404-img"><img src="/local/templates/.default/i/404.jpg"></div>
		      <div class="page404-title">Извините страница не найдена или была удалена. <br>Начните, пожалуйста, с главной страницы.</div><a href="/" class="link link--larrow"><span>Перейти на главную</span></a>
		    </div>
	</div>
	<?
}