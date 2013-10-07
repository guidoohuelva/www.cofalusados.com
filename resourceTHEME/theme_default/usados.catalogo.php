<?php
//---- INITIALIZATION
	$ASTEGdb				= new ASTEG_database();
	$vehicle_array			= array();
	$vehicle_array[0]		= array("field0"=>0,"field1"=>"Sedán");
	$vehicle_array[1]		= array("field0"=>1,"field1"=>"Hatchback");
	$vehicle_array[2]		= array("field0"=>2,"field1"=>"Camionetas");
	$vehicle_array[3]		= array("field0"=>3,"field1"=>"SUV");
	$vehicle_array[4]		= array("field0"=>4,"field1"=>"Comerciales");
	$vehicle_array[5]		= array("field0"=>5,"field1"=>"Deportivos");
	$vehicle_array[6]		= array("field0"=>6,"field1"=>"Pickups");

	$vehicle_price			= array();
	$vehicle_price[0]		= array("0","50000");
	$vehicle_price[1]		= array("50001","100000");
	$vehicle_price[2]		= array("100001","150000");
	$vehicle_price[3]		= array("150001","200000");
	$vehicle_price[4]		= array("200001","250000");
	$vehicle_price[5]		= array("250001","300000");
	$vehicle_price[6]		= array("300001","");
	
//---- NAVIGATION
	$gallery_count	= 15;
	$offset			= (isset($_GET[OFFSET]))?$_GET[OFFSET]:0;
//---- CATEGORIES
	$result_array	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT * FROM PLUGIN_BRAND_CATEGORIES ORDER BY CATEGORY_NAME"));
	$brand_array	= array();
	for ($i = 0; $i < $result_array[rowcount]; $i++)
		$brand_array[$result_array[$i][field0]] = $result_array[$i][field1];
//---- CUSTOM SEARCH
	$customsearch				= array();
	if (isset($_GET[BRAND_SELECT]) && ($_GET[BRAND_SELECT] >=0))
	{
		$customsearch[BRAND_SELECT]	= " VEHICLE_BRAND = ".$_GET[BRAND_SELECT]." ";
	}
	if (isset($_GET[YEAR_SELECT]) && ($_GET[YEAR_SELECT] >=0))
	{
		$customsearch[YEAR_SELECT]	= " VEHICLE_YEAR >= ".$_GET[YEAR_SELECT]." ";
	}
	if (isset($_GET[TYPE_SELECT]) && ($_GET[TYPE_SELECT] >=0))
	{
		$customsearch[TYPE_SELECT]	= " VEHICLE_CARTYPE = ".$_GET[TYPE_SELECT]." ";
	}
	if (isset($_GET[PRICE_SELECT]) && ($_GET[PRICE_SELECT] >=0))
	{
		$customsearch[PRICE_SELECT]	= " (VEHICLE_PRICE >= ".$vehicle_price[$_GET[PRICE_SELECT]][0]." AND VEHICLE_PRICE <= ".$vehicle_price[$_GET[PRICE_SELECT]][1].") ";
	}
	
	$current_where	= "";
	foreach ($customsearch as $where)
		$current_where	.= " AND ".$where;
	$url			= "";
	foreach ($customsearch as $key=>$data)
		$url	.= "&".$key."=".$_GET[$key];
	
//---- ITEMS	
	$vehicle_array	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT * FROM PLUGIN_CAR_GALLERY WHERE VEHICLE_SOLD = 0 ".$current_where." ORDER BY VEHICLE_YEAR ASC  LIMIT ".($gallery_count*$offset).",".$gallery_count));
	$popular_array	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT b.* FROM PLUGIN_CAR_SELECTED a LEFT JOIN PLUGIN_CAR_GALLERY b on a.CAR_ID = b.ID WHERE b.VEHICLE_SOLD = 0  ORDER BY a.ID ASC LIMIT 5"));
//---- COUNT
	$vehicle_count	= $ASTEGdb->database_advanced_query(array("query"=>"SELECT COUNT(*) FROM PLUGIN_CAR_GALLERY WHERE VEHICLE_SOLD = 0  ".$current_where));
	$page_count	= ceil($vehicle_count[0][field0]/$gallery_count);
	
	
	
?>
<div id="inner-content"> <!--inner-content-->
	<div class="index_content"> <!--index_content-->

		<div class="Catalogo-de"><!--Catalogo-de-->
			<h5>Catálogo de Vehículos</h5><br/><br/><br/>
<?php     //---- SET PAGE_SCROLL
				$scroll_begin	= 0;
				$scroll_end	= ($page_count > 9)?9:$page_count;
                                if($scroll_end >= 1):
	if ($offset > 0)
	{
?>
		<a href="./?PAGE=2&OFFSET=<?php echo ($offset-1).$url; ?>" class="next">Anterior</a>
<?php
	}
 else
	{
?>
		<div class="anterior">Anterior</div>
<?php
	}
?>
			<ul class="pagination">
