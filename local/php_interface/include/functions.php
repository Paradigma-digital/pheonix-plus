<?php

function customDetailUrl($url)
{
//    if (preg_match('/^(\/catalog\/[^\/]+\/)([^\/]+\/)*([^\/]+\/)$/ui', $url, $out))
//    {
//	return $out[1].$out[3];
//    }
    return $url;
}

function getCatalogLastChangeDT()
{	
	return file_get_contents(file_CATALOG_UPP);
}
function getCatalogSectLastChangeDT()
{	
	return file_get_contents(file_CATALOG_SECT_UPP);
}
function getBrandsLastChangeDT()
{	
	return file_get_contents(file_BRANDS_UPP);
}
function getBrandsPropCatLastChangeDT()
{	
	return file_get_contents(file_BRANDS_UPP_PROP_CAT);
}
function getUppBrandsSectionLastChangeDT()
{	
	return file_get_contents(file_BRANDS_UPP_SECTS);
}
function getCatalogBrandsSectLastChangeDT()
{	
	return file_get_contents(file_CATALOG_LAST_BRAND_SECT_UPP);
}
function isTestSite()
{
	return in_array($_SERVER['HTTP_HOST'], array(
	    CONST_test_host,
	    'www.'.CONST_test_host
	));
}
function clearDeliveryName($str)
{
	$str = trim(substr($str, 0, strpos($str, '(')));
	
	return $str;
}
function formAddress($arr)
{
	$str = $arr['CITY_TEXT'];
	if (!empty($arr['STREET'])) $str .= ', '.$arr['STREET'];
	if (!empty($arr['HOUSE'])) $str .= ', д.'.$arr['HOUSE'];
	if (!empty($arr['CORP'])) $str .= ', корп.'.$arr['CORP'];
	if (!empty($arr['APARTMENT'])) $str .= ', кв.'.$arr['APARTMENT'];
	
	return $str;
}
function deb($str, $exit = true)
{
	echo '<pre>';
	print_r($str);
	echo '</pre>';
	
	if ($exit)
	{
		exit;
	}
}
function deba($str, $exit = true)
{
	global $USER;
	if ($USER->IsAdmin())
	{
		deb($str, $exit);
	}
}
function debr($str)
{
	global $APPLICATION;
	
	$APPLICATION->RestartBuffer();
	deb($str);
}
function debm($str)
{
	mail('thurinnir@yandex.ru', 'test', serialize(array($str)));
}
function my_ucfirst($string, $e ='utf-8') { 
	if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($string)) { 
	    $string = mb_strtolower($string, $e); 
	    $upper = mb_strtoupper($string, $e); 
	    preg_match('#(.)#us', $upper, $matches); 
	    $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $e), $e); 
	} else { 
	    $string = ucfirst($string); 
	} 
	return $string; 
} 
function getNumEnding($number, $endingArray)
{
    $number = $number % 100;
    if ($number>=11 && $number<=19) {
        $ending=$endingArray[2];
    }
    else {
        $i = $number % 10;
        switch ($i)
        {
            case (1): $ending = $endingArray[0]; break;
            case (2):
            case (3):
            case (4): $ending = $endingArray[1]; break;
            default: $ending=$endingArray[2];
        }
    }
    return $ending;
}
function array_merge_keys(){
    $args = func_get_args();
    $result = array();
    foreach($args as &$array){
        foreach($array as $key=>&$value){
            $result[$key] = $value;
        }
    }
    return $result;
}