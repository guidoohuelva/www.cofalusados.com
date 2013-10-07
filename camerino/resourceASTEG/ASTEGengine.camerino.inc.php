<?php
class ASTEG_engine
{
	public function __construct()
	{
		/*---- FRAMEWORK SETTINGS ----*/
		global $framework_version;
		$_SESSION['FRAMEWORK_VERSION']	= $framework_version;
		/*---- SET INITIAL VIEW_STATUS ----*/
		if (!isset($_SESSION['ASTEGFRAMEWORK_STATUS_VIEW']))
		{
			$_SESSION["ASTEGFRAMEWORK_STATUS_VIEW"] = "PUBLIC";
		}
		if (ASTEG_security::security_licensing_check() == false)
			ASTEG_content::content_message_queue_add("9995");
	}

//---- PUBLIC FUNCTIONS
	public function engine_show_header()
	{
		return $this->protected_engine_show_header();
	}
	public function engine_header()
	{
		return $this->protected_engine_header();
	}
	public function engine_content()
	{
		return $this->protected_engine_content();
	}
	public function engine_footer()
	{
		return $this->protected_engine_footer();
	}
/*---- PROTECTED FUNCTIONS ----*/
	/*----  SHOWS THE PAGE HEADER  ----*/
	protected function protected_engine_show_header()
	{
		/*---- VARIABLE SETUP ----*/
		$page_specific_label		= "";
		$ASTEG_GET_ARRAY		= $_GET;

		/*---- IF GET ARRAY HAS INFORMATION CHANCES ARE THERE IS A PAGE OR GET RECORD ----*/
		if (count($ASTEG_GET_ARRAY) > 0)
		{
			if (isset($ASTEG_GET_ARRAY['ID']))
				$current_page_label = ASTEG_content::content_website_title($ASTEG_GET_ARRAY['ID']);
			elseif (isset($ASTEG_GET_ARRAY['PAGE']))
				$current_page_label = ASTEG_content::content_website_title($ASTEG_GET_ARRAY['PAGE']);
		}
		else
		{
			$current_page_label = ASTEG_content::content_website_title(1); //---- CHECK LABEL FOR INDEX PAGE
		}

		/*---- ADD THE "-" CHARACTER IF THERE IS A PAGE SPECIFIC TITLE ----*/
		if (!empty($current_page_label))
			$page_specific_label = " - ".$current_page_label;
		else
			$page_specific_label = "";
		/*---- RETURN TITLE ---*/
		return ASTEG_resource::resource_get("RESOURCE_WEBSITE_TITLE").$page_specific_label;
	}

	protected function protected_engine_header()
	{

		/*---- VARIABLE SETUP ----*/
		$theme_path						= ASTEG_resource::resource_get("RESOURCE_THEME_URL");
		$ASTEG_GET_ARRAY			= $_GET;
		$ASTEG_POST_ARRAY		= $_POST;
		$secure_allow 					= false;
		include ($theme_path."language.en.inc.php");
				/*---- INCLUDES SETUP ----*/
		include ($theme_path."theme.php");

		/*---- CHECK IF PAGE IS SECURE ----*/
		$current_id 		= 1; //---- DEFAULT PAGE ID (INDEX)

		/*---- PAGE/LINK REDIRECTION ?ID GETS PRECENDECE OVER ?PAGE ----*/
		if (isset($ASTEG_GET_ARRAY['ID']))
			$current_id 	= $ASTEG_GET_ARRAY['ID'];
		elseif (isset($ASTEG_GET_ARRAY['PAGE']))
			$current_id 	= $ASTEG_GET_ARRAY['PAGE'];


		/*---- CHECK THE SECURITY LEVEL ----*/
		if (ASTEG_content::content_page_access_level($current_id) > 0) //---- PAGE IS SECURE
		{
			if (ASTEG_security::security_login_check()) //---- THE USER HAS LOGGED IN
			{
				if (ASTEG_security::security_user_level() < ASTEG_security::security_page_level($current_id))
				{
					ASTEG_content::content_message_queue_add("9993");
					ASTEG_security::security_logout();
					unset($_GET['PAGE']);
					$_GET['ID'] = 1;
				}
				else //---- PAGE IS SECURE AND USER HAS CLEARANCE
				{
					$secure_allow = true;
				}
			}
			else //---- NO USER LOGGED IN
			{
				ASTEG_content::content_message_queue_add("9994");
				unset($_GET['PAGE']);
				$_GET['ID'] 		= 1;
			}
		}
		else //---- PAGE IS NOT SECURE ALLOW PROCESS
		{
			$secure_allow = true;
		}

		if ($secure_allow) //---- CLEARANCE
		{
			if (isset($_GET['ACTION'])) 					//----- PROCESS ACTION REQUESTS
				include ($theme_path."actions.php");
			if (count($ASTEG_POST_ARRAY) > 0)		//----- PROCESS POST REQUESTS
				include ($theme_path."posts.php");
		}
		include ($theme_path."header.php");		//---- HEADER
	}

	protected function protected_engine_content()
	{
		$theme_path	= ASTEG_resource::resource_get("RESOURCE_THEME_URL");
		include ($theme_path."language.en.inc.php");
		$ASTEG_GET_ARRAY		= $_GET;
		//---- MESSAGE QUEUE INCLUDE
		ASTEG_content::content_message_queue_display();

		 //---- ENGINE REDIRECTION

		if (count($ASTEG_GET_ARRAY) > 0) //---- MOTOR DE REDIRECCION DE PAGINAS
		{
			if (isset($ASTEG_GET_ARRAY['ID'])) //---- PAGE/LINK REDIRECTION
				include($theme_path.ASTEG_content::content_path($ASTEG_GET_ARRAY['ID']));
			elseif (isset($ASTEG_GET_ARRAY['PAGE'])) //---- PAGE/LINK REDIRECTION
				include($theme_path.ASTEG_content::content_path($ASTEG_GET_ARRAY['PAGE']));
		}
		else
			include ($theme_path."index.php");
	}

	protected function protected_engine_footer()
	{
		$theme_path	= ASTEG_resource::resource_get("RESOURCE_THEME_URL");
		include ($theme_path."language.en.inc.php");
		include ($theme_path."footer.php");
		unset($_GET['PAGE']);
		unset($_GET['ID']);
	}
}
?>