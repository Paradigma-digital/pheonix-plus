<?php

//use Bitrix\Main\EventManager;
//$eventManager = EventManager::getInstance();
//
////ajax post requests without notice
//class licenseClass
//{
//	public static function DeleteTopNotice(&$content)
//	{
//		if (strpos($content, '</font></font>') !== false)
//		{
//			$content = explode('</font></font>', $content);
//			$content = $content[1];
//		}
//	}
//}
//
//$eventManager->addEventHandler(
//    'main',
//    'OnEndBufferContent',
//    array('licenseClass', 'DeleteTopNotice')
//);