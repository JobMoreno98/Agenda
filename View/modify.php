
<?php
   require_once ("../Model/config.php");

    $operation = new Operation();
date_default_timezone_set("America/Mexico_City");
    $array_records_types = $operation->retrieve_from_table("tipo", EVENT_TYPES,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
    $array_records_spaces = $operation->retrieve_from_table("espacio", SPACES, NULL, $_SESSION["university_center"], NULL,NULL,NULL,NULL,NULL);
    $array_records_dependencies = $operation->retrieve_from_table("dependencia", DEPENDENCIES, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
   
    
    if (count($array_records_types) <= 0) {

        echo "
            <div>
                Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 8973.
            </div>
        ";
       
    }
    else if (count($array_records_spaces) <= 0) {

        echo "
            <div>
                Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 77223.
            </div>
        ";

      
    }
     else if (count($array_records_dependencies) <= 0) {

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
                <h5  class='modal-title' id='exampleModalLabel'>MODIFICAR EVENTO</h5>
                
              </div>

        <form name='modifyForm'  ng-submit='submitUpdate()'>

            <p><input type='hidden' name='insert' required readonly /></p>

           <div class='container'>
                  <div class = 'row'>
                    <!-- Columna Titulo -->
                    <div class='col-sm-12'>
                      <label for='id_titulo' style='color:#283b41'><strong>TÍTULO</strong></label><br>
                            <input type='text' style='border-style: solid;border-color: #a4a4a4; width:100%' id='id_titulo' name='titulo' ng-model='user.titulo' required autofocus minlength='' ng-value='datosMostrar.titulo' maxlength='' />
                    </div>
                    <!--Fin columna Titutlo -->
                  </div>
                  <!--Fin primera fila-->

                  <div class='row'>
                    <!--Columna Tipo -->
                    <div class='col-sm-12'>
                      <br><label for='id_tipo' style='color:#283b41'><strong>TIPO</strong></label><br>
                          <select ng-model='user.tipo' style='border-color: #a4a4a4; border-style:solid; width:100%;border-width: 2px;' id='id_tipo' name='tipo'>
                                <option value='Seleccionar' name='tipo' selected>Seleccionar</option>
                                    <?php
                                        foreach ($array_records_types as $record) 
                                        {
                                              $tipo = $record->tipo;

                                              echo "<option value='$tipo' name='$tipo'>$tipo</option>";
                                        }

                                    ?>
                                 
                          </select>
                    </div>
                    <!--Fin columna Tipo -->
                  </div>
                  <!-- Fin segunda FILA -->

                  <div class = 'row'>
                    <div class= 'col-sm-12'>
                                <br>
                                <label for='id_dependencia' style='color:#283b41'><strong>DEPENDECIA</strong></label><br>
                                <select style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px; id='id_dependencia' name='dependencia' ng-model='user.dependencia' onchange=\"if(this.value=='Otro') document.getElementById('otro').disabled=false; else if(this.value!='Otro') document.getElementById('otro').disabled=true;\"' required>
                                        <option value='Seleccionar' name='dependencia' selected>Seleccionar</option>
                                        <?php

                                            foreach ($array_records_dependencies as $record) {

                                                $dependencia = $record->dependencia;

                                                echo "<option value='$dependencia' name='dependencia'>$dependencia</option>";
                                            }
                                        ?>

                                
                                        <option  value='Otro' name='dependencia'>Otro</option>
                              </select>
                              <br>
                              <br>
                              <label for='id_dependencia' style='color:#283b41'><strong>OTRA DEPENDENCIA</strong></label>
                              <input style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;' ng-model='user.dependencia' type='text' id='otro' name='dependencia' placeholder='Dependencia externa' disabled>
                    </div>

                  </div>
                  <br>
                  <hr>
                  <!--Fin tercera fila-->

                <div class = 'row'>
                    <div class =  'col-sm-12'>
                          <label for='id_organizador' style='color:#283b41'><strong>ORGANIZADOR</strong></label><br>
                                    <input ng-value='user.organizador' type='text' id='id_organizador' name='organizador' required minlength='' ng-model='user.organizador' style='border-style: solid;border-color: #a4a4a4; width:100%'  maxlength='' />
                    </div>
                    <!--Fin columna Organizador -->
                </div>
                  <!--Fin cuarta fila -->

                <div class = 'row' >
                    <div class = 'col-sm-12'>
                       <br>
                       <label for='id_tel_organizador' style='color:#283b41'><strong>TELEFONO ORG</strong></label>
                       <br>
                       <input style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;' ng-value='user.tel_organizador' type='text' id='id_tel_organizador' name='tel_organizador' required minlength='".MIN_PHONE_LENGTH."' maxlength='"<?php.MAX_PHONE_LENGTH.?>"' ng-model='user.tel_organizador' placeholder='Extensión/Celular' />
                    </div>
                    <!-- fin columna tel organizador -->
                </div>
                  <!-- fin quinta fila -->
                <br>
                <hr>

                
                  <!-- fin sexta fila -->
               
                <br>
                <hr>
                  <!-- fin septima fila -->
                <div class = 'row' >
                      <div class='col-sm-12'>
                          <div class='row'>
                                <div class='col-4'>
                                    <label for='id_espacio' style='color:#283b41'><span class='ab-lugar'></span>ESPACIO</label><br>
                                </div>
                                 <div class='col-8'>
                                    
                                      <select ng-show="user.cu != 'Clases'" style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;' id='id_espacio' ng-model='user.espacio' name='espacio' >
                                              <option value='Seleccionar' name='espacio'  selected>Seleccionar</option>
                                              
                                              <?php
                                                    foreach ($array_records_spaces as $record) {

                                                        $espacio = $record->espacio;

                                                        echo "<option value='$espacio' name='$espacio'>$espacio</option>";
                                                    }
                                              ?> 
                                      </select>

                                     
                                      <select ng-init="splitEspacio(user.espacio)" ng-show="user.cu == 'Clases'" id="id_aulas" style='border-color: #a4a4a4; border-style:solid; border-width: 2px;'  ng-model='splitedSpace[0]' required>
                                                <option value='FBA' selected="selected"> FBA </option>
                                                <option value='FBB'> FBB </option>
                                                <option value='FBC'> FBC </option>
                                                <option value='FBD'> FBD </option>
                                                <option value='FBE'> FBE </option>
                                                
                                      </select>
                                       <select ng-show="user.cu == 'Clases'" id="id_salones" style='border-color: #a4a4a4; border-style:solid; border-width: 2px;'  ng-model='splitedSpace[1]' required>
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
                  <div class='row'>
                    <div class='col-5'>
                      <label for='id_fecha' style='color:#283b41'> <span class='ab-calendario'></span>FECHA</label><br>
                      </div>
                      <div class='col-7'>
                                    <input style='border-style: solid;border-color: #a4a4a4; width:100%' ng-value='user.fecha' type='date' id='id_fecha' name='fecha' min='". date("Y-m-d") ."' ng-model='created_time' ng-change='setDate(); changeFlag(created_time)' required /><br>
                      </div>
                      </div>
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
                  <div class = 'row' >
                    <div class='col-sm-12'>
                           <label for='id_notas_cta'style='color:#283b41'>NOTAS CTA</label>
                           <br>
                          <textarea style='width: 100%; height: 100px; background-color:#efefef' type='text' ng-value='user.notas_cta' type='text' id='id_notas_cta' ng-model='user.notas_cta' name='notas_cta' maxlength='' rows='' cols='' placeholder='Notas para CTA.' value='Sin notas'>
                
                          </textarea>
                    </div>
                    <!-- fin columna Notas CTA -->

                  </div>
                  <hr>
                  <!-- fin fila 12-->
                  <div class = 'row' >
                    <div class='col-sm-12'>
                    <label for='id_notas_sg' style='color:#283b41'>NOTAS SERVICIOS GENERALES</label>
                                    <br>
                                    <textarea style='width: 100%; height: 100px; background-color:#efefef' type='text' ng-value='user.notas_sg' type='text' id='id_notas_sg' name='notas_sg' ng-model='user.notas_sg' maxlength='' rows='' cols='' placeholder='Notas para Servicios generales.' value='Sin notas'></textarea>
                    </div>
                    <!-- fin columna Notas STG -->
                  </div>
                  <!-- fin fila 13-->
                  <!--Informacion sobre la insercion en la tabla-->
                 
                
                  <div ng-class='class' id='alertas' role='alert'> 
                    {{informacion.datos.info}}
                  </div>

                  <div>
                                <p>
                                    <button onclick='reFetch()' type='submit' ng-disabled="loading" style='color:#31bdca' class='btn btn-link'><img style='width:20px; height:20px' src='img/registrar.png'> <strong>Actualizar</strong><span class='glyphicon glyphicon-remove'></span><span ng-show="loading" class="fas fa-circle-notch fa-spin"></span></button>
                                   

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
