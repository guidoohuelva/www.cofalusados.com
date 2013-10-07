<?php
class ASTEGplugin_posts
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
		$this->plugin_table					= "FRAMEWORK_POSTS";
		$this->plugin_page					= 4;
		$this->plugin_post_code				= "ASTEGposts_code";
		$this->plugin_action_create			= "ASTEGposts_create";
		$this->plugin_action_read			= "ASTEGposts_read";
		$this->plugin_action_update			= "ASTEGposts_update";
		$this->plugin_action_delete			= "ASTEGposts_delete";
		$this->plugin_button_create			= "Crear Nueva Noticia";
		$this->plugin_button_cancel			= "Cancelar";
		$this->plugin_button_update			= "Guardar Cambios";
		$this->plugin_button_delete			= "Eliminar Contenido";
		$this->plugin_page_title			= "Contenidos";
		$this->plugin_page_create			= "Crear Nueva Noticia";
		$this->plugin_page_read				= "Mostrar contenido";
		$this->plugin_page_update			= "Editar Contenido";
		$this->plugin_page_delete				= "Eliminar";
		$this->plugin_display_array[0]			= "ID";
		$this->plugin_display_array[1]			= "T&iacute;tulo";
		$this->plugin_display_array[2]			= "";
		$this->plugin_display_array[3]			= "Tags &amp; Categor&iacute;as";
		$this->plugin_display_array[4]			= "Extras";
		$this->plugin_display_array[5]			= "C&oacute;digo de Grupo";
		$this->plugin_display_array[6]			= "&Uacute;ltima Modificaci&oacute;n";
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
		 $request_array[FIELDORDERFIELDNAME]			= "POST_GROUPID";
		$result_array			= $ASTEGdb->database_list($this->plugin_table,$request_array);
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
		$result					= ($event_array['ASTEGsubmit_code'] == $this->plugin_post_code)?true:false;
		$ASTEGdb				= new ASTEG_userdatabase();
		$request_array		= array();
		$result_array			= array();
		if ($result)
			switch ($event_array['POST_SUBMIT'])
			{
				case $this->plugin_button_create:
					$request_array								= $event_array;
					$request_array['DATE_MODIFIED']	= ASTEG_utilities::utilities_mysql_datetime();
					$result_array									= $ASTEGdb->database_create($this->plugin_table,$request_array);
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9901");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;
				case $this->plugin_button_update:
					$request_array								= $event_array;
					$request_array['ID']							= $event_array['ACTIONID'];
					$request_array['DATE_MODIFIED']	= ASTEG_utilities::utilities_mysql_datetime();
					$result_array									= $ASTEGdb->database_update($this->plugin_table,$request_array);
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9901");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;
				case $this->plugin_button_delete:
					$request_array								= $event_array;
					$request_array['ID']							= $event_array['ACTIONID'];
					$result_array									= $ASTEGdb->database_delete($this->plugin_table,$request_array);
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9902");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;
			}
		return $result;
	}
