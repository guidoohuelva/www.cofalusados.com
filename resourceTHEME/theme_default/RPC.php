<?php
/*---- RPC DRIVER ----*/
/*
 * JQUERY template
 * ==============
 * $.post("./resourceTHEME/theme_default/RPC.php",{ASTEGrpc:"HOUR"},function (resultString)
 * {
 * 		$(".gallery_items_chip[rel="+relID+"]").html(resultString);
 *  });

 */

switch ($_GET['ASTEGrpc'])
{
	case "export_toexcel":
		export_to_excel();
		break;
	case "redes_sociales":
		display_redes_sociales();
		break;
	default:
		default_exit();
		break;
}
function display_redes_sociales(){
	
	$ASTEGdb		= new ASTEG_database();
	$sql['query']	=  "SELECT PBC.ID, PBC.CATEGORY_NAME
						FROM PLUGIN_CAR_GALLERY PCG
						JOIN PLUGIN_BRAND_CATEGORIES PBC ON PBC.ID = PCG.VEHICLE_BRAND
						WHERE PCG.VEHICLE_SOLD = 0
						GROUP BY PBC.ID";
	$vehicle_brands	= $ASTEGdb->database_advanced_query($sql); unset($vehicle_brands['rowcount']); unset($vehicle_brands['result']);
	
	//Opciones del formulario
	$brands_options = '';
	foreach($vehicle_brands as $vehicle_brand)
		$brands_options .= '<option value="'.$vehicle_brand['field1'].'">'.$vehicle_brand['field1'].'</option>';
	
	$year_html		= "<option value='Todos'>Cotizar Todos</option>";
	for($i = date('Y'); $i >= (date('Y')-20); $i--)
		$year_html		.= "<option value='Desde ".$i."'>Desde ".$i."</option>";
	
	$prices_array = array(
						'0 - 50,000',
						'50,001 - 100,000',
						'100,001 - 150,000',
						'150,001 - 200,000',
						'200,001 - 250,000',
						'250,001 - 300,000',
						'300,001 y Más'
					);
	$prices_options = "<option value='Todos'>Cotizar Todos</option>";
	foreach($prices_array as $price)
		$prices_options .= '<option value="'.$price.'">'.$price.'</option>';
	
	$vehicle_array = array(
						"Sedán",
						"Hatchback",
						"Camionetas",
						"SUV",
						"Comerciales",
						"Deportivos",
						"Pickups");
	$vehicle_options = "<option value='Todos'>Cotizar Todos</option>";
	foreach($vehicle_array as $vehicle)
		$vehicle_options .= '<option value="'.$vehicle.'">'.$vehicle.'</option>';
	
	
	$html 	= 	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	$html 	.= 		'<html lang="en" dir="ltr" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">';
	$html	.= 			'<head>';
	$html	.= 				'<title>Formulario de Cofalusados :: Redes Sociales</title>';
	$html	.= 				'<link media="screen" type="text/css" href="./resourceTHEME/theme_default/top_links/css/bootstrap.min.css" rel="stylesheet">';
	$html	.= 				'<link media="screen" type="text/css" href="./resourceTHEME/theme_default/top_links/css/main.css" rel="stylesheet">';
	$html	.= 				'<link media="screen" type="text/css" href="./resourceTHEME/theme_default/style.css" rel="stylesheet">';
	$html	.= 			'</head>';
	$html	.= 			'<body style="background-color:#EFEFEF;">';
	$html	.= 			'<div class="content">';
	$html	.= 				'<div class="form_popup feedback_form">';
	$html	.= 					'<form action="./?PAGE=5" method="POST" name="QUOTE_FORM">';
	$html	.= 						'<input type="hidden" value="SOCIAL_QUOTE" name="ASTEGsubmit_code">';
	$html	.= 						'<input type="text" value="" name="FORM_INPUT">';
	$html	.= 						'<h4>Cotiza nuestros veh&iacute;culos de cofalusados.</h4>';
	$html	.= 						'<p>Dinos que tipo de veh&iacute;culo estas buscando con los campos siguientes:</p><br>';
	$html	.= 						'<div class="input_block"><label>Nombre:</label>';
	$html	.= 						'<input type="text" name="CONTACT_FORM_NAME" /></div>';
	$html	.= 						'<div class="input_block"><label>Apellido:</label>';
	$html	.= 						'<input type="text" name="CONTACT_FORM_SURNAME" /></div>';
	$html	.= 						'<div class="input_block"><label>Email:</label>';
	$html	.= 						'<input type="text" name="CONTACT_FORM_EMAIL" /></div>';
	$html	.= 						'<div class="input_block"><label>Tel&eacute;fono:</label>';
	$html	.= 						'<input type="text" name="CONTACT_FORM_TELEPHONE" /></div>';
	$html	.= 						'<div class="input_block"><label>Marca:</label>';
	$html	.= 						'<select name="marca">'.$brands_options.'</select></div>';
	$html	.= 						'<div class="input_block"><label>Modelo:</label>';
	$html	.= 						'<select name="modelo">'.$year_html.'</select></div>';
	$html	.= 						'<div class="input_block"><label>Precio:</label>';
	$html	.= 						'<select name="precio">'.$prices_options.'</select></div>';
	$html	.= 						'<div class="input_block"><label>Tipo:</label>';
	$html	.= 						'<select name="tipo">'.$vehicle_options.'</select></div>';
	$html	.= 						'<div class="input_block"><input type="submit" value="Enviar" name="FEEDBACK_FORM"></div>		';
	$html	.= 					'</form>	';
	$html	.= 				'</div>';
	$html	.= 			'</div>';
	$html	.= 			'</body>';
	$html	.=		'</html>';
	
	$array = array(
				array(
					'POSICION' 		=> 'Control de Maquinaria de ensamble',
					'EXPERIENCIA' 	=> 12
				),
				array(
					'POSICION'		=> 'Generación de energía alterna',
					'EXPERIENCIA'	=> 12
				)
			);
	echo json_encode($array);
	
	echo $html;
}
function export_to_excel()
{
	$current_session = md5(session_id());
	//---- SE DEBE DE ENVIAR EL SESSION_CODE PARA VALIDAR EL ENVIO
	if ($current_session == $_GET[CODE])
	{
		$ASTEGdb						= new ASTEG_database();
		$request_array					= array();
		$request_array[query]			= "SELECT * FROM FRAMEWORK_EMAILCATCHER";
		$result_array					= $ASTEGdb->database_advanced_query($request_array);
		header("Pragma: public");
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");;
	    header("Content-Disposition: attachment;filename=listado_de_correos.xls ");
	    header("Content-Transfer-Encoding: binary ");
	    xlsBOF();

        xlsWriteLabel(0,0,"Email");
        xlsWriteLabel(0,1,"Fecha de Ingreso");
		$xlsRow 						= 1;
		for ($i = 0; $i < $result_array[rowcount]; $i++)
		{
			xlsWriteLabel($xlsRow,0,$result_array[$i][field1]);
			xlsWriteLabel($xlsRow,1,$result_array[$i][field2]);
			$xlsRow++;
		}
		xlsEOF();
		exit();
	}
	else
	{
		print '
		<div align="center">
			<p>Para exportar debe de estar ingresado al sistema, gracias<p>
		</div>';
	}
}
function default_exit()
{
		print '
		<div align="center">
			<p>No deber&iacute;a de estar ac&aacute;<p>
		</div>';
}

function xlsBOF()
{
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
    return;
}

function xlsEOF()
{
    echo pack("ss", 0x0A, 0x00);
    return;
}

function xlsWriteNumber($Row, $Col, $Value)
{
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    echo pack("d", $Value);
    return;
}

function xlsWriteLabel($Row, $Col, $Value )
{
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
	return;
}

?>