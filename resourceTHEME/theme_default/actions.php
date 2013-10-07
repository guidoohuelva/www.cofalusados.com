<?php
//---- POST SERVICES HERE
$ASTEG_ACTION	= $_GET['ACTION'];

switch ($ASTEG_ACTION)
{
	case "<ACTION>":
		function_demo();
		break;		
	default:
		redirect_pages();
		break;
}

//---- PRIVATE FUNCTIONS
function function_demo()
{
	return "hello world";	
}


function redirect_pages()
{
	ASTEG_content::content_message_queue_add("9992");
	$_GET['PAGE'] 	= "null";
	$_GET['ID'] 		= "null";
}


?>