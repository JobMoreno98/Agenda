<?PHP             #Universidad de Guadalajara
                  #Menu e Ingreso/Consulta de datos
                  #Ultima modificacion : 27/06/2018 
                  #Por: Jose Eduardo Mendez Ortiz
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Agenda</title>
    <!-- Angular Script -->
    <script src = "https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <style>
      body {
        padding-top: 54px;
      }
      @media (min-width: 992px) {
        body {
          padding-top: 56px;
        }
      }
      .row-striped:nth-of-type(odd){
          background-color: #efefef;
          border-left: 4px #000000 solid;
        }

        .row-striped:nth-of-type(even){
          background-color: #ffffff;
          border-left: 4px #efefef solid;
        }

        .row-striped {
            padding: 15px 0;
        }
    </style>

  </head>

  <body ng-app="postApp" ng-controller="postController" data-ng-init="getEvents()">
    <?php
           session_cache_limiter("private"); # Evitar la pantalla de "Documento expirado" cuando se envía el formulario y luego se presiona "Atrás" en el navegador.

            require ("./Model/config.php");

            session_start();


            if (! isset($_SESSION["name"])) {

              header("location: ". LOGIN_INDEX ."");
            } 
            else {

                    if ($_SESSION["permission"] == 1) {

                      $role = "Rectoría";
                    }
                    else {

                      $role = $_SESSION["area"];
                    }

                  
                  echo "
                  <div>
                   <br>
                      <!--Barra de filtros-->
                   <br>
                  </div>
                  
                 ";
                 if ($_SESSION["permission"] == 1) {

          /*echo "
            <form action='".CONTROLLER."' method='POST'>

              <p><input type='submit' name='insert' value='Registrar' /></p>
              <p><input type='submit' name='add'    value='Agregar sesiones' /></p>
              <p><input type='submit' name='show'   value='Mostrar'   /></p>
              <p><input type='submit' name='search' value='Buscar'    /></p>
              <p><input type='submit' name='modify' value='Modificar' /></p>
              <p><input type='submit' name='delete' value='Eliminar'  /></p>

            </form>

            <br />

            <div>

            </div>
          ";

          /*<div>
            <form action='".MANAGE_USERS."' method='POST'>

              <div>
                <p>
                  <input type='submit' name='register_user' value='Registrar usuario' />
                </p>
              </div>

            </form>
          </div>*/
        }
        else {

          echo "
            <form action='".CONTROLLER."' method='POST'>

              <p><input type='submit' name='search' value='Buscar' /></p>

            </form>

            <p>Por ahora sólo pueden \"Buscar\".</p>
          ";

        }

      }

      ?>
    <!--Menu de Navegacion -->
    <?php include "nav.html" ?>

    <!-- Page Content -->
    <div class="container" >
      <div class="row">
        <div class="col-lg-12 text-center">

         <!--Agenda -->


              <div class="container" ng-repeat="e in eventos.show">
                  <div class="row row-striped" >
                    <div class="col-2 text-right"  >
                      <h1 class="display-4"><span class="badge badge-secondary">{{e.fecha.split('-')[2]}}</span></h1>
                      <h2 ng-if="e.fecha.split('-')[1] == '01'"> Enero</h2>
                      <h2 ng-if="e.fecha.split('-')[1] == '02'"> Febrero</h2>
                      <h2 ng-if="e.fecha.split('-')[1] == '03'"> Marzo</h2>
                      <h2 ng-if="e.fecha.split('-')[1] == '04'"> Abril</h2>
                      <h2 ng-if="e.fecha.split('-')[1] == '05'"> Mayo</h2>
                      <h2 ng-if="e.fecha.split('-')[1] == '06'"> Junio</h2>
                      <h2 ng-if="e.fecha.split('-')[1] == '07'"> Julio</h2>
                      <h2 ng-if="e.fecha.split('-')[1] == '08'"> Agosto</h2>
                      <h2 ng-if="e.fecha.split('-')[1] == '09'"> Septiembre</h2>
                      <h2 ng-if="e.fecha.split('-')[1] == '10'"> Octubre</h2>
                      <h2 ng-if="e.fecha.split('-')[1] == '11'"> Noviembre</h2>
                      <h2 ng-if="e.fecha.split('-')[1] == '12'"> Diciembre</h2>
                    </div>
                    <div class="col-8">
                      <h3 class="text-uppercase">
                      <strong>
                         
                                {{e.titulo}} 
                          
                      </strong></h3>

                      <h4> {{e.espacio}} </h4>
                      <ul class="list-inline">
                        <li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i> De: {{e.hora_inicial}} A: {{e.hora_final}}</li>
                        <li class="list-inline-item"><i class="fa fa-location-arrow" aria-hidden="true"></i>Organizador: {{e.organizador}}</li>
                        <li class="list-inline-item"><i class="fa fa-location-arrow" aria-hidden="true"></i>Responsable: {{e.responsable}}</li>
                      </ul>
                      <p><div ng-repeat="e in eventos.show">
                   
                  </div></p>
                    </div>
                    <div class="col-2">
                      <form >
                       <button onclick="sel_menu('insert')"> <span class="glyphicon glyphicon-pencil"></span></button>
                     </form>
                        <!-- ng-click="borrar(e.ID_evento)"-->
                        <button  ng-click="confirmar(e.ID_evento)"> <span class="glyphicon glyphicon-remove"></span></button>
                    </div>
                  </div>
                </div>
  
         <!--Agenda -->
            <?php if ($_SESSION["permission"] == 1) {
                    echo "
                      <div>
                            <h5>PHP/MySQL Programming by <a href=''>Edgar Orozco</a>.</h5>
                          </div>
                    ";

                  }
              ?>
          </ul>
        </div>
      </div>
    </div>
    
    <!-- Ventana Modal -->
        <div  class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
               <?php include "Controller/controller.php" ?>
               <div ng-class="class" role="alert"> 
                    {{informacion.datos.info}}
                </div>
              </div>
              <div class="modal-footer">
                {{prueba}}
                <button type="button" ng-click="getEvents()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" ng-click="getEvents()" class="btn btn-primary">Save changes</button>-->
              </div>
            </div>
          </div>
        </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!--Custom Scripts-->
    <script type="text/javascript">

    //funcion para prevenir modal cerrarse con ESC

          $(function () {
                $('.modal').modal({

                    show: <?php if(isset($_GET["insert"]))
                    { 
                     echo"true";
                    }
                    else
                    {
                      echo "false";
                    }
                    ?>,
                    keyboard: false,
                    backdrop: 'static'
                });
            });
         

    //Modulo seleccion del menu
     function sel_menu(nombre)
     {
          
        window.location.href = window.location.pathname + "?" + nombre + "=" + "1"; 
     }

    //modulo angular 

   var postApp = angular.module('postApp', []);
    postApp.controller('postController', function($sce,$scope, $http) {
      $scope.user = {};
      $scope.prueba = 2222222222;
        $scope.submitForm = function() {
        $http({
          method  : 'POST',
          url     : 'View/check.php',
          data    : $scope.user,
          //headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
         })
          .then(function successCallback(response) {
           $scope.informacion = response.data;
           changeClass($scope.informacion.datos.estatus)
           
          
          },
           function errorCallback(response) {
               // alert(response);
            }
             

          )};


               var changeClass = function(estado){
                if (estado == 1)
                {
                  $scope.class = "alert alert-success";
                  $scope.user = {};
                  $scope.eventForm.$setPristine();
                }
                if(estado == 2)
                {
                  $scope.class = "alert alert-warning";
                }
                if(estado == 3)
                {
                   $scope.class = "alert alert-danger";
                }
              };


               $scope.getEvents = function() {
                  $http({
                    method  : 'POST',
                    url     : 'View/show.php',
                    
                    //headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
                   })
                    .then(function successCallback(response) {
                     $scope.eventos = response.data;                  
                    },
                     function errorCallback(response) {
                          //alert(response);
                      }
                       

                    )};

                $scope.borrar = function(borrando) {
                  var Indata = {id: borrando};
                 

                        $http({
                          method  : 'POST',
                          url     : 'View/borrar.php',
                          data   : Indata
                          //headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
                         })
                          .then(function successCallback(response) {
                               $scope.answer = response.data;
                               $scope.getEvents();
                                            
                          },
                           function errorCallback(response) {
                                //alert(response);
                            }
                       

                    )};

                    $scope.confirmar = function(dato_conf)
                    {
                        var r = confirm("¿Realmente desea borrar este elemento?");
                          if (r == true)
                          {
                            $scope.borrar(dato_conf);
                          } 
                         
                    };
                    $scope.trustAsHtml = function(html) {
                        return $sce.trustAsHtml(html);
                      };

    });//
   
    </script>

  </body>

</html>
