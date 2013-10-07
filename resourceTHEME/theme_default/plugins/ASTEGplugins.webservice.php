<?php
/**
 * Conexión al webservice para envío de datos de consulta
 */
class ASTEGplugin_webservice{
	
	var $ASTEGdb;
	var $wsAddress;
	function __construct() {
		require_once('./resourcePLUGINS/nusoap/nusoap.php');
		
		$this->ASTEGdb		= new ASTEG_database();
		$this->wsAddress	= "http://www.cofal.com.gt:50001/PCRMW0001.asmx?wsdl";
	}
	
	/**
	 * Enviar los datos del formulario como cadena de valores
	 * @param	String		@string		Cadena con los valores a enviar separada por el caracter "|"
	 * @param	String		@function	Nombre del método a realizar el envío
	 * 
	 * @return	XML			Retorna el xml con el resultado del método solicitado.
	 */
	public function send_string_value($string, $function = 'PCRMO0001'){
		$client						= new nusoap_client($this->wsAddress, 'wsdl');
		$webservice_request			= array("datos"=>$string);
		$result						= $client->call($function,$webservice_request);
		
		/*
		$webservice_request			= array("p1"=>$string);
		$client						= new nusoap_client($this->wsAddress,'WSDL');
		$result						= $client->call($function,$string);*/
		
		return $result;
	}
}
