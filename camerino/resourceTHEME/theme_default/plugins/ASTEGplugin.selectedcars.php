<?php
class ASTEGplugin_selectedcars
{
	var $plugin_table;
	var $plugin_page;
	var $plugin_action_update;
	var $plugin_button_cancel;
	var $plugin_button_update;
	var $plugin_page_title;
	var $plugin_page_create;
	var $plugin_display_array;
	//---- CONSTRUCTOR
	public function __construct()
	{
		include_once "../resourceASTEG/ASTEGfunctions.userdatabase.php";
		//---- SETTINGS
		$this->plugin_table						= "PLUGIN_CAR_SELECTED";
		$this->plugin_page						= 10;
		$this->plugin_post_code					= "ASTEGselectedcars_code";
		$this->plugin_action_update				= "ASTEGselectedcars_update";
		$this->plugin_button_cancel				= "Cancelar";
		$this->plugin_button_update				= "Guardar Cambios";
		$this->plugin_page_title				= "Veh&iacute;culos Populares";
		$this->plugin_page_update				= "Editar Populares";
		$this->plugin_display_array[0]			= "ID";
		$this->plugin_display_array[1]			= "Veh&iacute;culo";
	}
	//---- PUBLIC FUNCTIONS
	public function plugin_update($current_ID)
	{
		return $this->private_plugin_update($current_ID);
	}
	public function plugin_display()
	{
		//---- DISPLAY_CODE
		$action_session			= $_GET['ACTION'];
		$action_ID				= $_GET['ACTIONID'];
		switch ($action_session)
		{
			case $this->plugin_action_update:
				echo "<h3>".$this->plugin_page_title."</h3><h4>".$this->plugin_page_update."</h4>";
				echo $this->private_plugin_update($action_ID);
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
		$ASTEGdb	= new ASTEG_userdatabase();
		$result		.= $this->protected_helper_list($ASTEGdb->database_list($this->plugin_table,array()));
		return $result;
	}
	private function private_plugin_update($action_ID)
	{
		$ASTEGdb				= new ASTEG_userdatabase();
		$result	.= $this->protected_helper_update($ASTEGdb->database_read($this->plugin_table,array("ID"=>$action_ID)));
		return $result;
	}
	private function private_dispatch($event_array)
	{
		$result		= ($event_array['ASTEGsubmit_code'] == $this->plugin_post_code)?true:false;
		if ($result)
		{
			$ASTEGdb				= new ASTEG_userdatabase();
			$request_array			= array();
			$result_array			= array();
			switch ($event_array['POST_SUBMIT'])
			{
				case $this->plugin_button_update:
					$request_array			= $event_array;
					$request_array['ID']	= $event_array['ACTIONID'];
					$result_array			= $ASTEGdb->database_update($this->plugin_table,$request_array);
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9901");
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
		$result	=  "<div class='information_display'>";
		$result	.= "	<div class='display_title'>";
		$result	.= "		<div class='column_10'>&nbsp;</div>";
		$result	.= "		<div class='column_200'>".$this->plugin_display_array[1]."</div>";
		$result	.= "		<div class='column_30'></div>";
		$result	.= "	</div>";
		for ($i=0; $i < $result_array['rowcount']; $i++)
		{
			
			if ($result_array[$i]['field1'] == -1)
			{
				$selected_vehicle	= "N/A";
			}
			else
			{
				$ASTEGdb			= new ASTEG_database();
				$vehicle_request	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT VEHICLE_NAME FROM PLUGIN_CAR_GALLERY WHERE ID = ".$result_array[$i]['field1']." "));
				$selected_vehicle	= $vehicle_request[0][field0];
			}
			$background_color	= ($i%2 == 0)?" background-color:#EEE; ":"";
			$result	.= "	<div class='display_result' style='".$background_color."'>";
			$result	.= "		<div class='column_10'>&nbsp;</div>";
			$result	.= "		<div class='column_200'><b><a href='./?PAGE=".$this->plugin_page."&ACTION=".$this->plugin_action_update."&ACTIONID=".$result_array[$i]['field0']." ' >&raquo; ".$selected_vehicle."</a></b></div>";
			$result	.= "		<div class='column_30'>&nbsp;</div>";
			$result	.= "	</div>";
		}
		$result	.= "</div>";
		return $result;
	}
	protected function protected_helper_update($result_array)
	{
		$car_select		= $this->protected_helper_car_select("CAR_ID",$result_array[field1]);
		
		$result	= "<form name='' method='post' action='./?PAGE=".$this->plugin_page."'>";
		$result	.=	"	<input type='hidden' name='ASTEGsubmit_code' value='".$this->plugin_post_code."' >";
		$result	.=	"	<input type='hidden' name='ACTIONID' value='".$result_array['field0']."' >";
		$result	.= "	<div class='information_display'>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[1]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$car_select."</div></div>";
		$result .= "		<div class='display_item'><div class='column_990 text_right'>";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_update."' class='button_default button_blue' />";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_cancel."' class='button_default button_gray' />";
		$result	.= "			<img src='".THEME_PATH."images/spacer.png' width='20' height='20' />";
		$result	.= "		</div></div>";
		$result	.= "	</div>";
		$result	.= "</form>";
		return $result;
	}
	protected function protected_helper_car_select($selected_name, $selected_car = -1)
	{
		$ASTEGdb			= new ASTEG_database();
		$vehicle_request	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT * FROM PLUGIN_CAR_GALLERY WHERE VEHICLE_SOLD = 0"));
		$select_html		= "<select name='$selected_name' >";
		for ($i = 0; $i < $vehicle_request[rowcount]; $i++)
		{
			$selected_tag		= ($vehicle_request[$i][field0] == $selected_car)?" selected='selected' ":"";
			$select_html		.= "<option value='".$vehicle_request[$i][field0]."' $selected_tag >".$vehicle_request[$i][field1]."</option>";
		}
		$select_html		.= "</select>";
		return $select_html;
	}
}
?>