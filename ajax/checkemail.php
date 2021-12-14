<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$out = array();
$email = htmlspecialchars($_REQUEST['email']);
$us = CUser::GetByLogin($email);
$us = $us->Fetch();

if ($us['ID'] <= 0)
{
	$out['type'] = 'error';
	$out['code'] = 1;
}
elseif ($us['ACTIVE'] == 'N')
{
	$out['type'] = 'error';
	$out['code'] = 2;
}
else
{
	$out['type'] = 'success';
}
echo json_encode($out);
exit;