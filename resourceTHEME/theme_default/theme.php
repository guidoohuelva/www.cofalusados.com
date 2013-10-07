<?php
/*---- THEME SETTINGS ----*/

//--- CONSTANT DEFINITION
	DEFINE("THEME_PATH",ASTEG_resource::resource_get('RESOURCE_THEME_URL'));

//---- ASTEGconsultores: XAJAX Initialization
	include_once (THEME_PATH."javascript.php");
	$xajax = new xajax();
	$xajax->register(XAJAX_FUNCTION, 'ajax_debug');
	$xajax->processRequest();
?>