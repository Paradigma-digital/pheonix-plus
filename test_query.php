<?php
	$arRequest = json_decode(file_get_contents('php://input'), true);
	echo "<pre>"; print_r($arRequest); echo "</pre>"; 
	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; 
?>