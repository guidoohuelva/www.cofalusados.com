<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo ASTEG_resource::resource_get('RESOURCE_THEME_LANGUAGE'); ?> >
<head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $this->engine_show_header(); ?></title>
	<meta name="description" content="Cofal Usados - Venta de vehiculos usados de agencia con el respaldo de Grupo Cofi&ntilde;o Stahl. " />
	<meta name="keywords" content="autos usados, vehiculos usados, usados, carro, de agencia, vehiculos agencia, compra venta, compra vehiculos, venta vehiculos, guatemala, cofino stahl, predios, autos, financiamiento, seguro, compra agencia, Alfa Romeo, Audi, BMW, Cadillac, Chevrolet, Chrysler, Citroen, Daihatsu, FAW, Fiat, Ford, GMC, Honda, Hummer, Hyundai, Infiniti, Isuzu, Jaguar, Jeep, Kia, Land Rover, Lexus, Lincoln, Mazda, Mercedes Benz, Mini, Mitsubishi, Nissan, Peugeot, Pontiac, Porsche, Renault, Seat, Skoda, Ssang Yong, Subaru, Suzuki, Toyota, Volkswagen, Volvo" />
	<meta name="google-site-verification" content="HR4g8vKQgolSH2MY2YB1Vvcb340dZzURiFIbfnBkiU4" />

<?php
	$ASTEGdb 		= new ASTEG_database();
	if ($_GET[PAGE] == 6)
	{
		$facebook_array	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT * FROM PLUGIN_CAR_GALLERY WHERE ID = ".$_GET[CAR]));
		echo '<meta property="og:title" content="Cofal Usados - '.$facebook_array[0][field1].'"/>';
	}

?>


	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo THEME_PATH; ?>style.css" type="text/css" media="screen" />
    <!-- <link rel="stylesheet" href="./resourceJAVASCRIPT/jqueryUI/style.css" type="text/css" media="screen" /> -->
    <?php echo $xajax->getJavascript('./resourceXAJAX'); ?>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
    <!-- <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" ></script> -->
    <script type="text/javascript" src="./resourceJAVASCRIPT/ASTEGfunctions.hoverover.js" ></script>
	<script type="text/javascript" src="<?php echo THEME_PATH; ?>/jquery_select.js" ></script>
    <script type="text/javascript" src="<?php echo THEME_PATH; ?>/javascript.js" ></script>

    <!-- top links -->
    <link rel="stylesheet" href="<?php echo THEME_PATH; ?>top_links/css/bootstrap.min.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo THEME_PATH; ?>top_links/css/main.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">


<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo THEME_PATH; ?>/ie.css"/>
	<script type="text/javascript" src="<?php echo THEME_PATH; ?>/i6_png_set.js"></script>
<![endif]-->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25634261-28']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
	<?php include 'top_links/index.php'; ?>

<div id="Wrapper"> <!--wrapper-->
<div id="header"> <!--header-->
	<div id="header_inner"></div> <!--header_inner-->
		<div class="head_wrap"> <!--head_wrap-->
			<a href="./?PAGE=1" class="logo">Cofiño Stahl - Usados</a>
			<div class="head-content"><!--head-content-->
				<p class="pbx"><img src="<?php echo THEME_PATH; ?>images/pbx-tex.png" alt="PBX. 1705" height="59" width="179" /> </p>
				<p>Km 14. Calz Roosevelt 5-25 Z.3 Mixco</p>
				<div class="social">
					<ul>
						<li><a href="https://www.facebook.com/pages/Cofal-Usados/314202608630103" target="_blank"><img src="<?php echo THEME_PATH; ?>images/fb.png" alt="Facebook Cofal Usados" class="ro" /> <span>facebook</span> </a></li>
					</ul>
				</div>
			</div><!--head-content-->
		</div>  <!--head_wrap-->
</div> <!--header-->
<div id="navigation"><!--navigation-->
	<div class="nav-content"> <!--nav-content-->
		<ul class="nav">
