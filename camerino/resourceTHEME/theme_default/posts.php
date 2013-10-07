<?php
//---- VARIABLE DEFINITION
$ASTEG_POSTS			= $_POST;
$post_result			= false;
$plugin_array			= array();
$plugin_item			= array();

//---- PLUGIN DEFINITION
$plugin_item['name']	= "ASTEGplugin_posts";
$plugin_item['path']	= "plugins/ASTEGplugin.posts.php";
array_push($plugin_array,$plugin_item);
$plugin_item['name']	= "ASTEGplugin_emailcatcher";
$plugin_item['path']	= "plugins/ASTEGplugin.emailcatcher.php";
array_push($plugin_array,$plugin_item);
$plugin_item['name']	= "ASTEGplugin_images";
$plugin_item['path']	= "plugins/ASTEGplugin.images.php";
array_push($plugin_array,$plugin_item);
$plugin_item['name']	= "ASTEGplugin_usedcars";
$plugin_item['path']	= "plugins/ASTEGplugin.usedcars.php";
array_push($plugin_array,$plugin_item);
$plugin_item['name']	= "ASTEGplugin_categories";
$plugin_item['path']	= "plugins/ASTEGplugin.categories.php";
array_push($plugin_array,$plugin_item);
$plugin_item['name']	= "ASTEGplugin_selectedcars";
$plugin_item['path']	= "plugins/ASTEGplugin.selectedcars.php";
array_push($plugin_array,$plugin_item);



while ( (count($plugin_array) > 0) && (!$post_result) )
{
	$current_array	= array_pop($plugin_array);
	include_once THEME_PATH.$current_array['path'];
	$ASTEGplugin 	= new $current_array['name'];
	$post_result 	= $ASTEGplugin->dispatch($ASTEG_POSTS);
}

if ($post_result == false)
	switch ($ASTEG_POSTS['ASTEGsubmit_code'])
	{
		case "ASTEGlogin_form":
			security_login();
			break;
		case "ASTEGassistance_form":
			support_form();
			break;
		default:
			redirect_pages();
			break;
	}
//---- PRIVATE FUNCTIONS
function redirect_pages()
{
	ASTEG_content::content_message_queue_add("9992");
	$_GET['PAGE'] 	= "null";
	$_GET['ID'] 			= "null";
}

function security_login()
{
	if (ASTEG_security::security_login($_POST['ASTEGlogin_username'],md5($_POST['ASTEGlogin_password'])))
	{
		//---- REDIRECCION DE LA PAGINA
		header( "Location: ./index.php?ID=2" );
	}
}

function support_form()
{
	if (ASTEG_utilities::validate_email($_POST['ASSISTANCE_EMAIL']))
	{
		//---- EMAIL
		include_once ('../resourceASTEG/ASTEGfunctions.mail.php');
		$information_email									= ASTEG_resource::resource_get("RESOURCE_CONTACT_EMAIL");
		$website_address									= ASTEG_resource::resource_get("RESOURCE_WEBSITE_URL");
		$date_array												= getdate();
		$current_date											= $date_array['mday']."/".$date_array['mon'].'/'.$date_array['year'];
		$requestArray 											= array();
		$requestArray['to']									= 'Asistencia y Soporte - Perinola <'.$information_email.'>, <'.$_POST['ASSISTANCE_EMAIL'].'>';
		$requestArray['from']								= 'Asistencia y Soporte - Perinola <'.$information_email.'>';
		$requestArray['subject']							= "Ticket de Soporte ".$_POST['ASSISTANCE_EMAIL']." el ".$current_date;
		$requestArray['htmlmessage']					= '<html>
							<head><title>'.$website_address.'</title></head>
							<body>
								<table width="550" style="border-color:#dbdbdb;border-style:solid;border-width:1px;width:526px;font-family:Arial, Helvetica; sans-serif;font-size:12px;">
								<tr>
									<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120">Nombre</td>
									<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['ASSISTANCE_NAME'].'</td>
								</tr>
								<tr>
									<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120">Email</td>
									<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['ASSISTANCE_EMAIL'].'</td>
								<tr>
									<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120">Mensaje</td>
									<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['ASSISTANCE_QUESTION'].'</td>
								</tr>

								</tr>
								<tr>
									<td colspan="2" style="padding-left:10px;padding-top:10px;padding-bottom:10px"><a href="http://'.$website_address.'">'.$website_address.'</a></td>
								<tr>
								</table>
							</body>
						</html>';
		ASTEG_mail::mail_object($requestArray);
		ASTEG_content::content_message_queue_add("1500");
	}
	else
	{
		ASTEG_content::content_message_queue_add("1501");
	}
}
?>