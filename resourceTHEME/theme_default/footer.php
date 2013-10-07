<?php
	$selected_page	= (isset($_GET[PAGE]))?$_GET[PAGE]:1;
?>
<div id="footer"><!--footer-->
	<div class="foot_wrapp"><!--foot_wrapp-->
		<ul class="sub-footer"><!--sub-footer-->
			<li>
				<div class="razones">
					<h5>Razones</h5>
					<?php
						$lines	= explode("\n",strip_tags(ASTEG_posts::get_singlepost(1001)));
						foreach ($lines as $value)
						{
							$trimmed	= trim($value);
							if (!empty($trimmed))
								echo '<p> <img src="'.THEME_PATH,'images/check.png" alt="" />'.$value.'</p>';
						}
					?>
				</div>
			</li>
			<li>
				<div class="finan">
					<h4>Financiamiento</h4>
					<p><?php echo strip_tags(ASTEG_posts::get_singlepost(1002),"<br>"); ?></p>
				</div>
			</li>
			<li>
				<div class="asegurado">
					<h4>Llévatelo Asegurado</h4>
					<p><?php echo strip_tags(ASTEG_posts::get_singlepost(1003),"<br>"); ?></p>
				</div>
			</li>
		</ul><!--sub-footer-->
		<div class="foot-left"><!--foot-left-->
			<div class="vehiculos"><!--vehiculos-->
				<h6><a href="./?PAGE=2">Vehículos</a></h6>
					<ul>
						<li> <a href="./?PAGE=2&BRAND_SELECT=-1&YEAR_SELECT=-1&PRICE_SELECT=-1&TYPE_SELECT=0">Sedán</a></li>
						<li> <a href="./?PAGE=2&BRAND_SELECT=-1&YEAR_SELECT=-1&PRICE_SELECT=-1&TYPE_SELECT=1">Hatchback</a></li>
						<li> <a href="./?PAGE=2&BRAND_SELECT=-1&YEAR_SELECT=-1&PRICE_SELECT=-1&TYPE_SELECT=2">Camionetas</a></li>
						<li> <a href="./?PAGE=2&BRAND_SELECT=-1&YEAR_SELECT=-1&PRICE_SELECT=-1&TYPE_SELECT=3">SUV</a></li>
						<li> <a href="./?PAGE=2&BRAND_SELECT=-1&YEAR_SELECT=-1&PRICE_SELECT=-1&TYPE_SELECT=4">Comerciales</a></li>
						<li> <a href="./?PAGE=2&BRAND_SELECT=-1&YEAR_SELECT=-1&PRICE_SELECT=-1&TYPE_SELECT=5">Deportivos</a></li>
						<li> <a href="./?PAGE=2">Ver Todos</a></li>
					</ul>
			</div><!--vehiculos-->
			<div class="servicio"><!--servicio-->
				<ul>
					<li><a href="./?PAGE=3">Servicios </a></li>
					<li><a href="./?PAGE=4">Beneficios</a></li>
				</ul>
			</div><!--servicio-->
			<div class="pbx-f"><!--servicio-->
				<h6>PBX. <span>1705</span></h6>
				<p class="usa-dos"> <a href="mailto:usados@cofal.com.gt">usados@cofal.com.gt</a></p>
				<?php echo strip_tags(ASTEG_posts::get_singlepost(6001),"<p><b><strong><i><em><br>"); ?>
			</div>
			<div class="info">
				<p>© 2013 Cofiño Stahl Guatemala. Reservados Todos los Derechos.&nbsp;&nbsp;|&nbsp;&nbsp;<a href="./?PAGE=7" style="color:#aaa;">Pol&iacute;ticas de Privacidad</a></p>
				<p class="custom">Desarrollado por
				<a href="http://www.grupoperinola.com" target="_blank">Perinola</a></p>
			</div>
		</div><!--foot-left-->
		<div class="foot-right"><!--foot-right-->
			<div class="subscribe">
				<form action="./?PAGE=<?php echo $selected_page; ?>" method="POST">
				<input type="hidden" name="ASTEGsubmit_code" value="EMAIL_CATCHER" />
                                <input type="text" name="FORM_INPUT" />
				<fieldset>
					<input type="text" class="input" name="EMAILCATCHER_EMAIL" />
					<input type="submit" class="submit" />
				</fieldset>
				</form>
				<?php echo strip_tags(ASTEG_posts::get_singlepost(6002),"<p><b><strong><i><em><br>"); ?>
			</div>
			<ul>
				<li> <a href="https://www.facebook.com/pages/Cofal-Usados/314202608630103" target="_blank"> <img src="<?php echo THEME_PATH; ?>images/fb-1.png" alt="Facebook" class="ro" /></a></li>
			</ul>
		</div><!--foot-right-->
	</div><!--foot_wrapp-->
</div><!--footer-->
</div><!--wrapper-->

<!-- AddThis Button BEGIN -->
	    <style>
          .addthis_toolbox.addthis_floating_style.addthis_counter_style {
            top: 180px !important;
            z-index: 999;
          }
          .fb_iframe_widget iframe {
            position: static !important;
          }
          .addthis_button_tweet.at300b iframe {
            width: 50px !important;
          }
      </style>
      <div class="addthis_toolbox addthis_floating_style addthis_counter_style" style="left:50px;top:50px;">
      <a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
      <a class="addthis_button_tweet" tw:count="vertical"></a>
      <a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
      <a class="addthis_counter"></a>
      </div>
      <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
      <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5166023e222d6474"></script>
      <!-- AddThis Button END -->

      <!-- top links -->
        <script src="<?php echo THEME_PATH; ?>top_links/js/vendor/bootstrap.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script src="<?php echo THEME_PATH; ?>top_links/js/vendor/civem-0.0.5.min.js"></script>

        <script src="<?php echo THEME_PATH; ?>top_links/js/main.js?v=2"></script>

<?php
echo "</body>";
echo "</html>";
?>