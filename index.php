<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<!--Jquery -->
<script src='js/jquery.min.js'></script>
<!-- FullCalendar librerias -->
<link href='lib/fullcalendar.min.css' rel='stylesheet' />
<link href='lib/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='lib/moment.min.js'></script>
<script src='lib/fullcalendar.min.js'></script>
<script src="locale/es.js"></script>
<link rel="stylesheet" href="css/estilos.css">

<!--Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<!-- Bootstrap -->
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

<!-- Angular Script -->
<script src = "https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-i18n/1.4.6/angular-locale_es-es.js"></script>



<link rel="stylesheet" type="text/css" href="css/tipo_actividad.css">
<link rel="stylesheet" type="text/css" href="css/colores_auditorios.css">
<link rel="stylesheet" type="text/css" href="css/general.css">

 <?php
            require ("./Model/config.php");

            session_start();

            if (! isset($_SESSION["name"])) 
            {

              echo "
                  <div>
                   <br>
                      <!--Barra de filtros-->
                   <br>
                  </div>
                  
                 ";
            } 
            else 
            {

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
            }

?>
 <!--Menu de Navegacion -->

<?php include "nav.php" ?>
</head>
<body ng-app="postApp" ng-controller="postController" id="postController">

  
    <input type="hidden" ng-init="session.cur='<?php if(isset($_SESSION['university_center']))
    {
      if($_SESSION['university_center'] == "Ambas")
      {
        echo "La Normal";
      }
      else
      {
        echo $_SESSION['university_center'];
      }
    } 
    else
    {
      echo "La Normal";
    }
    ?>'" ng-init="session.cura='<?php if(isset($_SESSION['university_center']))
    {
        echo $_SESSION['university_center'];
    } 
    else
    {
      echo "La Normal";
    } ?>'">
    <input type="hidden" ng-init="centro_actual='<?php if(isset($_SESSION['university_center']))
    {
      echo $_SESSION['university_center'];
    } 
    else
    {
      echo "La Normal";
    }
    ?>'">
    
   
<!--Eventos -->
<div class = "col-xs-12 col-md-6" id='calendar'></div>
<div class=" col-md-1">
   </div>
    <!-- Modal -->
    <div  class="modal fade" id="seccionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-header" style="padding: 1rem;">
            
            <button type="button" ng-click="clearBody(); limpiar();" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="ab-close-black"></span>
            </button>
          </div>
         
          <div class="modal-body" id="modal-body" dynamic="formReg">
            
          </div>
           <div ng-class='class' id='alertas' ng-show="informacion.datos.estatus == 1" role='alert'> 
                    {{informacion.datos.info}}
          </div>
         
        </div>
      </div>
    </div>



     <!-- Modal -->
    <div  class="modal fade" id="dateModal" tabindex="-1" role="dialog" aria-labelledby="dateModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-header" style="padding: 1rem;">
            
            <button type="button" ng-click="numeroFechas(user.fecha.length,$('#centro_uni').val())" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="ab-close-black"></span>
            </button>
          </div>
          <!-- -->
          <div class="modal-body">
              <div>
                    <multiple-date-picker disable-days-before="todayPicker"  ng-model='user.fecha' day-click="oneDaySelectionOnly"></multiple-date-picker>
              </div>
          </div>
          <div class="modal-footer">
           
           <button ng-click="popToArray(); numeroFechas(user.fecha.length);" type="button"  class="close" data-dismiss="modal" aria-label="Close" class="btn btn-primary">Listo</button>
            
          </div>
        </div>
      </div>
    </div>
<!--Modal code -->


