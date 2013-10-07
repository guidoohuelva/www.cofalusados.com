<?php

class ASTEG_security
{

	public function __contructor()
	{
	}

	public function security_login($username,$password)
	{
		return ASTEG_security::security_private_login($username, $password);
	}

	public function security_login_check()
	{
		return ASTEG_security::security_private_login_check();
	}

	public function security_login_username()
	{
		return ASTEG_security::security_private_login_username();
	}

	public function security_logout()
	{
		ASTEG_security::security_private_logout();
	}

	public function security_licensing_check()
	{
		return ASTEG_security::security_private_licensing_check();
	}

	public function security_user_level()
	{
		return ASTEG_security::security_private_user_level();
	}

	public function security_page_level($ID)
	{
		return ASTEG_security::security_private_page_level($ID);
	}

	public function sanitize_array(&$current_array, $sanitized_array)
	{
		return ASTEG_security::sanitize($current_array,$sanitized_array);
	}



//----- PRIVATE FUNCTIONS
	private function security_private_login($username, $password)
	{
		$result = false;
		$ASTEGdb				= new ASTEG_database;
		//---- CREAR EL QUERY CON USUARIO Y PASSWORD
		if (!empty($username) && !empty($password))
		{
			$requestArray['query']	= "SELECT * FROM FRAMEWORK_USERS WHERE USERNAME = '".$username."' AND PASSWORD = '".$password."' LIMIT 1";
			$resultArray				= $ASTEGdb->database_advanced_query($requestArray);
			if ($resultArray['rowcount'] == 1) //---- EXISTE USUARIO CON LA COMBINACION
			{

				$ASTEGdb				= new ASTEG_database;
				$readRequest 			= array();
				$readRequest['ID']		= $resultArray[0]['field0'];
				$readResult				= $ASTEGdb->database_read("FRAMEWORK_USERS", $readRequest);
				if (empty($readResult['field5']) AND empty($readResult['field6']) )//---- REVISAMOS QUE NO HAYA NADIE INGRESADO
				{
					$insertRequest 						= array();
					$insertRequest['ID']					= $resultArray[0]['field0'];
					$insertRequest['ID_IPADDRESS']	= ASTEG_utilities::utilities_ipaddress();
					$insertRequest['ID_SESSIONID']	= session_id();
					$insertResult		= $ASTEGdb->database_update("FRAMEWORK_USERS", $insertRequest);

					$_SESSION['ASTEGFRAMEWORK_STATUS_VIEW']			= "PRIVATE";
					$_SESSION['ASTEGFRAMEWORK_USER_ID']		 			= $resultArray[0]['field0'];
					$_SESSION['ASTEGFRAMEWORK_USER_IPADDRESS'] 		= ASTEG_utilities::utilities_ipaddress();
					$_SESSION['ASTEGFRAMEWORK_USER_TIMESTAMP']		= ASTEG_utilities::utilities_timestamp();
					$result																= true;
				}
				else //---- HAY ALGUIEN INGRESADO
				{
					//---- INGRESO DE ID PARA FORZAR LA SALIDA
					$_SESSION['ASTEGFRAMEWORK_USER_ID']		 			= $resultArray[0]['field0'];
					//---- MENSAJE DE WARNING
					ASTEG_content::content_message_queue_add("9999");
					//---- FORZAR LA SALIDA
					ASTEG_security::security_force_logout();
					$insertRequest 						= array();
					$insertRequest['ID']					= $resultArray[0]['field0'];
					$insertRequest['ID_IPADDRESS']	= ASTEG_utilities::utilities_ipaddress();
					$insertRequest['ID_SESSIONID']	= session_id();
					$insertResult		= $ASTEGdb->database_update("FRAMEWORK_USERS", $insertRequest);

					$_SESSION['ASTEGFRAMEWORK_STATUS_VIEW']			= "PRIVATE";
					$_SESSION['ASTEGFRAMEWORK_USER_ID']		 			= $resultArray[0]['field0'];
					$_SESSION['ASTEGFRAMEWORK_USER_IPADDRESS'] 		= ASTEG_utilities::utilities_ipaddress();
					$_SESSION['ASTEGFRAMEWORK_USER_TIMESTAMP']		= ASTEG_utilities::utilities_timestamp();
					$result																= true;
				}
			} //---- NO EXISTE USUARIO Y PASSWORD
			else
			{
				ASTEG_content::content_message_queue_add("9996");
				ASTEG_security::security_force_logout();
			}
		}
		else //---- ALGUNO DE LOS CAMPOS USER O PASSWORD VACIOS
		{
			ASTEG_content::content_message_queue_add("9996");
			ASTEG_security::security_force_logout();
		}
		return $result;
	}

