<?php
	include_once THEME_PATH."plugins/ASTEGplugin.emailcatcher.php";
	$ASTEGplugin 		= new ASTEGplugin_emailcatcher();
?>
<div class="content_background_white">
	<div id="camerino_content">
		<div class="content">
			<?php $ASTEGplugin->plugin_display(); ?>
		</div>
	</div>
</div>