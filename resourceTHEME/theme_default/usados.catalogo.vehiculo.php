<?php
	$ASTEGdb		= new ASTEG_database();
	
	$result_array	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT * FROM PLUGIN_BRAND_CATEGORIES ORDER BY CATEGORY_NAME"));
	$brand_array	= array();
	for ($i = 0; $i < $result_array[rowcount]; $i++)
		$brand_array[$result_array[$i][field0]] = $result_array[$i][field1];
	
	$selected_car	= (!isset($_GET[CAR]))?1:$_GET[CAR];
	$current_car	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT * FROM PLUGIN_CAR_GALLERY WHERE ID = ".$selected_car));

	$combustible_array		= array();
	$combustible_array[0]	= array("field0"=>0,"field1"=>"Gasolina");
	$combustible_array[1]	= array("field0"=>1,"field1"=>"Diesel");
	$combustible_array[2]	= array("field0"=>2,"field1"=>"Electricidad");
	$combustible_array[3]	= array("field0"=>3,"field1"=>"Híbrido");
	$transmision_array		= array();
	$transmision_array[0]	= array("field0"=>0,"field1"=>"Mecánico");
	$transmision_array[1]	= array("field0"=>1,"field1"=>"Automático");
	$transmision_array[2]	= array("field0"=>2,"field1"=>"Tiptronic");
	$vehicle_array			= array();
	$vehicle_array[0]		= array("field0"=>0,"field1"=>"Sedán");
	$vehicle_array[1]		= array("field0"=>1,"field1"=>"Hatchback");
	$vehicle_array[2]		= array("field0"=>2,"field1"=>"Camionetas");
	$vehicle_array[3]		= array("field0"=>3,"field1"=>"SUV");
	$vehicle_array[4]		= array("field0"=>4,"field1"=>"Comerciales");
	$vehicle_array[5]		= array("field0"=>5,"field1"=>"Deportivos");
	$vehicle_array[6]		= array("field0"=>6,"field1"=>"Pickups");
	$vehicle_array[7]		= array("field0"=>7,"field1"=>"Ver Todos");
	$doors_array			= array();
	$doors_array[0]			= array("field0"=>0,"field1"=>"2");
	$doors_array[1]			= array("field0"=>1,"field1"=>"3");
	$doors_array[2]			= array("field0"=>2,"field1"=>"4");
	$doors_array[3]			= array("field0"=>3,"field1"=>"5");
	$doors_array[4]			= array("field0"=>4,"field1"=>"6");
	
	
//---- CALCULATOR
	$form_percentage		= (!isset($_GET[FORM_PERCENTAGE]))?20:$_GET[FORM_PERCENTAGE];
	$form_month				= (!isset($_GET[FORM_MONTH]))?12:$_GET[FORM_MONTH];
	$display_enganche		= number_format(($current_car[0][field2]*($form_percentage/100)),2,".",",");

	
	$settings_interest			= 12.6; //---- l
	$settings_monthlyinterest	= ($settings_interest/12)/100; //---- i
	$settings_tofinance			= $current_car[0][field2]-($current_car[0][field2]*($form_percentage/100)); //---- C
	$settings_numberofmonths	= $form_month; //---- n
	
	$cuota_top					= (($settings_tofinance*$settings_monthlyinterest)*(pow((1+$settings_monthlyinterest),$settings_numberofmonths))); 
	$cuota_bottom				= (pow((1+$settings_monthlyinterest),$settings_numberofmonths)-1);
	$display_cuotas				= $cuota_top/$cuota_bottom;
//---- DISPLAY ONLY IF IT'S NOT SOLD        
	$vehicle_count	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT COUNT(*) FROM PLUGIN_CAR_GALLERY WHERE VEHICLE_SOLD = 0  AND ID = ".$_GET['CAR']));
        
        if($vehicle_count[0][field0] > 0):
