<?php
header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
session_start();
//---- NAVIGATION CHECK
include_once './resourceASTEG/ASTEGnavigation.php';
//---- COPYRIGHT
include_once './ASTEGconsultores.copyright.php';
//---- INITIALIZATION
include_once './resourceASTEG/ASTEGinitialization.php';
//---- INITIALIZE FRAMEWORK
$ASTEGframework		= new ASTEG_engine();
//---- PAGE LOADER
$ASTEGframework->engine_header();
$ASTEGframework->engine_content();
$ASTEGframework->engine_footer();
?>