<script>
 var currentDate= <?php  date_default_timezone_set("America/Mexico_City"); echo '"'.date("Y-m-d H:i:s").'"' ?>;
  var d = new Date();
          $(function () 
          {
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
 
</script>
<script type="text/javascript">
  
$(document).ready(function() {

    
    $('#reporte').click(function()
    {
      console.log("reporte");
      var json = [];
      $('#tablaBusqueda').find('tbody tr').each(function(){
          var obj = {},
              $td = $(this).find('td'),
              key = $td.eq(0).text(),
              val = parseInt( $td.eq(2).text(), 10 );
          obj[key] = val;
          json.push(obj);
          console.log(json);

          });
    });
    $('#hoyVista').click(function() 
    {
         $('#seccionModal').modal('show');
         angular.element('#postController').scope().getToday();
         var fecha = new Date();
         fecha.setDate(fecha.getDate()-1);
         angular.element('#postController').scope().todayEvents(fecha);
    });

    $('#mesVista').click(function() 
    {
         $('#calendar').fullCalendar('changeView', 'month');
    });
    $('#semanaVista').click(function() 
    {
         $('#calendar').fullCalendar('changeView', 'agendaWeek');
    });
    $('#agendaVista').click(function() 
    {
         $('#calendar').fullCalendar('changeView', 'listWeek');
    });

    $('#tipoH').click(function() 
    {
         angular.element("#postController").scope().tipoAgenda = $('#centro_uni').val();
         angular.element("#postController").scope().clasEvent($('#centro_uni').val());    
    });
    $("#buscar").click(function()
    {
                $('#seccionModal').modal('show');
                angular.element('#postController').scope().futureEvents();
                angular.element('#postController').scope().getSearch();
                
    });    
    $("#reportes").click(function()
    {
                $('#seccionModal').modal('show');
                angular.element('#postController').scope().allEvents();
                angular.element('#postController').scope().getReporte();
               
    });    

//responsive
  $('#permisoRes').click(function() 
    {
         angular.element("#postController").scope().getRegCont();
      });
    
    $("#buscarRes").click(function()
    {
                $('#seccionModal').modal('show');
                angular.element('#postController').scope().getSearch();
    });    
    $("#reporteRes").click(function()
    {
                $('#seccionModal').modal('show');
                angular.element('#postController').scope().getReporte();
    });    
    
     $("#lupa").click(function()
    {
                $('#seccionModal').modal('show');
                angular.element('#postController').scope().getSearch();
    });    

    $('#hoyVista1').click(function() 
    {
         $('#calendar').fullCalendar('changeView', 'agendaDay');
      });

    $('#mesVista1').click(function() 
    {
         $('#calendar').fullCalendar('changeView', 'month');
      });
    $('#semanaVista1').click(function() 
    {
         $('#calendar').fullCalendar('changeView', 'agendaWeek');
      });
    $('#agendaVista1').click(function() 
    {
         $('#calendar').fullCalendar('changeView', 'listWeek');
      });

    var reFetch = function()
     {
      //$("#calendar").fullCalendar( 'refetchEvents' );

     };
    /*setInterval(function () 
    {
       //reFetch();

    },1000);*/
     var limpio = function()
     {
      $('#postController').scope().user ={};
      $('#postController').scope().user.aula = 'A 01';
     }
     $('#centro_uni').ready(function() 
      {
        console.log($('#calendar').fullCalendar('clientEvents'));
            $('#calendar').fullCalendar('refetchEvents');
            if($('#centro_uni').val() == "Ambas" && angular.element('#postController').scope().centro_actual == "Clases" )
            {

              $('#tipoH').html('<li id="clase" class="nav-item d-none d-lg-block"><a class="nav-link" href="#"  data-toggle="modal" data-target="#seccionModal" >+ Agregar Clase</a></li>');
            }
            if($('#centro_uni').val() == "Clases" && angular.element('#postController').scope().centro_actual == "Clases" )
            {

              $('#tipoH').html('<li id="clase" class="nav-item d-none d-lg-block"><a class="nav-link" href="#"  data-toggle="modal" data-target="#seccionModal" >+ Agregar Clase</a></li>');
            }
            if($('#centro_uni').val() == "Belenes" && angular.element('#postController').scope().centro_actual == "Belenes" )
            {

              $('#tipoH').html('<li id="clase" class="nav-item d-none d-lg-block"><a class="nav-link" href="#"  data-toggle="modal" data-target="#seccionModal" >+ Agregar Evento</a></li>');
            }
            if($('#centro_uni').val() != "Clases")
            {
              $('#tipoH').html('<li id="permiso" class="nav-item d-none d-lg-block"><a class="nav-link" href="#"  data-toggle="modal" data-target="#seccionModal" >+ Agregar Evento</a></li>');
            }

            if($('#centro_uni').val() == "Clases" && angular.element('#postController').scope().centro_actual == "La Normal" )
            {

              $('#permiso').html('');
            }

            if($('#centro_uni').val() == "Belenes" && angular.element('#postController').scope().centro_actual == "La Normal" )
            {
              $('#permiso').html('');
            }
            if($('#centro_uni').val() == "Belenes" && angular.element('#postController').scope().centro_actual == "Clases" )
            {
              $('#permiso').html('');
            }
            if($('#centro_uni').val() == "La Normal" && angular.element('#postController').scope().centro_actual == "Belenes" )
            {
              $('#permiso').html('');
            }
             if($('#centro_uni').val() == "La Normal" && angular.element('#postController').scope().centro_actual == "Clases" )
            {
              $('#permiso').html('');
            }

            if($('#centro_uni').val() == "Clases" && angular.element('#postController').scope().centro_actual == "Belenes" )
            {
              $('#tipoH').html('<li id="clase" class="nav-item d-none d-lg-block"><a class="nav-link" href="#"  data-toggle="modal" data-target="#seccionModal" >+ Agregar Evento</a></li>');
            }
      });
     $('#centro_uni').change(
      function ()
      {
            console.log($('#calendar').fullCalendar('clientEvents'));
            $('#calendar').fullCalendar('refetchEvents');
            if($('#centro_uni').val() == "Clases" && angular.element('#postController').scope().centro_actual == "Clases" )
            {

              $('#tipoH').html('<li id="clase" class="nav-item d-none d-lg-block"><a class="nav-link" href="#"  data-toggle="modal" data-target="#seccionModal" >+ Agregar Clase</a></li>');
            }
            if($('#centro_uni').val() == "Belenes" && angular.element('#postController').scope().centro_actual == "Belenes" )
            {

              $('#tipoH').html('<li id="clase" class="nav-item d-none d-lg-block"><a class="nav-link" href="#"  data-toggle="modal" data-target="#seccionModal" >+ Agregar Evento</a></li>');
            }
            if($('#centro_uni').val() != "Clases")
            {
              $('#tipoH').html('<li id="permiso" class="nav-item d-none d-lg-block"><a class="nav-link" href="#"  data-toggle="modal" data-target="#seccionModal" >+ Agregar Evento</a></li>');
            }

            if($('#centro_uni').val() == "Clases" && angular.element('#postController').scope().centro_actual == "La Normal" )
            {

              $('#permiso').html('');
            }

            if($('#centro_uni').val() == "Belenes" && angular.element('#postController').scope().centro_actual == "La Normal" )
            {
              $('#permiso').html('');
            }
            if($('#centro_uni').val() == "Belenes" && angular.element('#postController').scope().centro_actual == "Clases" )
            {
              $('#permiso').html('');
            }
            if($('#centro_uni').val() == "La Normal" && angular.element('#postController').scope().centro_actual == "Belenes" )
            {
              $('#permiso').html('');
            }
             if($('#centro_uni').val() == "La Normal" && angular.element('#postController').scope().centro_actual == "Clases" )
            {
              $('#permiso').html('');
            }

            if($('#centro_uni').val() == "Clases" && angular.element('#postController').scope().centro_actual == "Belenes" )
            {
             $('#tipoH').html('<li id="clase" class="nav-item d-none d-lg-block"><a class="nav-link" href="#"  data-toggle="modal" data-target="#seccionModal" >+ Agregar Evento</a></li>');
            }
      });
  });    



</script>

</body>


<!-- Custom Javascript -->
<script src="https://superal.github.io/canvas2image/canvas2image.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/multipleDatePicker.css"/>
<script type="text/javascript" src="js/multipleDatePicker.min.js"></script> 
<script type="text/javascript" src="js/calendar_behavior.js"></script>
<script src="js/moduloAngular.js"></script>

</html>
