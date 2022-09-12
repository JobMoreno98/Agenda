<?PHP
session_start();
             
?>
              <div class='modal-body' style='background-color:#efefef'>
             
               
                    <div class='container'>

                    <div class='row row-striped'>
                      <div class='col-md-4 col-xs-12 text-left'>
                        <div class='display-4'><span style='background-color:{{datosMostrar.color}}' class='badge badge-secondary'>{{datosMostrar.fecha | date: 'dd' }}<br>{{datosMostrar.fecha | date: 'MMM' }}</span></div>
                      </div>
                      <div class='col-md-8 col-xs-12'>
                          <h5 class='text-uppercase'><strong>{{datosMostrar.titulo}}</strong></h5>
                          <ul class='list-inline'>

                            <li class='list-inline-item'  style='color:#61717d'>
                              <i class='ab-calendario' aria-hidden='true'></i>
                              {{datosMostrar.fecha | date: 'EEEE' }}

                            </li>
                            
                            <li class='list-inline-item' style='color:#61717d'>
                              <i class='ab-reloj' aria-hidden='true'></i> 
                              {{datosMostrar.hora_inicial}} - {{datosMostrar.hora_final}}
                            </li>
                            <li class='list-inline-item' style='color:#61717d'>
                              <i class='ab-lugar'  aria-hidden='true'></i> 
                              {{datosMostrar.espacio}}
                               <span ng-hide='conAula' class='ng-hide'>{{datosMostrar.aula}}</span>
                            </li>
                      </div>
                      <div class='col-12' style='margin-top:10px'>
                           
                          </ul>
                           <p>
                              <strong>ID</strong> <br> <span style='color:#61717d; font-size:13px'>{{datosMostrar.ID}}</span> <br>
                          </p>
                          <hr/
                          <p>
                              <strong ng-show="datosMostrar.vista == 1">PROFESOR</strong>
                              <strong ng-show="datosMostrar.vista == 0">ORGANIZADOR</strong> <br> <span style='color:#61717d; font-size:13px'>{{datosMostrar.organizador}}</span> <br>
                          </p>
                          <hr ng-show="datosMostrar.vista == 1">
                          <p>

                            <span>
                                    <strong ng-show="datosMostrar.vista == 0">TELÉFONO</strong><br>
                                    <strong ng-show="datosMostrar.vista == 1">NRC</strong><br>
                            <span style='color:#61717d; font-size:13px'>{{datosMostrar.tel_organizador}}</span></span>

                          </p>
                          <hr/ ng-show="datosMostrar.vista == 0">
                          <p>

                          <strong ng-show="datosMostrar.vista == 0">TIPO DE EVENTO</strong> <br><span ng-show="datosMostrar.vista == 0" style='color:#61717d; font-size:13px'>{{datosMostrar.tipo}}</span> <br>
                          </p>
                          
                          <p>
                            <strong ng-show="datosMostrar.vista == 0">DEPENDENCIA</strong><br><span style='color:#61717d; font-size:13px'>{{datosMostrar.dependencia}}</span>
                          </p>

                          </p>
                          <hr/ ng-show="datosMostrar.vista == 0">
                          <p>
                            <strong ng-show="datosMostrar.vista == 0">NOTAS CTA</strong> <br><span style='color:#61717d; font-size:13px'> {{datosMostrar.notas_cta}}</span> 
                          </p>
                          <hr/ ng-show="datosMostrar.vista == 0">
                          <p>
                            <strong ng-show="datosMostrar.vista == 0">NOTAS SERVICIOS GENERALES</strong><br><span style='color:#61717d; font-size:13px'> {{datosMostrar.notas_sg}}</span> 
                          </p>
                          <hr/>
                           <p>
                            <strong>REGISTRADO POR</strong><br><span style='color:#61717d; font-size:13px'>{{datosMostrar.registrado}}</span>
                          </p>
                      </div>
                    </div>
                   
                  </div>
                  
                   <div ng-class='class' id='alertas' role='alert'> 

                    {{informacion.datos.info}}

                   </div>
              </div>
        
          <td><input type="hidden" ng-init="sesion='<?php echo $_SESSION['university_center']; ?>'"></td>
          <div class='text-center' ng-show='verifica_centro(datosMostrar.cu)'>
            <?PHP if(isset($_SESSION["name"]))
                {

                  if($_SESSION["permission"] == 1 or  $_SESSION["permission"] == 0)
                    {
                      echo"
                           <button ng-show='datosMostrar.vista == 0' type='button' style='color:#31bdca' class='btn btn-link' ng-click='getModificar(); verifica_centro(datosMostrar.cu)'><img style='width:20px; height:20px' src='img/editar.png'> <strong>Editar</strong></button>

                           <button ng-show='datosMostrar.vista == 1' type='button' style='color:#31bdca' class='btn btn-link' ng-click='getModificar_clases(); verifica_centro(datosMostrar.cu)'><img style='width:20px; height:20px' src='img/editar.png'> <strong>Editar</strong></button>

                           <button type='button' ng-show='datosMostrar.vista == 0' ng-click='confirmar(datosMostrar.idsesion)' style='color:#31bdca' class='btn btn-link'><img style='width:20px; height:20px' src='img/cancelar.png'> <strong>Cancelar</strong><span class='glyphicon glyphicon-remove'></span></button>

                            <button type='button' ng-show='datosMostrar.vista == 1' ng-click='confirmar(datosMostrar.id)' style='color:#31bdca' class='btn btn-link'><img style='width:20px; height:20px' src='img/cancelar.png'> <strong>Cancelar</strong><span class='glyphicon glyphicon-remove'></span></button>

                           <button type='button' ng-click='reFetch(); limpiar();' style='color:#31bdca' class='btn btn-link'><img style='width:20px; height:20px' src='img/cerrarazul.png' data-dismiss='modal'> <strong data-dismiss='modal'>Cerrar</strong><span class='glyphicon glyphicon-remove'></span></button>
                          ";
                    }
                  }
              ?>
              
            </div>
            
         <script type="text/javascript">
           var sesion = $_SESSION['university_center'];
         </script>


