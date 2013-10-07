            <div id="inner-content"> <!--inner-content-->
              <div class="contact_content"> <!--contact_content-->
                <div class="servicios_inner"> <!--servicios_inner-->
                 <div class="Benefi"><!--Benefi-->
                   <div class="Benefi-bot"><!--Benefi-bot-->
                    <div class="Benefi-mid"><!--Benefi-mid-->
                     <h2>Beneficios</h2>               
					 <?php
						$beneficios_array		= explode("\n",strip_tags(ASTEG_posts::get_singlepost(4001),""));
						$counter				= 2;
						foreach ($beneficios_array as $beneficio)
						{
							if (!empty($beneficio))
							{
								echo '<p> <img src="'.THEME_PATH.'images/img-'.$counter.'.png" alt="" /><span>'.$beneficio.'</span></p>';
								$counter++;
							}
						}
					 ?>
                    </div><!--Benefi-mid-->
                   </div><!--Benefi-bot-->
                  </div><!--Benefi-->                                   
                 </div><!--servicios_inner-->          
              </div> <!--contact_content-->    
            </div> <!--inner-content-->   