<?php
$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler("", "BAdresaMagazinovOnAfterUpdate", "OnAfterHLUpdateAdd");
$eventManager->addEventHandler("", "BAdresaMagazinovOnAfterAdd", "OnAfterHLUpdateAdd");

// Акты
$eventManager->addEventHandler("", "DocReportHeadingOnAfterUpdate", "OnAfterHLUpdateAdd");
$eventManager->addEventHandler("", "DocReportHeadingOnAfterAdd", "OnAfterHLUpdateAdd");


// Акты
$eventManager->addEventHandler("", "AktpokupatelyaOnAfterUpdate", "OnAfterHLUpdateAdd");
$eventManager->addEventHandler("", "AktpokupatelyaOnAfterAdd", "OnAfterHLUpdateAdd");
 


function OnAfterHLUpdateAdd(\Bitrix\Main\Entity\Event $event) {
	$entity = $event->getEntity();
	$tableName = $entity->GetName();
    $result = $event->getParameter("id");
    $elID = ($result["ID"] ? $result["ID"] : $result);

	CGCHL::fixUpdate($tableName, $elID);
}
?>