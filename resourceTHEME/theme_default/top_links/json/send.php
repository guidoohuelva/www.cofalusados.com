<?php
error_reporting(0);
//get variables
$nombre = addslashes($_POST['fullname']);
$email = addslashes($_POST['email_date']);
$phone = addslashes($_POST['phone_date']);
$fecha_1 = addslashes($_POST['fecha_1']);
$fecha_2 = addslashes($_POST['fecha_2']);
$sent_from = addslashes($_POST['sent_from']);
//--
$cabeceras = "From: $nombre <$email>\n"
 . "Reply-To: $email\n";
$asunto = "¡Deseo programar una cita!"; //subject info@cofal.com.gt
// $email_to = "seo.cofal@gmail.com"; //email to
$email_to = "info@cofal.com.gt"; //email to
$contenido = "$nombre desea calendarizar una cita:\n"
. "\n"
. "Email: $email\n"
. "Telefono: $phone\n"
. "Fecha Disponible: $fecha_1\n"
. "Otra Fecha Disponible: $fecha_2\n"
. "Enviado desde: $sent_from\n"
. "\n";

if (mail($email_to, $asunto ,$contenido ,$cabeceras )) {
	$json = array('sent' => true,
				  'msg'  => "¡Solicitud enviada!" );
	// header('Location: contactform.php?success');
// die("Gracias, su mensaje se envio correctamente.");
}else{
	// header('Location: contactform.php?failed');
	$json = array('sent' => false,
				  'msg'  => "¡Su solicitud no ha sido enviada, intente enviar de nuevo!" );
}
echo json_encode($json);
?>