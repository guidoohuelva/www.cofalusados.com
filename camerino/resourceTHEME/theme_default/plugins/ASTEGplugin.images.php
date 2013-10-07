<?php
class ASTEGplugin_images
{
	var $plugin_page;
	var $plugin_post_code;
	var $plugin_action_update;
	var $plugin_button_cancel;
	var $plugin_button_update;
	var $plugin_page_title;
	var $plugin_display_array;
	var $plugin_media_path;
	var $image_array;


	//---- CONSTRUCTOR
	public function __construct()
	{
		include_once "../resourceASTEG/ASTEGfunctions.userdatabase.php";
		//---- SETTINGS
		$this->plugin_page									= 5;
		$this->plugin_post_code							= "ASTEGimage_code";
		$this->plugin_action_update					= "ASTEGimage_update";
		$this->plugin_button_cancel					= "Cancelar";
		$this->plugin_button_update					= "Upload";
		$this->plugin_page_title						  	= "Im&aacute;genes";
		$this->plugin_display_array[0]				= "T&iacute;tulo: ";
		$this->plugin_display_array[1]				= "Tama&ntilde;o: ";
		$this->plugin_display_array[2]				= "Posici&oacute;n";
		$this->plugin_display_array[3]				= "Vista Previa";
		$this->plugin_media_path						= "../userContent/CMS/";


		$image_array						= array();
		$image_counter						= 0;
		$temporal_array[ID]					= $image_counter;
		$temporal_array[FILENAME]			= 'img-1.png';
		$temporal_array[DESCRIPTION] 		= 'Contact Form';
		$temporal_array[SIZE]				= '200 x 140px';
		$temporal_array[HEIGHT]			 	= '50';
		array_push($image_array, $temporal_array); $image_counter++;
		$temporal_array[ID]					= $image_counter;
		$temporal_array[FILENAME]			= 'car_header.jpg';
		$temporal_array[DESCRIPTION] 		= 'Page Header';
		$temporal_array[SIZE]				= '450 x 130px';
		$temporal_array[HEIGHT]			 	= '90';
		array_push($image_array, $temporal_array); $image_counter++;
		$this->image_array					= $image_array;

	}
	//---- PUBLIC FUNCTIONS
	public function plugin_display()
	{
		//---- DISPLAY_CODE
		echo "<h3>".$this->plugin_page_title."</h3>";
		echo $this->private_plugin_display();
	}
	public function dispatch($event_array)
	{
		return $this->private_dispatch($event_array);
	}
	//---- PRIVATE FUNCTIONS
	private function private_plugin_display()
	{
		$result	.= $this->protected_helper_list();
		return $result;
	}

	private function private_dispatch($event_array)
	{
		$result					= ($event_array['ASTEGsubmit_code'] == $this->plugin_post_code)?true:false;
		$image_array		= $this->image_array;
		if ($result)
			switch ($event_array['POST_SUBMIT'])
			{
				case $this->plugin_button_update:
					//---- IMAGE LIST
					for ($i=0; $i < count($image_array); $i++)
						if ( ($event_array['POST_ID']==$image_array[$i][ID]) && (!empty($_FILES['POST_IMAGE']["name"])) )
						{
							copy  ($_FILES['POST_IMAGE']['tmp_name'],$this->plugin_media_path.$image_array[$i][FILENAME]);
							ASTEG_content::content_message_queue_add("9901");
						}

					break;
			}
		return $result;
	}
//---- PROTECTED FUNCTIONS
	protected function protected_helper_list()
	{
		$image_array		= $this->image_array;
		$random				= rand(0,3600);
		$result	.= "<div class='information_display'>";
		$result	.= "	<div class='display_title'>";
		$result	.= "		<div class='column_400'>Descripci&oacute;n</div>";
		$result	.= "		<div class='column_200'>".$this->plugin_display_array[3]."</div>";
		$result	.= "		<div class='column_50'></div>";
		$result	.= "	</div>";
		for ($i=0; $i < count($image_array); $i++)
		{
			$result	.= "	<div class='display_result'>";
			$result	.= "		<div class='column_400'>";
			$result	.= "			<b>".$this->plugin_display_array[0]."</b> ".$image_array[$i][DESCRIPTION]."<br />";
			$result	.= "			<img src='".THEME_PATH."images/spacer.png' width='400' height='5' />";
			$result	.= "			<b>".$this->plugin_display_array[1]."</b> ".$image_array[$i][SIZE]."<br />";
			$result	.= "			<img src='".THEME_PATH."images/spacer.png' width='400' height='5' />";
			$result 	.= "			<form action=''  method='post'  enctype='multipart/form-data' action='./?PAGE=".$this->plugin_page."'>
													<input type='hidden' 	name='ASTEGsubmit_code' 	value='".$this->plugin_post_code."'>
													<input type='hidden' 	name='POST_ID' 						value='".$image_array[$i][ID]."'>
													<input type='file' 			name='POST_IMAGE' 				value =''  class='form_input_line' />
													<input type='submit' 		name='POST_SUBMIT' 				value='".$this->plugin_button_update."' class='button_default button_blue' />
											</form>";
			$result	.= "		</div>";
			$result	.= "		<div class='column_200'><img src='".$this->plugin_media_path.$image_array[$i][FILENAME]."?$random'  height='".$image_array[$i][HEIGHT]."' /></div>";
			$result	.= "		<div class='column_50'></div>";
			$result	.= "	</div>";
		}
		$result	.= "	</div>";
		return $result;
	}
}
?>