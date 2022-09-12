
<?php
        require_once ("../Model/config.php");

        $operation = new Operation();

        $array_records_types = $operation->retrieve_from_table("tipo", EVENT_TYPES,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
        $array_records_dependencies = $operation->retrieve_from_table("dependencia", DEPENDENCIES, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
        $array_records_spaces = $operation->retrieve_from_table("espacio", SPACES, NULL, $_SESSION["university_center"], NULL,NULL,NULL,NULL,NULL);
        date_default_timezone_set("America/Mexico_City");
        
        if (count($array_records_types) <= 0) 
        {

            echo "
                  <div>
                      Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 8973.
                  </div>
                 ";
            
        }
        else if (count($array_records_dependencies) <= 0) 
        {

          echo "
                  <div>
                      Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 337363.
                  </div>
               ";

        }
        else if (count($array_records_spaces) <= 0) 
        {

            echo "
                <div>
                    Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 77223.
                </div>
            ";

           
        }

    ?>
      <div style='background-color:#33bdca; color:white; text-align: center'>
        <h5  class='modal-title' id='exampleModalLabel'>REGISTRO DE EVENTO PARA <?php echo strtoupper($_SESSION['university_center'])?></h5>       
      </div>
      <div class='row' style='overflow-y: scroll; height:600px'>

      <div class='col-1'></div>
      <div class='col-10'>
        
        <form name='eventForm'  ng-submit='submitForm()' style='border-left:5px solid;border-right:5px solid; border-color:#a4a4a4;padding-left:4%;  padding-right:4%;'>

            <p>
              <input type='hidden' name='insert' required readonly />
            </p>

            <div class='container'>

                  <div class = 'row'>
                    <!-- Columna TÍTULO -->
                    <div class='col-sm-12'>
                            <label for='id_titulo' style='color:#283b41'><strong>TÍTULO</strong></label><br>
                            <input style='border-style: solid;border-color: #a4a4a4; width:100%' type='text' id='id_titulo' name='titulo' ng-model='user.titulo' required autofocus minlength='' maxlength='' />
                    </div>
                    <!--Fin columna Titutlo -->

                  </div>
                  <!--Fin primera fila-->

                  <div class='row'>
                    <!--Columna Tipo -->
                    <div class='col-sm-12'>
                      <br>
                              <label for='id_tipo' style='color:#283b41'><strong>TIPO</strong></label>
                              <select style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;' ng-model='user.tipo' id='id_tipo' name='tipo' required>
                                    <option value='' name='tipo' selected>Seleccionar</option>
                                        <?php
                                         foreach ($array_records_types as $record) 
                                         {
                                                    $tipo = $record->tipo;

                                                    echo "<option value='$tipo' name='$tipo'>$tipo</option>";
                                         }
                                        ?>
                                 <option value='Otro' name ='Otro' > Otro </option>
                              </select>
                    </div>
                    <!--Fin columna Tipo -->
                  </div>
                  <!-- Fin segunda FILA -->

                  
                  <div class='row'>
                    <!--Columna Tipo -->
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
                    <!--Fin columna Tipo -->
                  </div>
                  <!-- Fin segunda FILA -->
                  
                  <hr>
                  <div class = 'row'>
                    <div class =  'col-sm-12'>
                          <label for='id_organizador' style='color:#283b41'><strong>ORGANIZADOR</strong></label><br>
                          <input type='text' id='id_organizador' name='organizador' required minlength='' ng-model='user.organizador' style='border-style: solid;border-color: #a4a4a4; width:100%' maxlength='' />
                    </div>

                    <!--Fin columna Organizador -->

                  </div>
                  <!--Fin cuarta fila -->

                  <div class = 'row' >
                    <div class = 'col-sm-12'>
                        <br>
                        <label for='id_tel_organizador' style='color:#283b41'><strong>TELEFONO ORG</strong></label><br>
                        <input style='border-style: solid;border-color: #a4a4a4; width:100%' type='text' id='id_tel_organizador' name='tel_organizador' required minlength='"<?php.MIN_PHONE_LENGTH.?>"' maxlength='"<?php.MAX_PHONE_LENGTH.?>"' ng-model='user.tel_organizador' placeholder='Extensión/Celular' />
                    </div>
                    <!-- fin columna tel organizador -->
                  </div>
                  <hr>
                  <!-- fin quinta fila -->
                <div class = 'row' ></div>
                  <!-- fin sexta fila -->
                <div class = 'row' >
                  <div class = 'col-sm-12'></div>  
                </div>
                 
                <div class = 'row' >
                  <div class='col-sm-12' style='border:1px solid; padding:15px; border-color:#405765'>
                  <div class='row'>
                  <div class='col-5'>
                    <label style='color:#283b41; text-align:center'><span class='ab-calendario'></span><strong>FECHA</strong></label><br>
                  </div>
                  <div class='col-7'>
                          <button type='button' data-toggle='modal' data-target='#dateModal'>
                                Agregar Fechas
                          </button>
                          <br><br><label><input ng-model='myCheckbox' ng-change='autoFill(myCheckbox)' type='checkbox' id='cbox1' value='first_checkbox'> Autocompletar</label><br>          
                  </div>
                  </div>
                  <hr>
                  <div class = 'row' >
                  <div class='col-sm-12' >
                    <div class='row' ng-show='false'>
                         <div class='col-4'>
                            <label for='id_espacio' style=' float:left; color:#283b41'><span class='ab-lugar'></span><strong>ESPACIO</strong>
                            </label>
                            <br>
                         </div>
                         <div class='col-8' id='cloneEventos' ng-show='true'>
                              <select style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;' id='id_espacio' ng-model='espacio' ng-change='pushToArray(espacio,user.espacios)' name='espacio'>
                                    <option value='Seleccionar' name='espacio' >Seleccionar</option>
                                          <?php
                                              foreach ($array_records_spaces as $record) 
                                              {

                                                  $espacio = $record->espacio;
                                                  echo $espacio; echo "espacio";
                                                  echo "<option value='$espacio' name='$espacio'>$espacio</option> ";
                                              }
                                            ?>
                                         
                                    <option value='Aula'>Aula</option>
                                    <option value='Otro'>Otro</option>
                              </select>
                          </div>
                    </div>

                    <div dynamic='elementosHtml' class='row'></div>
                    <div class='row'>
                        <div class='col-4'>
                        </div>
                        <div class='col-8'>
                                            
                        </div>
                        </div>
                    </div>
                    <!-- fin columna espacio Espacio -->
                  </div>
                  <br>
                  <br>
                  <div class='row' ng-show='false'>
                      <div class='col-6'>
                          <label for='id_hora_inicial' style='color:#283b41'><span class='ab-reloj'></span><strong>HORA INICIO</strong></label><br>
                      </div>

                          <div class='col-6'>
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' id='hora_inicial'  ng-model='user.hora_inicial_hora' required>
                                        <?php
                                             if ($_SESSION["university_center"] == "La Normal")
                                        {
                                         echo "
                                                <option value=''> -- </option>
                                               
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
                                            echo"
                                              <option value=''> -- </option>
                                              <option value='07'> 07 </option>
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
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_inicial_min' required  id='hora_inicial_min'>
                                          <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>
                          </div>
                      </div>
                                   
                          
                      <div class='row' ng-show='false'>
                            <div class='col-7'>
                                   <label for='id_hora_final' style=' color:#283b41; margin-left:20px'><strong>HORA TERMINO</strong></label>
                            </div>
                            <div class='col-5' style='margin-left: -28px;'>
                                     <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px; margin-left:-2px'  ng-model='user.hora_final_hora' required>";
                            
                                      <?PHP
                                            
                                        if ($_SESSION["university_center"] == "La Normal")
                                        {
                                          echo
                                            "<option value='' style='visibility: hidden;'> 00 </option>
                                            <option value='07'> 07 </option>
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
                                            "<option value='' style='visibility: hidden;'> 00 </option>
                                            <option value='07'> 07 </option>
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
                                      echo"
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_final_min' required>
                                         <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>                                  
                              </div>
                              
                      </div>
                    </div>
                  </div>
                  
                  <!-- fin fila 11 -->
                  <div class = 'row' >
                    <div class='col-sm-12'>
                    <br>
                     <label for='id_notas_cta' style='color:#283b41;'><strong>NOTAS CTA</strong></label><br>
                                    <textarea style='width: 100%; height: 100px; background-color:#efefef' type='text' id='id_notas_cta' ng-model='user.notas_cta' name='notas_cta' maxlength='' rows='' cols=''  value='Sin notas'></textarea>
                                    <hr>
                    </div>

                    <!-- fin columna Notas CTA -->

                  </div>
                 
                  <!-- fin fila 12-->
                  <div class = 'row' >
                    <div class='col-sm-0'></div>
                      <div class='col-sm-12'>
                      <label for='id_notas_sg' style='color:#283b41;'><strong>NOTAS SERVICIOS GENERALES</strong></label><br>
                          <textarea style='width: 100%; height: 100px; background-color:#efefef' type='text' id='id_notas_sg' name='notas_sg' ng-model='user.notas_sg' maxlength='' rows='' cols=''  value='Sin notas'></textarea>
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
                          <button onclick='reFetch()' type='submit' style='color:#31bdca' class='btn btn-link'><img style='width:20px; height:20px' src='img/registrar.png'> <strong>Registrar</strong><span class='glyphicon glyphicon-remove'></span></button>


                                    
                          <button onclick='reFetch()' type='reset' style='color:#31bdca' class='btn btn-link'><img style='width:20px; height:20px' src='img/limpiar.png'> <strong>Limpiar</strong><span class='glyphicon glyphicon-remove'></span></button>

                          <button type='button' onclick='reFetch()' style='color:#31bdca' class='btn btn-link'><img style='width:20px; height:20px' src='img/cerrarazul.png' data-dismiss='modal'> <strong data-dismiss='modal'>Cerrar</strong><span class='glyphicon glyphicon-remove'></span></button>

                      </p>
                  </div>

                </div>
                
                <!--Fin container -->

           

        </form>
        
        </div>
        <div class='col-1'>
        </div>
     
       

       </div>