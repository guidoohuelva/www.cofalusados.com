<?php
class ASTEGplugin_usedcars
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
		$this->plugin_table					= "PLUGIN_CAR_GALLERY";
		$this->plugin_page					= 8;
		$this->plugin_post_code					= "ASTEGused_code";
		$this->plugin_action_create				= "ASTEGused_create";
		$this->plugin_action_read				= "ASTEGused_read";
		$this->plugin_action_update				= "ASTEGused_update";
		$this->plugin_action_delete				= "ASTEGused_delete";
		$this->plugin_button_create				= "Crear Nuevo Vehículo";
		$this->plugin_button_cancel				= "Cancelar";
		$this->plugin_button_update				= "Guardar Cambios";
		$this->plugin_button_delete				= "Eliminar Vehículo";
		$this->plugin_button_reserve				= "Reservar Vehículo";
		$this->plugin_button_unreserve				= "Quitar Reserva";
		$this->plugin_button_uploadandcontinue                  = "Subir imagen y continuar";
		$this->plugin_button_upload				= "Subir imagen";
		$this->plugin_page_title				= "Veh&iacute;culos";
		$this->plugin_page_create				= "Crear Nuevo Vehículo";
		$this->plugin_page_read					= "Mostrar Vehículo";
		$this->plugin_page_update				= "Editar Vehículo";
		$this->plugin_page_delete				= "Eliminar Vehículo";
		$this->plugin_display_array[0]			= "ID";
		$this->plugin_display_array[1]			= "Título";
		$this->plugin_display_array[2]			= "Precio Q.";
		$this->plugin_display_array[3]			= "Marca";
		$this->plugin_display_array[4]			= "Año";
		$this->plugin_display_array[5]			= "Kilometraje";
		$this->plugin_display_array[6]			= "Tipo de Combustible";
		$this->plugin_display_array[7]			= "Trasmisión";
		$this->plugin_display_array[8]			= "Tipo de Veh&iacute;culo";
		$this->plugin_display_array[9]			= "Puertas";
		$this->plugin_display_array[10]			= "Color Exterior";
		$this->plugin_display_array[11]			= "Color Interior";
		$this->plugin_display_array[12]			= "Descripci&oacute;n";
		$this->plugin_display_array[13]			= "Cuotas desde Q.";
		$this->plugin_display_array[14]			= "Thumbnail";
		$this->plugin_display_array[15]			= "Imagen Principal";
		$this->plugin_display_array[16]			= "Galer&iacute;a de Im&aacute;genes";
		$this->plugin_display_array[17]			= "Agregar otra imagen";
		//---- Arrays
		$this->combustible_array	= array();
		$this->combustible_array[0]	= array("field0"=>0,"field1"=>"Gasolina");
		$this->combustible_array[1]	= array("field0"=>1,"field1"=>"Diesel");
		$this->combustible_array[2]	= array("field0"=>2,"field1"=>"Electricidad");
		$this->combustible_array[3]	= array("field0"=>3,"field1"=>"Híbrido");
		$this->transmision_array	= array();
		$this->transmision_array[0]	= array("field0"=>0,"field1"=>"Mecánico");
		$this->transmision_array[1]	= array("field0"=>1,"field1"=>"Automático");
		$this->transmision_array[2]	= array("field0"=>2,"field1"=>"Tiptronic");
		$this->vehicle_array		= array();
		$this->vehicle_array[0]		= array("field0"=>0,"field1"=>"Sedán");
		$this->vehicle_array[1]		= array("field0"=>1,"field1"=>"Hatchback");
		$this->vehicle_array[2]		= array("field0"=>2,"field1"=>"Camionetas");
		$this->vehicle_array[3]		= array("field0"=>3,"field1"=>"SUV");
		$this->vehicle_array[4]		= array("field0"=>4,"field1"=>"Comerciales");
		$this->vehicle_array[5]		= array("field0"=>5,"field1"=>"Deportivos");
		$this->vehicle_array[6]		= array("field0"=>6,"field1"=>"Pickups");
		$this->doors_array			= array();
		$this->doors_array[0]		= array("field0"=>2,"field1"=>"2");
		$this->doors_array[1]		= array("field0"=>3,"field1"=>"3");
		$this->doors_array[2]		= array("field0"=>4,"field1"=>"4");
		$this->doors_array[3]		= array("field0"=>5,"field1"=>"5");
		$this->doors_array[4]		= array("field0"=>6,"field1"=>"6");

		$ASTEGdb				= new ASTEG_database();
		$temp_array				= $ASTEGdb->database_advanced_query(array("query"=>"SELECT * FROM PLUGIN_BRAND_CATEGORIES ORDER BY CATEGORY_NAME"));
		$this->category_array	= array();
		for ($i = 0; $i < $temp_array[rowcount]; $i++)
		{
			$this->category_array[$i]	= $temp_array[$i];
		}
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
		$action_session			= $_GET['ACTION'];
		$action_ID				= $_GET['ACTIONID'];
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
		$result_array	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT * FROM ".$this->plugin_table." WHERE VEHICLE_SOLD < 2 ORDER BY VEHICLE_BRAND"));
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
		$result				= ($event_array['ASTEGsubmit_code'] == $this->plugin_post_code)?TRUE:FALSE;
		if ($result)
		{
			$ASTEGdb			= new ASTEG_userdatabase();
			$result_array		= array();
			$request_array		= $event_array;
			switch ($event_array['POST_SUBMIT'])
			{
				case $this->plugin_button_create:
					$request_array[VEHICLE_ADDEDON]	= date("Y-m-d H:i:s");
					//---- IMAGES MANAGEMENT
					$fullsize		= ASTEG_utilities::utilities_upload_image($_FILES[VEHICLE_IMAGE],"../userContent/");
					$gallery		= array();
					for ($i = 1; $i < 9; $i++)
					{
						$gallery_item	= ASTEG_utilities::utilities_upload_image($_FILES["VEHICLE_GALLERY0".$i],"../userContent/");
						if ($gallery_item != "")
							array_push ($gallery,$gallery_item);
					}


					if ($fullsize != "")
					{
						include_once '../resourcePLUGINS/SimpleImage.php';
						$resize_image	= new SimpleImage;
						$resize_image->load("../userContent/".$fullsize);
						$resize_image->resize(162,115);
						$resize_image->save("../userContent/thumb_".$fullsize);
						$thumbnail		= "thumb_".$fullsize;
						$request_array[VEHICLE_IMAGE]		= $fullsize;
						$request_array[VEHICLE_THUMBNAIL]	= $thumbnail;
					}
					if (is_array($gallery))
						$request_array[VEHICLE_GALLERY]	= json_encode ($gallery);

					//---- STARTING AT
					$request_array[VEHICLE_STARTING]	= $this->protected_helper_starting_price($request_array[VEHICLE_PRICE]);

					//---- CREATE ITEM
					$result_array		= $ASTEGdb->database_create($this->plugin_table,$request_array);
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9901");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;

				case $this->plugin_button_uploadandcontinue:
					$request_array[VEHICLE_ADDEDON]	= date("Y-m-d H:i:s");
					//---- IMAGES MANAGEMENT
					$fullsize		= ASTEG_utilities::utilities_upload_image($_FILES[VEHICLE_IMAGE],"../userContent/");
					$gallery		= array();
					for ($i = 1; $i < 9; $i++)
					{
						$gallery_item	= ASTEG_utilities::utilities_upload_image($_FILES["VEHICLE_GALLERY0".$i],"../userContent/");
						if ($gallery_item != "")
							array_push ($gallery,$gallery_item);
					}
					if ($fullsize != "")
					{
						include_once '../resourcePLUGINS/SimpleImage.php';
						$resize_image	= new SimpleImage;
						$resize_image->load("../userContent/".$fullsize);
						$resize_image->resize(162,115);
						$resize_image->save("../userContent/thumb_".$fullsize);
						$thumbnail		= "thumb_".$fullsize;
						$request_array[VEHICLE_IMAGE]		= $fullsize;
						$request_array[VEHICLE_THUMBNAIL]	= $thumbnail;
					}

					//---- STARTING AT
					$request_array[VEHICLE_STARTING]	= $this->protected_helper_starting_price($request_array[VEHICLE_PRICE]);

					if (is_array($gallery))
						$request_array[VEHICLE_GALLERY]	= json_encode ($gallery);
					//---- CREATE ITEM
					$result_array		= $ASTEGdb->database_create($this->plugin_table,$request_array);
					$_GET[PAGE]			= $this->plugin_page;
					$_GET[ACTION]		= $this->plugin_action_update;
					$_GET[ACTIONID]		= $result_array[ID];

					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9901");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;

				case $this->plugin_button_upload:
					$request_array['ID']	= $event_array['ACTIONID'];
					//---- IMAGES MANAGEMENT
					$fullsize		= ASTEG_utilities::utilities_upload_image($_FILES[VEHICLE_IMAGE],"../userContent/");
					$gallery		= ASTEG_utilities::utilities_upload_image($_FILES[VEHICLE_GALLERY],"../userContent/");
					if ($fullsize != "")
					{
						include_once '../resourcePLUGINS/SimpleImage.php';
						$resize_image	= new SimpleImage;
						$resize_image->load("../userContent/".$fullsize);
						$resize_image->resize(162,115);
						$resize_image->save("../userContent/thumb_".$fullsize);
						$thumbnail		= "thumb_".$fullsize;
						$request_array[VEHICLE_IMAGE]		= $fullsize;
						$request_array[VEHICLE_THUMBNAIL]	= $thumbnail;
					}
					$image_array		= array();
					foreach( $_POST as $key=>$value)
						if (strpos($key, "y_item") > 0)
							array_push ($image_array, $value);
					if ($gallery != "")
						array_push($image_array, $gallery);
					$request_array[VEHICLE_GALLERY]	= json_encode ($image_array);

					//---- STARTING AT
					$request_array[VEHICLE_STARTING]	= $this->protected_helper_starting_price($request_array[VEHICLE_PRICE]);


					//---- UPDATE ITEM
					$result_array		= $ASTEGdb->database_update($this->plugin_table,$request_array);
					$_GET[PAGE]			= $this->plugin_page;
					$_GET[ACTION]		= $this->plugin_action_update;
					$_GET[ACTIONID]		= $request_array[ID];
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9901");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;

				case $this->plugin_button_update:
					$request_array['ID']	= $event_array['ACTIONID'];
					//---- IMAGES MANAGEMENT
					$fullsize		= ASTEG_utilities::utilities_upload_image($_FILES[VEHICLE_IMAGE],"../userContent/");
					$gallery		= ASTEG_utilities::utilities_upload_image($_FILES[VEHICLE_GALLERY],"../userContent/");
					if ($fullsize != "")
					{
						include_once '../resourcePLUGINS/SimpleImage.php';
						$resize_image	= new SimpleImage;
						$resize_image->load("../userContent/".$fullsize);
						$resize_image->resize(162,115);
						$resize_image->save("../userContent/thumb_".$fullsize);
						$thumbnail		= "thumb_".$fullsize;
						$request_array[VEHICLE_IMAGE]		= $fullsize;
						$request_array[VEHICLE_THUMBNAIL]	= $thumbnail;
					}
					$image_array		= array();
					foreach( $_POST as $key=>$value)
						if (strpos($key, "y_item") > 0)
							array_push ($image_array, $value);
					if ($gallery != "")
						array_push($image_array, $gallery);
					$request_array[VEHICLE_GALLERY]	= json_encode ($image_array);

					//---- STARTING AT
					$request_array[VEHICLE_STARTING]	= $this->protected_helper_starting_price($request_array[VEHICLE_PRICE]);

					//---- UPDATE ITEM
					$result_array			= $ASTEGdb->database_update($this->plugin_table,$request_array);
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9901");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;

				case $this->plugin_button_reserve:
					$result_array			= $ASTEGdb->database_update($this->plugin_table,array("ID"=>$event_array[ACTIONID],"VEHICLE_SOLD"=>1));
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9903");
					else
						ASTEG_content::content_message_queue_add("9900");
					break;
				case $this->plugin_button_unreserve:
					$result_array			= $ASTEGdb->database_update($this->plugin_table,array("ID"=>$event_array[ACTIONID],"VEHICLE_SOLD"=>0));
					if ($result_array['result']	=== true)
						ASTEG_content::content_message_queue_add("9904");
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
		$result	.= "		<div class='column_300'>".$this->plugin_display_array[3]."</div>";
		$result	.= "		<div class='column_200'>".$this->plugin_display_array[8]."</div>";
		$result	.= "		<div class='column_30'></div>";
		$result	.= "	</div>";
		$result	.= "	<div id='accordion'>";
		$current_brand		= "n/a";
		$previous_brand		= "";
		for ($i=0; $i < $result_array['rowcount']; $i++)
		{
			for ($j = 0; $j < count($this->category_array); $j++)
				$current_brand	= ($result_array[$i]['field3'] == $this->category_array[$j][field0])?$this->category_array[$j][field1]:$current_brand;
			if ($previous_brand <> $current_brand && $previous_brand != "")
				$result	.= "	</div>";
			if ($previous_brand <> $current_brand)
			{
				$result	.= "	<h3><div class='display_result'>";
				$result	.= "		<div class='column_30'>&nbsp;</div>";
				$result	.= "		<div class='column_200'>$current_brand</div>";
				$result	.= "	</div></h3>";
				$result	.= "	<div>";
				$previous_brand	= $current_brand;
			}
			$result	.= "	<div class='display_result' style='".$background_color."'>";
			$result	.= "		<div class='column_10'>&nbsp;</div>";
			$result	.= "		<div class='column_200'><b><a href='./?PAGE=".$this->plugin_page."&ACTION=".$this->plugin_action_update."&ACTIONID=".$result_array[$i]['field0']." ' >".$result_array[$i]['field1']."</a></b></div>";
			$result	.= "		<div class='column_300'>".$current_brand."</div>";
			$result	.= "		<div class='column_200'>".$this->vehicle_array[$result_array[$i]['field8']][field1]."</div>";
                        $reservation_status     = ($result_array[$i]['field18'] != '0')? "Reservado": "Disponible";
			$result	.= "		<div class='column_200'>".$reservation_status."</div>";
			$result	.= "		<div class='column_30'>&nbsp;</div>";
			$result	.= "	</div>";

		}
		$result	.= "</div>";
		$result	.= "</div>";
		$result	.= "
			<script type='text/javascript'>
			activate_accordion();
			function activate_accordion()
			{
				$('#accordion').accordion({ active: false, header: 'h3', autoHeight: false });
			}
			</script>";
		return $result;
	}
	protected function protected_helper_create()
	{
		$result	= "<form name='' method='post' action='./?PAGE=".$this->plugin_page."' enctype='multipart/form-data'>";
		$result	.=	"	<input type='hidden' name='ASTEGsubmit_code' value='".$this->plugin_post_code."' >";
		$result	.= "	<div class='information_display'>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[1]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_NAME'			value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[2]."<div style='padding-top:5px; font-weight:normal; font-size:11px; color:#3F82DD; line-height:15px;'>Correcto: 30000.00</div><div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>Incorrecto: Q.30,000.00</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_PRICE'			value='' /></div></div>";
//		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[13]."<div style='padding-top:5px; font-weight:normal; font-size:11px; color:#3F82DD; line-height:15px;'>Correcto: 3000.00</div><div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>Incorrecto: Q.3,000.00</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_STARTING'		value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[3]."<div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999; line-height:15px;'>Si la Marca que busca no est&aacute; en este Listado, puede crearla usando el editor de <a href='./?PAGE=9' style='font-size:11px; color:#3F82DD;'>Marcas</a></div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$this->protected_helper_select($this->category_array, "VEHICLE_BRAND")."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[4]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_YEAR'			value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[5]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_KM'				value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[6]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$this->protected_helper_select($this->combustible_array, "VEHICLE_FUELTYPE")."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[7]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$this->protected_helper_select($this->transmision_array, "VEHICLE_TRANSMISSION")."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[8]."<div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999; line-height:15px;'>Solicite la creaci&oacute;n de nuevos Tipos de Veh&iacute;culos escribiendo a <a href='mailto:info@grupoperinola.com' style='font-size:11px; color:#3F82DD;'>info@grupoperinola.com</a></div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$this->protected_helper_select($this->vehicle_array, "VEHICLE_CARTYPE")."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[9]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$this->protected_helper_select($this->doors_array, "VEHICLE_DOORS")."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[10]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_EXTERIORCOLOUR' value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[11]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_INTERIORCOLOUR' value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold' style='height:310px;vertical-align:top;'>".$this->plugin_display_array[12]."</div><div class='column_10'></div><div class='column_780 form_input_line column_editor'><textarea id='textarea_editor' name='VEHICLE_DETAIL'></textarea></div></div>";
//		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[14]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_THUMBNAIL'		value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[15]."<div style='padding-top:5px; font-weight:normal; font-size:11px; color:#3F82DD;'>600 x 450px JPG</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_IMAGE'			value='' /></div></div>";

		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[17]." 01 <div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>600 x 450px JPG</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_GALLERY01'		value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[17]." 02 <div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>600 x 450px JPG</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_GALLERY02'		value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[17]." 03 <div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>600 x 450px JPG</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_GALLERY03'		value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[17]." 04 <div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>600 x 450px JPG</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_GALLERY04'		value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[17]." 05 <div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>600 x 450px JPG</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_GALLERY05'		value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[17]." 06 <div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>600 x 450px JPG</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_GALLERY06'		value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[17]." 07 <div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>600 x 450px JPG</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_GALLERY07'		value='' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[17]." 08 <div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>600 x 450px JPG</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_GALLERY08'		value='' /></div></div>";




		$result .= "		<div class='display_item'><div class='column_990 text_right'>";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_uploadandcontinue."' class='button_default button_green' />";
		$result	.= "			<img src='".THEME_PATH."images/spacer.png' width='20' height='20' />";
		$result	.= "		</div></div>";
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
		$result	= "<form name='update_vehicle' method='post' action='./?PAGE=".$this->plugin_page."' enctype='multipart/form-data'>";
		$result	.=	"	<input type='hidden' name='ASTEGsubmit_code' value='".$this->plugin_post_code."' >";
		$result	.=	"	<input type='hidden' name='ACTIONID' value='".$result_array['field0']."' >";
		$result	.= "	<div class='information_display'>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[1]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_NAME'			value='".$result_array['field1']."' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[2]."<div style='padding-top:5px; font-weight:normal; font-size:11px; color:#3F82DD; line-height:15px;'>Correcto: 30000.00</div><div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>Incorrecto: Q.30,000.00</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_PRICE'			value='".$result_array['field2']."' /></div></div>";
//		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[13]."<div style='padding-top:5px; font-weight:normal; font-size:11px; color:#3F82DD; line-height:15px;'>Correcto: 3000.00</div><div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>Incorrecto: Q.3,000.00</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_STARTING'		value='".$result_array['field13']."' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[3]."<div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999; line-height:15px;'>Si la Marca que busca no est&aacute; en este Listado, puede crearla usando el editor de <a href='./?PAGE=9' style='font-size:11px; color:#3F82DD;'>Marcas</a></div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$this->protected_helper_select($this->category_array, "VEHICLE_BRAND",$result_array['field3'])."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[4]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_YEAR'			value='".$result_array['field4']."' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[5]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_KM'				value='".$result_array['field5']."' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[6]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$this->protected_helper_select($this->combustible_array, "VEHICLE_FUELTYPE",$result_array['field6'])."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[7]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$this->protected_helper_select($this->transmision_array, "VEHICLE_TRANSMISSION",$result_array['field7'])."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[8]."<div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999; line-height:15px;'>Solicite la creaci&oacute;n de nuevos Tipos de Veh&iacute;culos escribiendo a <a href='mailto:info@grupoperinola.com' style='font-size:11px; color:#3F82DD;'>info@grupoperinola.com</a></div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$this->protected_helper_select($this->vehicle_array, "VEHICLE_CARTYPE",$result_array['field8'])."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[9]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'>".$this->protected_helper_select($this->doors_array, "VEHICLE_DOORS",$result_array['field9'])."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[10]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_EXTERIORCOLOUR' value='".$result_array['field10']."' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[11]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='text' name='VEHICLE_INTERIORCOLOUR' value='".$result_array['field11']."' /></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold' style='height:310px;vertical-align:top;'>".$this->plugin_display_array[12]."</div><div class='column_10'></div><div class='column_780 form_input_line column_editor'><textarea id='textarea_editor' name='VEHICLE_DETAIL'>".$result_array['field12']."</textarea></div></div>";
//		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[14]."</div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_THUMBNAIL'		/></div></div>";
		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[15]."<div style='padding-top:5px; font-weight:normal; font-size:11px; color:#3F82DD;'>600 x 450px JPG</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_IMAGE'			/></div></div>";

		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[16]."</div></div>";
		$result	.= "		<div class='display_item'><div class='column_990 text_right' id='gallery_block'>";
		$gallery_array	= json_decode($result_array[field16],TRUE);
		for ($i = 0; $i < count($gallery_array); $i++)
			$result	.= "<div class='gallery_item gallery_item_".$i."'>
							<input type='hidden' name='gallery_item_".$i."' value='".$gallery_array[$i]."' />
							<img src='../userContent/".$gallery_array[$i]."' />
							<a href='javascript:void()' onclick='remove_item(\"gallery_item_".$i."\")'>&times;</a>
						</div>";
		$result	.= "		</div></div>";

		$result	.= "		<div class='display_item'><div class='column_200 text_right text_bold'>".$this->plugin_display_array[17]."<div style='padding-top:5px; font-weight:normal; font-size:11px; color:#999;'>600 x 450px JPG</div></div><div class='column_10'>&nbsp;</div><div class='column_780 form_input_line'><input type='file' name='VEHICLE_GALLERY'		/></div></div>";
		$result .= "		<div class='display_item'><div class='column_990 text_right'>";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_upload."' class='button_default button_green' />";
		$result	.= "			<img src='".THEME_PATH."images/spacer.png' width='20' height='20' />";
		$result	.= "		</div></div>";
		$result .= "		<div class='display_item'><div class='column_990 text_right'>";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_update."' class='button_default button_blue' />";
          $vehicle_reservation            = ($result_array['field18'] == '0')?$this->plugin_button_reserve:$this->plugin_button_unreserve;
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$vehicle_reservation."' class='button_default button_orange' />";
		$result	.= 			($result_array['field18'] != '0')?"<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_delete."' class='button_default button_red'/>":"";
		$result	.= "			<input type='submit' name='POST_SUBMIT' value='".$this->plugin_button_cancel."' class='button_default button_gray' />";
		$result	.= "			<img src='".THEME_PATH."images/spacer.png' width='20' height='20' />";
		$result	.= "		</div></div>";
		$result	.= "	</div>";
		$result	.= "</form><br/>";
		$result .= '<script type="text/javascript">
					CKEDITOR.replace( "textarea_editor");
					$( "#gallery_block" ).sortable();
					$( "#gallery_block" ).disableSelection();
					function remove_item($current_block)
					{
						$("."+$current_block).remove();
					}
                         function confirmacion()
                         {
	                        if (confirm("¿Estas seguro de eliminar este vehículo?")){
	                           document.update_vehicle.submit()
                              }
					}
					</script>';
		return $result;
	}
	//---- HELPER
	protected function protected_helper_select($array_list,$select_name,$selected = -1)
	{
		$html_select		= "<select name='$select_name' >";
		for ($i = 0; $i < count($array_list); $i++)
		{
			$select			= ($array_list[$i][field0] == $selected)?" selected='selected' ":"";
			$html_select	.= "<option value='".$array_list[$i][field0]."' $select>".$array_list[$i][field1]."</option>";
		}
		$html_select		.= "</select>";
		return $html_select;
	}
	protected function protected_helper_starting_price($vehicle_price)
	{
		if (is_numeric($vehicle_price))
		{
			$form_percentage		= 20;
			$form_month				= 60;

			$settings_interest			= 12.6; //---- l
			$settings_monthlyinterest	= ($settings_interest/12)/100; //---- i
			$settings_tofinance			= $vehicle_price-($vehicle_price*($form_percentage/100)); //---- C
			$settings_numberofmonths	= $form_month; //---- n

			$cuota_top					= (($settings_tofinance*$settings_monthlyinterest)*(pow((1+$settings_monthlyinterest),$settings_numberofmonths)));
			$cuota_bottom				= (pow((1+$settings_monthlyinterest),$settings_numberofmonths)-1);
			$display_cuotas				= $cuota_top/$cuota_bottom;
		}
		else
		{
			$display_cuotas = 0;
		}
		return $display_cuotas;
	}


}
?>