?>
<div id="inner-content"> <!--inner-content-->
	<div class="index_content"> <!--index_content-->
		<div class="vehicle-top"><!--vehicle-top-->
			<div class="title"><!--title-->
				<h3><?php echo $current_car[0][field1]; ?></h3>
				<div class="like">
					<div class="fb-like" data-href="http://www.cofalusados.com/?PAGE=6&CAR=<?php echo $selected_car;  ?>" data-send="true" data-width="450" data-show-faces="true"></div>				
				</div>
			</div><!--title-->
			<div class="details-img"><!--details-img-->
				<div class="show-img"> <img src="./userContent/<?php echo $current_car[0][field15]; ?>" alt="" id="car_gallery_image" width="600" height="450" /></div>
				<div class="image-gallery">
					<ul>
<?php
							$image_array	= json_decode($current_car[0][field16],TRUE);
							foreach ($image_array as $car_value)
							{
?>
						<li> <a href="javascript:void(0)" onclick="car_image_popup('<?php echo $car_value ?>');">
								<img src="./userContent/<?php echo $car_value ?>" alt="" width="162" height="115" /></a></li>
<?php
							}
?>
					</ul>
				</div> 
			</div> <!--details-img-->
			<div class="details"> <!--details-->
				<div class="details-top"> <!--details-top-->
					<div class="details-bot"> <!--details-bot-->
						<div class="details-mid"> <!--details-mid-->
							<h3 class="preo-top"><span>Precio</span> <em>Q.</em> <?php echo number_format($current_car[0][field2],2,".",","); ?></h3>
							<div class="cuotas"><!--cuotas-->
								<div class="cuotas-top">
									<h5><?php echo $form_month; ?> Cuotas de</h5>
									<h2>Q.<?php echo number_format($display_cuotas,2,".",","); ?></h2>
									<p>Enganche desde el <?php echo $form_percentage; ?>%: <strong>Q. <?php echo $display_enganche; ?></strong></p>
									<small style="font-size:10px; color:#777;">*Este estimado no incluye seguro.</small>
								</div>
								<div class="cuotas-bot">
									<form action="./" method="GET">
										<input type="hidden" name="PAGE" value="<?php echo $_GET[PAGE] ?>" />
										<input type="hidden" name="CAR" value="<?php echo $_GET[CAR] ?>" />
										<ul>
											<li> 
												<em>Enganche</em>
												<select class="select" name="FORM_PERCENTAGE">
													<option value="20">20% </option>
													<option value="30">30% </option>
													<option value="40">40%</option>
													<option value="50">50%</option>
												</select>
											</li>
											<li> 
												<em>Cuotas</em>
												<select class="select" name="FORM_MONTH">
													<option value="12"> 12 meses </option>
													<option value="24"> 24 meses </option>
													<option value="36"> 36 meses</option>
													<option value="48"> 48 meses</option>
													<option value="60"> 60 meses</option>
												</select>
											</li>
											<li>
												<em> &nbsp;</em> <input type="submit" class="calcular"  />
											</li>
										</ul>
									</form> 
								</div>
							</div> <!--cuotas-->
							<ul class="deta-ul">
								<li> <strong>Marca</strong> <span><?php echo $brand_array[$current_car[0][field3]]; ?></span></li>
								<li> <strong>Modelo</strong> <span><?php echo $current_car[0][field4]; ?></span></li>
								<li> <strong>Kilometraje</strong> <span><?php echo number_format($current_car[0][field5],0,".",","); ?></span></li>
								<li> <strong>Combustible</strong> <span><?php echo $combustible_array[$current_car[0][field6]][field1]; ?></span></li> 
								<li> <strong>Transmisi&oacute;n</strong> <span><?php echo $transmision_array[$current_car[0][field7]][field1]; ?></span></li> 
								<li> <strong>Tipo</strong> <span><?php echo $vehicle_array[$current_car[0][field8]][field1]; ?></span></li>
								<li> <strong>Puertas</strong> <span><?php echo $current_car[0][field9]; ?></span></li>
								<li> <strong>Exterior</strong> <span><?php echo $current_car[0][field10]; ?></span></li>
								<li> <strong>Interior</strong> <span><?php echo $current_car[0][field11]; ?></span></li>
							</ul>
							<div class="descr">
								<h6>Descripción</h6>
								<?php echo $current_car[0][field12]; ?>
							</div>
						</div> <!--details-mid--> 
					</div><!--details-bot-->
				</div><!--details-top-->
				<div class="actions">
					<a href="javascript:void(0)" class="more-info" onclick="interest_popup()">more-info</a>
					<a href="javascript:void(0)" class="more-in" onclick="share_popup()">more-info</a>
				</div>
			</div> <!--details-->                    
		</div> <!--vehicle-top-->  

		<div class="Marca-box"><!--Marca-box-->  
			<h5><span>Otros vehículos</span> Marca &raquo; <?php echo $brand_array[$current_car[0][field3]]; ?></h5>
			<ul class="car-marca">
