<?php
class ASTEGplugin_emailcatcher
{
	var $plugin_table;
	var $plugin_page;
	var $plugin_settings;
	var $plugin_action_create;
	var $plugin_action_read;
	var $plugin_action_update;
	var $plugin_action_delete;
	var $plugin_button_create;
	var $plugin_button_cancel;
	var $plugin_button_update;
	var $plugin_page_title;
	var $plugin_page_create;
	var $plugin_display_array;
	var $plugin_groupcode_array;


	//---- CONSTRUCTOR
	public function __construct()
	{
		include_once "../resourceASTEG/ASTEGfunctions.userdatabase.php";
		//---- SETTINGS
		$this->plugin_table				= "FRAMEWORK_EMAILCATCHER";
		$this->plugin_page				= 7;
		$this->plugin_post_code			= "ASTEGemailcatcher_code";
		$this->plugin_action_create		= "ASTEGemailcatcher_create";
		$this->plugin_action_read			= "ASTEGemailcatcher_read";
		$this->plugin_action_update		= "ASTEGemailcatcher_update";
		$this->plugin_action_delete		= "ASTEGemailcatcher_delete";
		$this->plugin_button_create		= "Crear Nuevo";
		$this->plugin_button_cancel		= "Cancelar";
		$this->plugin_button_update		= "Guardar Cambios";
		$this->plugin_button_delete		= "Eliminar Email";
		$this->plugin_page_title			= "Listado de Suscriptores";
		$this->plugin_page_create			= "Nuevo Email";
		$this->plugin_page_read			= "Mostrar Email";
		$this->plugin_page_update		= "Editar Email";
		$this->plugin_page_delete			= "Eliminar Email";
		$this->plugin_display_array[0]		= "ID";
		$this->plugin_display_array[1]		= "Email";
		$this->plugin_display_array[2]		= "Fecha de Ingreso";
		$this->plugin_page_export					= "Descargar Listado";
	}
	//---- PUBLIC FUNCTIONS
	public function plugin_create()
	{
		return $this->private_plugin_create();
	}
	public function plugin_read($current_ID)
	{
		return $this->private_plugin_read($current_ID);
	}
	public function plugin_update($current_ID)
	{
		return $this->private_plugin_update($current_ID);
	}
	public function plugin_delete($current_ID)
	{
		return $this->private_plugin_delete($current_ID);
	}
	public function plugin_display()
	{
		//---- DISPLAY_CODE
		$action_session		= $_GET['ACTION'];
		$action_ID				= $_GET['ACTIONID'];
		switch ($action_session)
		{
			case $this->plugin_action_create:
				echo "<h3>".$this->plugin_page_title."</h3><h4>".$this->plugin_page_create."</h4>";
				echo $this->private_plugin_create();
				break;
			case $this->plugin_action_read:
				echo "<h3>".$this->plugin_page_title."</h3><h4>".$this->plugin_page_read."</h4>";
				echo $this->private_plugin_read($action_ID);
				break;
			case $this->plugin_action_update:
				echo "<h3>".$this->plugin_page_title."</h3><h4>".$this->plugin_page_update."</h4>";
				echo $this->private_plugin_update($action_ID);
				break;
			case $this->plugin_action_delete:
				echo "<h3>".$this->plugin_page_title."</h3><h4>".$this->plugin_page_delete."</h4>";
				echo $this->private_plugin_delete();
				break;
			default:
				echo "<h3>".$this->plugin_page_title."</h3>";
				echo $this->private_plugin_display();
				break;
		}
	}
	public function dispatch($event_array)
	{
		$result	= $this->private_dispatch($event_array);
		return $result;
	}
	//---- PRIVATE FUNCTIONS
	private function private_plugin_display()
	{
		$ASTEGdb				= new ASTEG_userdatabase();
		$request_array		= array();
		$result_array			= array();
		$request_array[query]		= "SELECT * FROM ".$this->plugin_table." WHERE FRAMEWORK_EMAIL <> '' GROUP BY FRAMEWORK_EMAIL ORDER BY ID DESC";
		$result_array						= $ASTEGdb->database_advanced_query($request_array);
		$result	.= $this->protected_helper_list($result_array);
		return $result;
	}
	private function private_plugin_create()
	{
		$result	.= $this->protected_helper_create();
		return $result;
	}
	private function private_plugin_read($action_ID)
	{
		$ASTEGdb				= new ASTEG_userdatabase();
		$request_array		= array();
		$result_array			= array();
		$request_array['ID']	= $action_ID;
		$result_array			= $ASTEGdb->database_read($this->plugin_table,$request_array);
		$result	.= $this->protected_helper_read($result_array);
		return $result;
	}
	private function private_plugin_update($action_ID)
	{

		$ASTEGdb				= new ASTEG_userdatabase();
		$request_array		= array();
		$result_array			= array();
		$request_array['ID']	= $action_ID;
		$result_array			= $ASTEGdb->database_read($this->plugin_table,$request_array);
		$result	.= $this->protected_helper_update($result_array);
		return $result;
	}
	private function private_plugin_delete()
	{
		return $result;
	}
	private function private_dispatch($event_array)
	{
		$result						= ($event_array['ASTEGsubmit_code'] == $this->plugin_post_code)?true:false;
		$ASTEGdb				= new ASTEG_userdatabase();
		$request_array		= array();
		$result_array			= array();
		if ($result)
			switch ($event_array['POST_SUBMIT'])
			{
				case $this->plugin_button_create:
					$request_array														= $event_array;
					$request_array['FRAMEWORK_DATETIME']		= ASTEG_utilities::utilities_mysql_datetime();
					$result_array									= $ASTEGdb->database_create($this->plugin_table,$request_array);
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9901");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;
				case $this->plugin_button_update:
					$request_array														= $event_array;
					$request_array['ID']												= $event_array['ACTIONID'];
					$request_array['FRAMEWORK_DATETIME']		= ASTEG_utilities::utilities_mysql_datetime();
					$result_array															= $ASTEGdb->database_update($this->plugin_table,$request_array);
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9901");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;
				case $this->plugin_button_delete:
					$request_array								= $event_array;
					$request_array['ID']						= $event_array['ACTIONID'];
					$result_array									= $ASTEGdb->database_read($this->plugin_table,$request_array);
					$delete_query[query]					= "DELETE FROM ".$this->plugin_table." WHERE FRAMEWORK_EMAIL = '".$result_array[field1]."'";
					$result_array									= $ASTEGdb->database_advanced_query($delete_query);
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9902");
					else
						ASTEG_content::content_message_queue_add("9901");
					break;
			}

		return $result;
	}
//---- PROTECTED FUNCTIONS




