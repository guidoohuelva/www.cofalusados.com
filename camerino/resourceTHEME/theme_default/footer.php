<?php $date_array	= ASTEG_utilities::utilities_padded_date_array(getdate()); ?>
	<div id="footer">Para una mejor experiencia utilice <a href="http://www.mozilla.com" target="_blank">Mozilla Firefox</a> &oacute; <a href="http://www.google.com/chrome" target="_blank">Google Chrome.</a>&nbsp;&nbsp;&nbsp;&nbsp;&copy; <?php echo $date_array['year'].". "; print ASTEG_utilities::utilities_display_companies(); ?> Reservados todos los derechos.</div>
<?php echo "</body></html>"; ?>
