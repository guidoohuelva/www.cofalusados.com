<?php
class ASTEGplugin_emailcatcher
{
	public $result;
	public function __construct($email_caught)
	{
		$email_result				= 1601;

		if ( !empty($email_caught) && ASTEG_utilities::validate_email($email_caught) )
		{
			$ASTEGdb					= new ASTEG_database();
			$request_array				= array();
			$request_array[query]	= "SELECT COUNT(*) FROM FRAMEWORK_EMAILCATCHER WHERE FRAMEWORK_EMAIL = '$email_caught' ";
			$result_array					= $ASTEGdb->database_advanced_query($request_array);
			if ($result_array[0][field0] == 0)
			{
				$request_array															= array();
				$request_array[FRAMEWORK_EMAIL]			= $email_caught;
				$request_array[FRAMEWORK_DATETIME]		= ASTEG_utilities::utilities_mysql_datetime();
				$result_array																= $ASTEGdb->database_create("FRAMEWORK_EMAILCATCHER",$request_array);
				$email_result																= 1600;
			}
		}

		$this->result		= $email_result;
	}

}
//---- INSERT INTO POST
/*
function email_catcher()
{
	include_once (THEME_PATH.'./plugins/ASTEGplugins.emailcatcher.php');
	$ASTEGemail_catcher			= new ASTEGplugin_emailcatcher($_POST[EMAILCATCHER_EMAIL]);
	ASTEG_content::content_message_queue_add($ASTEGemail_catcher->result);
}
*/
//---- INSERT INTO MESSAGES
/*
$ASTEG_MESSAGE_ARRAY[1600] = "Email Ingresado";
$ASTEG_MESSAGE_ARRAY[1601] = "Email Duplicado o Vacio, intente de nuevo";
*/
