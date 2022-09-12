<!--Eventos de hoy -->

   <div class = "col-md-12">
   	 <div style='background-color:#33bdca; color:white; text-align: center'>
                <h5  class='modal-title' id='exampleModalLabel'>Buscar Evento</h5>
                
      </div>
      <br>

     <input type="text" style='border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;' ng-model="search" ">
    <br><br>
    <h4 ng-show="search.length > 0"> Eventos Encontrados </h4>
    <hr ng-show="search.length > 0"> 
              <!--Table-->
        <div id ="eventosScroll" style="overflow-y: scroll; height: 350px" ng-show="search.length > 0">
        <table id="tablaBusqueda"  style="max-width: 100%" class="table table-sm table-borderless">

          <!--Table body-->
          <tbody ng-click="detalles(dato.id)" ng-repeat="dato in sesionesFuturas.datos | filter:search">
            <tr>
              <td ng-if='dato.tipo === "Seminario"' style="font-size: 40px;" class="tipo-seminario"></td>
              <td ng-if='dato.tipo === "Conferencia"' style="font-size: 40px;" class="tipo-conferencia"></td>
              <td ng-if='dato.tipo === "Conversatorio"' style="font-size: 40px;" class="tipo-conversatorio"></td>
              <td ng-if='dato.tipo === "Acto académico"' style="font-size: 40px;" class="tipo-academico"></td>
              <td ng-if='dato.tipo === "Acto protocolar"' style="font-size: 40px;" class="tipo-protocolar"></td>
              <td ng-if='dato.tipo === "Coloquio"' style="font-size: 40px;" class="tipo-coloquio"></td>
              <td ng-if='dato.tipo === "Videoconferencia"' style="font-size: 40px;" class="tipo-videoconf"></td>
              <td ng-if='dato.tipo === "Clase"' style="font-size: 40px;" class="tipo-clase"></td>
              <td ng-if='dato.tipo === "Actividad académica"' style="font-size: 40px;" class="tipo-clase"></td>
              <td ng-if='dato.tipo === "Diplomado"' style="font-size: 40px;" class="tipo-clase"></td>
              <td ng-if='dato.tipo === "Foro"' style="font-size: 40px;" class="tipo-clase"></td>
              <td ng-if='dato.tipo === "Otro"' style="font-size: 40px;" class="tipo-seminario ng-scope"></td>
              <td ng-if='dato.tipo === "Curso"' style="font-size: 40px;" class="tipo-seminario ng-scope"></td>
              <td ng-if='dato.tipo === "Aplicación de examen"' style="font-size: 40px;" class="tipo-seminario ng-scope"></td>
              <td ng-if='dato.tipo === "Presentación de libro"' style="font-size: 40px;" class="tipo-seminario ng-scope"></td>
              <td ng-if='dato.tipo === "Taller"' style="font-size: 40px;" class="tipo-seminario ng-scope"></td> 
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
              <td style="width: 500px">{{dato.titulo}} </td>
          
              
             
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