<?php
				//---- SET PAGE_SCROLL
				$scroll_begin	= 0;
				$scroll_end		= ($page_count > 9)?9:$page_count;
				if ($page_count > 10)
					if ( ($offset-4) > 0 )
					{
						$scroll_begin	= ( ($offset + 4) <= $page_count )?($offset - 4):($page_count-8);
						$scroll_end		= ( ($offset + 4) <= $page_count )?($offset + 4):$page_count;
					}
				for ($i = $scroll_begin; $i < $scroll_end; $i++)
				{
					$selected_class	= ($offset	== $i)?' class="active" ':'';
					$last_class		= ($scroll_end == $i)?' class="last" ':'';
					echo '<li '.$last_class.'> <a href="./?PAGE=2&OFFSET='.$i.$url.'" '.$selected_class.'> '.($i+1).'</a> </li>';
				}
?>
			</ul>
                
<?php
	if ($offset < ($page_count-1))
	{
?>
			<a href="./?PAGE=2&OFFSET=<?php echo ($offset+1).$url; ?>" class="next">Siguiente</a>
<?php
	}
 else
	{
?>
		<div class="anterior">Siguiente</div>
<?php
	}
    endif;
?>
		</div> <!--Catalogo-de-->   
		
		<div class="Catalogo-2">  <!--Catalogo-2e-->
			<ul class="mas-ul">
<?php
//---- SELECTED CARS
	for ($i = 0; $i < 16; $i++)
		if (isset($vehicle_array[$i]))
		{
?>		
				<li>
					<div class="car-details">
						<a href="./?PAGE=6&CAR=<?php echo $vehicle_array[$i][field0] ?>">
							<img src="./userContent/<?php echo $vehicle_array[$i][field14] ?>" alt="" height="115" width="161" />
							<div class="cuota"><p>Cuotas desde</p><button>Q.<?php echo number_format($vehicle_array[$i][field13],0,".",","); ?><sup>.00</sup></button></div>
								<div class="name"><?php echo $vehicle_array[$i][field1] ?></div>
								<div class="year"><?php echo $vehicle_array[$i][field4] ?><span><?php echo number_format($vehicle_array[$i][field5],0,".",","); ?> Km<span></div></a>
					</div>
				</li>
<?php
		}
?>
<?php			
	if ($vehicle_array[rowcount] == 0)
	{
		echo "<li class='row_warning'><h4 style='font-weight:normal; line-height:22px; font-size:18px;'>No se encontraron resultados para la b&uacute;squeda.</h4><br/><p>Por favor, intente de nuevo o regrese al<a href='./?PAGE=2' style='color:#65A5EB;'> Cat&aacute;logo</p></a></li>";
	}
?>

			</ul>
		</div> <!--Catalogo-2-->  
		<div class="catalogo-top"><!--catalogo-top-->
			<h5>Más Populares de la Semana</h5>
			<ul class="side-ul">
<?php
//---- SELECTED CARS
	for ($i = 0; $i < $popular_array[rowcount]; $i++)
	{
?>		
		<li>
			<div class="car-det">
				<a href="./?PAGE=6&CAR=<?php echo $popular_array[$i][field0] ?>">
					<img src="./userContent/<?php echo $popular_array[$i][field14] ?>" alt="" height="115" width="161" />
							<div class="name"><?php echo $popular_array[$i][field1] ?></div>
							<div class="year_popular"><?php echo $popular_array[$i][field4] ?><span><?php echo number_format($vehicle_array[$i][field5],0,".",","); ?> Km</span></div></a>
			</div>
		</li>
<?php
	}
?>
			</ul>             
		</div> <!--catalogo-top-->	
		<div class="clear">&nbsp;</div>

		<div class="page-2">
<?php     //---- SET PAGE_SCROLL
				$scroll_begin	= 0;
				$scroll_end		= ($page_count > 9)?9:$page_count;
                                if($scroll_end >= 1):
	if ($offset > 0)
	{
?>
		<a href="./?PAGE=2&OFFSET=<?php echo ($offset-1).$url; ?>" class="next">Anterior</a>
<?php
	}
 else
	{
?>
		<div class="anterior">Anterior</div>
<?php
	}
?>
				<ul class="pagination">
<?php
				//---- SET PAGE_SCROLL
				$scroll_begin	= 0;
				$scroll_end		= ($page_count > 9)?9:$page_count;
				if ($page_count > 10)
					if ( ($offset-4) > 0 )
					{
						$scroll_begin	= ( ($offset + 4) <= $page_count )?($offset - 4):($page_count-8);
						$scroll_end		= ( ($offset + 4) <= $page_count )?($offset + 4):$page_count;
					}
				for ($i = $scroll_begin; $i < $scroll_end; $i++)
				{
					$selected_class	= ($offset	== $i)?' class="active" ':'';
					$last_class		= ($scroll_end == $i)?' class="last" ':'';
					echo '<li '.$last_class.'> <a href="./?PAGE=2&OFFSET='.$i.$url.'" '.$selected_class.'> '.($i+1).'</a> </li>';
				}
?>
				</ul>
<?php
	if ($offset < ($page_count-1))
	{
?>
			<a href="./?PAGE=2&OFFSET=<?php echo ($offset+1).$url; ?>" class="next">Siguiente</a>
<?php
	}
 else
	{
?>
		<div class="anterior">Siguiente</div>
<?php
	}
        endif;
?>
			</div> 
		
	</div> <!--index_content-->    
</div>