<?php
	$gallery_array	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT * FROM PLUGIN_CAR_GALLERY WHERE VEHICLE_BRAND = ".$current_car[0][field3]." AND VEHICLE_SOLD = 0  ORDER BY RAND() LIMIT 4"));
	for ($i = 0; $i < $gallery_array[rowcount]; $i++)
		if (isset($gallery_array[$i]))
		{
?>
				<li>
					<div class="car-details">
						<a href="./?PAGE=6&CAR=<?php echo $gallery_array[$i][field0] ?>">
							<img src="./userContent/<?php echo $gallery_array[$i][field14] ?>" alt="" height="115" width="161" />
							<div class="cuota"><p>Cuotas desde</p><button>Q.<?php echo number_format($gallery_array[$i][field13],0,".",","); ?><sup>.00</sup></button></div>
							<div class="name"><?php echo $gallery_array[$i][field1] ?></div>
							<div class="year"><?php echo $gallery_array[$i][field4] ?><span><?php echo number_format($gallery_array[$i][field5],0,".",","); ?> Km</span></div>
						</a>
					</div>
				</li>
<?php
		}
?>
			</ul> 
			<p class="ver"> <a href="./?PAGE=2&BRAND_SELECT=<?php echo $current_car[0][field3] ?>"><img src="<?php echo THEME_PATH; ?>images/a-arrow.gif" alt="" /> Otros vehículos   <strong>Marca &raquo; <?php echo $brand_array[$current_car[0][field3]]; ?></strong> </a></p>
		</div> <!--Marca-box-->     
		
		
		<div class="Marca-box"><!--Marca-box-->  
			<h5><span>Otros vehículos</span> Tipo &raquo; <?php echo $vehicle_array[$current_car[0][field8]][field1]; ?></h5>
			<ul class="car-marca">
<?php
	$gallery_array	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT * FROM PLUGIN_CAR_GALLERY WHERE VEHICLE_CARTYPE = ".$current_car[0][field8]." AND VEHICLE_SOLD = 0 ORDER BY RAND() LIMIT 4"));
	for ($i = 0; $i < $gallery_array[rowcount]; $i++)
		if (isset($gallery_array[$i]))
		{
?>
				<li>
					<div class="car-details">
						<a href="./?PAGE=6&CAR=<?php echo $gallery_array[$i][field0] ?>">
							<img src="./userContent/<?php echo $gallery_array[$i][field14] ?>" alt="" height="115" width="161" />
							<div class="cuota"><p>Cuotas desde</p><button>Q.<?php echo number_format($gallery_array[$i][field13],0,".",","); ?><sup>.00</sup></button></div>
							<div class="name"><?php echo $gallery_array[$i][field1] ?></div>
							<div class="year"><?php echo $gallery_array[$i][field4] ?><span><?php echo number_format($gallery_array[$i][field5],0,".",","); ?> Km</span></div>
						</a>	
					</div>
				</li>
<?php
		}
