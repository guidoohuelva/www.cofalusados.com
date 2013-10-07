<?php
	include_once THEME_PATH."plugins/ASTEGplugin.posts.php";
	$ASTEGplugin 		= new ASTEGplugin_posts();
?>
<div class="content_background_white">
	<div id="camerino_content">
		<div class="content">
			<?php $ASTEGplugin->plugin_display(); ?>
		</div>
	</div>
</div>