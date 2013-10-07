<?php
header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
session_start();
/*---- ASTEGconsultores INTERFASE "REMOTE PROCEDURE CALL" ----*/
//---- COPYRIGHT
include_once './ASTEGconsultores.copyright.php';
//---- INITIALIZATION
include_once './resourceASTEG/ASTEGrpcinitialization.php';
//---- INITIALIZE FRAMEWORK
$ASTEGframework		= new ASTEG_engine();
//---- LOAD THEME RPC
include_once ASTEG_resource::resource_get('RESOURCE_THEME_URL')."RPC.php";
?>