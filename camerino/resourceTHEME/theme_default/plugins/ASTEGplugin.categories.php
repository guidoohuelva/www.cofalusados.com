<?php
class ASTEGplugin_categories
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
		$this->plugin_table					= "PLUGIN_BRAND_CATEGORIES";
		$this->plugin_page					= 9;
		$this->plugin_post_code				= "ASTEGcategories_code";
		$this->plugin_action_create			= "ASTEGcategories_create";
		$this->plugin_action_read			= "ASTEGcategories_read";
		$this->plugin_action_update			= "ASTEGcategories_update";
		$this->plugin_action_delete			= "ASTEGcategories_delete";
		$this->plugin_button_create			= "Crear Nueva Marca";
		$this->plugin_button_cancel			= "Cancelar";
		$this->plugin_button_update			= "Guardar Cambios";
		$this->plugin_button_delete			= "Eliminar";
		$this->plugin_page_title			= "Marcas";
		$this->plugin_page_create			= "Crear Nueva Marca";
		$this->plugin_page_read				= "Mostrar Marca";
		$this->plugin_page_update			= "Editar Marca";
		$this->plugin_page_delete			= "Eliminar";
		$this->plugin_display_array[0]		= "ID";
		$this->plugin_display_array[1]		= "Marca";
	}
	//---- PUBLIC FUNCTIONS
	public function plugin_create()
	{
		return $this->private_plugin_create();
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
		$action_ID			= $_GET['ACTIONID'];
		switch ($action_session)
		{
			case $this->plugin_action_create:
				echo "<h3>".$this->plugin_page_title."</h3><h4>".$this->plugin_page_create."</h4>";
				echo $this->private_plugin_create();
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
		$ASTEGdb		= new ASTEG_userdatabase();
		$result_array	= $ASTEGdb->database_list($this->plugin_table,array());
		$result			.= $this->protected_helper_list($result_array);
		return $result;
	}
	private function private_plugin_create()
	{
		$result	.= $this->protected_helper_create();
		return $result;
	}
	private function private_plugin_update($action_ID)
	{
		$ASTEGdb		= new ASTEG_userdatabase();
		$result_array	= $ASTEGdb->database_read($this->plugin_table,array("ID"=>$action_ID));
		$result			.= $this->protected_helper_update($result_array);
		return $result;
	}
	private function private_plugin_delete()
	{
		return TRUE;
	}
	private function private_dispatch($event_array)
	{
		$result			= ($event_array['ASTEGsubmit_code'] == $this->plugin_post_code)?TRUE:FALSE;
		if ($result)
		{
			$ASTEGdb				= new ASTEG_userdatabase();
			$request_array			= array();
			$result_array			= array();
			switch ($event_array['POST_SUBMIT'])
			{
				case $this->plugin_button_create:
					$request_array		= $event_array;
					$result_array		= $ASTEGdb->database_create($this->plugin_table,$request_array);
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9901");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;
				case $this->plugin_button_update:
					$request_array			= $event_array;
					$request_array['ID']	= $event_array['ACTIONID'];
					$result_array			= $ASTEGdb->database_update($this->plugin_table,$request_array);
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9901");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;
				case $this->plugin_button_delete:
					$request_array			= $event_array;
					$request_array['ID']	= $event_array['ACTIONID'];
					$result_array			= $ASTEGdb->database_delete($this->plugin_table,$request_array);
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9902");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;
			}
		}
		return $result;
	}
//---- PROTECTED FUNCTIONS
	protected function protected_helper_list($result_array)
	{
		$result	= "<div class='information_display_main'>";
		$result	.= "	<div class='display_result'>";
		$result	.= "		<div class='column_200 button_space'><a href='./?PAGE=".$this->plugin_page."&ACTION=".$this->plugin_action_create."'class='button_default button_blue' >".$this->plugin_page_create."</a></div>";
		$result	.= "	</div>";
		$result	.= "</div>";

		$result	.= "<div class='information_display'>";
		$result	.= "	<div class='display_title'>";
		$result	.= "		<div class='column_10'>&nbsp;</div>";
		$result	.= "		<div class='column_200'>".$this->plugin_display_array[1]."</div>";
		$result	.= "		<div class='column_30'></div>";
		$result	.= "	</div>";
		for ($i=0; $i < $result_array['rowcount']; $i++)
		{
			$background_color	= ($i%2 == 0)?" background-color:#EEE; ":"";
			$result	.= "	<div class='display_result' style='".$background_color."'>";
			$result	.= "		<div class='column_10'>&nbsp;</div>";
			$result	.= "		<div class='column_200'><b><a href='./?PAGE=".$this->plugin_page."&ACTION=".$this->plugin_action_update."&ACTIONID=".$result_array[$i]['field0']." ' >".$result_array[$i]['field1']."</a></b></div>";
			$result	.= "		<div class='column_30'>&nbsp;</div>";
			$result	.= "	</div>";
		}
		$result	.= "</div>";
		return $result;
	}
	protected function protected_helper_create()
	{
		$result	= "<form name='' method='post' action='./?PAGE=".$this->plugin_page."'>";
		$result	.=	"	<input type='hidden' name='ASTEGsubmit_code' value='".$this->plugin_post_code."' >";
		$result	.= "	<div class='information_display'>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[1]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='CATEGORY_NAME' value='' /></div></div>";
		$result .= "		<div class='display_item'><div class='column_990 text_right'>";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_create."' class='button_default button_blue' />";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_cancel."' class='button_default button_gray' />";
		$result	.= "			<img src='".THEME_PATH."images/spacer.png' width='20' height='20' />";
		$result	.= "		</div></div>";
		$result	.= "</div>";
		$result	.= "</form>";
		$result .= '<script type="text/javascript">CKEDITOR.replace( "textarea_editor");</script><br/>';
		return $result;
	}
	protected function protected_helper_update($result_array)
	{
		$result	= "<form name='' method='post' action='./?PAGE=".$this->plugin_page."'>";
		$result	.=	"	<input type='hidden' name='ASTEGsubmit_code' value='".$this->plugin_post_code."' >";
		$result	.=	"	<input type='hidden' name='ACTIONID' value='".$result_array['field0']."' >";
		$result	.= "	<div class='information_display'>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[1]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='CATEGORY_NAME' value='".$result_array['field1']."' /></div></div>";
		$result .= "		<div class='display_item'><div class='column_990 text_right'>";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_update."' class='button_default button_blue' />";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_delete."' class='button_default button_red' />";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_cancel."' class='button_default button_gray' />";
		$result	.= "			<img src='".THEME_PATH."images/spacer.png' width='20' height='20' />";
		$result	.= "		</div></div>";
		$result	.= "	</div>";
		$result	.= "</form><br/>";
		$result .= '<script type="text/javascript">CKEDITOR.replace( "textarea_editor");</script>';
		return $result;
	}
}
?>