        <div class="external-links-bar">
            <div class="container">
                <div class="row links-container collapse">
                    <div class="span3">
                        <div class="links-box">
                            <ul class="external-links">
                                <li><a href="http://www.toyota.com.gt" target="_blank"><i class="icon-toyota"></i> Toyota Guatemala</a></li>
                                <li><a href="http://www.renault.com.gt" target="_blank"><i class="icon-renault"></i> Renault Guatemala</a></li>
                                <li><a href="http://www.chevrolet.com.gt" target="_blank"><i class="icon-chevrolet"></i> Chevrolet Guatemala</a></li>
                                <li><a href="https://www.expressonline.com.gt" target="_blank"><i class="icon-express"></i> Express Online</a></li>
                                <li><a href="#cita_form" class="open-form" rel="popover" title="" id="cita" data-toggle="button" data-original-title="Calendarice una Cita"><i class="icon-clock"></i> Haga una Cita</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="get_form_container" class="toyota">
                </div>
                <!-- form -->
                    <div class="hidden" hidden="" id="cita_form">
                        <form action="<?php echo THEME_PATH; ?>top_links/json/send.php" method="post" class="get_date_form" id="get_date">
                            <input type="hidden" name="sent_from">
                            <p>
                                <label for="fullname">Nombre Completo</label>
                                <input type="text" name="fullname" id="fullname" required data-errormessage-value-missing="Por favor ingrese su nombre.">
                            </p>
                            <p>
                                <label for="emailaddress">Email</label>
                                <input type="email" name="email_date" id="emailaddress" required data-errormessage-value-missing="Ingrese su direccion de correo electronico." required data-errormessage-type-mismatch="Por favor ingrese una direccion de emailo valida.">
                            </p>
                            <p>
                                <label for="phonenumber">Tel&eacute;fono</label>
                                <input type="tel" name="phone_date" id="phonenumber" required data-errormessage-value-missing="Ingrese una fecha">
                            </p>
                            <p>
                                <label for="availabledate">Fecha Disponible</label>
                                <input type="text" name="fecha_1" class="availabledate" id="availabledate" required data-errormessage-value-missing="Ingrese una fecha">
                            </p>
                            <p>
                                <label for="availabledate_2">Otra Fecha Disponible</label>
                                <input type="text" name="fecha_2" disabled="disabled" class="availabledate_2" id="availabledate_2" required data-errormessage-value-missing="">
                            </p>
                            <p class="description">Un agente de servicio estar&aacute; en contacto con usted para calendarizar una cita seg&uacute;n sus requerimientos. Tome en cuenta que las fechas est&aacute;n sujetas a condiciones de disponibilidad de nuestros agentes y unidades.</p>
                            <input type="submit" class="btn btn-primary" value="Enviar"><img style="display: none;" src="<?php echo THEME_PATH; ?>top_links/img/ajax-loader.gif" class="ajax-loader">
                        </form>
                      </div>
                    <!-- end form -->
                <div class="row">
                    <div class="span2">
                        <div class="external-links-tab-container">
                            <div class="external-links-tab">
                                <a href="#" id="external_link" class="btn-link" data-toggle="collapse" data-target=".links-container"><span>Abrir</span> <i class="icon-plus-sign"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
