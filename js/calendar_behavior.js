

     $('#calendar').fullCalendar({
     
     
      header: {
        
        left: 'prev',
        center: 'title',
        right: 'next'

        
      },
       contentHeight: ()=>{
      console.log(screen.width);
      if(screen.width < 577) {
            return 2000
        } else {
            return 485
        }
      },
      locale: 'es',
      defaultDate: currentDate,
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      eventStartEditable: false, //no permite drag and drop
      eventDurationEditable: false,
      height: 'parent',  
      minTime: '07:00:00',
      maxTime: '23:00:00',
      events:
      {
        url:'View/show.php',
        data: function()  
          { 
             return{   
                cu: $('#centro_uni').val(),
                //agregar el tipo de actividad
                //act: $('#postController').scope().actividad
               };
                  
          },
         error: function()
          {
                alert('there was an error while fetching events!');
          },
      }, 

      showNonCurrentDates: false,
      displayEventTime:false,
      eventClick: function(calEvent, jsEvent, view, resourceObj) 
      {
        
        $("#seccionModal").modal("show");
        $('#postController').scope().eventId(calEvent);
        $('#postController').scope().class = "";
        $('#postController').scope().informacion ={};
        
       
       },
      

        navLinkDayClick: function(date, jsEvent) 
        {
            $('#seccionModal').modal('show');
            fecha = new Date(date);
            angular.element('#postController').scope().getToday();
            angular.element('#postController').scope().todayEvents(fecha);
        },

        dayClick: function(date, jsEvent, view, resourceObj) 
        {

           if(screen.width > 577)
            {
              $('#seccionModal').modal('show');
            }
            fecha = new Date(date);
            angular.element('#postController').scope().getToday();
            angular.element('#postController').scope().todayEvents(fecha);

        },
       eventRender: function(calEvent, jsEvent, view, resourceObj)
       {
         
        $('#tablaEventos').trigger('click');
        $('#tablaSearchEventos').trigger('click');
        
       }
       
    });