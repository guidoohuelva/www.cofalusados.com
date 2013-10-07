<?php

//---- MAIL CLASS
class ASTEG_mail
{
	//---- CONSTRUCTOR
	public function __construct()
	{
	}


	public function mail_object($requestArray)
	{
		/*
		 * $requestArray
		 * 		['to']						= email que recibe el correo
		 *  	['subject']				= encabezado del correo
		 *  	['message']			= correo en plaintext
		 *  	['htmlmessage']	= correo en HTML
		 *  	['from']					= email del que lo envia
		 *  	['reply']					= email a re-enviar
		 */


		$to							= $requestArray['to'];
		$reply						= (!empty($requestArray['reply']))?$requestArray['reply']:$requestArray['from'];
		$subject				= utf8_decode($requestArray['subject']);
		$message				= (!isset($requestArray['message']))?$requestArray['htmlmessage']:$requestArray['message'];
		$message 			= utf8_decode($message);
		$codeHTML			= "\nContent-Type: text/html; charset=ISO-8859-1;";
		$codeFROM		= "From:".$requestArray['from']."\r\nReply-To: ".$reply."";
		$headers				= $codeFROM.$codeHTML."X-mailer: ASTEGframeworkMailSender";
	 	$result					= mail($to,$subject,$message,$headers);

		return $result;
	}

	public function mail_multipart_object($request_array)
	{
		/*
		 * $request_array
		 * 		['to']							= email que recibe el correo
		 *  	['subject']					= encabezado del correo
		 *  	['text_message']		= correo en plaintext
		 *  	['htmlmessage']		= correo en HTML
		 *  	['from']						= email del que lo envia
		 *  	['reply']						= email a re-enviar
		 */


		$to							= $request_array['to'];
		$reply						= (!empty($request_array['reply']))?$request_array['reply']:$request_array['from'];
		$subject				= utf8_decode($request_array['subject']);
		$from						= $request_array['from'];
		$random_hash	= md5(date('r', time()));
		$message_text	= utf8_decode($request_array['text_message']);
		$message_html	= utf8_decode($request_array['html_message']);
		//---- HEADERS
		$headers				= "From: ".$from."\r\nReply-To: ".$reply."\r\nX-mailer:ASTEGframeworkMailSender\r\nMIME-Version:1.0\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"\r\n";
		//---- MESSAGE
		$message				=  "--PHP-alt-".$random_hash."\n";
		$message				.= "Content-Type: text/plain; charset=\"ISO-8859-1\""."\n";
		$message				.= "Content-Transfer-Encoding: 8bit"."\n\n";
		$message				.= $message_text."\n";
		$message				.=  "--PHP-alt-".$random_hash."\n";
		$message				.= "Content-Type: text/html; charset=\"ISO-8859-1\""."\n";
		$message				.= "Content-Transfer-Encoding: 8bit"."\n\n";
		$message				.= $message_html."\n";
		$message				.=  "--PHP-alt-".$random_hash."--"."\n";
		//---- SEND MAIL
		$result					= mail($to,$subject,$message,$headers);

		return $result;
	}
}
?>