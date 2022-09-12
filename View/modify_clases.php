
<?php
   require_once ("../Model/config.php");

    $operation = new Operation();
date_default_timezone_set("America/Mexico_City");
    #$array_records_types = $operation->retrieve_from_table("tipo", EVENT_TYPES,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
    #$array_records_spaces = $operation->retrieve_from_table("espacio", SPACES, NULL, $_SESSION["university_center"], NULL,NULL,NULL,NULL,NULL);
    $array_records_dependencies = $operation->retrieve_from_table("dependencia", DEPENDENCIES, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
   
    
    /*if (count($array_records_types) <= 0) {

        echo "
            <div>
                Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 8973.
            </div>
        ";
       
    }*/
    /*else if (count($array_records_spaces) <= 0) {

        echo "
            <div>
                Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 77223.
            </div>
        ";

      
    }*/
     if (count($array_records_dependencies) <= 0) {

      echo "
          <div>
              Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 337363.
          </div>
      ";

      
    }
    
    ?>
    <div class='row'>

        <div class='col-2'>
        </div>
        <div class='col-9' style='border-left:5px solid; border-color:#a4a4a4'>
          <div style='background-color:#33bdca; color:white; text-align: center'>
                <h5  class='modal-title' id='exampleModalLabel'>MODIFICAR CLASES</h5>
                
              </div>

        <form name='modifyForm'  ng-submit='updateClases()'>

            <p><input type='hidden' name='insert' required readonly /></p>

           <div class='container'>
                  <div class = 'row'>
                    <!-- Columna Titulo -->
                    <div class='col-sm-12'>
                      <label for='id_titulo' style='color:#283b41'><strong>NOMBRE DE LA CLASE</strong></label><br>
                            <input type='text' style='border-style: solid;border-color: #a4a4a4; width:100%' id='id_titulo' name='titulo' ng-model='user.titulo' required autofocus minlength='' ng-value='datosMostrar.titulo' maxlength='' />
                    </div>
                    <!--Fin columna Titutlo -->
                  </div>
                  <!--Fin primera fila-->

                  <div class='row'>
                    <!--Columna Tipo -->
                    <div class='col-sm-12'>
                      <br><label for='tel_organizador' style='color:#283b41'><strong>NRC</strong></label><br>
                         <input ng-value='user.tel_organizador' type='text' id='tel_organizador' name='tel_organizador'  ng-model='user.tel_organizador' style='border-style: solid;border-color: #a4a4a4; width:100%' />
                    </div>
                    <!--Fin columna Tipo -->
                  </div>
                  <!-- Fin segunda FILA -->
                  <!--Fin tercera fila-->
                <br>
                <div class = 'row'>
                    <div class =  'col-sm-12'>
                          <label for='id_organizador' style='color:#283b41'><strong>PROFESOR</strong></label><br>
                                    <input ng-value='user.organizador' type='text' id='id_organizador' name='organizador' required minlength='' ng-model='user.organizador' style='border-style: solid;border-color: #a4a4a4; width:100%'  maxlength='' />
                    </div>
                    <!--Fin columna Organizador -->
                </div>
                  <!--Fin cuarta fila -->
                  <div ng-ini="user.fecha = datosMostrar.fecha ">
                  </div>
              
                  <!-- fin quinta fila -->
                <br>
                <hr>
                  <!-- fin sexta fila -->
                  <!-- fin septima fila -->
                <div ng-init="user.edificio = user.espacio.split(' ')[0]; user.numero_salon = user.espacio.split(' ')[1]" class = 'row' >
                      <div class='col-sm-12'>
                          <div class='row'>
                                 <div class='col-sm-3'>
                          <br><label for='edificio' style='color:#283b41'><strong>EDIFICIO</strong></label>
                      </div>
                    <div class='col-sm-3'>
                      <br>
                             
                                <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' id='edificio'  ng-model='user.edificio' required>
                                                <option value='FBA' selected="selected"> FBA </option>
                                                <option value='FBB'> FBB </option>
                                                <option value='FBC'> FBC </option>
                                                <option value='FBD'> FBD </option>
                                                
                                </select>
                    </div>
                    <div class='col-sm-3'>
                          <br><label for='edificio' style='color:#283b41'><strong>AULA</strong></label>
                      </div>
                     <div class='col-sm-3'>
                      <br>
                             
                                <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' id='numero_salon'  ng-model='user.numero_salon' required>
                                                <option value='01' selected="selected"> 01 </option>
                                                <option value='02'> 02 </option>
                                                <option value='03'> 03 </option>
                                                <option value='04'> 04 </option>
                                                <option value='05'> 05 </option>
                                                <option value='06'> 06 </option>
                                                <option value='07'> 07 </option>
                                                <option value='08'> 08 </option>
                                                <option value='09'> 09 </option>
                                                <option value='10'> 10 </option>
                                                <option value='11'> 11 </option>
                                                <option value='12'> 12 </option>
                                                <option value='13'> 13 </option>
                                                <option value='14'> 14 </option>
                                                <option value='15'> 15 </option>
                                                <option value='16'> 16 </option>
                                                <option value='17'> 17 </option>
                                                <option value='18'> 18 </option>
                                                <option value='19'> 19 </option>
                                                <option value='20'> 20 </option>                                                
                                </select>
                    </div>
                            </div>
                            <div class='row'></div>
                      </div>
                        <!-- fin columna espacio Espacio -->
                      <br>
                </div>
                <br>
                  <!-- fin novena fila -->

                <div class = 'row' >
                  <div class='col-sm-12' style='border:1px solid; padding:15px; border-color:#405765'>
                      <br>
                      <div class='row'>
                          <div class='col-6'>
                                    <label for='id_hora_inicial' style='color:#283b41'><span class='ab-reloj'></span>HORA INICIO</label>
                                    <br>
                          </div>
                         
                          <div class='col-6'>
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-change='updateHourI(user.hora_inicial_h,user.hora_inicial_m)' ng-init='ajuste(datosMostrar.hora_inicial_h);' ng-model='user.hora_inicial_h;' required>
                                       
                                        <?php 
                                            if ($_SESSION["university_center"] == "La Normal")
                                            {
                                              echo
                                                "<option value='07'> 07 </option>
                                                <option value='08'> 08 </option>
                                                <option value='09'> 09 </option>
                                                <option value='10'> 10 </option>
                                                <option value='11'> 11 </option>
                                                <option value='12'> 12 </option>
                                                <option value='13'> 13 </option>
                                                <option value='14'> 14 </option>
                                                <option value='15'> 15 </option>
                                                <option value='16'> 16  </option>
                                                <option value='17'> 17  </option>
                                                <option value='18'> 18  </option>
                                                <option value='19'> 19  </option>
                                                <option value='20'> 20  </option>
                                                <option value='21'> 21  </option>
                                                ";
                                            }
                                            else   
                                              { 
                                                echo
                                                "<option value='07'> 07 </option>
                                                <option value='08'> 08 </option>
                                                <option value='09'> 09 </option>
                                                <option value='10'> 10 </option>
                                                <option value='11'> 11 </option>
                                                <option value='12'> 12 </option>
                                                <option value='13'> 13 </option>
                                                <option value='14'> 14 </option>
                                                <option value='15'> 15 </option>
                                                <option value='16'> 16  </option>
                                                <option value='17'> 17  </option>
                                                <option value='18'> 18  </option>
                                                <option value='19'> 19  </option>
                                                <option value='20'> 20  </option>
                                                <option value='21'> 21  </option>
                                                <option value='22'> 22  </option>";
                                              }
                                        ?>
                                          
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-change='updateHourI(user.hora_inicial_h,user.hora_inicial_m)' ng-model='user.hora_inicial_m' required>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>
                          </div>
                      </div>
                                    <!--<input type='time' id='id_hora_inicial' name='hora_inicial' required /><br>-->

                        <div class='row'>
                          <div class='col-6'>
                                <label for='id_hora_final' style='color:#283b41; margin-left:20px'>HORA TERMINO</label>
                          </div>
                          <div class='col-6'>
                                     <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-change='updateHourF(user.hora_final_h,user.hora_final_m)' ng-model='user.hora_final_h' required>";
                                        <?php
                                              if ($_SESSION["university_center"] == "La Normal")
                                              {
                                                echo
                                                  "<option value='07'> 07 </option>
                                                  <option value='08'> 08 </option>
                                                  <option value='09'> 09 </option>
                                                  <option value='10'> 10 </option>
                                                  <option value='11'> 11 </option>
                                                  <option value='12'> 12 </option>
                                                  <option value='13'> 13 </option>
                                                  <option value='14'> 14 </option>
                                                  <option value='15'> 15 </option>
                                                  <option value='16'> 16  </option>
                                                  <option value='17'> 17  </option>
                                                  <option value='18'> 18  </option>
                                                  <option value='19'> 19  </option>
                                                  <option value='20'> 20  </option>
                                                  <option value='21'> 21  </option>
                                                  ";
                                              }
                                              else   
                                                { 
                                                  echo
                                                  "<option value='07'> 07 </option>
                                                  <option value='08'> 08 </option>
                                                  <option value='09'> 09 </option>
                                                  <option value='10'> 10 </option>
                                                  <option value='11'> 11 </option>
                                                  <option value='12'> 12 </option>
                                                  <option value='13'> 13 </option>
                                                  <option value='14'> 14 </option>
                                                  <option value='15'> 15 </option>
                                                  <option value='16'> 16  </option>
                                                  <option value='17'> 17  </option>
                                                  <option value='18'> 18  </option>
                                                  <option value='19'> 19  </option>
                                                  <option value='20'> 20  </option>
                                                  <option value='21'> 21  </option>
                                                  <option value='22'> 22  </option>";
                                                }     
                                          ?>
                                            
                                       
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-change='updateHourF(user.hora_final_h,user.hora_final_m)' ng-model='user.hora_final_m' required>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>
                            </div>
                          </div>
                                    <!--<input type='time' id='id_hora_final' name='hora_final' ng-model='user.hora_final' required />-->
                      </div>
                    <!-- fin columna fecha -->
                  </div>
                  <!-- fin fila 11 -->
                  <br>
                 
                  <hr>
                  <!-- fin fila 12-->
                
                  <!-- fin fila 13-->
                  <!--Informacion sobre la insercion en la tabla-->
                 
                
                  <div ng-class='class' id='alertas' role='alert'> 
                    {{informacion.datos.info}}
                  </div>

                  <div>
                                <p>
                                    <button onclick='reFetch()' type='submit' style='color:#31bdca' class='btn btn-link'><img style='width:20px; height:20px' src='img/registrar.png'> <strong>Actualizar</strong><span class='glyphicon glyphicon-remove'></span></button>
                                   

                                    <button type='button' onclick='reFetch();' ng-click='limpiar();' style='color:#31bdca' class='btn btn-link' data-dismiss='modal'><img style='width:20px; height:20px' src='img/cerrarazul.png' data-dismiss='modal'> <strong data-dismiss='modal'>Cerrar</strong><span class='glyphicon glyphicon-remove'></span></button>
                                </p>                                    
                  </div>

                </div>
           
                <!--Fin container -->

     

        </form>
        </div>
        <div class='col-1'>
        </div>
        </div>
