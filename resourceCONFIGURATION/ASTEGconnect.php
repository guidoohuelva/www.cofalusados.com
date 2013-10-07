<?php
//---- DATABASE connection script
global $deploy_dbhost;
global $deploy_dbuser;
global $deploy_dbpass;
global $deploy_dbname;

$db = &ADONewConnection('mysql'); 													//---- CONNECTION TYPE DEFINITION
$db->PConnect($deploy_dbhost,$deploy_dbuser,$deploy_dbpass,$deploy_dbname);  		//---- CONNECTION SCRIPT
if ($db->IsConnected() == 0)
	die("<h1 style=\"color:#F00;text-align:center\">Error en Conexion con la Base de Datos<h1>");
?>