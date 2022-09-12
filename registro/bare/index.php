<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bare - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
      body {
        padding-top: 54px;
      }
      @media (min-width: 992px) {
        body {
          padding-top: 56px;
        }
      }

    </style>

  </head>

  <body>
    <!--Menu de Navegacion -->
    <?php #include "nav.html" ?>

    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
           <!--Contenido de la pagina -->
             <?php

                require ("./Model/classOperation.php");

                # Crear una sesión para el usuario / Reanudar la sesión del usuario.
                session_start();
                /*
                 * La primera vez que se ingrese a esta página, "session_start()"
                 * creará una sesión para el usuario, después si por algún motivo
                 * se accede nuevamente (con una sesión ya creada [después de un
                 * inicio de sesión exitoso]), se redigirá al usuario a la página principal
                 * en lugar de mostrar el formulario de inicio de sesión nuevamente.
                 */


                # Verificar el contenido de la sesión "name".
                if (! isset($_SESSION["name"])) {

                  $server = $_SERVER["PHP_SELF"];


                  echo "

                    <div class='jumbotron'>
                    <div  class='border border-primary'>
                    <h1>Iniciar sesión</h1>

                    <form action='$server' method='POST'>
                          <div class='row'>
                                <div class='col-md-4'></div>
                                <div class='col-xs-12 col-md-4' >

                                   <label for='id_codigo'>Código</label><br>
                                   <input class='form-control' type='text' id='id_codigo' name='codigo' minlength='".MIN_CODE_LENGTH."' placeholder='#######' required autofocus />

                                </div>
                                <div class='col-md-4'>
                                </div>
                          </div>
                          <!--Cierra Fila -->
                          <div class='row'>
                                <div class='col-md-4'>
                                  
                                  

                                </div>
                                <div class='col-xs-12 col-md-4'>
                                      
                                      <label for='id_contrasenia'>Contraseña</label><br>
                                      <input class='form-control' type='password' id='id_contrasenia' name='contrasenia' minlength='".MIN_PASS_LENGTH."' placeholder='**********' required />

                                </div>
                          </div>
                          <!--Cierra Fila -->
                           <div class='row'>
                                <div class='col-md-4'></div>
                                <div class='col-md-4'><br>
                                    <p>
                                      <input class='btn btn-primary' type='submit' name='iniciar_sesion' value='Iniciar sesión' />
                                    </p>
                                </div>
                                <div class='col-md-4'></div>
                          
                            </div> 
                            <!--Cierra Fila --> 
                      </form>
                      <!--Cierra Form -->
                      </div>
                    </div>
                    <!--Cierra jumbotron -->
                        ";

                }
                else if (isset($_SESSION["name"])) {

                  header("location: ". MAIN_INDEX ."");
                }

                if (isset($_POST["iniciar_sesion"])) {

                      $codigo      = $_POST["codigo"];
                      $contrasenia = $_POST["contrasenia"];


                      if ((ctype_space($codigo)) || ($codigo == "") || ($contrasenia == "")) {

                        ;
                        #echo "<div>Alguno(s) de los campos no contiene(n) información válida.</div>";
                      }
                      else if (strlen($codigo) < MIN_CODE_LENGTH) {

                        ;
                        #echo "<div>El código debe ser de ".MIN_CODE_LENGTH." dígitos.</div>";
                      }
                      else if (strlen($contrasenia) < MIN_PASS_LENGTH) {

                        ;
                        #echo "<div>La contraseña debe contener al menos ".MIN_PASS_LENGTH." caracteres.</div>";
                      }
                      else if (! ctype_digit($codigo)) {

                        echo "<div>El código debe ser numérico.</div>";
                      }
                      else {

                        $operation = new Operation();

                        $user_data = $operation->login($codigo, $contrasenia);

                        if ($user_data) {

                              # (Crear una sesión para el usuario)*.
                              #session_start();
                              # *Si no se hubiera creado con aterioridad sería necesario crearla en este punto.

                              # Almacenar en la sesión "name" el nombre del usuario.
                              $_SESSION["name"] = $user_data[0];

                          # Almacenar en la sesión "code" el código del usuario.
                              $_SESSION["code"] = $user_data[1];

                              # Almacenar en la sesión "permission" el nivel de permisos del usuario.
                              $_SESSION["permission"] = $user_data[2];

                              # Almacenar en la sesión "area" el área del usuario.
                              $_SESSION["area"] = $user_data[3];

                              # Almacenar en la sesión "university_center" el centro universitario al que pertenece el usuario.
                              $_SESSION["university_center"] = $user_data[4];


                              # Redirigir al usuario a la página principal.
                              header("location: ". MAIN_INDEX ."");

                          }
                          else {

                            echo "<div>Credenciales de acceso no válidas.</div>";
                          }

                      }

                    }

              ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