	protected function protected_helper_list($result_array)
	{
		$result	= "<div class='information_display_main'>";
		$result	.= "	<div class='display_result'>";
		$result	.= "		<div class='column_500 button_space'><a href='./?PAGE=".$this->plugin_page."&ACTION=".$this->plugin_action_create."'class='button_default button_blue' >".$this->plugin_page_create."</a>&nbsp;<a href='../RPC.php?ASTEGrpc=export_toexcel&CODE=".md5(session_id())."' target='_blank' class='button_default button_green' >".$this->plugin_page_export."</a></div>";
		$result	.= "	</div>";
		$result	.= "</div>";

		$result	.= "<div class='information_display'>";
		$result	.= "	<div class='display_title'>";
		$result	.= "		<div class='column_30'>&nbsp;</div>";
		$result	.= "		<div class='column_500'>".$this->plugin_display_array[1]."</div>";
		$result	.= "		<div class='column_200'>".$this->plugin_display_array[2]."</div>";
		$result	.= "		<div class='column_10'></div>";
		$result	.= "	</div>";
		for ($i=0; $i < $result_array['rowcount']; $i++)
		{
			$result	.= "	<div class='display_result'>";
			$result	.= "		<div class='column_30'>&nbsp;</div>";
			$result	.= "		<div class='column_500'><a href='./?PAGE=".$this->plugin_page."&ACTION=".$this->plugin_action_update."&ACTIONID=".$result_array[$i]['field0']." ' >".$result_array[$i]['field1']."</a></div>";
			$result	.= "		<div class='column_200'>".ASTEG_utilities::utilities_cropstring(strip_tags($result_array[$i]['field2']),85)."</div>";
			$result	.= "		<div class='column_10'>&nbsp;</div>";
			$result	.= "	</div>";
			$result	.= "	<div class='display_result' id='display_item".$result_array[$i]['field0']."' style='display:none;'></div>";
		}
		$result	.= "</div>";
		return $result;
	}
	protected function protected_helper_create()
	{
		$result	= "<form name='' method='post' action='./?PAGE=".$this->plugin_page."'>";
		$result	.=	"	<input type='hidden' name='ASTEGsubmit_code' value='".$this->plugin_post_code."' >";
		$result	.= "	<div class='information_display'>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[1]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='FRAMEWORK_EMAIL' value='' /></div></div>";
		$result 	.= "		<div class='display_item'><div class='column_990 text_right'>";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_create."' class='button_default button_blue' />";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_cancel."' class='button_default button_gray' />";
		$result	.= "			<img src='".THEME_PATH."images/spacer.png' width='20' height='20' />";
		$result	.= "		</div></div>";
		$result	.= "</div>";
		$result	.= "</form>";
		return $result;
			}
	protected function protected_helper_update($result_array)
	{
		$result	= "<form name='' method='post' action='./?PAGE=".$this->plugin_page."'>";
		$result	.=	"	<input type='hidden' name='ASTEGsubmit_code' value='".$this->plugin_post_code."' >";
		$result	.=	"	<input type='hidden' name='ACTIONID' value='".$result_array['field0']."' >";
		$result	.= "	<div class='information_display'>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[1]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$result_array['field1']."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[2]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$result_array['field2']."</div></div>";
		$result 	.= "		<div class='display_item'><div class='column_990 text_right'>";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_delete."' class='button_default button_red' />";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_cancel."' class='button_default button_gray' />";
		$result	.= "			<img src='".THEME_PATH."images/spacer.png' width='20' height='20' />";
		$result	.= "		</div></div>";
		$result	.= "	</div>";
		$result	.= "</form>";
		$result .= '<script type="text/javascript">CKEDITOR.replace( "textarea_editor");</script>';
		return $result;
	}
}
?>