


var postApp = angular.module('postApp', ['multipleDatePicker'])

.factory("personal", ['$http', function ($http){
  var Indata = {personal:true};
  var jsonRespond ; 
  
  
  var interfaz = {
      getInterfaz: function()
      {
        
        this.setHtml();
        return jsonRespond;
      },

    setHtml : function()
    {
      
      jsonRespond= $http({
        method  : 'POST',
            url     : 'Controller/controller.php',
            data    :  Indata
    
                                                      })
        .then(function successCallback(response) 
            {
              return response.data;
           
            },
            function errorCallback(response) 
            {
              return response.data;
            }
        )

    }
    
  }

  return interfaz;
}])


//esta directiva permite compilar el html
.directive('dynamic', function($compile) {
    return {
        restrict: 'A',
        replace: true,
        link: function (scope, element, attrs) {
            scope.$watch(attrs.dynamic, function(html) {
                element[0].innerHTML = html; 
                $compile(element.contents())(scope);
            });
        }
    };
});

postApp.controller('postController',       function($sce,$scope, $http, personal) {
        $scope.loading = false;
        $scope.user = {};
        $scope.user.aula = 'A 01';
        $scope.flag = 0;
        $scope.filtrado = {};
        $scope.todasSesiones = {};
        $scope.sesionesFuturas ={};
        $scope.fechaInicial = new Date();
        $scope.fechaFinal = new Date();
        $scope.filtro = {};
        $scope.filtro.espacio = 'todos';
        $scope.filtro.tipo = 'todos';
        $scope.filtro.depen = 'todos';
        $scope.borrando = {};
        $scope.formReg={};
        $scope.todayPicker = moment();
        $scope.user.espacios =[];
        $scope.user.hora_inicial_hora=[];
        $scope.user.salon=[];
        $scope.user.hora_inicial_min = [];
        $scope.user.hora_final_hora=[];
        $scope.user.hora_final_min = [];
        $scope.user.hora_inicial = [];
        $scope.user.hora_final =[];
        $scope.elementosHtml = '';
        $scope.prueba = [];
        
        $scope.submitClases = function() {
            $scope.loading = true;
            $field_ini_hora = $scope.user.hora_inicial_hora.filter(function (el) 
              {
                  return el != null;
              });
             $field_ini_min = $scope.user.hora_inicial_min.filter(function (el) 
              {
                  return el != null;
              });
             $field_fin_hora = $scope.user.hora_final_hora.filter(function (el) 
              {
                  return el != null;
              });
             $field_fin_min = $scope.user.hora_final_min.filter(function (el) 
              {
                  return el != null;
              });
            console.log($scope.user.hora_inicial_hora);
            for(var c = 0; c < $field_ini_hora.length; c++)
            {
                $scope.user.hora_inicial[c] = "1970-01-01T"+$field_ini_hora[c]+":"+$field_ini_min[c]+":00.000Z";
                $scope.user.hora_final[c]= "1970-01-01T"+$field_fin_hora[c]+":"+ $field_fin_min[c]+":00.000Z";
            }

            if(!$scope.user.notas_cta) 
            {
               
              $scope.user.notas_cta = 'Sin notas';

            }
            if(!$scope.user.notas_sg) 
            {

              $scope.user.notas_sg = 'Sin notas';

            }
            
            if($('#centro_uni').val() == 'Clases')
            {
              $scope.user.actividad = "clase";
              $scope.user.salon = $scope.user.edificio + ' ' + $scope.user.numero_salon;
            }
            else{

              $scope.user.actividad ="evento";
             
            }
            $http({
              method  : 'POST',
              url     : 'View/inserta_clases.php',
              data    : $scope.user,
              
             })
              .then(function successCallback(response) {
              
               $scope.informacion = response.data;
               changeClass($scope.informacion.datos.estatus)
               if($scope.informacion.datos.estatus == 1)
                {
                   $scope.loading = false;
                   $scope.eventClases.$setPristine();
                   $scope.user = {};
                   $scope.user.aula = 'A 01';
                   $scope.formReg = "";
                };

          
              },
               function errorCallback(response) {
                    console.log(response);
                }
             

          )};

        $scope.submitForm = function() 
        {
            
            for(var c = 0; c < $scope.user.hora_inicial_hora.length; c++)
            {
              if($scope.user.hora_inicial_hora[c] == "")
              {
                $scope.user.hora_inicial_hora[c] = '?';
              }
              if($scope.user.hora_inicial_min[c] == "")
              {
                $scope.user.hora_inicial_min[c] = '?';
              }
              if($scope.user.hora_final_hora[c] == "")
              {
                $scope.user.hora_final_hora[c] = '?';
              }
              if($scope.user.hora_final_min[c] == "")
              {
                $scope.user.hora_final_min[c] = '?';
              }

              if($scope.user.hora_inicial_min.length == $scope.user.fecha.length)
              {
                $scope.user.hora_inicial[c] = "1970-01-01T"+$scope.user.hora_inicial_hora[c]+":"+$scope.user.hora_inicial_min[c]+":00.000Z";
                $scope.user.hora_final[c]= "1970-01-01T"+$scope.user.hora_final_hora[c]+":"+$scope.user.hora_final_min[c]+":00.000Z";
              }
              else
              {
                $scope.user.hora_inicial[c] = "1970-01-01T"+$scope.user.hora_inicial_hora[c]+":"+'?'+":00.000Z";
                $scope.user.hora_final[c]= "1970-01-01T"+$scope.user.hora_final_hora[c]+":"+'?'+":00.000Z";
              }
              
            }

            if(!$scope.user.notas_cta) 
            {
               
              $scope.user.notas_cta = 'Sin notas';

            }
            if(!$scope.user.notas_sg) 
            {

              $scope.user.notas_sg = 'Sin notas';

            }
            if($scope.user.salon)
            {
              var tam = $scope.user.salon.length;
              for(i=0;i<tam;i++)
              {
                $scope.user.espacios[i] =$scope.user.espacios[i] + " " + $scope.user.salon[i]; 
              }
              $scope.user.aula = 1;
            }
            if($('#centro_uni').val() == 'Clases')
            {
              $scope.user.actividad = "clase";
              
            }
            else{

              $scope.user.actividad ="evento";
             
            }
            $http({
              method  : 'POST',
              url     : 'View/check.php',
              data    : $scope.user,
              
             })
              .then(function successCallback(response) {
              
               $scope.informacion = response.data;
               changeClass($scope.informacion.datos.estatus)
                
               if($scope.informacion.datos.estatus == 1)
                {
                   $scope.eventForm.$setPristine();
                   $scope.user = {};
                   $scope.user.aula = 'A 01';
                   $scope.user.salon = [];
                   $scope.formReg = "";
                   $scope.lugares = {};


                };

          
              },
               function errorCallback(response) {
                    console.log(response);
                }
             

          )};


        $scope.updateClases = function() 
        {

              $scope.user.hora_inicial = "1970-01-01T"+$scope.user.hora_inicial_h+":"+$scope.user.hora_inicial_m+":00.000Z";
              $scope.user.hora_final = "1970-01-01T"+$scope.user.hora_final_h+":"+$scope.user.hora_final_m+":00.000Z";
            
              $http({
                method  : 'POST',
                url     : 'View/update_clases.php',
                data    : $scope.user,
                
               })
                .then(function successCallback(response) {
                 
                 $scope.informacion = response.data;
                 changeClass($scope.informacion.datos.estatus);
                 if($scope.informacion.datos.estatus == 1)
                  {
                     $scope.modifyForm.$setPristine();
                     $scope.user = {};
                     $scope.user.aula = 'A 01';
                     $scope.formReg = "";
                  };

            
                },
                 function errorCallback(response) {
                     console.log(response);
                  }
             

          )};
        $scope.submitUpdate = function() 
        {
              $scope.loading = true;
              $scope.user.hora_inicial = "1970-01-01T"+$scope.user.hora_inicial_h+":"+$scope.user.hora_inicial_m+":00.000Z";
              $scope.user.hora_final = "1970-01-01T"+$scope.user.hora_final_h+":"+$scope.user.hora_final_m+":00.000Z";
              if(!$scope.user.notas_cta) 
              {
                 
                  $scope.user.notas_cta = 'Sin notas';

              }
               if(!$scope.user.notas_sg) 
               {

                  $scope.user.notas_sg = 'Sin notas';

               }
               if ($scope.created_time == null)
               {
                     var  date = new Date($scope.user.fecha);

               }
               else
               {
                     var  date = $scope.created_time;

               }
               
              var  dia_dt =new Date ($scope.user.fecha);
              var respaldo = $scope.user.fecha;  
              $scope.user.fecha = date;

              if($scope.user.cu == 'Clases')
              {
                $scope.user.espacio = $scope.splitedSpace[0] + " " + $scope.splitedSpace[1];
                $scope.user.aula = 1;
              }


              $http({
                method  : 'POST',
                url     : 'View/update.php',
                data    : $scope.user,
                
               })
                .then(function successCallback(response) {
                 
                 $scope.informacion = response.data;
                 changeClass($scope.informacion.datos.estatus);
                 if($scope.informacion.datos.estatus == 1)
                  {
                     $scope.modifyForm.$setPristine();
                     $scope.user = {};
                     $scope.user.aula = 'A 01';
                     $scope.formReg = "";
                     
                  }
                  else{
                    $scope.user.fecha = respaldo;
                  }
                  $scope.loading = false;

            
                },
                 function errorCallback(response) {
                     console.log(response);
                  }
             

          )};                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        


        $scope.changeFlag = function(tiempo_creado)
        {
              if (tiempo_creado == null) 
              {
                    $scope.flag = 0;
                   
              }
              else
              {
              
                    $scope.flag = 1;
              }
                 
        }

        //Segun el estatus cambia la clase de la alerta
        var changeClass = function(estado)
        {
            if (estado == 1)
            {
                $scope.class = "alert alert-success";
                $scope.user = {};
                
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

        $scope.checkLength = function(longitud) 
        {
                
               if ( longitud == 0) 
                {
                
                 return true;
                }
                else 
                {
                 return false;
                }

        };

        //Carga el formulario de registro de eventos 
        $scope.getRegCont = function() 
        {
            var Indata = {insert: true};
            $http({
                    method  : 'POST',
                    url     : 'Controller/controller.php',
                    data   : Indata
                   
                                                              })
                    .then(function successCallback(response) 
                    {
                     $scope.htmlReg = response.data;
                     $scope.formReg = $sce.trustAsHtml($scope.htmlReg);
                                      
                    },

                    function errorCallback(response) 
                    {
                          console.log(response);
                    }
                       

          )};
          $scope.getClassReg = function()
          {
            var Indata = {clases: true};
            $http({
                                method  : 'POST',
                                url     : 'Controller/controller.php',
                                data    :  Indata
                      
                                                                          })
                        .then(function successCallback(response) 
                        {
                         $scope.htmlReg = response.data;
                         $scope.formReg = $sce.trustAsHtml($scope.htmlReg);
                                          
                        },

                        function errorCallback(response) 
                        {
                              console.log(response);
                        }
          )};
              //Carga el formulario de busqueda de eventos
          $scope.getSearch = function() 
          {
                    var Indata = {search: true};
                    $http({
                              method  : 'POST',
                              url     : 'Controller/controller.php',
                              data    :  Indata
                    
                                                                        })
                      .then(function successCallback(response) 
                      {
                       $scope.htmlReg = response.data;
                       $scope.formReg = $sce.trustAsHtml($scope.htmlReg);
                                        
                      },

                      function errorCallback(response) 
                      {
                            console.log(response);
                      }
          )};

          //Carga la vista de eventos de hoy
          $scope.getToday = function() 
          {
                    var Indata = {today: true};
                    $http({
                              method  : 'POST',
                              url     : 'Controller/controller.php',
                              data    : Indata
                    
                                                                        })
                      .then(function successCallback(response) 
                      {
                       $scope.htmlReg = response.data;
                       $scope.formReg = $sce.trustAsHtml($scope.htmlReg);
                                        
                      },

                      function errorCallback(response) 
                      {
                            console.log(response);
                      }
          )};


          //Funcion para obtener la vista de reporte
          $scope.getReporte = function() 
                {
                  var Indata = {report: true};
                  $http({
                                  method  : 'POST',
                                  url     : 'Controller/controller.php',
                                  data    : Indata
                     
                                                                        })
                      .then(function successCallback(response) 
                      {
                         $scope.htmlReg = response.data;
                         $scope.formReg = $sce.trustAsHtml($scope.htmlReg);                  
                      },
                      function errorCallback(response) 
                      {
                            console.log(response);
                      }
                         

                 )};

           $scope.getGepe= function() 
                 {
                   var Indata = {gestion: true};
                   $http({
                                   method  : 'POST',
                                   url     : 'Controller/controller.php',
                                   data    : Indata
                      
                                                                         })
                       .then(function successCallback(response) 
                       {
                          $scope.htmlReg = response.data;
                          $scope.formReg = $sce.trustAsHtml($scope.htmlReg);                  
                       },
                       function errorCallback(response) 
                       {
                             console.log(response);
                       }
                          
 
                  )};

          //Carga el formulario para modificar eventos
          $scope.getModificar = function() 
                {
                  
                  
                  $scope.created_time =  new Date(($scope.datosMostrar.fecha) - 1);
                  $scope.user.fecha =  $scope.datosMostrar.fecha;
                  
                  $scope.user = angular.copy($scope.datosMostrar);
                  var Indata = {modify: true};
                  $http(  {
                                method  : 'POST',
                                url     : 'Controller/controller.php',
                                data   : Indata
                                                              })
                    .then(function successCallback(response) 
                    {
                     $scope.htmlReg = response.data;
                     $scope.formReg = $sce.trustAsHtml($scope.htmlReg);           
                    },
                    function errorCallback(response) 
                    {
                         console.log(response);
                    }                   
                    )};

          $scope.getModificar_clases = function() 
                {
                  
                  
                  $scope.created_time =  new Date(($scope.datosMostrar.fecha) - 1);
                  $scope.user.fecha =  $scope.datosMostrar.fecha;
                  
                  $scope.user = angular.copy($scope.datosMostrar);
                  var Indata = {modify_clases: true};
                  $http(  {
                                method  : 'POST',
                                url     : 'Controller/controller.php',
                                data    : Indata
                                                              })
                    .then(function successCallback(response) 
                    {
                     $scope.htmlReg = response.data;
                     $scope.formReg = $sce.trustAsHtml($scope.htmlReg);           
                    },
                    function errorCallback(response) 
                    {
                         console.log(response);
                    }                   
                    )};


          $scope.borrar = function(borrando) 
          {
                       var Indata = {id: borrando};
                        $http({
                          method  : 'POST',
                          url     : 'View/borrar.php',
                          data   : Indata
                         })
                          .then(function successCallback(response) 
                          {
                               $scope.informacion= response.data;

                               changeClass($scope.informacion.datos.estatus);

                               $("#calendar").fullCalendar( 'refetchEvents' );

                               if($scope.informacion.datos.estatus == 1)
                               {
                                     $scope.formReg = "";
                               };
                                             
                          },
                          function errorCallback(response) 
                          {
                                console.log(response);
                          }
                       

          )};

          $scope.confirmar = function(dato_conf)
          {
              var r = confirm("¿Realmente desea cancelar este evento?");
              if (r == true)
              {
                $scope.borrar(dato_conf);
              } 
                         
          };

          $scope.updateHourF = function(horas,minutos)
          {
             $scope.user.hora_final = horas + ":" + minutos;
                         
          };

          $scope.updateHourI = function(horas,minutos)
          {

            $scope.user.hora_inicial = horas + ":" + minutos; 

          };
                    
          $scope.trustAsHtml = function(html) 
          {
            return $sce.trustAsHtml(html);
          };

          $scope.clearBody = function()
          {

            $("#calendar").fullCalendar( 'refetchEvents' );
            $scope.formReg={};
          };
                    
          $scope.eventId = function(identificador)
          {
              $scope.getShowCont(identificador);    
          };

          $scope.getShowCont = function(mostrar) 
          {
            
                 var Indata = {insert: true};
                 $http({
                    method  : 'POST',
                    url     : 'View/eventData.php',
                    data   : Indata
                    
                   })
                  .then(function successCallback(response) 
                  {
                    console.log(mostrar);
                       $scope.htmlReg = response.data;
                       $scope.formReg = $sce.trustAsHtml($scope.htmlReg);
                       $scope.datosMostrar = { 
                          ID: mostrar.ID,
                          titulo: mostrar.title,
                          espacio: mostrar.espacio,
                          aula: "A 01",
                          fecha: mostrar.start.format('YYYY-MM-DD'),
                          hora_final: mostrar.end.format('kk:mm'),
                          hora_final_h: mostrar.end.format('k'),
                          hora_final_m: mostrar.end.format('mm'),
                          hora_inicial: mostrar.start.format('kk:mm'),
                          hora_inicial_h: mostrar.start.format('k'),
                          hora_inicial_m: mostrar.start.format('mm'),
                          organizador: mostrar.organizador,
                          tel_organizador: mostrar.tel_organizador,
                          responsable: mostrar.responsable,
                          tel_responsable: mostrar.tel_responsable,
                          tipo: mostrar.tipo,
                          notas_cta: mostrar.notas_cta,
                          notas_sg: mostrar.notas_sg,
                          dependencia: mostrar.dependencia, 
                          id: mostrar.ID,
                          color: mostrar.backgroundColor,
                          cu: mostrar.centro_univ,
                          sesion: mostrar.ID_actividad,
                          idsesion: mostrar.id_sesion,
                          registrado: mostrar.registrado_por,
                          vista: mostrar.view,
                          personal: mostrar.personal
                    };
                    
                    var hora_lar =  $scope.datosMostrar.hora_inicial_h;

                    if(hora_lar.length == 1)
                    {
                      $scope.datosMostrar.hora_inicial_h = '0' + $scope.datosMostrar.hora_inicial_h;
                    }
                    hora_lar = $scope.datosMostrar.hora_final_h;

                    if(hora_lar.length == 1)
                    {
                      $scope.datosMostrar.hora_final_h = '0' + $scope.datosMostrar.hora_final_h;
                    } 
                    $scope.disponible = true;
                    var arr = $scope.datosMostrar.espacio;

                    $scope.conAula = true;
                    if(arr.length == 4)
                    {
                      $scope.datosMostrar.aula = $scope.datosMostrar.espacio;
                      $scope.datosMostrar.espacio = "Aula";
                      $scope.disponible = false;
                      $scope.conAula = false;

                    }
                       
                               
                    },
                    function errorCallback(response) {
                          console.log(response);
                    }
      )};

      $scope.printConcat =function(concat)
      {
          $scope.user.hora_inicial_hora = "1970-01-01T"+concat;
          return $scope.user.hora_inicial_hora;
      };


      $scope.todayEvents = function(fecha)
      {
          var eventos = $('#calendar').fullCalendar('clientEvents');

          var count = Object.keys(eventos).length;
          var espacioName;
          var tomorrow = new Date(fecha);
          if(fecha!=null)
          {
            tomorrow.setDate(fecha.getDate() + 1);
          }
         
          var json = 
          {

            datos: []
                  
          };
          for (i = 0; i < count; i++) 
          { 
                   
              if(formatDate(eventos[i].start) == formatDate(tomorrow))
              {
                        

                 
                  json.datos.push(
                  {
                        "titulo"  : eventos[i].title,
                        "fecha"   : formatDate(eventos[i].start),
                        "horaIni" : gethora(eventos[i].start),
                        "horaFin" : gethora(eventos[i].end),
                        "tipo"    : eventos[i].tipo,
                        "id"      : eventos[i].ID,
                        "color"   : eventos[i].backgroundColor,
                        "lugar"   : eventos[i].espacio,
                        "vista"   : eventos[i].view,
                        "idsesion": eventos[i].id_sesion
                        
                  });
              }
         }
          
         $scope.sesiones = json;
         
      };

      $scope.allEvents = function()
      {
                  var eventos = $('#calendar').fullCalendar('clientEvents');
                  var today = new Date();
                  var espacioName;
                  var json = {
                      datos: []
                  };
                  for ( var i = 0, len = Object.keys(eventos).length; i < len; i++) 
                  { 
                          json.datos.push({
                          "titulo"  : eventos[i].title,
                          "fecha"   : formatDate(eventos[i].start),
                          "horaIni" : gethora(eventos[i].start),
                          "horaFin" : gethora(eventos[i].end),
                          "org"     : eventos[i].organizador,
                          "dep"     : eventos[i].dependencia,
                          "espacio" : eventos[i].espacio,
                          "tipo"    : eventos[i].tipo,
                          "id"      : eventos[i].ID,
                          "color"   : eventos[i].backgroundColor,
                          "cu"      : eventos[i].centro_univ,
                          "dep"     : eventos[i].dependencia,
                          "vista"   : eventos[i].view             
                        });
                      
                  }
                  
                  $scope.todasSesiones = json;                  
                  json = {};
      };

      $scope.futureEvents = function()
      {
        var eventos = $('#calendar').fullCalendar('clientEvents');
        var today = new Date();
        var count = Object.keys(eventos).length;
        var espacioName;

        var json = {
                     datos: []
                  };
                  for (i = 0; i < count; i++) 
                  { 
                   
                      if(formatDate(eventos[i].start) >= formatDate(today))
                      {
                          
                          json.datos.push({
                          "titulo"  : eventos[i].title,
                          "fecha"   : formatDate(eventos[i].start),
                          "horaIni" : gethora(eventos[i].start),
                          "horaFin" : gethora(eventos[i].end),
                          "espacio" : eventos[i].espacio,
                          "tipo"    : eventos[i].tipo,
                          "id"      : eventos[i].ID,
                          "color"   : eventos[i].backgroundColor,
                          "vista"   : eventos[i].view
                          
                        });
                      }
                      
                  }
                  
                  $scope.sesionesFuturas = json;                     

                };

                $scope.ajuste =function(agregar)
                {
                    
                  if(agregar.length == 1)
                  {
                    $scope.datosMostrar.hora_inicial_h = 0 + agregar;

                    
                  }
                };


                function formatDate(date) 
                {

                    var d = new Date(date),
                      month = '' + (d.getMonth() + 1),
                      day = '' + d.getDate(),
                      year = d.getFullYear();

                      if (month.length < 2) month = '0' + month;
                      if (day.length < 2) day = '0'.concat(day);
                      return [day, month, year].join('/');
                };


                function gethora(hora)
                {
                  
                  now = new Date(hora);
                  var nowUtc = new Date( now.getTime() + (now.getTimezoneOffset() * 60000));
                  
                  if(nowUtc.getHours() < 12)
                  {
                    
                    if(nowUtc.getMinutes() < 10 &&  nowUtc.getHours() < 10 )
                    {

                       return ["0" + nowUtc.getHours(), nowUtc.getMinutes() + "0"].join(':') + " AM";
                    }

                    if(nowUtc.getMinutes() < 10 &&  nowUtc.getHours() > 10 )
                    {

                       return [nowUtc.getHours(), nowUtc.getMinutes() + "0"].join(':') + " AM";
                    }

                    if(nowUtc.getMinutes() > 10 &&  nowUtc.getHours() < 10 )
                    {

                       return ["0" + nowUtc.getHours(), nowUtc.getMinutes()].join(':') + " AM";
                    }

                    else
                    {
                       return [nowUtc.getHours(), nowUtc.getMinutes()].join(':') + " AM";

                    }

                  }
                   if(nowUtc.getHours() >= 12)
                  {
                    if(nowUtc.getMinutes() == 0)
                    {
                       return [nowUtc.getHours(), nowUtc.getMinutes() + "0"].join(':') + " PM";
                    }
                    else
                    {
                       return [nowUtc.getHours(), nowUtc.getMinutes()].join(':') + " PM";
                    }
                  }

                };

            $scope.detalles = function(numEvent, numSesion)
            {
              var eventos = $('#calendar').fullCalendar('clientEvents');

              var count = Object.keys(eventos).length;
              $("#seccionModal").modal("show");
                $scope.class = "";
                $scope.informacion ={};
                var espacioName;


                var json = {
                      datos: []
                  };
               
                var evento = binarySearch($('#calendar').fullCalendar('clientEvents'), numSesion);
                //console.log(plain_search(eventos, numSesion));      
                console.log(evento);  
                if(evento == -1)
                {
                  evento = plain_search(eventos, numSesion);
      
                }
                if(evento == -1)
                {
                  evento = plain_search(eventos, numEvent);
                }
                        espacioName = evento.espacio.split(',');
                        json.datos.push({
                        "title"   : evento.title,
                        "start"   : evento.start,
                        "horaIni" : gethora(eventos.start),
                        "horaFin" : gethora(eventos.end),
                        "espacio" : evento.espacio,
                        "tipo"    : evento.tipo,
                        "ID"      : evento.ID,
                        "end"     : evento.end,
                        "organizador" : evento.organizador,
                        "tel_organizador" : evento.tel_organizador,
                        "responsable": evento.responsable,
                        "tel_responsable": evento.tel_responsable,
                        "tipo": evento.tipo,
                        "notas_cta": evento.notas_cta,
                        "notas_sg": evento.notas_sg,
                        "dependencia": evento.dependencia,
                        "backgroundColor" : evento.backgroundColor,
                        "centro_univ": evento.centro_univ,
                        "id_sesion": evento.id_sesion,
                        "view": evento.view,
                        "registrado_por": evento.registrado_por,
                        "personal" : evento.personal
                        
                      });
                  $scope.detallesHoy  = json;
                  $scope.eventId(json.datos[0]);

                  json = {};
                
              
            }; 
            

             $scope.exportToPdf = function(filtro)
             {

                  var columns = [
                                    {title: "Titulo", dataKey: "titulo"},
                                    {title: "Responsable", dataKey: "org"},
                                    {title: "Dependencia", dataKey: "dep"},
                                    {title: "Fecha", dataKey: "fecha"}, 
                                    {title: "Espacio", dataKey: "espacio"}, ];
                  var rows = filtro;
                  var doc = new jsPDF('l', 'pt');
                  var eventosFiltro = 0;
                  
                  while(eventosFiltro < filtro.length)
                  {
                       objFecha = rows[eventosFiltro].fecha.split("/");
                       objFecha = new Date(objFecha[2], objFecha[1] - 1, objFecha[0]);
                       rows[eventosFiltro].fecha = objFecha.getTime();
                       eventosFiltro++;

                  }
                  
                  rows = quick_Sort(rows);

                  eventosFiltro = 0;
                 
                  if(rows.length != 1)
                  { 
                    while(eventosFiltro < filtro.length+1)
                    {
                        rows[eventosFiltro].fecha = formatDate(rows[eventosFiltro].fecha);
                        eventosFiltro++;
                      
                    }
                  }
                  else
                  {
                    rows[eventosFiltro].fecha = formatDate(rows[eventosFiltro].fecha);
                  }
                  
                  doc.text(30, 30, 'Reporte Agenda CUCSH del ' + formatDate($scope.fechaInicial) + ' al ' + formatDate($scope.fechaFinal) ); 
                  doc.text(600, 30, 'Número de Registros: '+ rows.length); 
                  doc.autoTable(columns, rows,
                    {
                        styles: { overflow: 'linebreak', columnWidth: 'wrap' },
                        columnStyles: 
                        {
                            org: 
                            {
                                columnWidth: 'auto'
                            },
                            titulo: 
                            {
                              columnWidth: 'auto',
                            }
                        },
                    });  
                  doc.save('reporte.pdf');
                  
                  $scope.filtroEventos = {};
              };

              $scope.getFiltro = function (names, query) 
              {
                
                $scope.filtroEventos = $scope.daterange(names,$scope.fechaInicial, $scope.fechaFinal);
                
              };


              $scope.daterange = function (input, startDate, endDate)
              {
                 
                  $today = new Date(startDate);
                  $yesterday = new Date(startDate);
                  $yesterday.setDate($today.getDate() - 1);
                  var json = {
                                  datos: []
                              };


                   angular.forEach(input, function(obj)
                   {

                      objFecha = obj.fecha.split("/");
                      objFecha = new Date(objFecha[2], objFecha[1] - 1, objFecha[0]);
                                            //año        //mes             //dia
                     
                                            
                      if($scope.filtro.espacio != 'todos' && $scope.filtro.tipo != 'todos' && $scope.filtro.depen != 'todos')
                      {
                        if(objFecha.getTime() >=  $yesterday.getTime() && 
                              objFecha.getTime() <= endDate.getTime() && 
                                obj.espacio == $scope.filtro.espacio &&
                                  obj.tipo  == $scope.filtro.tipo &&
                                    obj.dep == $scope.filtro.depen)   
                                            {
                                                
                                                json.datos.push(obj);
                                            }
                      }

                      if($scope.filtro.espacio != 'todos' && $scope.filtro.tipo == 'todos' && $scope.filtro.depen == 'todos')
                      {
                         if(objFecha.getTime() >=  $yesterday.getTime() && objFecha.getTime() <= endDate.getTime() 
                             && obj.espacio == $scope.filtro.espacio)   
                                            {
                                                
                                                json.datos.push(obj);
                                            }
                      }

                      if($scope.filtro.espacio == 'todos' && $scope.filtro.tipo != 'todos' && $scope.filtro.depen == 'todos')
                      {
                         if(objFecha.getTime() >=  $yesterday.getTime() && objFecha.getTime() <= endDate.getTime()
                             && obj.tipo == $scope.filtro.tipo)   
                                            {
                                                
                                                json.datos.push(obj);
                                            }
                      }

                      //casos de dependencia

                      if($scope.filtro.espacio == 'todos' && $scope.filtro.tipo == 'todos' && $scope.filtro.depen != 'todos')
                      {
                         if(objFecha.getTime() >=  $yesterday.getTime() && objFecha.getTime() <= endDate.getTime() 
                             && obj.dep == $scope.filtro.depen)   
                                            {
                                                
                                                json.datos.push(obj);
                                            }
                      }

                      if($scope.filtro.espacio == 'todos' && $scope.filtro.tipo != 'todos' && $scope.filtro.depen != 'todos')
                      {
                         if(objFecha.getTime() >=  $yesterday.getTime() && objFecha.getTime() <= endDate.getTime() 
                             && obj.dep == $scope.filtro.depen && obj.tipo == $scope.filtro.tipo)   
                                            {
                                                
                                                json.datos.push(obj);
                                            }
                      }

                      if($scope.filtro.espacio != 'todos' && $scope.filtro.tipo == 'todos' && $scope.filtro.depen != 'todos')
                      {
                         if(objFecha.getTime() >=  $yesterday.getTime() && objFecha.getTime() <= endDate.getTime() 
                             && obj.dep == $scope.filtro.depen && obj.espacio == $scope.filtro.espacio)   
                                            {
                                                
                                                json.datos.push(obj);
                                            }
                      }

                      if($scope.filtro.espacio != 'todos' && $scope.filtro.tipo != 'todos' && $scope.filtro.depen == 'todos')
                      {
                         if(objFecha.getTime() >=  $yesterday.getTime() && objFecha.getTime() <= endDate.getTime() 
                             && obj.tipo == $scope.filtro.tipo && obj.espacio == $scope.filtro.espacio)   
                                            {
                                                
                                                json.datos.push(obj);
                                            }
                      }

                      //caso todos los filtros sin aplicar
                      if($scope.filtro.espacio == 'todos' && $scope.filtro.tipo == 'todos' && $scope.filtro.depen == 'todos' )
                      {
                         if(objFecha.getTime() >=  $yesterday.getTime() && objFecha.getTime() <= endDate.getTime())   
                                            {
                                                
                                                json.datos.push(obj);
                                            }
                      }
                   });
                    
                    return json;
               
            };

            //Funcion de ordenamiento quick sort para ordenar el JSON de eventos por fecha - + 
            function quick_Sort(origArray) 
            {
                
                    if (origArray.length <= 1)
                    { 
                      return origArray;
                    } 
                    else 
                    {
                      var left = [];
                      var right = [];
                      var newArray = [];
                      var pivot = origArray.pop();
                     
                      var length = origArray.length;
                      
                      for (var i = 0; i < length; i++) 
                      {
                        if (origArray[i].fecha <= pivot.fecha) 
                        {
                          left.push(origArray[i]);
                          
                        } else 
                        {
                          right.push(origArray[i]);
                        }
                      }
                      return newArray.concat(quick_Sort(left), pivot, quick_Sort(right));
                    }
            }

            $scope.limpiar = function()
            {
                  $scope.class="";
                  $scope.informacion={};
                  $scope.user={};
                  $scope.user.aula = 'A 01';
                  $scope.flag = 0;
                  $scope.todasSesiones = {};
                  $scope.user.espacios =[];
                  $scope.user.hora_inicial_hora=[];
                  $scope.user.hora_inicial_min = [];
                  $scope.user.hora_final_hora=[];
                  $scope.user.hora_final_min = [];
                  $scope.user.hora_inicial = [];
                  $scope.user.hora_final =[];
                  $scope.elementosHtml = '';
                  $scope.user.fecha = [];
                  $scope.myCheckbox = false;
                  $scope.user.salon = [];
            }

            $scope.limpiarVista = function()
            {
              $scope.formReg= {};
            }

            $scope.verifica_centro = function(centro)
            {
              
              if(centro == $scope.sesion)
              {
                return true;
              }
              if(centro == "Clases" && $scope.sesion == 'Belenes' )
              {
                return true;
              }
              if((centro == "La Normal" || centro=="Belenes") || $scope.sesion == 'Ambas' )
              {
                return true;
              }
              else
              {
                return false;
              }
            }

            $scope.verifica_espacios = function(centro)
            {

              if(centro == 'La Normal')
              {
                $scope.valor_espacio = 1;
              }
              if(centro == 'Belenes')
              {
                $scope.valor_espacio = 2;
              }
              if(centro == 'Clases')
              {
                $scope.valor_espacio = 3;
              }
            }

          $scope.pushToArray = function(elemento,array,lugar,otro)
          {

              if(elemento != 'Otro')
              {
                    array[lugar] = elemento;       
              }
              if(elemento == 'Otro')
              {
               array[lugar] = otro;       
              }
          }
          $scope.popToArray = function()
          {
              $scope.lugares ={};
              $scope.user.espacios = [];
              $scope.user.hora_inicial_hora=[];
              $scope.user.hora_inicial_min =[];
              $scope.user.hora_final_hora=[];
              $scope.user.hora_final_min=[];
              $scope.user.hora_inicial=[];
              $scope.user.hora_final=[];
              $scope.myCheckbox = false;
          }

          $scope.mostrar = function(espacio,lugar)
          {
            if(espacio == 'Otro')
            {
              
              $scope.prueba[lugar]= true;
            }
            else
            {
              
              $scope.prueba[lugar] = false;
            }
          }
          $scope.numeroFechas = function (cantidad)
          {
             
             $scope.elementosHtml = '';
             var clonEspacio =  document.querySelector( '#id_espacio' );
             var clonAula =  document.querySelector( '#id_aulas' );
            $scope.clonNumero = document.querySelector('#id_salones');
             var clonHora_inicial =  document.querySelector( '#hora_inicial' );
             var clonHora_inicial_min =  document.querySelector( '#hora_inicial_min' );
             var cu = document.querySelector('#centro_uni').value;
             var i = 0;
             var orden=[]; 
            
             for(i=0;i<cantidad;i++)
             {
                orden.push({"fecha": $scope.user.fecha[i]});
             }

             orden = quick_Sort(orden);

             for(i=0;i<cantidad;i++)
             {
                $scope.user.fecha[i] = orden[i].fecha;
             }
             i=0;
             if(cu !== 'Clases')
             { 
                 while(i < cantidad)
                 {
                   $scope.elementosHtml =
                   $sce.trustAsHtml ($scope.elementosHtml 
                                                              + '<div class="row"><div class="col-sm-12">'
                                                              + '<div class="col-12" style="color:#283b41;"><strong><br>Evento del día '+formatDate($scope.user.fecha[i])+ '</strong></div>'
                                                              + '<div class="col-12" style="color:#283b41;"><span class="ab-lugar"></span><strong>Espacio</strong><select ng-disabled="myCheckbox" ng-model="lugares.espacio'+i+'" ng-init="lugares.espacio'+i+'=inicia();" ng-change="pushToArray(lugares.espacio'+i+',user.espacios,'+i+'); mostrar(lugares.espacio'+i+','+i+')" style="border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;" required>'
                                                              +  clonEspacio.innerHTML+ '</select>'
                                                              + '<br><br><div class="row">'
                                                              + '<div class="col-12"><input ng-disabled="myCheckbox" ng-init="Olugares.espacio'+i+' = inicia(); mostrar(lugares.espacio'+i+', '+i+');" ng-blur="pushToArray(lugares.espacio'+i+',user.espacios,'+i+',Olugares.espacio'+i+')" ng-model="Olugares.espacio'+i+'" ng-show="prueba['+i+']"  ge="pushToArray(lugares.espacio'+i+',user.espacios,'+i+')" type="text" style="border-color: #a4a4a4; border-style:solid; border-width: 2px; width:100%"></div>'
                                                              + '</div>'
                                                              + '<div class="row"><br><br><div class="col-6"><span class="ab-reloj"></span><strong style="color:#283b41;">Hora Inicial</strong><br><select ng-disabled="myCheckbox" ng-model="lugares.horaI'+i+'" ng-init="lugares.horaI'+i+'=iniciaH(); pushToArray(lugares.horaI'+i+',user.hora_inicial_hora,'+i+')" ng-change="pushToArray(lugares.horaI'+i+',user.hora_inicial_hora,'+i+')" style="border-color: #a4a4a4; border-style:solid;  border-width: 2px;">' + clonHora_inicial.innerHTML + '</select> : <select ng-disabled="myCheckbox" ng-model="lugares.minutoI'+i+'" ng-init="lugares.minutoI'+i+'=iniciaM(); pushToArray(lugares.minutoI'+i+',user.hora_inicial_min,'+i+')"  ng-change="pushToArray(lugares.minutoI'+i+',user.hora_inicial_min,'+i+')" style="border-color: #a4a4a4; border-style:solid; border-width: 2px;">' + clonHora_inicial_min.innerHTML + '</select></div>'
                                                              + '<div class="col-6"><span class="ab-reloj"></span><strong style="color:#283b41;">Hora Termino</strong><br><select ng-disabled="myCheckbox" ng-model="lugares.horaF'+i+'" ng-init="lugares.horaF'+i+'=iniciaH(); pushToArray(lugares.horaF'+i+',user.hora_final_hora,'+i+')" ng-change="pushToArray(lugares.horaF'+i+',user.hora_final_hora,'+i+')" style="border-color: #a4a4a4; border-style:solid;  border-width: 2px;">' + clonHora_inicial.innerHTML + '</select> : <select ng-disabled="myCheckbox" ng-model="lugares.minutoF'+i+'" ng-init="lugares.minutoF'+i+'=iniciaM(); pushToArray(lugares.minutoF'+i+',user.hora_final_min,'+i+')" ng-change="pushToArray(lugares.minutoF'+i+',user.hora_final_min,'+i+')" style="border-color: #a4a4a4; border-style:solid; border-width: 2px;">' + clonHora_inicial_min.innerHTML + '</select></div></div>')
                                                              + '</div></div></div>'
                                                              +'<div class="col-12" style="border-bottom:1px solid #ccc;" ><br></div>';
                   i++;

                 }
            }
            if(cu === 'Clases')
            {
                  while(i < cantidad)
                 {
                   $scope.elementosHtml =
                   $sce.trustAsHtml ($scope.elementosHtml 
                    + '<div class="row"><div class="col-sm-12">'
                    + '<div class="col-12" style="color:#283b41;"><strong><br>Evento del día '+formatDate($scope.user.fecha[i])+ '</strong></div>'
                    + '<div class="col-12" style="color:#283b41;"><span class="ab-lugar"></span><strong>Edificio</strong><select ng-disabled="myCheckbox" ng-model="lugares.espacio'+i+'" ng-init="lugares.espacio'+i+'=inicia();" ng-change="pushToArray(lugares.espacio'+i+',user.espacios,'+i+'); printChange(lugares.espacio'+i+', '+i+'); mostrar(lugares.espacio'+i+','+i+')" style="border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;" required>'
                    +  clonAula.innerHTML+ '</select>'
                    + '<br><br><div class="row">'
                    + '<div class="col-12" style="color:#283b41;"><span class="ab-lugar"></span><strong>Aula</strong><select id="aul'+i+'" ng-disabled="myCheckbox" ng-model="lugares.numero'+i+'" ng-init="lugares.numero'+i+'=inicia();" ng-change="pushToArray(lugares.numero'+i+',user.salon,'+i+'); mostrar(lugares.numero'+i+','+i+')" style="border-color: #a4a4a4; border-style:solid; width:100%; border-width: 2px;" required>'
                    +  $scope.clonNumero.innerHTML+ '<option value="Cubiculo tutorias 1"> Cubiculo tutorias 1 </option><option value="Cubiculo tutorias 2"> Cubiculo tutorias 2 </option></select>'
                    + '<br><br><div class="row">'
                    + '<div class="col-12"><input ng-disabled="myCheckbox" ng-init="Olugares.espacio'+i+' = inicia(); mostrar(lugares.espacio'+i+', '+i+');" ng-blur="pushToArray(lugares.espacio'+i+',user.espacios,'+i+',Olugares.espacio'+i+')" ng-model="Olugares.espacio'+i+'" ng-show="prueba['+i+']" ng-change="pushToArray(lugares.espacio'+i+',user.espacios,'+i+')" type="text" style="border-color: #a4a4a4; border-style:solid; border-width: 2px; width:100%"></div>'
                    + '</div>'
                    + '<div class="row"><br><br><div class="col-6"><span class="ab-reloj"></span><strong style="color:#283b41;">Hora Inicial</strong><br><select ng-disabled="myCheckbox" ng-model="lugares.horaI'+i+'" ng-init="lugares.horaI'+i+'=iniciaH(); pushToArray(lugares.horaI'+i+',user.hora_inicial_hora,'+i+')" ng-change="pushToArray(lugares.horaI'+i+',user.hora_inicial_hora,'+i+')" style="border-color: #a4a4a4; border-style:solid;  border-width: 2px;">' + clonHora_inicial.innerHTML + '</select> : <select ng-disabled="myCheckbox" ng-model="lugares.minutoI'+i+'" ng-init="lugares.minutoI'+i+'=iniciaM(); pushToArray(lugares.minutoI'+i+',user.hora_inicial_min,'+i+')"  ng-change="pushToArray(lugares.minutoI'+i+',user.hora_inicial_min,'+i+')" style="border-color: #a4a4a4; border-style:solid; border-width: 2px;">' + clonHora_inicial_min.innerHTML + '</select></div>'
                    + '<div class="col-6"><span class="ab-reloj"></span><strong style="color:#283b41;">Hora Final</strong><br><select ng-disabled="myCheckbox" ng-model="lugares.horaF'+i+'" ng-init="lugares.horaF'+i+'=iniciaH(); pushToArray(lugares.horaF'+i+',user.hora_final_hora,'+i+')" ng-change="pushToArray(lugares.horaF'+i+',user.hora_final_hora,'+i+')" style="border-color: #a4a4a4; border-style:solid;  border-width: 2px;">' + clonHora_inicial.innerHTML + '</select> : <select ng-disabled="myCheckbox" ng-model="lugares.minutoF'+i+'" ng-init="lugares.minutoF'+i+'=iniciaM(); pushToArray(lugares.minutoF'+i+',user.hora_final_min,'+i+')" ng-change="pushToArray(lugares.minutoF'+i+',user.hora_final_min,'+i+')" style="border-color: #a4a4a4; border-style:solid; border-width: 2px;">' + clonHora_inicial_min.innerHTML + '</select></div></div>')
                    + '</div></div></div>'
                    +'<div class="col-12" style="border-bottom:1px solid #ccc;" ><br></div>';
                   i++;

                 }
            }
          }

          $scope.inicia = function()
          {
            
            dato = 'Seleccionar';
            return dato;
          }

          $scope.iniciaH = function()
          {
            
            dato = '08';
            return dato;
          }
          $scope.iniciaM = function()
          {
            
            dato = '00';
            return dato;
          }

          $scope.aula_tipo = function(tipo,lugar)
          { 
            if(tipo == 'Aula')
            {
              return true;
            }
            else
            {
              return false;
            }

          }
        $scope.autoFill = function(numberOfElements)
        {

         var place=0;
         var more =0;
         var innerI = 1;
         var aux = $scope.lugares[Object.keys($scope.lugares)[0]];
         
          for(i=0; i < Object.keys($scope.lugares).length ; i=numberOfElements+i )
          {
            if($scope.lugares[Object.keys($scope.lugares)[0]] == 'Otro')
            {
              $scope.lugares[Object.keys($scope.lugares)[i]] = $scope.Olugares[Object.keys($scope.Olugares)[0]];
        
            }
            else
            {
              $scope.mostrar(aux, innerI);
              $scope.lugares[Object.keys($scope.lugares)[i]] = $scope.lugares[Object.keys($scope.lugares)[0]];
              $scope.Olugares[Object.keys($scope.Olugares)[innerI]] = $scope.lugares[Object.keys($scope.lugares)[0]];
              innerI = innerI + 1;

            }

            $scope.pushToArray($scope.lugares[Object.keys($scope.lugares)[0]],$scope.user.espacios,place);
            place = place +1;

          }
          if(numberOfElements == 6)
            {
              console.log(numberOfElements);
              place = 0;
              for(i=1; i < Object.keys($scope.lugares).length ; i=numberOfElements+i )
              {
                    $scope.lugares[Object.keys($scope.lugares)[i]] = $scope.lugares[Object.keys($scope.lugares)[1]];
                    $scope.pushToArray($scope.lugares[Object.keys($scope.lugares)[1]],$scope.user.salon,place);
                    place = place +1;
              }
              more = 1;
            }
          place = 0;
          for(i=(1 + more); i < Object.keys($scope.lugares).length ; i=numberOfElements+i )
          {
          
              $scope.lugares[Object.keys($scope.lugares)[i]] = $scope.lugares[Object.keys($scope.lugares)[1 + more]];
              $scope.pushToArray($scope.lugares[Object.keys($scope.lugares)[1 + more]],$scope.user.hora_inicial_hora,place);
              place = place +1;
            

          }
          place = 0;
          for(i=(2 + more); i < Object.keys($scope.lugares).length ; i=numberOfElements+i )
          {
            $scope.lugares[Object.keys($scope.lugares)[i]] = $scope.lugares[Object.keys($scope.lugares)[2 + more ]];
            $scope.pushToArray($scope.lugares[Object.keys($scope.lugares)[2 + more]],$scope.user.hora_inicial_min,place);
            place = place +1;

          }
          //numberOfElements- (numberOfElements - place)
          place = 0;
          for(i=(3 + more); i < Object.keys($scope.lugares).length; i=numberOfElements+i )
          {
            $scope.lugares[Object.keys($scope.lugares)[i]] = $scope.lugares[Object.keys($scope.lugares)[3 + more]];
            $scope.pushToArray($scope.lugares[Object.keys($scope.lugares)[3 + more]],$scope.user.hora_final_hora,place);
            place = place +1;

          }
          place = 0;
          for(i=(4 + more); i < Object.keys($scope.lugares).length ; i=numberOfElements+i )
          {
            $scope.lugares[Object.keys($scope.lugares)[i]] = $scope.lugares[Object.keys($scope.lugares)[4 + more]];
            $scope.pushToArray($scope.lugares[Object.keys($scope.lugares)[4 + more]],$scope.user.hora_final_min,place);
            place = place +1;

          }
        }

    function binarySearch(arr, i) 
    {
          var mid = Math.floor(arr.length / 2);
          if (arr[mid].id_sesion === i) 
          {
              return arr[mid];
          } 
          else if (arr[mid].id_sesion < i && arr.length > 1)
          {
              return binarySearch(arr.splice(mid, Number.MAX_VALUE), i);
          } 
          else if (arr[mid].id_sesion > i && arr.length > 1) {
              
              return binarySearch(arr.splice(0, mid), i);
          } 
          else 
          {
              return -1;
          }
    
    }

   function plain_search(arr, i)
    {
      var size = arr.length;
      for (o = 0; o < size; o++)
      {
  //console.log(arr[o].id_sesion + "-" + i);
  
        if(arr[o].id_sesion == i)
        {
          return arr[o];
          
        }
      }
    }

    $scope.clasEvent = function (tipo)
    {

      if(tipo == "Clases")
      {
        $scope.getClassReg();
      }

      else
      {
        $scope.getRegCont();
      }
    }


    $scope.init = function()
    {
      alert($('#centro_uni').val());
      $("#calendar").fullCalendar( 'refetchEvents' );
    }

    $scope.splitEspacio = function(espacio)
    {
      if($scope.user.cu == 'Clases')
      {
        $scope.splitedSpace = espacio.split(" ");
        return $scope.splitedSpace;
      }
      
    }

    $scope.printChange = function(a,b)
    { 
      
     /*if(a == "FB1")
     {

      document.getElementById("aul0").innerHTML=("<option value='01' selected='selected'> 01 </option>"+
      "<option value='Cubiculo tutorias 1'> Cubiculo tutorias 1 </option>"+
      "<option value='Cubiculo tutorias 2'> Cubiculo tutorias 2 </option>");
     
     }
     else
     {
      e = document.querySelector( '#id_salones' );
      document.getElementById('aul0').innerHTML=$scope.clonNumero.innerHTML;
      //$compile( document.getElementById('aul0'))($scope);
     }*/
      
    }

    $scope.getpersonal = function() 
    {
        Promise.resolve(personal.getInterfaz())
            .then(function(value) 
            {       
              $scope.formReg = $sce.trustAsHtml(value); 
            });
     
    };


    $scope.registroPersonal = function(evento, persona)
    {
      $http({
        method  : 'POST',
        url     : 'View/personal_alta.php',
        data    : {id_ses:evento,id_per:persona},
        
       })
        .then(function successCallback(response) {
        
        
         $scope.informacion = response.data;
    
        },
         function errorCallback(response) {
              console.log(response);
          }
       

    )
    }

    $scope.altaBaja = function(pers,activo)
    {
      $http({
        method  : 'POST',
        url     : 'View/activoPersonal.php',
        data    : {id_ses:pers, estado:activo}
        
       })
        .then(function successCallback(response) {
         $scope.informacion = response.data;
         $scope.getGepe();
         
        },
         function errorCallback(response) {
              console.log(response);
          }
       )
    }

    $scope.nuevoPersonal = function(name)
    {
      $http({
        method  : 'POST',
        url     : 'View/nuevoPersonal.php',
        data    : {id_ses:name}
        
       })
        .then(function successCallback(response) {
         $scope.informacion = response.data;
         
        },
         function errorCallback(response) {
              console.log(response);
          }
       )
    }

    
    });//Fin controller




