<?php
	$ASTEGdb		= new ASTEG_database();

//---- CATEGORY ARRAY
	$result_array	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT * FROM PLUGIN_BRAND_CATEGORIES ORDER BY CATEGORY_NAME"));
	$brand_array	= array();
	for ($i = 0; $i < $result_array[rowcount]; $i++)
		$brand_array[$result_array[$i][field0]] = $result_array[$i][field1];

//---- GALLERY
	$vehicle_array	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT * FROM PLUGIN_CAR_GALLERY WHERE VEHICLE_SOLD = 0 ORDER BY ID DESC LIMIT 9"));

	$popular_array	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT b.* FROM PLUGIN_CAR_SELECTED a LEFT JOIN PLUGIN_CAR_GALLERY b on a.CAR_ID = b.ID WHERE b.VEHICLE_SOLD = 0  ORDER BY a.ID ASC"));

?>
<div id="showcase"><!--showcase-->
	<div class="showcase-content"><!--showcase-content-->
		<div class="slider"><!--slider-->
			<div class="slider-left"><a href="javascript:void()" onclick="ASTEGfunctions_showcase_previous()" ><img src="<?php echo THEME_PATH; ?>images/left-arrow.png" alt="Izquierda" class="ro"  /></a></div>
			<div class="slider-img" id="slider-block"><!--slider-img-->
				<img src="<?php echo THEME_PATH ?>images/spacer.png" alt="img" height="480" width="640" />
<?php 
	for ($i = 0; $i < $popular_array[rowcount]; $i++)
	{
?>
				<a href="./?PAGE=6&CAR=<?php echo $popular_array[$i][field0]; ?>"><img src="./userContent/<?php echo $popular_array[$i][field15]; ?>" alt="Showcase Vehiculos Usados" height="480" width="640" class="showcase_image" id="showcase_image_<?php echo ($i+1) ?>"  /></a>
<?php
	}
	for ($i = 0; $i < $popular_array[rowcount]; $i++)
	{
?>
				<a href="./?PAGE=6&CAR=<?php echo $popular_array[$i][field0]; ?>">
					<div class="cap showcase_text" id="showcase_text_<?php echo ($i+1) ?>"><!--cap-->
						<div class="cap-left"><h3><?php echo $popular_array[$i][field1]; ?></h3><h4><?php echo $popular_array[$i][field4] ?><span><?php echo number_format($popular_array[$i][field5],0,".",","); ?> Km</span></h4></div>
						<div class="pricing"><p>Cuotas desde</p><button>Q.<?php echo number_format($popular_array[$i][field13],0,".",","); ?></button></div>
					</div><!--cap-->
				</a>
<?php 
	}
?>
			</div><!--slider-img-->
			<div class="slider-right"><a href="javascript:void()" onclick="ASTEGfunctions_showcase_next()"><img src="<?php echo THEME_PATH; ?>images/right-arrow.png" alt="Derecha" class="ro" /></a></div>
		</div><!--slider-->
	</div><!--showcase-content-->
</div><!--showcase-->

<div id="home-content"> <!--home-content-->
	<div class="index_content"> <!--index_content-->
		<div class="home-wrapp"><!--home-wrapp-->
			<div class="home_left"> <!--home_left-->
				<h5>Vehículos más Recientes</h5>    
				<ul class="car-tab">
<?php
	for ($i = 0; $i < $vehicle_array[rowcount];$i++)
	{
?>
					<li>
						<div class="car-details">
							<a href="./?PAGE=6&CAR=<?php echo $vehicle_array[$i][field0] ?>">
								<img src="./userContent/<?php echo $vehicle_array[$i][field14] ?>" alt="Vehiculo Usado" height="115" width="161" />
								<div class="cuota"><p>Cuotas desde</p><button>Q.<?php echo number_format($vehicle_array[$i][field13],0,".",","); ?><sup>.00</sup></button></div>
								<div class="name"><?php echo $vehicle_array[$i][field1] ?></div>
								<div class="year"><?php echo $vehicle_array[$i][field4] ?><span><?php echo number_format($vehicle_array[$i][field5],0,".",","); ?> Km<span></div>
							</a>								
						</div>
					</li>
<?php
	}
?>
				</ul>
			</div> <!--home_left--> 
			<div class="sidebar"> <!--sidebar-->
				<div class="sidebar-inner"> <!--sidebar-inner-->
					<h5>Más Populares <span>de la Semana</span></h5>
					<ul>
<?php
	for ($i = 0; $i < 3;$i++)
	{
?>
				<li>
					<a href="./?PAGE=6&CAR=<?php echo $popular_array[$i][field0] ?>">
						<div class="car-det">
							<img src="./userContent/<?php echo $popular_array[$i][field14] ?>" alt="Vehiculo Usado Popular" height="115" width="161" />
							<div class="cuota"><p>Cuotas desde</p><button>Q.<?php echo number_format($popular_array[$i][field13],0,".",","); ?><sup>.00</sup></button></div>
							<div class="name"><?php echo $popular_array[$i][field1] ?></div>
							<div class="year_popular"><?php echo $popular_array[$i][field4] ?><span><?php echo number_format($popular_array[$i][field5],0,".",","); ?> Km</span></div>
						</div>
					</a>
				</li>
<?php
	}
?>
					</ul>
				</div><!--sidebar-inner-->
			</div> <!--sidebar-->
		</div> <!--home-wrapp-->    
		<div class="home-wrapp"> <a href="./?PAGE=2" class="ver-mas">Ver más Vehículos</a> </div><!--home-wrapp-->        
	</div> <!--index_content-->    
</div> <!--home-content-->    
<script type="text/javascript">
var $showcase_image_count				= <?php echo $popular_array[rowcount]-1; ?>;
var $showcase_timeout 					= (8 * 1000);
var $showcase_current_image			 	= 0;
ASTEGfunctions_showcase_initialization();
function ASTEGfunctions_showcase_initialization()
{
	$(".showcase_image").hide();
	$(".showcase_text").hide();
	ASTEGfunctions_showcase();
}
function ASTEGfunctions_showcase()
{
	$("#showcase_image_"+$showcase_current_image).fadeOut(200);
	$("#showcase_text_"+$showcase_current_image).hide();
	$showcase_current_image		= ($showcase_current_image < ($showcase_image_count+1))?$showcase_current_image+1:1;
	$("#showcase_image_"+$showcase_current_image).fadeIn(400);
	$("#showcase_text_"+$showcase_current_image).show();
	setTimeout("ASTEGfunctions_showcase()",$showcase_timeout);
}
function ASTEGfunctions_showcase_next()
{
	$("#showcase_image_"+$showcase_current_image).fadeOut(200);
	$("#showcase_text_"+$showcase_current_image).hide();
	$showcase_current_image		= ($showcase_current_image < ($showcase_image_count+1))?$showcase_current_image+1:1;
	$("#showcase_image_"+$showcase_current_image).fadeIn(400);
	$("#showcase_text_"+$showcase_current_image).show();
}
function ASTEGfunctions_showcase_previous()
{
	$("#showcase_image_"+$showcase_current_image).fadeOut(200);
	$("#showcase_text_"+$showcase_current_image).hide();
	$showcase_current_image		= ($showcase_current_image > 1 )?$showcase_current_image-1:($showcase_image_count+1);
	$("#showcase_image_"+$showcase_current_image).fadeIn(400);
	$("#showcase_text_"+$showcase_current_image).show();
}
</script>