<?php
	$button_html	= "";
	$selected_page	= (isset($_GET[PAGE]))?$_GET[PAGE]:1;
	$button_array	= array("1"=>'<img src="'.THEME_PATH.'images/home-icon.png" alt="home" />',"2"=>"Catálogo","3"=>"Servicios","4"=>"Beneficios","5"=>"Contacto");
	foreach ($button_array as $page_number=>$button_content)
	{
		$first_button		= ($page_number == 1)?' id="first" ':'';
		$selected_button	= ($page_number == $selected_page)?' class="active" ':"";
		$selected_button	= ($page_number == 2 && $selected_page == 6)?' class="active" ':$selected_button;
		$button_html	.= '<li '.$first_button.'><a href="./?PAGE='.$page_number.'" '.$selected_button.'><span>'.$button_content.'</span></a></li>';
	}
	echo $button_html;
?>
		</ul>
	</div> <!--nav-content-->
</div> <!--navigation-->
<?php
        $BRAND_QUERY                    =  "SELECT PBC.ID, PBC.CATEGORY_NAME
                                            FROM PLUGIN_CAR_GALLERY PCG
                                            JOIN PLUGIN_BRAND_CATEGORIES PBC ON PBC.ID = PCG.VEHICLE_BRAND
                                            WHERE PCG.VEHICLE_SOLD = 0
                                            GROUP BY PBC.ID";
	$brand_array			= $ASTEGdb->database_advanced_query(array("query"=>$BRAND_QUERY));
	$current_year			= date("Y");
	$vehicle_array			= array();
	//---- AGREGAR TIPOS DE VEHICULOS (BELOW)
	$vehicle_array[0]		= array("field0"=>0,"field1"=>"Sedán");
	$vehicle_array[1]		= array("field0"=>1,"field1"=>"Hatchback");
	$vehicle_array[2]		= array("field0"=>2,"field1"=>"Camionetas");
	$vehicle_array[3]		= array("field0"=>3,"field1"=>"SUV");
	$vehicle_array[4]		= array("field0"=>4,"field1"=>"Comerciales");
	$vehicle_array[5]		= array("field0"=>5,"field1"=>"Deportivos");
	$vehicle_array[6]		= array("field0"=>6,"field1"=>"Pickups");
?>
<div id="search-panel"><!--search-panel-->
	<div class="search-content"><!--search-content-->
		<h5>Busca tu Vehículo</h5>
		<form action="./" method="GET">
			<input type="hidden" name="PAGE" value="2" />
		<fieldset>
			<ul class="select-ul">
			<li><h6>Marca</h6>
				<select class="select" name="BRAND_SELECT">
<?php
	$brand_html		= "<option value='-1'>Ver Todas</option>";
	for($i = 0; $i < $brand_array[rowcount]; $i++){

		$brand_html		.= "<option value='".$brand_array[$i][field0]."'>".$brand_array[$i][field1]."</option>";
        }

	echo $brand_html;
?>
				</select>
			</li>
			<li class="modelo"> <h6>Modelo</h6>
				<select class="select" name="YEAR_SELECT">
<?php
	$year_html		= "<option value='-1'>Ver Todos</option>";
	for($i = $current_year; $i >= ($current_year-20); $i--)
		$year_html		.= "<option value='".$i."'>Desde ".$i."</option>";

	echo $year_html;
?>
				</select>
			</li>
			<li class="precio"> <h6>Precio</h6>
				<select class="select" name="PRICE_SELECT">
					<option value='-1'>Ver Todos</option>
					<option value='0'>0 - 50,000</option>
					<option value='1'>50,001 - 100,000</option>
					<option value='2'>100,001 - 150,000</option>
					<option value='3'>150,001 - 200,000</option>
					<option value='4'>200,001 - 250,000</option>
					<option value='5'>250,001 - 300,000</option>
					<option value='6'>300,001 y Más</option>
				</select>
			</li>
			<li class="tipo"> <h6>Tipo</h6>
				<select class="select" name="TYPE_SELECT">
<?php
	$type_html		= "<option value='-1'>Ver Todos</option>";
	for($i = 0; $i < count($vehicle_array); $i++)
		$type_html		.= "<option value='".$vehicle_array[$i][field0]."'>".$vehicle_array[$i][field1]."</option>";

	echo $type_html;
?>

				</select>
			</li>
			<li><button class="buscar">BUSCAR</button></li></ul>
		</fieldset>
		</form>
	</div><!--search-content-->
</div><!--search-panel-->
