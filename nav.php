 <!-- Navigation --><?php //session_start(); ?>
    <nav id="topnav-head" data-ng-init="getEvents()" class="navbar navbar-expand-lg navbar-custom fixed-top navbar-dark bg-dark" style="z-index: 7">
      <div class=" container">

           
                <img src="img/logoagenda.png" style="width: 200px; height: 100px">
               <a class="navbar-brand d-none d-lg-block" style="margin-left: 40px" href="#">Eventos Programados</a><br><br> 
               
               <select ng-model="session.cur" style='border-color: #a4a4a4; border-style:solid; border-width: 2px; width: 20%; margin-top: 66px; margin-left: -213px' id="centro_uni"> 
                      <option value="La Normal" >La Normal</option>
                      <option value="Belenes">Belenes</option>
                      <!--<option value="Clases">Belenes(Clases)</option>-->
                      <option value="Clases">Belenes(Aulas)</option>
                </select>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse flex-column ml-lg-0 ml-3" id="navbarResponsive" >
                      <ul class="navbar-nav ml-auto">
                        
                        <?php 
                          if (isset($_SESSION["name"]))
                          {

                            echo '<li class="nav-item">
                                  <a class="nav-link" href="#"  data-toggle="modal" data-target="#exampleModal" ><div>'.$_SESSION["name"].' - '.$role.'</div> </a>
                                  
                            </li> ';
                            if($_SESSION["permission"] == 1 )
                            {
                              echo'
                                  <li class="nav-item">

                                        <a class="nav-link" href="menu_users.php">Administrar Usuarios</a>
                                   
                                  </li>'; 

                          }
                        }
                          else
                          {
                            
                             echo '<li class="nav-item">
                                  <a class="nav-link" href="login.php" >Iniciar Sesion </a>
                            </li> '; 
                          }
                        ?>
                            <li class="nav-item" style='background-image: url(img/logout.png); background-repeat: no-repeat;
                                                    background-size: 30px 30px; padding-left: 30px; height:30px; '>
                              <?php if(isset($_SESSION["name"]))echo " <a class='nav-link' href='".LOGOUT_INDEX."'>Cerrar sesión</a> "?>
                            </li>
                          <?php 
                            if(isset($_SESSION["name"]))
                            {
                              if($_SESSION["permission"] == 1 or $_SESSION["permission"] == 0 )
                              {
                                  echo ' 
                                    <li id="permisoRes" class="nav-item d-lg-none d-xl-none ">
                                      <a class="nav-link" href="#"  data-toggle="modal" data-target="#seccionModal" >Agregar Evento</a>
                                    </li>';
                              }
                            };
                            ?> 
                            <li   id="hoyVista1" class="nav-item  d-lg-none d-xl-none">
                              <?php echo " <a  data-toggle='collapse' data-target='.navbar-collapse.show' class='nav-link' href='#'>Hoy</a> "?>
                            </li>
                            
                            <li id="mesVista1" class="nav-item  d-lg-none d-xl-none">
                              <a class="nav-link " href="#"  data-toggle="collapse" data-target=".navbar-collapse.show" >Mes</a>

                            </li>
                            
                            <li id="semanaVista1" class="nav-item  d-lg-none d-xl-none">
                              <a class="nav-link " href="#" data-toggle="collapse" data-target=".navbar-collapse.show" >Semana</a>

                            </li>

                            <li id="agendaVista1" class="nav-item  d-lg-none d-xl-none">
                              <a class="nav-link " href="#"   data-toggle="collapse" data-target=".navbar-collapse.show" >Agenda</a>

                            </li>
                            <li id="buscarRes" class="nav-item  d-lg-none d-xl-none " >
                              <a class="nav-link " href="#" data-toggle="collapse" data-target=".navbar-collapse.show" >Buscar</a>

                            </li>
                            <?php
                              if(isset($_SESSION["permission"]) )
                              {
                                  echo '
                                  <li id="reporteRes" class="nav-item  d-lg-none d-xl-none " >
                                    <a class="nav-link " href="#" data-toggle="collapse" data-target=".navbar-collapse.show" >Reporte</a>

                                  </li>';
                                }

                            ?>

                      </ul>

                </div>      
        
      </div>

     
    </nav>


    <nav id="topnav" data-ng-init="getEvents()" class="navbar navbar-expand-lg navbar-custom fixed-top navbar-dark bg-dark" style="background-color: #32bdca !important; margin-top:20px; z-index: 6">
      <div class=" container">

           
              
        
      </div>

     
    </nav>

     <nav id="topnav" data-ng-init="getEvents()" class="navbar navbar-expand-lg navbar-custom fixed-top navbar-dark bg-dark" style="background-color: #3e5865 !important; margin-top:60px; z-index: 5">
      <div class=" container">

           <ul style="margin-top:55px; font-size: 20px" class="navbar-nav ">

                    <?php 
                         if(isset($_SESSION["name"]))
                         {
                          if($_SESSION["permission"] == 1 or $_SESSION["permission"] == 0 )
                              {
                                  
                                  echo '
                                <div id="tipoH">
                                <li id="permiso" class="nav-item d-none d-lg-block  ">
                                      <a class="nav-link" href="#"  data-toggle="modal" data-target="#seccionModal" >+ Agregar Evento</a>
                                </li> </div>'; 
                              }
                         }
                    ?>
                            <li id="hoyVista"  href="#"  data-toggle="modal" data-target="#seccionModal" class="nav-item  d-none d-lg-block">
                                <a class='nav-link' href="#" >Hoy</a> 
                            </li>
                             <li id="hoyVista" class="nav-item  d-lg-none d-xl-none">
                                <a class="navbar-brand" style="margin-left: 40px" href="#">Eventos Programados</a> 
                            </li>
                            <li class="nav-item  d-none d-lg-block">
                              <a class="nav-link " href="#"  data-toggle="modal" data-target="#exampleModal" >|</a>

                            </li>
                            <li id="mesVista" class="nav-item  d-none d-lg-block">
                              <a class="nav-link " href="#"   data-toggle="modal" data-target="#exampleModal" >Mes</a>

                            </li>
                            <li class="nav-item  d-none d-lg-block">
                              <a class="nav-link " href="#"  data-toggle="modal" data-target="#exampleModal" >|</a>

                            </li>
                            <li id="semanaVista" class="nav-item  d-none d-lg-block">
                              <a class="nav-link " href="#"  data-toggle="modal" data-target="#exampleModal" >Semana</a>
                            <li class="nav-item  d-none d-lg-block">
                              <a class="nav-link " href="#"  data-toggle="modal" data-target="#exampleModal" >|</a>

                            </li>
                            <li id="agendaVista" class="nav-item  d-none d-lg-block">
                              <a class="nav-link " href="#"  data-toggle="modal" data-target="#exampleModal" >Agenda</a>

                            </li>
                            
                             <li id="lupa" class="nav-item fas d-none d-lg-block" style="margin-left: 13em; margin-top: 5px">
                              
                              <a class="nav-link fa-search " href="#"  data-toggle="modal" data-target="#seccionModal" ></a>

                            </li>
                            
                            <li id="buscar" class="nav-item  d-none d-lg-block " >
                              <a class="nav-link " href="#"  data-toggle="modal" data-tar12 get="#seccionModal" >Buscar</a>

                            </li>
                             <?php
                              if(isset($_SESSION["permission"]) )
                              {
                                  echo '
                                    <li class="nav-item  d-none d-lg-block">
                                      <a class="nav-link " href="#"  data-toggle="modal" data-target="#exampleModal" >|</a>

                                    </li>
                            
                                    <li id="reportes" class="nav-item  d-none d-lg-block " >
                                      <a class="nav-link " href="#"  data-toggle="modal" data-tar12 get="#seccionModal" >Reportes</a>

                                    </li>';
                              }
                              ?>
                      </ul>

              
        
      </div>

     
    </nav>


  