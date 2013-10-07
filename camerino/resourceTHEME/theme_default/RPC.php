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

switch ($_POST['ASTEGrpc'])
{
	case "IMAGEPAGE_001":
		rpc_image_uploader(01, $_FILES);
		break;
	case "IMAGEPAGE_002":
		rpc_image_uploader(02, $_FILES);
		break;
}


function rpc_image_uploader($ID,$image_array)
{

	$dirpath  =  "../userContent/CMS";
//---- PAGE 01
	if ( ($ID==01) && (!empty($image_array['ASTEGimage01']["name"])) )
		copy  ($_FILES['ASTEGimage01']['tmp_name'],$dirpath."/page01_01.jpg");
	if ( ($ID==01) && (!empty($image_array['ASTEGimage02']["name"])) )
		copy  ($_FILES['ASTEGimage02']['tmp_name'],$dirpath."/page01_02.jpg");
	if ( ($ID==01) && (!empty($image_array['ASTEGimage03']["name"])) )
		copy  ($_FILES['ASTEGimage03']['tmp_name'],$dirpath."/page01_03.jpg");
//---- PAGE 02
	if ( ($ID==02) && (!empty($image_array['ASTEGimage01']["name"])) )
		copy  ($_FILES['ASTEGimage01']['tmp_name'],$dirpath."/page03_01.jpg");

	ASTEG_content::content_message_queue_add("9911");
	header( "Location: ./index.php?ID=12" );

}
?>