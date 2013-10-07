<?php
$allowed_array		= array('ACTION'=>'plain');
$get_array				= array();
$action_result			= false;

//---- CLEANUP GET
$get_array				= ASTEG_security::sanitize_array($_GET,$allowed_array);
$ASTEG_ACTION	= $get_array['ACTION'];
if ($action_result == false)
	switch ($ASTEG_ACTION)
	{
		case "logout":
			security_logout();
			break;
	}
//---- PRIVATE FUNCTIONS
function security_logout()
{
	ASTEG_security::security_logout();
	header( "Location: ./index.php");
}
?>