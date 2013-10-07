            <div id="inner-content"> <!--inner-content-->
              <div class="contact_content"> <!--contact_content-->
                <div class="servicios_inner"> <!--servicios_inner-->
                 <div class="ser-left"><!--ser-left-->
                   <div class="ser-bot"><!--ser-bot-->
                    <div class="ser-mid"><!--ser-mid-->
                     <h2>Servicios</h2>                  
                      <ul class="vendemos-ul">
						  <?php echo strip_tags(ASTEG_posts::get_singlepost(3001),"<li><p>"); ?>
                     </ul>
                    </div><!--ser-mid-->
                   </div><!--ser-bot-->
                  </div><!--ser-left-->
                  <div class="ser-right"><!--ser-right-->
                    <div class="ser-right-bot"><!--ser-right-bot-->
                      <div class="ser-right-mid"><!--ser-right-mid-->
                        <h6>Solicita más Información</h6>
                         <form action="./?PAGE=3" method="POST">
							<input type="hidden" name="ASTEGsubmit_code" value="INFORMATION_FORM_POST" />
                                                        <input type="text" name="FORM_INPUT" />
                          <fieldset>
                           <ul class="nombre">
                            <li> <strong>Nombre</strong> <input type="text" name="CONTACT_FORM_NAME" /></li>
                            <li> <strong>Email</strong> <input type="text" name="CONTACT_FORM_EMAIL" /></li> 
                            <li> <strong>Teléfono</strong> <input type="text" name="CONTACT_FORM_TELEPHONE" /></li>
                            <li> <strong>Asunto</strong >
                             <select class="select"  name="CONTACT_FORM_INTEREST">
				 			   <option>Deseo informacion de Seguros</option>
				  			 	 <option>Deseo informacion de Financiamiento</option>
				 			   <option>Deseo vender mi vehiculo en este sitio</option>			
				 			   <option>Otro...</option>			
							 </select></li>
                            <li> <strong>Mensaje</strong> <textarea cols="10" rows="10" name="CONTACT_FORM_DETAIL"></textarea></li>
                         </ul>  
                         <input type="submit" value="Enviar" class="btn-enviar" />
                        </fieldset>
                        </form>                     
                      </div><!--ser-right-mid-->
                    </div><!--ser-right-bot-->
                   </div><!--ser-right-->
                 </div><!--servicios_inner-->          
              </div> <!--contact_content-->    
            </div> <!--inner-content-->    