?>
			</ul> 
			<p class="ver"> <a href="./?PAGE=2&TYPE_SELECT=<?php echo $current_car[0][field8]; ?>"><img src="<?php echo THEME_PATH; ?>images/a-arrow.gif" alt="" /> Ver todos los vehículos  <strong>Tipo &raquo; <?php echo $vehicle_array[$current_car[0][field8]][field1]; ?></strong> </a></p>
		</div> <!--Marca-box--> 
		<div class="line-div"></div>    
	</div> <!--index_content-->    
</div> <!--inner-content-->        
<script type="text/javascript">
<?php
	$current_url	= "/?PAGE=6";
	unset($_GET[PAGE]);
	foreach ($_GET as $key=>$value)
		$current_url	.= "&".$key."=".$value;
?>
var $current_url = "<?php echo $current_url; ?>";
function car_image_popup($filename)
{
	$("#car_gallery_image").attr({
			"src":"./userContent/"+$filename,
			"width":"600",
			"height":"450"
		});
	
}
function interest_popup()
{
	var $content	=	"	<div class='form_popup feedback_form'>"+
						"		<form name='FEEDBACK_FORM' method='POST' action='<?php echo $current_url; ?>'>"+
						"			<input type='hidden' name='ASTEGsubmit_code' value='FEEDBACK_POST' />"+
						"			<input type='hidden' name='FORM_URL' value='<?php echo $current_url; ?>' />"+
						"			<input type='text' name='FORM_INPUT' value='' />"+
						"			<h4>&iquest;Te interesa este veh&iacute;culo?</h4>"+
						"			<p>Por favor, ingresa tus datos y tu mensaje llegar&aacute; directamente a uno de nuestros asesores.</p><br/>"+
						"			<div class='input_block'><label>Nombre</label><input type='text' name='FORM_NAME' /></div>"+
						"			<div class='input_block'><label>Email</label><input type='text' name='FORM_EMAIL' /></div>"+
						"			<div class='input_block'><label>Teléfono</label><input type='text' name='FORM_TELEPHONE' /></div>"+
						"			<div class='input_block textarea_fix'><label>Comentarios</label><textarea name='FORM_DETAIL'></textarea></div>"+
						"			<div class='input_block'><input type='submit' name='FEEDBACK_FORM' value='Enviar' /></div>"+
						"		</form>"+
						"	</div>";
	popup_show($content);
}
function share_popup()
{
	var $content	=	"	<div class='form_popup feedback_form'>"+
						"		<form name='SHARE_FORM' method='POST' action='<?php echo $current_url; ?>'>"+
						"			<input type='hidden' name='ASTEGsubmit_code' value='SHARE_POST' />"+
						"			<input type='hidden' name='FORM_URL' value='<?php echo $current_url; ?>' />"+
						"			<input type='text' name='FORM_INPUT' value='' />"+
						"			<h4>Env&iacute;a este veh&iacute;culo a un Amigo</h4>"+
						"			<div class='input_block'><label>Nombre de tu Amigo</label><input type='text' name='FORM_FRIEND_NAME' /></div>"+
						"			<div class='input_block'><label>Email de tu Amigo</label><input type='text' name='FORM_FRIEND_EMAIL' /></div>"+
						"			<div class='input_block textarea_fix'><label>Comentarios</label><textarea name='FORM_DETAIL'></textarea></div>"+
						"			<div class='input_block'><label>Tu Nombre</label><input type='text' name='FORM_NAME' /></div>"+
						"			<div class='input_block'><label>Tu Email</label><input type='text' name='FORM_EMAIL' /></div>"+
						"			<div class='input_block'><input type='submit' name='FEEDBACK_FORM' value='Enviar' /></div>"+
						"		</form>"+
						"	</div>";
	popup_show($content);
}

</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<?php
else:?>
<script type="text/javascript">
location.href = "./?PAGE=2";
</script>
<?php endif; ?>