	private function security_private_login_check()
	{
		$result = false;

		//---- REVISAR EL TIMEOUT A TRAVES DEL TIMESTAMP
		if ((isset ($_SESSION['ASTEGFRAMEWORK_USER_TIMESTAMP'])) AND ($_SESSION['ASTEGFRAMEWORK_USER_TIMESTAMP'] < ASTEG_utilities::utilities_timestamp()*(10*60) ) )
			if ($_SESSION['ASTEGFRAMEWORK_STATUS_VIEW'] == "PRIVATE") //---- REVISAR EL ESTADO DEL USUARIO
			{
				$ASTEGdb				= new ASTEG_database;
				$readRequest 			= array();
				$readRequest['ID']		= $_SESSION['ASTEGFRAMEWORK_USER_ID'];
				$readResult				= $ASTEGdb->database_read("FRAMEWORK_USERS", $readRequest);
				//---- SI EL USUARIO EXISTE
				if ($readResult['result'] == 'true')
				{
					//---- REVISAR IP Y SESSION
					if ($_SESSION['ASTEGFRAMEWORK_USER_IPADDRESS'] == $readResult['field5'] AND session_id() == $readResult['field6'])
					{
						$_SESSION['ASTEGFRAMEWORK_USER_TIMESTAMP']		= ASTEG_utilities::utilities_timestamp();
						$result															= true;
					}
					else //--- SI EL IP Y LA SESSION NO COINCIDEN HAY MULTIPLES SESSIONES
					{
						ASTEG_content::content_message_queue_add("9999");
						ASTEG_security::security_force_logout();
					}
				}
				else //---- EJECUTA EL TIMEOUT
				{
					ASTEG_content::content_message_queue_add("9998");
					ASTEG_security::security_force_logout();
				}

			}

		return $result;
	}

	private function security_private_login_username()
	{
		$result = "n/a";
		$ASTEGdb							= new ASTEG_database;
		$readRequest 						= array();
		$readRequest['ID']					= $_SESSION['ASTEGFRAMEWORK_USER_ID'];
		$readResult							= $ASTEGdb->database_read("FRAMEWORK_USERS", $readRequest);
		if ($readResult['result'] == 'true')
		{
			$result	= $readResult['field1'];
		}

		return $result;
	}

	private function security_force_logout()
	{
		$ASTEGdb							= new ASTEG_database;
		if (!empty($_SESSION['ASTEGFRAMEWORK_USER_ID'])) //---- SI EXISTE ID LO ACTUALIZA
		{
			$insertRequest 						= array();
			$insertRequest['ID']					= $_SESSION['ASTEGFRAMEWORK_USER_ID'];
			$insertRequest['ID_IPADDRESS']	= "";
			$insertRequest['ID_SESSIONID']	= "";
			$insertResult		= $ASTEGdb->database_update("FRAMEWORK_USERS", $insertRequest);
		}

		$_SESSION['ASTEGFRAMEWORK_STATUS_VIEW']			= "PUBLIC";
		session_unregister('ASTEGFRAMEWORK_USER_ID');
		session_unregister('ASTEGFRAMEWORK_USER_IPADDRESS');
		session_unregister('ASTEGFRAMEWORK_USER_TIMESTAMP');
	}

