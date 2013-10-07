            <div id="inner-content"> <!--inner-content-->
              <div class="contact_content"> <!--contact_content-->
                <div class="contact_inner"> <!--contact_inner-->
                 <div class="contacto-left"><!--contacto-left-->
                   <div class="contacto-bot"><!--contacto-bot-->
                    <div class="contacto-mid"><!--contacto-mid-->
                     <h4>Contacto</h4>
                     <p class="lorem-p"><?php echo strip_tags(ASTEG_posts::get_singlepost(5001)); ?></p>
                     <form action="./?PAGE=5" method="POST"> 
						 <input type="hidden" name="ASTEGsubmit_code" value="CONTACT_FORM_POST" />
                                                 <input type="text" name="FORM_INPUT" value="" />
                                                 
                       <ul class="contact-form">
							<li> <strong>Nombre</strong> <input type="text" name="CONTACT_FORM_NAME" /></li>
							<li> <strong>Email</strong> <input type="text" name="CONTACT_FORM_EMAIL" /></li>
							<li> <strong>Teléfono</strong> <input type="text" name="CONTACT_FORM_TELEPHONE" /></li>
							<li> <strong>Asunto</strong> <input type="text" name="CONTACT_FORM_INTEREST" /></li>
							<li> <strong>Mensaje</strong> <textarea cols="10" rows="10" name="CONTACT_FORM_DETAIL"></textarea> </li>
                       </ul>
                       <input type="submit" class="btn-enviar" value="Enviar" />
                     </fieldset>
                     </form>
                    </div><!--contacto-mid-->
                   </div><!--contacto-bot-->
                  </div><!--contacto-left-->
                  <div class="contacto-right"><!--contacto-right-->
                    <div class="contacto-right-bot"><!--contacto-right-bot-->
                      <div class="contacto-right-mid"><!--contacto-right-mid-->
                       <img src="./userContent/CMS/img-1.png" alt="" />
                       <h4><span>PBX.</span> 1705</h4>
                       <p><strong>Dirección</strong> </p>
					   <?php echo strip_tags(ASTEG_posts::get_singlepost(5002),"<p><b><strong><em><i>"); ?>
                       <p class="email-p"><strong>Email</strong></p>
                       <p><a href="emailto:usados@cofal.com.gt">usados@cofal.com.gt</a></p>
                      </div><!--contacto-right-mid-->
                    </div><!--contacto-right-bot-->
                   </div><!--contacto-right-->
                 </div><!--contact_inner-->          
              </div> <!--contact_content-->    
            </div> <!--inner-content-->      