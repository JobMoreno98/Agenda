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

    $('#permiso').click(function() 
    {
         angular.element("#postController").scope().getRegCont();
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


    setInterval(function () {
        reFetch();

    },100000);

    var reFetch = function()
     {

      $("#calendar").fullCalendar( 'refetchEvents' );

     };

     var limpio = function()
     {
      $('#postController').scope().user ={};
      $('#postController').scope().user.aula = 'A 01';
     }
     $('#centro_uni').change(
      function ()
      {
            $('#calendar').fullCalendar('refetchEvents');
      });
  });
     