	private function security_private_logout()
	{
		ASTEG_security::security_force_logout();
		ASTEG_content::content_message_queue_add("9997");
	}

	private function security_private_licensing_check()
	{
		$result								= false;
		$ASTEGdb 							= new ASTEG_database();
		$readRequest 						= array();
		$readRequest['FIELDNAME']		= "RESOURCE_LABEL";
		$readRequest['FIELDCRITERIA']	= "RESOURCE_WEBSITE_ADDRESS";
		$readResult							= $ASTEGdb->database_read("FRAMEWORK_RESOURCE", $readRequest);
		if ($readResult['result'] == 'true')
		{
			if (md5("ASTEGFRAMEWORK-".$_SERVER['HTTP_HOST']) == $readResult['field2'])
				$result = true;
		}

		return $result;
	}

	private function security_private_user_level()
	{
		$result			= 0;

		$ASTEGdb 							= new ASTEG_database();
		$readRequest 						= array();
		$readRequest['ID']					= $_SESSION['ASTEGFRAMEWORK_USER_ID'];
		$readResult							= $ASTEGdb->database_read("FRAMEWORK_USERS", $readRequest);
		if ($readResult['result'] == 'true')
		{

				$result = $readResult[field4];
		}
		return $result;
	}

	private function security_private_page_level($ID)
	{
		$result			= -1;

		$ASTEGdb 							= new ASTEG_database();
		$readRequest 						= array();
		$readRequest['ID']					= $ID;
		$readResult							= $ASTEGdb->database_read("FRAMEWORK_PAGES", $readRequest);
		if ($readResult['result'] == 'true')
		{

				$result = $readResult['field7'];
		}
		return $result;
	}

	protected function sanitize( $data, $whatToKeep )
	{
		/* ---- EXAMPLE: ---- sanitize($_GET, array(	'PAGE'=>'int','ID'=>'int','PID'=>'int','GID'=>'int','FID'=>'int','LID'=>'int','P'=>'int','PID'=>'int','VID'=>'int','NID'=>'int','KEY'=>'int'));  ----*/
		//---- FUNCTIONS
			function sanitizeOne($var, $type)
			{
			        switch ( $type )
			        {
			                        case 'int': // integer
			                        $var = (int) $var;
			                        break;
			                        case 'str': // trim string
			                        $var = trim ( $var );
			                        break;
			                        case 'nohtml': // trim string, no HTML allowed
			                        $var = htmlentities ( trim ( $var ), ENT_QUOTES );
			                        break;
			                        case 'plain': // trim string, no HTML allowed, plain text
			                        $var =  htmlentities ( trim ( $var ) , ENT_NOQUOTES )  ;
			                        break;
			                        case 'upper_word': // trim string, upper case words
			                        $var = ucwords ( strtolower ( trim ( $var ) ) );
			                        break;
			                        case 'ucfirst': // trim string, upper case first word
			                        $var = ucfirst ( strtolower ( trim ( $var ) ) );
			                        break;
			                        case 'lower': // trim string, lower case words
			                        $var = strtolower ( trim ( $var ) );
			                        break;
			                        case 'urle': // trim string, url encoded
			                        $var = urlencode ( trim ( $var ) );
			                        break;
			                        case 'trim_urle': // trim string, url decoded
			                        $var = urldecode ( trim ( $var ) );
			                        break;
			                        case 'filename': // trim string, url decoded
				                        $var = str_replace('../','',urldecode ( trim ( $var ) ));
				                        $var = str_replace('./','',urldecode ( trim ( $var ) ));
				                        $var = str_replace('/','',urldecode ( trim ( $var ) ));
			                        break;
			        }
			        return $var;
			}

			$data = array_intersect_key( $data, $whatToKeep );
	        foreach ($data as $key => $value)
	        {
	                $data[$key] = sanitizeOne( $data[$key] , $whatToKeep[$key] );
	        }
	        return $data;
	}
}
?>