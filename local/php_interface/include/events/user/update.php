<?php

use Bitrix\Main\EventManager;
$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    'main',
    'OnBeforeUserUpdate',
    array('CGCUser', 'sendEmailIfActivated')
);