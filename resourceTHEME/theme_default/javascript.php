<?php
/* 
 * @ASTEGconsultores
 * AJAX-PHP FUNCTIONS
 */

function ajax_debug($content,$div_name)
{
	$objResponse = new xajaxResponse();
	$objResponse->assign($div_name,"innerHTML", $content);
	return $objResponse;
}
?>