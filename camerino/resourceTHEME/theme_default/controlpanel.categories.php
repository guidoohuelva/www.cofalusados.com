<?php
	include_once THEME_PATH."plugins/ASTEGplugin.categories.php";
	$ASTEGplugin 		= new ASTEGplugin_categories();
?>
<div class="content_background_white">
	<div id="camerino_content">
		<div class="content">
			<?php $ASTEGplugin->plugin_display(); ?>
		</div>
	</div>
</div>