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

function camerino_googleanalytics()
{
	include_once (THEME_PATH."plugins/ASTEGplugin.users.php");
	$user_class		= new ASTEGplugin_users();

	include_once ("../resourcePLUGINS/gapi.class.php");
	$objResponse = new xajaxResponse();

	//---- DATE
	$date_array		= ASTEG_utilities::utilities_padded_date_array(getdate());
	$date_beginning = $date_array['year']."-".$date_array['month']."-01";
	$date_end			= $date_array['year']."-".$date_array['month']."-".$date_array['day'];

	//---- GOOGLE ANALYTICS
	$analytics_count 				= "0000";
	$analytics_report 				= $user_class->users_get_analytics_ID();
	$analytics_username		= 'camerino.analytics@gmail.com';
	$analytics_password		= 'ANALYTICS321';

	$ga = new gapi($analytics_username,$analytics_password);
	$ga->requestReportData($analytics_report,array('browser'),array('newVisits','visits'),NULL,NULL,$date_beginning,$date_end);
	$newVisits			=	$ga->getMetrics();
	$analytics_count = str_pad($newVisits['visits'],4,"0",STR_PAD_LEFT);

	$content ="<h3>".$analytics_count."</h3><h4>Visitas este Mes</h4><br/><small>Actualizado el: ".ASTEG_utilities::utilities_padded_date(getdate())."</small><br />";


	$objResponse->assign("xajax_camerino_googleanalytics","innerHTML", $content);
	return $objResponse;
}

function posts_display($current_ID)
{
	$objResponse 						= new xajaxResponse();
	include_once THEME_PATH."plugins/ASTEGplugin.posts.php";
	$ASTEGplugin				 		= new ASTEGplugin_posts();
	$return_result							= $ASTEGplugin->plugin_read($current_ID);
	$objResponse->setReturnValue($return_result);
	return $objResponse;
}

?>