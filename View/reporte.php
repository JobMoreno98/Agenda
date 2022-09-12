<!--Eventos de hoy -->

   <div class = "col-md-12">
   	 <div style='background-color:#33bdca; color:white; text-align: center'>
                <h5  class='modal-title' id='exampleModalLabel'>Reportes de Eventos</h5>
                
              </div>
     <br>
     <div class="row">
      <div class="col-6">
          <h6>Fecha Inicial</h6> <input type="date" style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;'  ng-model="fechaInicial" ng-change="getFiltro(todasSesiones.datos, fechaInicial)">
      </div>
      <div class="col-6">
       <h6>Fecha Final</h6>
       <input type="date" style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;'  ng-change="getFiltro(todasSesiones.datos, fechaFinal)" ng-model="fechaFinal" >
      </div>

    </div>
    <br>
     <?php
     echo '<pre>';
#var_dump($_SESSION);
echo '</pre>';
     require_once ("../Model/config.php");
     $operation = new Operation();
     if(isset($_SESSION["university_center"]))
     {
         $array_records_spaces = $operation->retrieve_from_table("espacio", SPACES, NULL, "La Normal", NULL,NULL,NULL,NULL,NULL);
         $array_records_spaces_belenes = $operation->retrieve_from_table("espacio", SPACES, NULL, "Belenes", NULL,NULL,NULL,NULL,NULL);
         $array_records_tipos = $operation->retrieve_from_table("tipo","tipos_evento",NULL, NULL, NULL,NULL,NULL,NULL,NULL);
         $array_records_dependencias = $operation->retrieve_from_table("dependencia","dependencias",NULL, NULL, NULL,NULL,NULL,NULL,NULL);
     }
     else
     {
        $array_records_spaces = $operation->retrieve_from_table("espacio", SPACES, NULL,"La Normal", NULL,NULL,NULL,NULL,NULL); 
     }

     echo "
     <div class='row'>
      <div class='col-6'>
       <h6>Espacio</h6>
       
        <select ng-init='verifica_espacios(session.cur)' ng-show='valor_espacio == 1' style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;' ng-model='filtro.espacio' id='id_tipo' name='tipo' ng-change='getFiltro(todasSesiones.datos, fechaInicial)' >
                                          <option name='todos' selected='selected'  value='todos'>Todos</option>
                                    ";
                                  foreach ($array_records_spaces as $record) {

                                              $espacio = $record->espacio;

                                              echo "<option value='$espacio' name='$espacio'>$espacio</option>";
                                          }

                                   echo "</select>";

        
         echo"<select  ng-init='verifica_espacios(session.cur)' ng-show='valor_espacio == 2' style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;' ng-model='filtro.espacio' id='id_tipo' name='tipo' ng-change='getFiltro(todasSesiones.datos, fechaInicial)' >
                                          <option name='todos' selected='selected'  value='todos'>Todos</option>
                                    ";
                                  foreach ($array_records_spaces_belenes as $record) {

                                              $espacio = $record->espacio;

                                              echo "<option value='$espacio' name='$espacio'>$espacio</option>";
                                          }

        echo "</select> ";
        

       echo "<select  ng-init='verifica_espacios(session.cur)' ng-show='valor_espacio == 3' style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;' ng-model='filtro.espacio' id='id_tipo' name='tipo' ng-change='getFiltro(todasSesiones.datos, fechaInicial)' >
                                          <option name='todos' selected='selected'  value='todos'>Todos</option>

                                           <option value='FBA' selected='selected'> FBA </option>
                                                <option value='FBB'> FBB </option>
                                                <option value='FBC'> FBC </option>
                                                <option value='FBD'> FBD </option>
                                    ";
                                 

        echo "</select> </div>

      ";


      echo"
      
        <div class='col-6'>
          <h6>Tipo</h6>
          <select style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;' ng-model='filtro.tipo' id='id_tipo' name='tipo' ng-change='getFiltro(todasSesiones.datos, fechaInicial)' >
                                            <option name='todos' selected='selected'  value='todos'>Todos</option>
                                      ";
                                    foreach ($array_records_tipos as $record) {

                                                $espacio = $record->tipo;

                                                echo "<option value='$espacio' name='$espacio'>$espacio</option>";
                                            }

                                     echo "</select>
        </div>
      </div>";

      echo"
     <br>
          <h6>Dependencia</h6>

          <select style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;' ng-model='filtro.depen' id='id_tipo' name='tipo' ng-change='getFiltro(todasSesiones.datos, fechaInicial)' >
                                            <option name='todos' selected='selected'  value='todos'>Todos</option>
                                      ";
                                    foreach ($array_records_dependencias as $record) {

                                                $espacio = $record->dependencia;

                                                echo "<option value='$espacio' name='$espacio'>$espacio</option>";
                                            }

                                     echo "</select>";

     ?>
     
    <br><br>
   
              <!--Table-->
        <button id="reporte" ng-click="exportToPdf(filtroEventos.datos)" ng-hide="filtroEventos.length<=0 || search.length == 0 || search.$pristine" style="width: 100%">Generar Reporte</button>
        <hr>
          
        
        <div id ="" style="overflow-y: scroll; height: 350px" > 
        <table id="tablaBusqueda"  style="max-width: 100%" class="table table-sm table-borderless">

          <!--Table body-->

          <tbody ng-click="detalles(dato.id)" ng-repeat="dato in filtroEventos.datos | filter: fechaInicial : fechaFinal | orderBy: 'fecha'">
            <tr>
              <td ng-if='dato.tipo === "Seminario"' style="font-size: 40px;" class="tipo-seminario"></td>
              <td ng-if='dato.tipo === "Conferencia"' style="font-size: 40px;" class="tipo-conferencia"></td>
              <td ng-if='dato.tipo === "Conversatorio"' style="font-size: 40px;" class="tipo-conversatorio"></td>
              <td ng-if='dato.tipo === "Acto académico"' style="font-size: 40px;" class="tipo-academico"></td>
              <td ng-if='dato.tipo === "Acto protocolar"' style="font-size: 40px;" class="tipo-protocolar"></td>
              <td ng-if='dato.tipo === "Coloquio"' style="font-size: 40px;" class="tipo-coloquio"></td>
              <td ng-if='dato.tipo === "Videoconferencia"' style="font-size: 40px;" class="tipo-videoconf"></td>
              <td ng-if='dato.tipo === "Clase"' style="font-size: 40px;" class="tipo-clase"></td>
              <td ng-if='dato.tipo === "Diplomado"' style="font-size: 40px;" class="tipo-clase"></td>
              <td ng-if='dato.tipo === "Actividad académica"' style="font-size: 40px;" class="tipo-clase"></td>
              <td ng-if='dato.tipo === "Taller"' style="font-size: 40px;" class="tipo-clase"></td>
              <td ng-if='dato.tipo === "Presentación de libro"' style="font-size: 40px;" class="tipo-seminario"></td>
              <td ng-if='dato.tipo === "Curso"' style="font-size: 40px;" class="tipo-seminario"></td>
              <td ng-if='dato.tipo === "Foro"' style="font-size: 40px;" class="tipo-conversatorio"></td>
              <td >
                    <div ng-if='dato.color === "#535c5c"' class="cuadradoGrisOscuro" style="float: right;"></div>
                    <div ng-if='dato.color === "#e5a04c"' class="cuadradoNaranja" style="float: right;"></div>
                    <div ng-if='dato.color === "#2a3a42"' class="cuadradoAzulMarino" style="float: right;"></div>
                    <div ng-if='dato.color === "#c0c075"' class="cuadradoAmaPalido" style="float: right;"></div> 
                    <div ng-if='dato.color === "#74b2a2"' class="cuadradoVerdeAgua" style="float: right;"></div>           
                    <div ng-if='dato.color === "#225999"' class="cuadradoAzul" style="float: right;"></div>
                    <div ng-if='dato.color === "#9bb2bc"' class="cuadradoGrisClaro" style="float: right;"></div>
                    <div ng-if='dato.color == "#8159a4"' class="cuadradoMorado" style="float: right;"></div>
                    <div ng-if='dato.color == "#ef5624"' class="cuadradoNallende" style="float: right;"></div>  
              </td>
              <td style="width: 500px">{{dato.titulo}}</td>
          
              
             
            </tr>
            <tr style="">
              <td></td>
              <td colspan="2" style="font-size: 12px; color:#939393; border-bottom: solid;border-width: thin; border-color:#939393 "><span class="fas fa-clock"></span> {{dato.fecha}} {{dato.horaIni}} - {{dato.horaFin}} {{dato.espacio}}</span></td>
            </tr>
            
          </tbody>
          <!--Table body-->
          
        </table>
        
      </div>
        

        <!--Table-->
     
   </div>
   <!--Eventos -->