//---- PROTECTED FUNCTIONS




	protected function protected_helper_list($result_array)
	{

//----
		$title_array						= array();
		$title_array[0][title]				= "General";
		$title_array[0][top]				= 1000;
		$title_array[0][bottom]				= 1999;
		$title_array[1][title]				= "Servicios";
		$title_array[1][top]				= 3000;
		$title_array[1][bottom]				= 3999;
		$title_array[2][title]				= "Beneficios";
		$title_array[2][top]				= 4000;
		$title_array[2][bottom]				= 4999;
		$title_array[3][title]				= "Contacto";
		$title_array[3][top]				= 5000;
		$title_array[3][bottom]				= 5999;
		$title_array[4][title]				= "Footer";
		$title_array[4][top]				= 6000;
		$title_array[4][bottom]				= 6999;
		$title_counter						= 0;
//----
		$result	.= "<div class='information_display'>";
		$result	.= "	<div class='display_title'>";
		$result	.= "		<div class='column_10'>&nbsp;</div>";
		$result	.= "		<div class='column_200'>".$this->plugin_display_array[1]."</div>";
		$result	.= "		<div class='column_500'>".$this->plugin_display_array[2]."</div>";
		$result	.= "		<div class='column_200'>".$this->plugin_display_array[6]."</div>";
		$result	.= "		<div class='column_30'></div>";
		$result	.= "	</div>";
		for ($i=0; $i < $result_array['rowcount']; $i++)
		{
			$background_color	= ($i%2 == 0)?" background-color:#EEE; ":"";

			if ( ($title_array[$title_counter][top] < $result_array[$i]['field5']) && ($title_array[$title_counter][bottom] > $result_array[$i]['field5']) )
			{
				$result	.= "	<div class='display_result' style='padding-top:20px'>";
				$result	.= "		<div class='column_200'><b>".$title_array[$title_counter][title]."</b></div>";
				$result	.= "	</div>";
				$title_counter++;
			}

			$result	.= "	<div class='display_result' style='".$background_color."'>";
			$result	.= "		<div class='column_10'>&nbsp;</div>";
			$result	.= "		<div class='column_200'><b><a href='./?PAGE=".$this->plugin_page."&ACTION=".$this->plugin_action_update."&ACTIONID=".$result_array[$i]['field0']." ' >".$result_array[$i]['field1']."</a></b></div>";
			$result	.= "		<div class='column_500'>".ASTEG_utilities::utilities_cropstring(strip_tags($result_array[$i]['field2']),85)."</div>";
			$result	.= "		<div class='column_200'>".$result_array[$i]['field6']."</div>";
			$result	.= "		<div class='column_30'><b class='button' style='color:#3F82DD' onclick='display_post(".$result_array[$i]['field0'].")'></b></div>";
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
		$result	.=	"	<input type='hidden' name='POST_GROUPID' value='9101' >";
		$result	.= "	<div class='information_display'>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[1]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='POST_TITLE' value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold' style='height:310px;vertical-align:top;'>".$this->plugin_display_array[2]."</div><div class='column_10'></div><div class='column_780 form_input_line column_editor'><textarea id='textarea_editor' name='POST_DETAIL'></textarea></div></div>";
		$result 	.= "		<div class='display_item'><div class='column_990 text_right'>";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_create."' class='button_default button_blue' />";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_cancel."' class='button_default button_gray' />";
		$result	.= "			<img src='".THEME_PATH."images/spacer.png' width='20' height='20' />";
		$result	.= "		</div></div>";
		$result	.= "</div>";
		$result	.= "</form>";
		$result .= '<script type="text/javascript">CKEDITOR.replace( "textarea_editor");</script><br/>';
		return $result;
			}
	protected function protected_helper_read($result_array)
	{
		$result	= "<div class='information_display_read'>";
		$result	.= "<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[2]."</div><div class='column_600 '>".$result_array['field2']."</div></div>";
		$result	.= "<form name='' method='post' action='./?PAGE=".$this->plugin_page."'><input type='hidden' name='ASTEGsubmit_code' value='".$this->plugin_post_code."' ><input type='hidden' name='ACTIONID' value='".$result_array['field0']."' >";
		$result	.= "		<div class='column_400 button_space'>";
		$result	.= "			<a href='./?PAGE=".$this->plugin_page."&ACTION=".$this->plugin_action_update."&ACTIONID=".$result_array['field0']."' class='link_button_default' style='color:#6fa200;' >&raquo; Editar Contenido</a>";
		$result	.= "		</div>";
		$result	.= "	</div>";
		$result	.= "</form>";
		$result	.= "</div><br/>";
		return $result;
	}
	protected function protected_helper_update($result_array)
	{
		$result	= "<form name='' method='post' action='./?PAGE=".$this->plugin_page."'>";
		$result	.=	"	<input type='hidden' name='ASTEGsubmit_code' value='".$this->plugin_post_code."' >";
		$result	.=	"	<input type='hidden' name='ACTIONID' value='".$result_array['field0']."' >";
		$result	.= "	<div class='information_display'>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[1]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='POST_TITLE' value='".$result_array['field1']."' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[6]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$result_array['field6']."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold' style='height:310px;vertical-align:top;'>".$this->plugin_display_array[2]."</div><div class='column_10'></div><div class='column_780 form_input_line column_editor'><textarea name='POST_DETAIL' id='textarea_editor'>".$result_array['field2']."</textarea></div></div>";
		$result 	.= "		<div class='display_item'><div class='column_990 text_right'>";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_update."' class='button_default button_blue' />";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_cancel."' class='button_default button_gray' />";
		$result	.= "			<img src='".THEME_PATH."images/spacer.png' width='20' height='20' />";
		$result	.= "		</div></div>";
		$result	.= "	</div>";
		$result	.= "</form><br/>";
		$result .= '<script type="text/javascript">CKEDITOR.replace( "textarea_editor");</script>';
		return $result;
	}

	protected function helper_group_code($select_name,$selected_ID = 0)
	{
			$result	= "<select name='".$select_name."'>";
			for ($i = 0;$i < count($this->plugin_groupcode_array); $i++)
			if ($selected_ID == $this->plugin_groupcode_array[$i][0])
				$result	.= "<option value='".$this->plugin_groupcode_array[$i][0]."' selected='selected'>Seleccionado: <b>".$this->plugin_groupcode_array[$i][1]."</b></option>";
			else
				$result	.= "<option value='".$this->plugin_groupcode_array[$i][0]."'>".$this->plugin_groupcode_array[$i][1]."</option>";
			$result	.= "</select>";
			return $result;
	}

	protected function helper_display_groupcode($selected_ID)
	{
			for ($i = 0;$i < count($this->plugin_groupcode_array); $i++)
			if ($selected_ID == $this->plugin_groupcode_array[$i][0])
				$result	.= $this->plugin_groupcode_array[$i][1];
			return $result;
	}

}
?>