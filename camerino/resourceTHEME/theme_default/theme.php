<?php
//---- THEME SETTINGS BEFORE HTML
//---- CONSTANT DEFINITION
	DEFINE("THEME_PATH",ASTEG_resource::resource_get('RESOURCE_THEME_URL'));

	//---- ASTEGconsultores LOCALIZATION
	//---- ASTEGconsultores XAJAX Initialization
	include_once (THEME_PATH."javascript.php");
	$xajax = new xajax();
	$xajax->configure( 'defaultMode', 'synchronous' );
	$xajax->register(XAJAX_FUNCTION, 'camerino_twitter');
	$xajax->register(XAJAX_FUNCTION, 'camerino_googleanalytics');
	$xajax->register(XAJAX_FUNCTION, 'posts_display');
	$xajax->processRequest();
?>