<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php echo '<html xmlns="http://www.w3.org/1999/xhtml" '.ASTEG_resource::resource_get('RESOURCE_THEME_LANGUAGE').">" ?>
<head>
	<meta http-equiv="Content-Type" content="<?php echo ASTEG_resource::resource_get('RESOURCE_THEME_HTMLTYPE'); ?>; charset=<?php echo ASTEG_resource::resource_get('RESOURCE_THEME_CHARSET'); ?>" />
	<title><?php echo $this->engine_show_header(); ?></title>
	<link rel="stylesheet" href="../resourceJAVASCRIPT/jqueryUI/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo THEME_PATH; ?>style.css" type="text/css" media="screen" />
	<?php echo $xajax->getJavascript('../resourceXAJAX'); ?>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" ></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" ></script>
	<script type="text/javascript" src="../resourceJAVASCRIPT/jquery.tools.js" ></script>
	<script type="text/javascript" src="../resourceJAVASCRIPT/ASTEGfunctions.hoverover.js" ></script>
	<script type="text/javascript" src="../resourceJAVASCRIPT/ckeditor/ckeditor.js" ></script>
	<script type="text/javascript" src="<?php echo THEME_PATH; ?>javascript.js" ></script>
</head>
<?php echo "<body>"; ?>
<?php 	$login_result = ASTEG_security::security_login_check(); ?>
<div id="header">
	<a href="./?PAGE=2"><img src="<?php echo THEME_PATH; ?>/images/logo.png" width="109" height="22" class="header_logo" /></a>
<?php
	if ($login_result == true)
	{
		include_once (THEME_PATH."plugins/ASTEGplugin.users.php");
		$user_class		= new ASTEGplugin_users();
?>

<?php
	$current_background_color	= "background_nav";
	$button_array								= array();
	for ($i = 0; $i < 7; $i++)
		$button_array[$i]	= "button_nav";


	//---- HELPER FUNCTION
	if ( ($_GET['ID'] == 4) || ($_GET['PAGE'] == 4) )
	{
		$button_array[0]			= "button_nav_yellow";
		$current_background_color	= "background_nav_yellow";
	}
	if ( ($_GET['ID'] == 5) || ($_GET['PAGE'] == 5) )
	{
		$button_array[1]			= "button_nav_green";
		$current_background_color	= "background_nav_green";
	}
	if ( ($_GET['ID'] == 6) || ($_GET['PAGE'] == 6) )
	{
		$button_array[2]			= "button_nav_orange";
		$current_background_color	= "background_nav_orange";
	}
	if ( ($_GET['ID'] == 7) || ($_GET['PAGE'] == 7) )
	{
		$button_array[3]			= "button_nav_purple";
		$current_background_color	= "background_nav_purple";
	}
	if ( ($_GET['ID'] == 8) || ($_GET['PAGE'] == 8) )
	{
		$button_array[4]			= "button_nav_yellow";
		$current_background_color	= "background_nav_yellow";
	}
	if ( ($_GET['ID'] == 9) || ($_GET['PAGE'] == 9) )
	{
		$button_array[5]			= "button_nav_green";
		$current_background_color	= "background_nav_green";
	}
	if ( ($_GET['ID'] == 10) || ($_GET['PAGE'] == 10) )
	{
		$button_array[6]			= "button_nav_orange";
		$current_background_color	= "background_nav_orange";
	}

?>


	<div class="header_button_bar">
		<label><?php echo $header_text['navigation01'] ?><i><?php echo ASTEG_security::security_login_username(); ?></i></label><a href="./?PAGE=2" class="button_default button_gray"><?php echo $header_text['navigation02'] ?></a><a href="./?ACTION=logout" class="button_default button_red"><?php echo $header_text['navigation04'] ?></a>
	</div>
</div>
<div id="navigation">
	<div class="navigation_button_bar">
<?php
		echo '<a href="./?PAGE=4" class="button_default '.$button_array[0].'">'.$header_text['button01'].'</a>';
		echo '<a href="./?PAGE=9" class="button_default '.$button_array[5].'">'.$header_text['button06'].'</a>';
		echo '<a href="./?PAGE=8" class="button_default '.$button_array[4].'">'.$header_text['button05'].'</a>';
		echo '<a href="./?PAGE=10" class="button_default '.$button_array[6].'">'.$header_text['button07'].'</a>';
		echo '<a href="./?PAGE=7" class="button_default '.$button_array[3].'">'.$header_text['button04'].'</a>';
		echo '<a href="./?PAGE=5" class="button_default '.$button_array[1].'">'.$header_text['button02'].'</a>';
?>
		<a href="<?php echo ASTEG_resource::resource_get("RESOURCE_WEBSITE_URL")?>"  target="_blank" class="button_default button_nav_black navigation_last_button"><?php echo $header_text['button99']; ?></a>
	</div>
</div>


	<div id="navigation_location" class="<?php echo $current_background_color; ?>">&nbsp;</div>
<?php
	}
	else
	{
?>
	<div class="header_button_bar"><a href="<?php echo ASTEG_resource::resource_get("RESOURCE_WEBSITE_URL")?>" class="button_default button_gray"><?php  echo $header_text['backtosite']; ?></a></div>
</div><!-- HEADER -->
<?php
	}
?>