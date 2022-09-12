
<?php
        require_once ("../Model/config.php");

        $operation = new Operation();
        $hours_N = "option value=''> -- </option>
                                               
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
                                                <option value='21'> 21  </option>";
        $hours_B=" <option value=''> -- </option>
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
        #$array_records_types = $operation->retrieve_from_table("tipo", EVENT_TYPES,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
        $array_records_dependencies = $operation->retrieve_from_table("dependencia", DEPENDENCIES, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
        #$array_records_spaces = $operation->retrieve_from_table("espacio", SPACES, NULL, $_SESSION["university_center"], NULL,NULL,NULL,NULL,NULL);
        date_default_timezone_set("America/Mexico_City");
        
        /*if (count($array_records_types) <= 0) 
        {

            echo "
                  <div>
                      Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 8973.
                  </div>
                 ";
            
        }*/
        if (count($array_records_dependencies) <= 0) 
        {

          echo "
                  <div>
                      Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 337363.
                  </div>
               ";

        }
        /*else if (count($array_records_spaces) <= 0) 
        {

            echo "
                <div>
                    Se prudujo un error. Póngase en contacto con el responsable de la aplicación y proporcione el siguiente código: 77223.
                </div>
            ";

           
        }*/

    ?>
      <div style='background-color:#33bdca; color:white; text-align: center'>
        <h5  class='modal-title' id='exampleModalLabel'>REGISTRO DE CLASES BELENES</h5>       
      </div>
      <div class='row' style='overflow-y: scroll; height:600px'>

      <div class='col-1'></div>
      <div class='col-10'>
        
        <form name='eventClases'  ng-submit='submitClases()' style='border-left:5px solid;border-right:5px solid; border-color:#a4a4a4;padding-left:4%;  padding-right:4%;'>

            <p>
              <input name='insert' style="visibility: hidden;" readonly />
            </p>

            <div class='container'>

                  <div class = 'row'>
                    <!-- Columna TÍTULO -->
                    <div class='col-sm-12'>
                            <label for='id_titulo' style='color:#283b41'><strong>NOMBRE DE LA CLASE</strong></label><br>
                            <input style='border-style: solid;border-color: #a4a4a4; width:100%' type='text' id='id_nombre' name='titulo' ng-model='user.nombre' required autofocus minlength='' maxlength='' />
                    </div>
                    <!--Fin columna Titutlo -->

                  </div>
                  <!--Fin primera fila-->

                  <div class='row'>
                    <!--Columna Tipo -->
                    <div class='col-sm-12'>
                      <br>
                             
                               <label for='id_nrc' style='color:#283b41'><strong>NRC</strong></label><br>
                               <input type='text' id='id_nrc' name='nrc' required minlength='' ng-model='user.nrc' style='border-style: solid;border-color: #a4a4a4; width:100%' maxlength='' />
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
                          <label for='id_profesor' style='color:#283b41'><strong>PROFESOR</strong></label><br>
                          <input type='text' id='id_profesor' name='profesor' required minlength='' ng-model='user.profesor' style='border-style: solid;border-color: #a4a4a4; width:100%' maxlength='' />
                    </div>
                    <!--Fin columna Organizador -->
                   <hr>
                  </div>
                  <br>
                   <div class = 'row' >
                  <div class='col-sm-12' style='border:1px solid; padding:15px; border-color:#405765'>
                  <div class='row'>
                  <div class='col-5'>
                    <label style='color:#283b41; text-align:center'><span class='ab-calendario'></span><strong>PERIODO</strong></label>
                    <br>
                  </div>
                  <div class='col-7'>
                          <button type='button' data-toggle='modal' data-target='#dateModal'>
                                Agregar Fechas
                          </button>
                          <!--<br><br><label><input ng-model='myCheckbox' ng-change='autoFill(myCheckbox)' type='checkbox' id='cbox1' value='first_checkbox'> Autocompletar</label><br> -->         
                  </div>
                  </div>
                  <hr>
                  <div class = 'row' >
                  <div class='col-sm-12' >
                    <div class='row' ng-show='false'>
                         <div class='col-4'>
                            <label for='id_espacio' style=' float:left; color:#283b41'><span class='ab-lugar'></span><strong>Aula</strong>
                            </label>
                            <br>
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
                    <div class="row" ng-show="user.fecha.length == 2">
                    <div class="col-sm-12">
                      <label for='id_profesor' style='color:#283b41'><strong>HORARIO</strong></label><br>
                      
                      
                      
                      
                      
                      
                      <div class="row">
                            <div class="col-md-4">
                               <input type="checkbox" name="lunes" value="lunes" ng-model="user.weekDay[1]">Lunes<br>
                            </div>
                            <div class="col-xs-12 col-md-4">
                              <input type="checkbox" name="Martes" ng-model="user.weekDay[2]" value="martes">Martes<br>
                            </div>
                            <div class="col-md-4">
                              <input type="checkbox" name="Miercoles" ng-model="user.weekDay[3]" value="miertcoles">Miercoles<br>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                             <input type="checkbox" name="Jueves" ng-model="user.weekDay[4]" value="jueves" >Jueves<br>
                            </div>
                            <div class="col-xs-12 col-md-4">
                              <input type="checkbox" name="Viernes" ng-model="user.weekDay[5]" value="viernes">Viernes<br>
                            </div>
                            <div class="col-md-4">
                              <input type="checkbox" name="Sabado" ng-model="user.weekDay[6]" value="sabado">Sabado<br>
                            </div>
                          </div>
                    </div>
                  </div>

                         <div class="row" ng-show="user.weekDay[1]">
                    <div class="col-sm-12">
                      <div style="border-bottom:1px solid; padding:15px; border-color:#405765" >
                        <label style='color:#283b41'><strong>LUNES</strong></label><br><br>
                        <div class='row'>

                          <div class='col-6'>
                              <label for='id_hora_inicial' style='color:#283b41'><span class='ab-reloj'></span><strong>HORA INICIO</strong></label><br>
                          </div>

                          <div class='col-6'>
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' id='hora_inicial'  ng-model='user.hora_inicial_hora[0]' >
                                        <?php
                                             if ($_SESSION["university_center"] == "La Normal")
                                        {
                                         echo $hours_N;
                                            
                                        }
                                        else   
                                          { 
                                            echo $hours_B;
                                          }
                                      ?>
                                     
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_inicial_min[0]'   id='hora_inicial_min'>
                                          <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>
                          </div>
                      </div>

                      <div class='row'>
                            <div class='col-7'>
                                   <label for='id_hora_final' style=' color:#283b41; margin-left:20px'><strong>HORA TERMINO</strong></label>
                            </div>
                            <div class='col-5' style='margin-left: -28px;'>
                                     <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px; margin-left:-2px'  ng-model='user.hora_final_hora[0]' >";
                            
                                      <?PHP
                                            
                                        if ($_SESSION["university_center"] == "La Normal")
                                        {
                                          echo $hours_N;
                                        }
                                        else   
                                        { 
                                          echo $hours_B;
                                        }
                                                                              
                                      ?>
                                      echo"
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_final_min[0]'>
                                         <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>                                  
                              </div>
                              
                      </div>
                      </div>
                    </div>
                  </div>

                  <div class="row" ng-show="user.weekDay[2]">
                    <div class="col-sm-12">
                      <div style="border-bottom:1px solid; padding:15px; border-color:#405765">
                        <label style='color:#283b41'><strong>MARTES</strong></label><br><br>
                        <div class='row'>

                          <div class='col-6'>
                              <label for='id_hora_inicial' style='color:#283b41'><span class='ab-reloj'></span><strong>HORA INICIO</strong></label><br>
                          </div>

                          <div class='col-6'>
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' id='hora_inicial'  ng-model='user.hora_inicial_hora[1]' >
                                        <?php
                                             if ($_SESSION["university_center"] == "La Normal")
                                        {
                                         echo $hours_N;
                                            
                                        }
                                        else   
                                          { 
                                             echo $hours_B;
                                          }
                                      ?>
                                     
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_inicial_min[1]' id='hora_inicial_min'>
                                          <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>
                          </div>
                      </div>

                      <div class='row'>
                            <div class='col-7'>
                                   <label for='id_hora_final' style=' color:#283b41; margin-left:20px'><strong>HORA TERMINO</strong></label>
                            </div>
                            <div class='col-5' style='margin-left: -28px;'>
                                     <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px; margin-left:-2px'  ng-model='user.hora_final_hora[1]' >";
                            
                                      <?PHP
                                            
                                        if ($_SESSION["university_center"] == "La Normal")
                                        {
                                           echo $hours_N;
                                        }
                                        else   
                                        { 
                                           echo $hours_B;
                                        }
                                                                              
                                      ?>
                                      echo"
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_final_min[1]' >
                                         <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>                                  
                              </div>
                              
                      </div>
                      </div>
                    </div>
                  </div>
                  <!--Fin cuarta fila -->

                  <div class="row" ng-show="user.weekDay[3]">
                    <div class="col-sm-12">
                      <div style="border-bottom:1px solid; padding:15px; border-color:#405765" >
                        <label style='color:#283b41'><strong>MIERCOLES</strong></label><br><br>
                        <div class='row'>

                          <div class='col-6'>
                              <label for='id_hora_inicial' style='color:#283b41'><span class='ab-reloj'></span><strong>HORA INICIO</strong></label><br>
                          </div>

                          <div class='col-6'>
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' id='hora_inicial'  ng-model='user.hora_inicial_hora[2]' >
                                        <?php
                                        if ($_SESSION["university_center"] == "La Normal")
                                        {
                                         echo $hours_N;    
                                        }
                                        else   
                                        { 
                                          echo $hours_B;
                                        }
                                      ?>
                                     
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_inicial_min[2]' id='hora_inicial_min'>
                                          <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>
                          </div>
                      </div>

                      <div class='row'>
                            <div class='col-7'>
                                   <label for='id_hora_final' style=' color:#283b41; margin-left:20px'><strong>HORA TERMINO</strong></label>
                            </div>
                            <div class='col-5' style='margin-left: -28px;'>
                                     <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px; margin-left:-2px'  ng-model='user.hora_final_hora[2]'>";
                            
                                      <?PHP
                                            
                                        if ($_SESSION["university_center"] == "La Normal")
                                        {
                                           echo $hours_N;
                                        }
                                        else   
                                        { 
                                           echo $hours_B;
                                        }
                                                                              
                                      ?>
                                      echo"
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_final_min[2]' >
                                         <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>                                  
                              </div>
                              
                      </div>
                      </div>
                    </div>
                  </div>

                  <div class="row" ng-show="user.weekDay[4]">
                    <div class="col-sm-12">
                      <div style="border-bottom:1px solid; padding:15px; border-color:#405765" >
                        <label style='color:#283b41'><strong>JUEVES</strong></label><br><br>
                        <div class='row'>

                          <div class='col-6'>
                              <label for='id_hora_inicial' style='color:#283b41'><span class='ab-reloj'></span><strong>HORA INICIO</strong></label><br>
                          </div>

                          <div class='col-6'>
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' id='hora_inicial'  ng-model='user.hora_inicial_hora[3]' >
                                        <?php
                                        if ($_SESSION["university_center"] == "La Normal")
                                        {
                                         echo $hours_N;    
                                        }
                                        else   
                                        { 
                                          echo $hours_B;
                                        }
                                      ?>
                                     
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_inicial_min[3]'   id='hora_inicial_min'>
                                          <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>
                          </div>
                      </div>

                      <div class='row'>
                            <div class='col-7'>
                                   <label for='id_hora_final' style=' color:#283b41; margin-left:20px'><strong>HORA TERMINO</strong></label>
                            </div>
                            <div class='col-5' style='margin-left: -28px;'>
                                     <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px; margin-left:-2px'  ng-model='user.hora_final_hora[3]' >";
                            
                                      <?PHP
                                            
                                        if ($_SESSION["university_center"] == "La Normal")
                                        {
                                           echo $hours_N;
                                        }
                                        else   
                                        { 
                                           echo $hours_B;
                                        }
                                                                              
                                      ?>
                                      echo"
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_final_min[3]' >
                                         <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>                                  
                              </div>
                              
                      </div>
                      </div>
                    </div>
                  </div>

                  <div class="row" ng-show="user.weekDay[5]">
                    <div class="col-sm-12">
                      <div style="border-bottom:1px solid; padding:15px; border-color:#405765" >
                        <label style='color:#283b41'><strong>VIERNES</strong></label><br><br>
                        <div class='row'>

                          <div class='col-6'>
                              <label for='id_hora_inicial' style='color:#283b41'><span class='ab-reloj'></span><strong>HORA INICIO</strong></label><br>
                          </div>

                          <div class='col-6'>
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' id='hora_inicial'  ng-model='user.hora_inicial_hora[4]' >
                                        <?php
                                        if ($_SESSION["university_center"] == "La Normal")
                                        {
                                         echo $hours_N;    
                                        }
                                        else   
                                        { 
                                          echo $hours_B;
                                        }
                                      ?>
                                     
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_inicial_min[4]'  id='hora_inicial_min'>
                                         <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>
                          </div>
                      </div>

                      <div class='row'>
                            <div class='col-7'>
                                   <label for='id_hora_final' style=' color:#283b41; margin-left:20px'><strong>HORA TERMINO</strong></label>
                            </div>
                            <div class='col-5' style='margin-left: -28px;'>
                                     <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px; margin-left:-2px'  ng-model='user.hora_final_hora[4]' >";
                            
                                      <?PHP
                                            
                                        if ($_SESSION["university_center"] == "La Normal")
                                        {
                                           echo $hours_N;
                                        }
                                        else   
                                        { 
                                           echo $hours_B;
                                        }
                                                                              
                                      ?>
                                      echo"
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_final_min[4]' >
                                         <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>                                  
                              </div>
                              
                      </div>
                      </div>
                    </div>
                  </div>
                  <!--Fin cuarta fila -->
                  <div class="row" ng-show="user.weekDay[6]">
                    <div class="col-sm-12">
                      <div style="border-bottom:1px solid; padding:15px; border-color:#405765" >
                        <label style='color:#283b41'><strong>SABADO</strong></label><br><br>
                        <div class='row'>

                          <div class='col-6'>
                              <label for='id_hora_inicial' style='color:#283b41'><span class='ab-reloj'></span><strong>HORA INICIO</strong></label><br>
                          </div>

                          <div class='col-6'>
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' id='hora_inicial'  ng-model='user.hora_inicial_hora[5]' >
                                        <?php
                                        if ($_SESSION["university_center"] == "La Normal")
                                        {
                                         echo $hours_N;    
                                        }
                                        else   
                                        { 
                                          echo $hours_B;
                                        }
                                      ?>
                                     
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_inicial_min[5]'  id='hora_inicial_min'>
                                          <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>
                          </div>
                      </div>

                      <div class='row'>
                            <div class='col-7'>
                                   <label for='id_hora_final' style=' color:#283b41; margin-left:20px'><strong>HORA TERMINO</strong></label>
                            </div>
                            <div class='col-5' style='margin-left: -28px;'>
                                     <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px; margin-left:-2px'  ng-model='user.hora_final_hora[5]' >";
                            
                                      <?PHP
                                            
                                        if ($_SESSION["university_center"] == "La Normal")
                                        {
                                           echo $hours_N;
                                        }
                                        else   
                                        { 
                                           echo $hours_B;
                                        }
                                                                              
                                      ?>
                                      echo"
                                      </select>:
                                      <select style='border-color: #a4a4a4; border-style:solid; border-width: 2px;' ng-model='user.hora_final_min[5]'>
                                         <option value= ''>--</option>
                                          <option value= '00'>00</option>
                                          <option value= '30'>30</option>
                                      </select>                                  
                              </div>
                              
                      </div>
                      </div>
                    </div>
                  </div>
                  <!--Fin cuarta fila -->

                    </div>
                  </div>
                  <!--Informacion sobre la insercion en la tabla-->
                  <br>
                  <br>
                  
                  <hr> 

                 
                  <br>

                  
                  <div ng-class='class' id='alertas' role='alert'> 
                    {{informacion.datos.info}}
                  </div>
                  <div>
                      <p>
                          <button type='submit' ng-disabled="loading" style='color:#31bdca' class='btn btn-link'><img style='width:20px; height:20px' src='img/registrar.png'> <strong>Registrar</strong><span class='glyphicon glyphicon-remove'></span></button><span ng-show="loading" class="fas fa-circle-notch fa-spin"></span>


                                    
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