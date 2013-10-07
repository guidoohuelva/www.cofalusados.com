<?php
//---- POST SERVICES HERE
$ASTEG_POSTS		= 	$_POST;
//---- POST RUTINE MANAGEMENT
switch ($ASTEG_POSTS['ASTEGsubmit_code'])
{
	case "CONTACT_FORM_POST":
		contact_form_submit();
		break;
	case "INFORMATION_FORM_POST":
		information_form_submit();
		break;
	case "FEEDBACK_POST":
		feedback_form_submit();
		break;
	case "SHARE_POST":
		share_form_submit();
		break;
	case "EMAIL_CATCHER":
		email_catcher();
		break;
	case "SOCIAL_QUOTE":
		social_quote();
	default:
		redirect_pages();
		break;
}
//---- PRIVATE FUNCTIONS
function redirect_pages()
{
	ASTEG_content::content_message_queue_add("9992");
	$_GET['PAGE'] 	= "null";
	$_GET['ID'] 	= "null";
}
function email_catcher()
{
    if($_POST['FORM_INPUT'] == ''):
	include_once (THEME_PATH.'./plugins/ASTEGplugins.emailcatcher.php');
	$ASTEGemail_catcher			= new ASTEGplugin_emailcatcher($_POST[EMAILCATCHER_EMAIL]);
	ASTEG_content::content_message_queue_add($ASTEGemail_catcher->result);
    else:
        ASTEG_content::content_message_queue_add("1600");
    endif;
}
function share_form_submit()
{
    if($_POST['FORM_INPUT'] == ''):
	if (ASTEG_utilities::validate_email($_POST['FORM_FRIEND_EMAIL']))
		if (ASTEG_utilities::validate_email($_POST['FORM_EMAIL']))
		{
			include_once ('./resourceASTEG/ASTEGfunctions.mail.php');
			$information_email							= ASTEG_resource::resource_get("RESOURCE_SHAREPERSON_EMAIL");
			$current_date								= date("d/m/Y");
			$current_website							= $_SERVER[HTTP_HOST];
			$requestArray 								= array();
			$requestArray['to']							= $_POST['FORM_FRIEND_NAME'].' <'.$_POST['FORM_FRIEND_EMAIL'].'>, '.$_POST['FORM_NAME'].' <'.$_POST['FORM_EMAIL'].'>';
			$requestArray['from']						= $information_email.' <'.$information_email.'>';
			$requestArray['subject']					= "Un amigo te ha enviado un enlace - ".$_POST['FORM_FRIEND_EMAIL']." - el ".$current_date;
			$requestArray['htmlmessage']				= '<html>
								<head><title>'.$current_website.'</title></head>
								<body style="font-family:Arial, Helvetica; sans-serif;">
									<p><span style="font-size:18px;color:#000;font-weight:bold;">Un amigo quiere que veas un veh&iacute;culo de Cofal Usados</span><p>
									<p><span style="font-size:14px;color:#505050;">Solicita m&aacute;s informaci&oacute;n escribiendo a <b>usados@cofal.com.gt</b>.</span></p>
									<table width="550" style="background-color:#EEE;width:526px;font-size:12px;">
										<tr>
											<td>	
												<table width="550" style="border-color:#dbdbdb;border-style:solid;border-width:1px;width:526px;font-size:12px; font-family:Arial, Helvetica; sans-serif;">
												<tr style="line-height:20px;"><td colspan="2" style="font-size:14px;"><img src="http://'.$current_website.'/userContent/CMS/email_header.jpg" width="550" height="60" style="padding:0px;margin:0px;" /></td></tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>&iquest;Por qu&eacute; recib&iacute; este mensaje?</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">Tu amigo '.$_POST['FORM_NAME'].' te ha compartido un veh&iacute;culo</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Mensaje</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['FORM_DETAIL'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Enlace </b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px"><a href="http://'.$current_website."/".$_POST['FORM_URL'].'">Ver Veh&iacute;culo</a></td>
												</tr>
												<tr style="height:30px;"><td>&nbsp;</td></tr>
												<tr>
													<td colspan="2" style="padding-left:10px;padding-top:10px;padding-bottom:10px"><a href="http://'.$current_website.'">'.$current_website.'</a></td>
												<tr>
												</table>
											</td>
										</tr>
									</table>
									<p style="font-size:11px;color:#505050;">La informaci&oacute;n contenida en este mensaje es privada y confidencial. Si la ha recibido por error, por favor procede a notificarlo al remitente y eliminarlo de tu sistema.</p>
									<p style="font-size:12px;color:#505050;">Atentamente,</p>
									<p style="font-size:12px;color:#505050;">Cofi&ntilde;o Stahl - Usados</p>
									<p style="font-size:11px;color:#505050;">PBX. 1705</p>
									<p style="font-size:11px;color:#505050;">usados@cofal.com.gt</p>
									<p style="font-size:9px;color:#707070;">Custom Site desarrollado por <a href="http://www.grupoperinola.com">Perinola</a></p>
								</body>
							</html>';
			ASTEG_mail::mail_object($requestArray);
			ASTEG_content::content_message_queue_add("1500");
		}
		else
		{
			ASTEG_content::content_message_queue_add("1502");
		}
	else
	{
		ASTEG_content::content_message_queue_add("1501");
	}
        else:
            ASTEG_content::content_message_queue_add("1500");
        endif;
}
function feedback_form_submit()
{
    if($_POST['FORM_INPUT'] == ''):
	if (ASTEG_utilities::validate_email($_POST['FORM_EMAIL']))
		if ( !empty($_POST['FORM_NAME']) )
		{
			include_once ('./resourceASTEG/ASTEGfunctions.mail.php');
			$information_email							= ASTEG_resource::resource_get("RESOURCE_SALEPERSON_EMAIL");
			$current_date								= date("d/m/Y");
			$current_website							= $_SERVER[HTTP_HOST];
			$requestArray 								= array();
			$requestArray['to']							= ' <'.$information_email.'>, '.$_POST['FORM_NAME'].' <'.$_POST['FORM_EMAIL'].'>';
			$requestArray['from']						= $information_email.' <'.$information_email.'>';
			$requestArray['subject']					= "Me Interesa un Vehiculo - Enviado por ".$_POST['FORM_EMAIL']." el ".$current_date;
			$requestArray['htmlmessage']				= '<html>
								<head><title>'.$current_website.'</title></head>
								<body style="font-family:Arial, Helvetica; sans-serif;">
									<p><span style="font-size:18px;color:#000;font-weight:bold;">Me interesa un veh&iacute;culo</span><p>
									<p><span style="font-size:14px;color:#505050;">A continuaci&oacute;n una copia de la informaci&oacute;n enviada. Si necesitas agregar o modificar alg&uacute;n dato, por favor escribe a <b>usados@cofal.com.gt</b>.</span></p>
									<table width="550" style="background-color:#e3f1ff;width:526px;font-size:12px;">
										<tr>
											<td>	
												<table width="550" style="border-color:#dbdbdb;border-style:solid;border-width:1px;width:526px;font-size:12px; font-family:Arial, Helvetica; sans-serif;">
												<tr style="line-height:20px;"><td colspan="2" style="font-size:14px;"><img src="http://'.$current_website.'/userContent/CMS/email_header.jpg" width="550" height="60" style="padding:0px;margin:0px;" /></td></tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Nombre</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['FORM_NAME'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Email</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['FORM_EMAIL'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Tel&eacute;fono</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['FORM_TELEPHONE'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Comentarios</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['FORM_DETAIL'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Veh&iacute;culo</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px"><a href="http://'.$current_website.$_POST['FORM_URL'].'">Ver Veh&iacute;culo</a></td>
												</tr>
												<tr style="height:30px;"><td>&nbsp;</td></tr>
												<tr>
													<td colspan="2" style="padding-left:10px;padding-top:10px;padding-bottom:10px"><a href="http://'.$current_website.'">'.$current_website.'</a></td>
												<tr>
												</table>
											</td>
										</tr>
									</table>
									<p style="font-size:11px;color:#505050;">La informaci&oacute;n contenida en este mensaje es privada y confidencial. Si la has recibido por error, por favor procede a notificarlo al remitente y eliminarlo de tu sistema.</p>
									<p style="font-size:12px;color:#505050;">Atentamente,</p>
									<p style="font-size:12px;color:#505050;">Cofi&ntilde;o Stahl - Usados</p>
									<p style="font-size:11px;color:#505050;">PBX. 1705</p>
									<p style="font-size:11px;color:#505050;">usados@cofal.com.gt</p>
									<p style="font-size:9px;color:#707070;">Custom Site desarrollado por <a href="http://www.grupoperinola.com">Perinola</a></p>
								</body>
							</html>';
			ASTEG_mail::mail_object($requestArray);
			ASTEG_content::content_message_queue_add("1500");
		}
		else
		{
			ASTEG_content::content_message_queue_add("1502");
		}
	else
	{
		ASTEG_content::content_message_queue_add("1501");
	}
        else:
            ASTEG_content::content_message_queue_add("1500");
        endif;
}
function contact_form_submit()
{
    if($_POST['FORM_INPUT'] == ''):
	if (ASTEG_utilities::validate_email($_POST['CONTACT_FORM_EMAIL']))
		if ( !empty($_POST['CONTACT_FORM_NAME']) )
		{
			include_once ('./resourceASTEG/ASTEGfunctions.mail.php');
			$information_email							= ASTEG_resource::resource_get("RESOURCE_CONTACT_EMAIL");
			$date_array									= getdate();
			$current_date								= $date_array['mday']."/".$date_array['mon'].'/'.$date_array['year'];
			$current_website							= $_SERVER[HTTP_HOST];
			$to_name									= ASTEG_resource::resource_get("RESOURCE_CONTACT_TO");
			$from_name									= ASTEG_resource::resource_get("RESOURCE_CONTACT_FROM");
			$requestArray 								= array();
			$requestArray['to']							= $to_name.' <'.$information_email.'>, '.$_POST['CONTACT_FORM_NAME'].' <'.$_POST['CONTACT_FORM_EMAIL'].'>';
			$requestArray['from']						= $from_name.' <'.$information_email.'>';
			$requestArray['subject']					= "Mensaje enviado desde el Formulario de Contacto por ".$_POST['CONTACT_FORM_NAME']." el ".$current_date;
			$requestArray['htmlmessage']				= '<html>
								<head><title>'.$current_website.'</title></head>
								<body style="font-family:Arial, Helvetica; sans-serif;">
									<p><span style="font-size:18px;color:#000;font-weight:bold;">Solicitud de Contacto</span><p>
									<p><span style="font-size:14px;color:#505050;">Gracias por tu mensaje.</span></p>
									<p><span style="font-size:14px;color:#505050;">A continuaci&oacute;n una copia de la informaci&oacute;n enviada. Si necesitas agregar o modificar alg&uacute;n dato, por favor escribe a <b>usados@cofal.com.gt</b>.</span></p>
									<table width="550" style="background-color:#ffffe3;width:526px;font-size:12px;">
										<tr>
											<td>	
												<table width="550" style="border-color:#dbdbdb;border-style:solid;border-width:1px;width:526px;font-size:12px; font-family:Arial, Helvetica; sans-serif;">
												<tr style="line-height:20px;"><td colspan="2" style="font-size:14px;"><img src="http://'.$current_website.'/userContent/CMS/email_header.jpg" width="550" height="60" style="padding:0px;margin:0px;" /></td></tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Nombre</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['CONTACT_FORM_NAME']." ".$_POST['CONTACT_FORM_SURNAME'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Email</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['CONTACT_FORM_EMAIL'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Tel&eacute;fono</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['CONTACT_FORM_TELEPHONE'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Asunto</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['CONTACT_FORM_INTEREST'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Mensaje</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['CONTACT_FORM_DETAIL'].'</td>
												</tr>
												<tr style="height:30px;"><td>&nbsp;</td></tr>
												<tr>
													<td colspan="2" style="padding-left:10px;padding-top:10px;padding-bottom:10px"><a href="http://'.$current_website.'">'.$current_website.'</a></td>
												<tr>
												</table>
											</td>
										</tr>
									</table>
									<p style="font-size:11px;color:#505050;">La informaci&oacute;n contenida en este mensaje es privada y confidencial. Si la has recibido por error, por favor procede a notificarlo al remitente y eliminarla de tu sistema.</p>
									<p style="font-size:12px;color:#505050;">Atentamente,</p>
									<p style="font-size:12px;color:#505050;">Cofi&ntilde;o Stahl - Usados</p>
									<p style="font-size:11px;color:#505050;">PBX. 1705</p>
									<p style="font-size:11px;color:#505050;">usados@cofal.com.gt</p>
									<p style="font-size:9px;color:#707070;">Custom Site desarrollado por <a href="http://www.grupoperinola.com">Perinola</a></p>
								</body>
							</html>';
			ASTEG_mail::mail_object($requestArray);
			ASTEG_content::content_message_queue_add("1700");
		}
		else
		{
			ASTEG_content::content_message_queue_add("1702");
		}
	else
	{
		ASTEG_content::content_message_queue_add("1701");
	}
        else:
            ASTEG_content::content_message_queue_add("1500");
        endif;
}

function information_form_submit()
{
    if($_POST['FORM_INPUT'] == ''):
	if (ASTEG_utilities::validate_email($_POST['CONTACT_FORM_EMAIL']))
		if ( !empty($_POST['CONTACT_FORM_NAME']) )
		{
			include_once ('./resourceASTEG/ASTEGfunctions.mail.php');
			$information_email							= ASTEG_resource::resource_get("RESOURCE_CONTACT_EMAIL");
			$date_array									= getdate();
			$current_date								= $date_array['mday']."/".$date_array['mon'].'/'.$date_array['year'];
			$current_website							= $_SERVER[HTTP_HOST];
			$to_name									= ASTEG_resource::resource_get("RESOURCE_CONTACT_TO");
			$from_name									= ASTEG_resource::resource_get("RESOURCE_CONTACT_FROM");
			$requestArray 								= array();
			$requestArray['to']							= $to_name.' <'.$information_email.'>, '.$_POST['CONTACT_FORM_NAME'].' <'.$_POST['CONTACT_FORM_EMAIL'].'>';
			$requestArray['from']						= $from_name.' <'.$information_email.'>';
			$requestArray['subject']					= "Mensaje enviado desde el Formulario de Servicios por ".$_POST['CONTACT_FORM_NAME']." el ".$current_date;
			$requestArray['htmlmessage']				= '<html>
								<head><title>'.$current_website.'</title></head>
								<body style="font-family:Arial, Helvetica; sans-serif;">
									<p><span style="font-size:18px;color:#000;font-weight:bold;">Solicitud de Informaci&oacute;n</span><p>
									<p><span style="font-size:14px;color:#505050;">Gracias por tu mensaje.</span></p>
									<p><span style="font-size:14px;color:#505050;">A continuaci&oacute;n una copia de la informaci&oacute;n enviada. Si necesitas agregar o modificar alg&uacute;n dato, por favor escribe a <b>usados@cofal.com.gt</b>.</span></p>
									<table width="550" style="background-color:#EEE;width:526px;font-size:12px;">
										<tr>
											<td>	
												<table width="550" style="border-color:#dbdbdb;border-style:solid;border-width:1px;width:526px;font-size:12px; font-family:Arial, Helvetica; sans-serif;">
												<tr style="line-height:20px;"><td colspan="2" style="font-size:14px;"><img src="http://'.$current_website.'/userContent/CMS/email_header.jpg" width="550" height="60" style="padding:0px;margin:0px;" /></td></tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Nombre</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['CONTACT_FORM_NAME']." ".$_POST['CONTACT_FORM_SURNAME'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Email</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['CONTACT_FORM_EMAIL'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Tel&eacute;fono</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['CONTACT_FORM_TELEPHONE'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Asunto</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['CONTACT_FORM_INTEREST'].'</td>
												</tr>
												<tr>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>Mensaje</b></td>
													<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$_POST['CONTACT_FORM_DETAIL'].'</td>
												</tr>
												<tr style="height:30px;"><td>&nbsp;</td></tr>
												<tr>
													<td colspan="2" style="padding-left:10px;padding-top:10px;padding-bottom:10px"><a href="http://'.$current_website.'">'.$current_website.'</a></td>
												<tr>
												</table>
											</td>
										</tr>
									</table>
									<p style="font-size:11px;color:#505050;">La informaci&oacute;n contenida en este mensaje es privada y confidencial. Si la has recibido por error, por favor procede a notificar al remitente y eliminarla de tu sistema.</p>
									<p style="font-size:12px;color:#505050;">Atentamente,</p>
									<p style="font-size:12px;color:#505050;">Cofi&ntilde;o Stahl - Usados</p>
									<p style="font-size:11px;color:#505050;">PBX. 1705</p>
									<p style="font-size:11px;color:#505050;">usados@cofal.com.gt</p>
									<p style="font-size:9px;color:#707070;">Custom Site desarrollado por <a href="http://www.grupoperinola.com">Perinola</a></p>
								</body>
							</html>';
			ASTEG_mail::mail_object($requestArray);
			ASTEG_content::content_message_queue_add("1800");
		}
		else
		{
			ASTEG_content::content_message_queue_add("1802");
		}
	else
	{
		ASTEG_content::content_message_queue_add("1801");
	}
        else:
            ASTEG_content::content_message_queue_add("1500");
        endif;
}	
function social_quote(){

	include_once ('./resourceASTEG/ASTEGfunctions.mail.php');
	if ($_POST[FORM_INPUT] == "")
	{
//		$form_values	= json_decode(json_encode($_POST));
		$form_values	= (object) $_POST;
		if (ASTEG_utilities::validate_email($form_values->CONTACT_FORM_EMAIL)){
			include_once (THEME_PATH.'./plugins/ASTEGplugins.webservice.php');
			$ws			= new ASTEGplugin_webservice();
			
			//Tipo de contacto
			$contact_interest[1] = "Cotización de vehículos";
			$contact_interest[2] = "Cotización Repuestos y Accesorios";
			$contact_interest[3] = "Solicitud de Servicio";
			$contact_interest[4] = "Solicitud de Test Drive";
			$contact_interest[5] = "Otros";
			
			//Datos a enviar
			$post[0] 	= $form_values->CONTACT_FORM_NAME;
			$post[1] 	= $form_values->CONTACT_FORM_SURNAME;
			$post[2] 	= $form_values->CONTACT_FORM_EMAIL;
			$post[3] 	= $form_values->CONTACT_FORM_TELEPHONE;
			$post[4] 	= "Deseo cotizar vehiculos marca ".$form_values->marca.", modelo: ".$form_values->modelo.", precio:".$form_values->precio.", tipo:".$form_values->tipo;
			$post[5] 	= 7;
			$post[6] 	= 5;
			
			$entry_string = implode('|', $post);
			
			//Enviar al ws
			
				$function 	= 'PCRMO0001';
				$wsResult	= $ws->send_string_value($entry_string, $function);
			
				if(empty($wsResult) || $wsResult['PCRMO0001Result'] != 'OK'):
					$requestFail 								= array();
					$requestFail['to']							= ASTEG_resource::resource_get("RESOURCE_CONTACT_EMAIL");
					$requestFail['from']						= ASTEG_resource::resource_get("RESOURCE_CONTACT_EMAIL");
					$requestFail['subject']					= "Error al Asignar un NDC desde la Web";
					$requestFail['htmlmessage']				= '<html>
										<head><title>Error al asignar NDC</title></head>
										<body style="font-family:Arial, Helvetica; sans-serif;">
											<p><span style="font-size:18px;color:#000;font-weight:bold;">Se produjo un error al asignar un NDC desde la web.</span><p>
											<p><span style="font-size:14px;color:#505050;">Cadena Obtenida: '.$entry_string.'</span></p>
										</body>
									</html>';
					ASTEG_mail::mail_object($requestFail);
				endif;
			
			
			echo '<pre>';
			print_r($wsResult);
			echo '</pre>';
			
			//Enviar copia de correo al cliente
			$to_name							= "Cofalusados Guatemala";
			$from_name							= "Cofalusados Guatemala";
			$information_email					= ($post[6] != 1)?$to_name.'<'.ASTEG_resource::resource_get("RESOURCE_CONTACT_EMAIL").'>, ':'';
			$date_array							= getdate();
			$current_date						= $date_array['mday']."/".$date_array['mon'].'/'.$date_array['year'];
			$current_website					= $_SERVER[HTTP_HOST];
			$requestArray 						= array();
			$requestArray['to']					= $information_email.$form_values->CONTACT_FORM_NAME.' <'.$form_values->CONTACT_FORM_EMAIL.'>';
			$requestArray['from']				= $from_name.' <info@cofal.com.gt>';
			$requestArray['subject']			= "Mensaje de ".$contact_interest[$post[6]]." enviado desde el sitio de Cofalusados ";
			$requestArray['htmlmessage']		= '<html>
								<head><title>'.$current_website.'</title></head>
								<body style="font-family:Arial, Helvetica; sans-serif;">
									<p><span style="font-size:18px;color:#000;font-weight:bold;">'.$contact_interest[$post[6]].' - Cofalusados Guatemala</span><p> 
									<p><span style="font-size:14px;color:#505050;">Gracias por su mensaje.</span></p>
									<p><span style="font-size:14px;color:#505050;">A continuaci&oacute;n una copia de la informaci&oacute;n enviada. Si necesita agregar o modificar alg&uacute;n dato, por favor escriba a <b>'.ASTEG_resource::resource_get("RESOURCE_CONTACT_EMAIL").'</b>.</span></p>
									<table width="550" style="background-color:#EEE;width:526px;font-size:12px;">
									<tr>
										<td>	
									<table width="550" style="border-color:#dbdbdb;border-style:solid;border-width:1px;width:526px;font-size:12px; font-family:Arial, Helvetica; sans-serif;">
									<tr style="line-height:20px;"><td colspan="2" style="font-size:14px;"><img src="http://'.$current_website.'/userContent/CMS/email_header.jpg" width="550" height="60" style="padding:0px;margin:0px;" /></td></tr>
									<tr>
										<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120">Nombre</td>
											<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$form_values->CONTACT_FORM_NAME." ".$form_values->CONTACT_FORM_SURNAME.'</td>
										</tr>
										<tr>
											<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120">Email</td>
											<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$form_values->CONTACT_FORM_EMAIL.'</td>
										</tr>
										<tr>
											<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120">Tel&eacute;fono</td>
											<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$form_values->CONTACT_FORM_TELEPHONE.'</td>
										</tr>
										<tr>
											<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120">Mensaje</td>
											<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$post[4].'</td>
										</tr>
										<tr style="height:30px;">&nbsp;</tr>
										<tr>
											<td colspan="2" style="padding-left:10px;padding-top:10px;padding-bottom:10px"><a href="http://'.$current_website.'">'.$current_website.'</a></td>
										<tr>
											</table>
										</td>
										</tr>
										</table>
										<p style="font-size:11px;color:#505050;">Si usted ha recibido este mensaje por error, por favor notifique el malentendido respondiendo a este correo.</p>
										<p style="font-size:12px;color:#505050;">Atentamente,</p>
										<p style="font-size:12px;color:#505050;">Cofalusados Guatemala</p>
										<p style="font-size:9px;color:#707070;">Custom Site desarrollado por <a href="http://www.grupoperinola.com">Perinola</a></p>
									</body>
								</html>';
				ASTEG_mail::mail_object($requestArray);
				
				
				ASTEG_content::content_message_queue_add("1507");
		}
	}else
	{
		ASTEG_content::content_message_queue_add("1500");
	}	
}
