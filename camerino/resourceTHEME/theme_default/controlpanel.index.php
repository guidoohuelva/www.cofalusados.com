<?php
	include_once (THEME_PATH."plugins/ASTEGplugin.users.php");
	$user_class				= new ASTEGplugin_users();
	$resource_class		= new ASTEG_resource();
?>
<div class="content_background_white">
	<div id="camerino_content">
		<div class="content">
			<div class="content_column float_left">
				<div id="xajax_camerino_googleanalytics" class="content_stats">loading...</div>
				<p>Para ingresar a su cuenta de <a href="http://www.google.com/analytics" target="_blank">Google Analytics:</a></p>
				<p><b>User:</b> <?php echo $resource_class->resource_get("RESOURCE_ANALYTICS_USER")?></p>
				<p><b>Password:</b> <?php echo $resource_class->resource_get("RESOURCE_ANALYTICS_PASSWORD")?></p>
				<br/><br/>
				<p><a href="<?php echo $resource_class->resource_get("RESOURCE_GUIDE_URL")?>" target="_blank">Descargar Gu&iacute;a de Administraci&oacute;n &raquo;</a></p>
			    <p><b>Contrase&ntilde;a de PDF:</b>  c9o8f7a6l5u1s2a3d4o5s6</p>
			    <p style="font-size:10px;"><b>Nota:</b> Es requerido abrir el documento con <a href="http://get.adobe.com/reader/" target="_blank" style="font-size:10px;">Adobe Acrobat 6</a> como m&iacute;nimo.</p>
			</div>
			<div class="content_column float_left">
				<div class="bulletin_board">
					<?php echo $user_class->users_get_bulletinboard(); ?>
				</div>
				<div class="support_form">
					<h3>&nbsp;&nbsp;&nbsp;&nbsp;&iquest;Dudas?</h3>
					<p style="font-size:11px;">Si necesita asistencia en el manejo de este sistema de administraci&oacute;n,<br/>puede contactarnos por medio de este formulario.</p>
					<form name="assistance_fieldset" method="post" action="./?PAGE=2" class=common_short_form>
						<input type="hidden" name="ASTEGsubmit_code" value="ASTEGassistance_form" />
						<div class="short_form_input"><label>Nombre</label><input name="ASSISTANCE_NAME" /></div>
						<div class="short_form_input"><label>Email</label><input name="ASSISTANCE_EMAIL"  /></div>
						<div class="short_form_input textarea"><label>Mensaje</label><textarea name="ASSISTANCE_QUESTION"></textarea></div>
						<div class="short_form_submit"><input type="submit" value="<?php echo $form_buttons['control_index_submit']; ?>" class="button_default button_blue content_button"/></div>
					</form>
				</div>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready( function()
	{
		xajax.call('camerino_googleanalytics',{mode:'asynchronous'});
	});
</script>