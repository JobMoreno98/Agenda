
<!DOCTYPE html>

<html>

	<head>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
		<title>Administrar usuarios</title>

        <link rel="icon" type="image/x-icon" href="X.ico" />

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="es" />

	</head>

	<body>


		<?php
            $cod = $_GET["codigo"];
			require ("Model/classOperation.php");
            require ("Model/config.php");
            $operation = new Operation();

            session_start();
            $_POST["register_user"] = "hola";
            
            if ($_SESSION['permission']) {
                
                $server = $_SERVER["PHP_SELF"];

                if (isset($_POST["register_user"])) {

                    echo "
                              <form action='$server' method='POST'>
                                <section class='testimonial py-5' id='testimonial'>
                                    <div class='container'>
                                        <div class='row '>
                                            <div class='col-md-4 py-5 text-white text-center ' style='background-color: #283b42'>
                                                <div class=' '>
                                                    <div class='card-body'>
                                                        <img src='http://www.ansonika.com/mavia/img/registration_bg.svg' style='width:30%;'>
                                                        <h2 class='py-3'>Registro</h2>
                                                        <p>Tation argumentum et usu, dicit viderer evertitur te has. Eu dictas concludaturque usu, facete detracto patrioque an per, lucilius pertinacia eu vel.

                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='col-md-8 py-5 border'>
                                                <h4 class='pb-4'>Llena los campos con la informacion requerida</h4>
                                                <form>
                                                    <div class='form-row'>
                                                        <div class='form-group col-md-6'>
                                                          <input id='id_nombre' name='nombre' placeholder='Nombre Completo' class='form-control' minlength='".MIN_NAME_LENGTH."' type='text' required='required'>
                                                        </div>
                                                        <div class='form-group col-md-6'>
                                                          <input type='text' class='form-control'  id='id_codigo' name='codigo'  placeholder='Codigo' minlength='".MIN_CODE_LENGTH."' required='required'>
                                                        </div>
                                                      </div>
                                                    <div class='form-row'>
                                                        <div class='form-group col-md-6'>
                                                            <input id='password' id='id_contraseña' name='contrasenia' placeholder='Contraseña' class='form-control' required='required' minlength='".MIN_PASS_LENGTH."' type='password'>
                                                        </div> 
                                                         <div class='form-group col-md-6'>
                                                         <input id='confirmPass' id='id_contraseña2' name='contrasenia2' placeholder='Confirma Contraseña' class='form-control' required='required' minlength='".MIN_PASS_LENGTH."'  type='password'>
                                                        </div> 
                                                        <div class='form-group col-md-6'>
                                                                  
                                                                  <select id='id_cu' name='cu' class='form-control'>
                                                                    <option selected>Centro Universitario</option>
                                                                    <option name='la_normal' value='La Normal'>La normal</option>
                                                                    <option name='belenes' value='Belenes'> Belenes</option>
                                                                  </select>
                                                        </div>
                                                        <div class='form-group col-md-6'>
                                                                   <select id='permiso' name='permiso' class='form-control'>
                                                                    <option selected>Permiso</option>
                                                                    <option name='1' value ='1'>Administrador</option>
                                                                    <option name='0' value ='0'>Usuario</option>
                                                                  </select>
                                                        </div>
                                                         <div class='form-group col-md-12'>
                                                                   <select id='id_area' name='area' class='form-control'>
                                                                    <option selected>Area</option>
                                                                    <option name='CTA' value='CTA'> CTA</option>
                                                                    <option  name='Serv. Generales' value='Serv. Generales'> Servicios Generales</option>
                                                                  </select>
                                                        </div>
                                                    </div>
                                                  
                                                    
                                                    <div class='form-row'>
                                                        
                                                        <input type='submit' name='registrar_usuario' class='btn btn-danger' value='Registrar' />
                                                    </div>
                                                     <br>
                                                        <br>
                                                     <div class='form-row'>

                                                        <a href='/newAgenda' class='btn btn-danger' > Regresar a la agenda </a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </form>

                     
                    ";


                    

                    if (isset($_POST["registrar_usuario"])) {

                        $nombre       = $_POST["nombre"];
                        $codigo       = $_POST["codigo"];
                        $contrasenia  = $_POST["contrasenia"];
                        $contrasenia2 = $_POST["contrasenia2"];
                        $permisos     = $_POST["permiso"];
                        $area         = $_POST["area"];
                        $cu           = $_POST["cu"]; # "cu" = Centro universitario.


                        if ((ctype_space($nombre)) || ($nombre == "") || ($codigo == "") || ($contrasenia == "") || ($contrasenia2 == "") || ($area == "") || ($cu == "")) {

                            echo "<p>Alguno(s) de los campos no contiene(n) información válida.</p>";
                        }
                        else if (strlen($nombre) < MIN_NAME_LENGTH) {

                            echo "<p>El nombre deber contener al menos ".MIN_NAME_LENGTH." caracteres.</p>";
                        }
                        else if (strlen($codigo) < MIN_CODE_LENGTH) {

                            echo "<p>El código deber ser de ".MIN_CODE_LENGTH." dígitos.</p>";
                        }
                        else if (! is_numeric($codigo)) {

                            echo "<p>El código debe ser numérico.</p>";
                        }
                        else if ((strlen($contrasenia) < MIN_PASS_LENGTH) || (strlen($contrasenia2) < MIN_PASS_LENGTH)) {

                            echo "<p>La contraseña deber contener al menos ".MIN_PASS_LENGTH." caracteres.</p>";
                        }
                        else if ((! in_array($area, ["CTA", "Serv. Generales"]))) {
                            
                            echo "<p>El área no es válida. $area</p>";
                        }
                        else if ((! in_array($cu, ["La Normal", "Belenes"]))) {

                            echo "<p>El centro universitario no es válido.</p>";
                        }
                        else {

                            $nombre = mb_convert_case($nombre, MB_CASE_TITLE);

                            # Crear el hash de "contrasenia" con el algoritmo por default.
                            $contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);
                            #$contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT, array("cost"=>FORCE));


                            $operation = new Operation();

                            $bool_result = $operation->user_register($nombre, $codigo, $contrasenia, $permisos, $area, $cu);

                            if ($bool_result) {

                                echo "<div class='alert alert-success' role='alert'>
                                            El usuario $nombre ($codigo) ha sido registrado correctamente.
                                      </div>";
                            }
                            else {

                                echo " <div class='alert alert-danger' role='alert'>
                                            No fue posible registrar al usuario.
                                       </div>";
                            }

                        }

                    }

                }
                else if (isset($_POST["delete_user"])) {

                    echo "<h1>¡Próximamente!</h1>";
                }
                else {
                    echo $_SESSION['permission'];
                    //header("location: ". MAIN_INDEX ."");
                }

            }
            else {
                echo $_SESSION['permission'];
                //header("location: ". MAIN_INDEX ."");
            }

            //echo "<p><a href='./".MAIN_INDEX."'><button type='button' value='regresar'>Regresar</button></a></p>";

		?>


	</body>

</html>
