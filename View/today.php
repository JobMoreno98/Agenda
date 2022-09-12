
             
        <div style='background-color:#33bdca; color:white; text-align: center'>
            <h5  class='modal-title' id='exampleModalLabel'>Eventos del día {{sesiones.datos[0].fecha}}</h5>             
        </div> 
 
              <br>
        <table id="tablaEventos" ng-click="todayEvents(); allEvents();"  style="max-width: 100%" id="tablePreview" class="table table-sm table-borderless ">

          <!--Table body-->
          <tbody class="hvr-bubble-float-right" ng-click="detalles(dato.id, dato.idsesion)" ng-repeat="dato in sesiones.datos | orderBy:'horaIni'">
            <tr style="cursor: pointer;" class="">
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
              <td ng-if='dato.tipo === "Aplicación de examen"' style="font-size: 40px;" class="tipo-academico"></td>
	      <td ng-if='dato.tipo === "Otro"' style="font-size: 40px;" class="tipo-seminario"></td>
              <td >

                    <div ng-style='{
                                        "height": "40px",
                                        "width": "10px",
                                        "background-color": dato.color,
                                        "margin-left" : "5px",
                                        "float": "right"
                                      }'>              
                    </div>


              </td>
              <td style="width: 500px">{{dato.titulo}}  </td>
          
              
             
            </tr>
            <tr style="">
              <td></td>
              <td colspan="2" style="font-size: 12px; color:#939393; border-bottom: solid;border-width: thin; border-color:#939393 "><span class="fas fa-clock"></span> {{dato.lugar}} {{dato.horaIni}} - {{dato.horaFin}} {{dato.espacio}}</span></td>
            </tr>
            
          </tbody>
          <!--Table body-->
        </table>
        <!--Table-->
  <!--   
   </div> -->