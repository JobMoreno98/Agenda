
<!DOCTYPE html>

<html>

	<head>

		<title>Administrar usuarios</title>

        <link rel="icon" type="image/x-icon" href="./Documents/Images/IP.png" />

		<!-- Bootstrap. -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="es" />

       <style type="text/css">
           
       </style>
	</head>

	<body  style='background-image: url("img/bginicio2.jpg");'>


		<?php

			require ("./Model/classOperation.php");
            require_once ("Model/config.php");

            session_start();


            if (empty($_SESSION)) {

                header("location: ". MAIN_INDEX ."");
            }
            else {

                if ($_SESSION["permission"] == 1) {

                    $server = $_SERVER["PHP_SELF"];

                    echo "
                        <div class='container' style='margin-top:50px;' >
                        <div class='row'>
                        <div class='col-6 ' style='background-color:#e4e4e4; border:5px solid; border-color:#32bdca; height:700px'>
                             <img src='img/logoagenda.png' style='margin:0 auto;width: 25em; height: 200px; margin-top:200px;'  class='mx-auto d-block' alt='Responsive image'>
                        ";
                            #inicia seccion para registrar usuario
                             if (isset($_POST["register_u"])) 
                                {
                                    $areas = ["CTA", "Serv. Generales"];
                                    $sedes = ["La Normal", "Belenes", "Ambas"];
                                    $nombre       = $_POST["nombre"];
                                    $codigo       = $_POST["codigo"];
                                    $contrasenia  = $_POST["contrasenia"];
                                    $contrasenia2 = $_POST["contrasenia2"];
                                    $area         = $_POST["area"];
                                    $sede         = $_POST["sede"];
                                    $permiso      = 0;


                                    $style = "danger";

                                    if ((ctype_space($nombre)) || ($nombre == "") || ($codigo == "") || ($contrasenia == "") || ($contrasenia2 == "") || ($area == "") || ($sede == "")) {

                                                echo "<div class='alert alert-$style'>Alguno(s) de los campos no contiene(n) información válida.</div>";
                                            }
                                            else if (strlen($codigo) != MIN_CODE_LENGTH) {

                                                echo "<br><div class='alert alert-$style'>El código deber contener".MIN_CODE_LENGTH." dígitos.</div>";
                                            }
                                            else if (! is_numeric($codigo)) {

                                                $style = "warning";

                                                echo "<br><div class='alert alert-$style'>El código debe ser numérico.</div>";
                                            }
                                            else if ((strlen($contrasenia) < MIN_PASS_LENGTH) || (strlen($contrasenia2) < MIN_PASS_LENGTH)) {

                                                echo "<br><div class='alert alert-$style'>La contraseña deber contener al menos ".MIN_PASS_LENGTH." caracteres.</div>";
                                            }
                                            else if ($contrasenia !== $contrasenia2) {

                                                $style = "warning";

                                                echo "<br><div class='alert alert-$style'>Las contraseñas no coinciden.</div>";
                                            }
                                            else if ($area == "Seleccionar") {

                                                $style = "warning";

                                                echo "<br><div class='alert alert-$style'>Ningún área fue seleccionada.</div>";
                                            }
                                            else if ((! in_array($area, $areas))) {

                                                echo "<br><div class='alert alert-$style'>El área no es válida.</div>";
                                            }
                                            else if ($sede == "Seleccionar") {

                                                $style = "warning";

                                                echo "<br><div class='alert alert-$style'>Ninguna sede fue seleccionada.</div>";
                                            }
                                            else if ((! in_array($sede, $sedes))) {

                                                echo "<br><div class='alert alert-$style'>La sede no es válida.</div>";
                                            }
                                             else {

                                                $nombre = mb_convert_case($nombre, MB_CASE_TITLE);

                                                # Crear el hash de "contrasenia" con el algoritmo por default.
                                                $contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);
                                                #$contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT, array("cost"=>FORCE));


                                                $operation = new Operation();

                                                $bool_result = $operation->register_user($nombre, $codigo, $contrasenia, $area, $sede, $permiso);

                                                if ($bool_result) {

                                                    $style = "success";

                                                    echo "<br><div class='alert alert-$style'>El usuario $nombre ($codigo) ha sido registrado correctamente.</div>";
                                                }
                                                else {

                                                    echo "<div class='alert alert-$style'>No fue posible registrar al usuario.</div>";
                                                }

                                            }

                                }
                        
                        echo"     
                        </div>
                        <div class='col-6' style='background-color:#3f5866; color:white'>
                    ";
                    

                            if (isset($_POST["register_user"])) 
                            {

                                $areas = ["CTA", "Serv. Generales"];
                                $sedes = ["La Normal", "Belenes", "Ambas"];


                                echo "
                                    <div class='container' >
                                    <div class='row'>
                                    

                                    <div class='col-12'>
                                        <h1 style='text-align:center'>Registrar usuario</h1>

                                        <form action='$server' method='POST' style='width:80%; margin:0 auto;'>

                                            <p><input type='hidden' name='register_user' required readonly /></p>

                                            <div class='form-group'>
                                                <p>
                                                    <label class='font-weight-bold' for='id_nombre'>Nombre</label>
                                                    <input type='text' class='form-control' id='id_nombre' name='nombre' minlength='".MIN_NAME_LENGTH."'  placeholder='Nombre' required autofocus /></p>
                                                </p>
                                            </div>

                                            <div class='form-group'>
                                                <p>
                                                    <label class='font-weight-bold' for='id_codigo'>Código</label>
                                                    <input type='text' class='form-control' id='id_codigo' name='codigo' minlength='".MIN_CODE_LENGTH."'  placeholder='#######' required /></p>
                                                </p>
                                            </div>
                                            <div class='row'>
                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <p>
                                                            <label class='font-weight-bold' for='id_contraseña'>Contraseña</label>
                                                            <input type='password' class='form-control' id='id_contraseña' name='contrasenia' minlength='".MIN_PASS_LENGTH."'  placeholder='**********' required /></p>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class='col-6'>
                                                    <div class='form-group'>
                                                        <p>
                                                            <label class='font-weight-bold' for='id_contraseña'>Confirmar contraseña</label>
                                                            <input type='password' class='form-control' id='id_contraseña2' name='contrasenia2' minlength='".MIN_PASS_LENGTH."'  placeholder='**********' required /></p>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <p>
                                                    <label class='font-weight-bold' for='id_area'>Área</label>
                                                    <select class='form-control' id='id_area' name='area'>
                                                        <option value='Seleccionar' selected>Seleccionar</option>";

                                                        foreach ($areas as $area) {

                                                            echo "<option value='$area'>$area</option>";
                                                        }

                                                    echo "
                                                    </select>
                                                </p>
                                            </div>

                                            <div class='form-group'>
                                                <p>
                                                    <label class='font-weight-bold' for='id_sede'>Sede</label>
                                                    <select class='form-control' id='id_sede' name='sede'>
                                                        <option value='Seleccionar' selected>Seleccionar</option>";

                                                        foreach ($sedes as $sede) {

                                                            echo "<option value='$sede'>$sede</option>";
                                                        }

                                                    echo "
                                                    </select>
                                                </p>
                                            </div>
                                           

                                            <div class='clearfix'>
                                                <p>
                                                    <input type='submit' class='btn btn-success float-left' name='register_u' value='Registrar' />
                                                    <input type='reset' class='btn btn-danger float-right' name='clean' value='Limpiar' />
                                                </p>
                                                
                                                <p><br><br><a href='/newAgenda/menu_users.php'><button type='button' class='btn btn-info btn-sm btn-block' value='regresar'>Regresar</button></a></p>
                                            </div>

                                        </form>

                                        </div>
                                    
                                    </div>
                                ";


                                if (isset($_POST["register_u"])) 
                                {

                                    $nombre       = $_POST["nombre"];
                                    $codigo       = $_POST["codigo"];
                                    $contrasenia  = $_POST["contrasenia"];
                                    $contrasenia2 = $_POST["contrasenia2"];
                                    $area         = $_POST["area"];
                                    $sede         = $_POST["sede"];


                                    $style = "danger";

                                    echo "
                                        <div class='container'>
                                        <div class='row'>
                                        <div class='col-sm-1 col-md-2 col-lg-3 col-xl-4'></div>
                                        <div class='col-sm-10 col-md-8 col-lg-6 col-xl-4 text-center'>
                                    ";


                                            

                                    echo "
                                        </div>
                                        <div class='col-sm-1 col-md-2 col-lg-3 col-xl-4'></div>
                                        </div>
                                        </div>
                                    ";

                                }

                            }
                            #termina seccion de registro de usuario



                            #inicia seccion para borrar usuario
                            else if (isset($_POST["delete_user"])) {

                                $operation = new Operation();

                                $array_records = $operation->get_users();

                                if (count($array_records) <= 0) {

                                    echo "
                                        <div class='container'>
                                        <div class='row'>
                                        
                                        <div class='col-12'>

                                            <h1 class='text-center '>Eliminar usuario</h1>
                                            <br />
                                            <div class='alert alert-danger'>No hay usuarios (sin privilegios) registrados.</div>

                                        </div>
                                        <div class='col-sm-1 col-md-2 col-lg-3 col-xl-4'></div>
                                        </div>
                                        </div>
                                    ";

                                }
                                else {

                                    echo "
                                        <div class='container'>
                                        <div class='row'>
                                        
                                        <div class='col-12'>


                                            <h1 class='text-center  mt-5 py-1 '>Eliminar usuario</h1>

                                            <form action='$server' method='POST'>

                                                <p><input type='hidden' name='delete_user' required readonly /></p>

                                                <div class='form-group'>
                                                    <p>
                                                        <label class='font-weight-bold' for='id_user'>Usuario</label>
                                                        <select class='form-control' id='id_user' name='codigo'>
                                                            <option value='Seleccionar' selected>Seleccionar</option>";

                                                            foreach ($array_records as $record) {

                                                                $nombre = $record->nombre;
                                                                $codigo = $record->codigo;
                                                                $area   = $record->area;
                                                                $sede   = $record->centro_univ;

                                                                echo "<option value='$codigo'>$nombre ($area, $sede)</option>";
                                                            }

                                                        echo "
                                                        </select>
                                                    </p>
                                                </div>

                                                <div class='clearfix'>
                                                    <p>
                                                        <input type='submit' class='btn btn-danger float-left' name='delete_u' value='Eliminar' /> &nbsp
                                                        <a href='/newAgenda/menu_users.php'><button type='button' class='btn btn-info' style='width:80%' value='regresar'>Regresar</button></a>
                                                    </p>
                                                    <p></p>
                                                </div>

                                            </form>


                                        </div>
                                        <div class='col-sm-1 col-md-2 col-lg-3 col-xl-4'></div>
                                        </div>
                                        </div>
                                    ";


                                    if (isset($_POST["delete_u"])) {

                                        $codigo = $_POST["codigo"];


                                        $style = "danger";

                                        echo "
                                            <div class='container'>
                                            <div class='row'>
                                            
                                            <div class='col-12 text-center'>
                                        ";


                                                if ((ctype_space($codigo)) || $codigo == "") {

                                                    echo "<div class='alert alert-$style'>Alguno(s) de los campos no contiene(n) información válida.</div>";
                                                }
                                                else if ($codigo == "Seleccionar") {

                                                    $style = "warning";

                                                    echo "<div class='alert alert-$style'>Ningún usuario fue seleccionado.</div>";
                                                }
                                                else {

                                                    $operation = new Operation();

                                                    $bool_result = $operation->delete_user($codigo);

                                                    if ($bool_result) {

                                                        $style = "success";

                                                        echo "<div class='alert alert-$style'>El usuario ha sido eliminado correctamente.</div>";

                                                            $bool_result = $operation->insert_into("sesiones_canceladas", "eliminado_por", $_SESSION["name"]);
                                                            #$bool_result = $operation->insert_into("usuarios_inactivos", "eliminado_por", $_SESSION["nombre"]);

                                                            if ($bool_result) {

                                                                # Bien.
                                                                #...
                                                                echo 1;
                                                            }
                                                            else {

                                                                echo "<div>No fue posible registrar el los datos para el evento eliminado.</div>";
                                                            }

                                                    }
                                                    else {

                                                        echo "<div class='alert alert-$style'>No fue posible eliminar al usuario.</div>";
                                                    }

                                                }


                                        echo "
                                            </div>
                                            </div>
                                            </div>
                                        ";

                                    }

                                }
                            }
                            else {

                                header("location: ". MAIN_INDEX ."");
                            }

                    echo "
                        </div>
                        <div class='col-sm-1 col-md-2 col-lg-3 col-xl-4'></div>
                        </div>
                        </div>
                    ";

                }
                else {

                    header("location: ". MAIN_INDEX ."");
                }

            }

            echo "
                <br />
                <div class='container'>
                <div class='row'>
                <div class='col-sm-1 col-md-2 col-lg-3 col-xl-4'></div>
                <div class='col-sm-10 col-md-8 col-lg-6 col-xl-4'>
                    
                </div>
                <div class='col-sm-1 col-md-2 col-lg-3 col-xl-4'></div>
                </div>
                </div>
            ";
		?>


	</body>

<script type="text/javascript">
    
</script>
</html>
