<?php

use Bitrix\Main\EventManager;
$eventManager = EventManager::getInstance();

//ajax post requests without notice
class deleteByTmpClass
{
	public static function Tmp1(&$content)
	{
		$reg = '<article class=\"article\"\>[\ \r\n\t\v]+\<div class=\"article\-content\"\>[\ \r\n\t\v]+\<\/div\>[\ \r\n\t\v]+\<\/article\>';
		
		if (preg_match('/'.$reg.'/ui', $content))
		{
			$content = preg_replace('/'.$reg.'/ui', '', $content);
		}
	}
	
	
}


$eventManager->addEventHandler(
    'main',
    'OnEndBufferContent',
    array('deleteByTmpClass', 'Tmp1')
);